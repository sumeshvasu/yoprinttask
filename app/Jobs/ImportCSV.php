<?php
/**
 * Job : ImportCSV.
 *
 * This file used to handle queued product saving
 *
 * @author Sumesh K V <sumeshvasu@gmail.com>
 *
 * @version 1.0
 */

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class ImportCSV implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $product;
    private $uploadHistory;
    public $documents;
    public $timeout = 0;

    /**
     * Create a new job instance.
     */
    public function __construct($product, $uploadHistory, $documents)
    {
        $this->product = $product;
        $this->uploadHistory = $uploadHistory;
        $this->documents = $documents;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // ini_set('max_execution_time', '0');

        $failedFlag = false;

        foreach ($this->documents as $file) {
            $this->uploadHistory->store($file);

            $uploadedFileData = file(storage_path('CSV/uploads/') . $file);

            $batches = array_chunk($uploadedFileData, 1000);

            $columnsForSave = [
                'UNIQUE_KEY',
                'PRODUCT_TITLE',
                'PRODUCT_DESCRIPTION',
                'STYLE#',
                'SANMAR_MAINFRAME_COLOR',
                'SIZE',
                'COLOR_NAME',
                'PIECE_PRICE',
            ];

            $header = [];
            $removedKeys = [];

            foreach ($batches as $key => $batch) {
                $data = array_map('str_getcsv', $batch);

                if ($key == 0) {
                    foreach ($data[0] as $keyData => $valueData) {
                        if (!in_array($valueData, $columnsForSave)) {
                            $removedKeys[] = $keyData;
                            unset($data[0][$keyData]);
                        }
                    }

                    $header = $data[0];

                    unset($data[0]);
                }

                foreach ($data as $itemKey => $item) {
                    foreach ($item as $iKey => $iValue) {
                        if (in_array($iKey, $removedKeys)) {
                            unset($data[$itemKey][$iKey]);
                        } else {
                            $data[$itemKey][$iKey] = $this->filterUTF8($iValue);
                        }
                    }
                }

                try {
                    $this->uploadHistory->updateStatus($file, 'processing');

                    foreach ($data as $itemToSave) {
                        $itemData = array_combine($header, $itemToSave);

                        $this->product->store($itemData);
                    }

                } catch (Exception $e) {
                    $failedFlag = true;
                    $this->uploadHistory->updateStatus($file, 'failed');
                }
            }

            if (!$failedFlag) {
                $this->uploadHistory->updateStatus($file, 'completed');
            }
        }
    }

    /**
     * Filter UTF8
     *
     * @param string $string
     *
     * @return string
     */
    private function filterUTF8($string)
    {
        return (string) Str::of($string)->replaceMatches('/[^\x{0000}-\x{007F}]+/u', '');
    }
}
