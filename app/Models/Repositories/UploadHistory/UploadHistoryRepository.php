<?php
/**
 * Repository : UploadHistoryRepository.
 *
 * This file used to handling all upload history related activities, which all in UploadHistoryInterface
 *
 * @author Sumesh K V <sumeshvasu@gmail.com>
 *
 * @version 1.0
 */

namespace App\Models\Repositories\UploadHistory;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UploadHistoryRepository implements UploadHistoryInterface
{
    // Our Eloquent model
    protected $uploadHistoryModel;

    /**
     * Setting our class to the injected model.
     *
     * @return UploadHistoryRepository
     */
    public function __construct(Model $uploadHistoryModel)
    {
        $this->uploadHistoryModel = $uploadHistoryModel;
    }

    /**
     * Get uploaded files list.
     */
    public function getList()
    {
        return $this->uploadHistoryModel->get();
    }

    /**
     * Store upload history.
     */
    public function store($fileName)
    {
        $originalFileName = $this->getOriginalFileName($fileName);

        $uploadHistoryObject = $this->uploadHistoryModel::where('file_name', $originalFileName)
            ->whereIn('status', ['failed', 'completed'])
            ->first();

        if ($uploadHistoryObject) {
            $uploadHistoryObject->status = 'pending';
            $uploadHistoryObject->updated_at = Carbon::now();

            $uploadHistoryObject->update();
        } else {
            $this->uploadHistoryModel::create([
                'file_name' => $originalFileName,
                'storage_file_name' => $fileName,
                'status' => 'pending',
            ]);
        }
    }

    /**
     * Update status.
     */
    public function updateStatus($fileName, $status)
    {
        $originalFileName = $this->getOriginalFileName($fileName);

        $uploadHistoryObject = $this->uploadHistoryModel::where('file_name', $originalFileName)
            ->whereNotIn('status', ['failed', 'completed'])
            ->first();

        if ($uploadHistoryObject) {
            $uploadHistoryObject->status = $status;
            $uploadHistoryObject->updated_at = Carbon::now();

            $uploadHistoryObject->update();
        }
    }

    private function getOriginalFileName($fileName)
    {
        strtok($fileName, '_');

        return strtok('');
    }
}
