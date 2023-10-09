<?php
/**
 * Controller : HomeController.
 *
 * This file used to handle Home
 *
 * @author Sumesh K V <sumeshvasu@gmail.com>
 *
 * @version 1.0
 */

namespace App\Http\Controllers;

use App\Jobs\ImportCSV;
use App\Models\Repositories\Product\ProductInterface as ProductInterface;
use App\Models\Repositories\UploadHistory\UploadHistoryInterface as UploadHistoryInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $product;
    protected $uploadHistory;

    /**
     * Create a new controller instance.
     */
    public function __construct(ProductInterface $product, UploadHistoryInterface $uploadHistory)
    {
        $this->product = $product;
        $this->uploadHistory = $uploadHistory;
    }

    /**
     * Index section.
     *
     * @return \Illuminate\Http\Response
     *
     * @author Sumesh K V <sumeshvasu@gmail.com>
     */
    public function index()
    {
        $data['result'] = $this->uploadHistory->getList();

        return view('welcome', $data);
    }

    /**
     * Store products to darabase.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     *
     * @author Sumesh K V <sumeshvasu@gmail.com>
     */
    public function store(Request $request)
    {
        ImportCSV::dispatch($this->product, $this->uploadHistory, $request->input('document', []));

        return redirect('/');
    }

    /**
     * Store products to darabase.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Sumesh K V <sumeshvasu@gmail.com>
     */
    public function uploads(Request $request)
    {
        $path = storage_path('CSV/uploads');

        !(file_exists($path)) && mkdir($path, 0777, true);

        $file = $request->file('file');
        $name = uniqid() . '_' . trim($file->getClientOriginalName());
        $file->move($path, $name);

        return response()->json([
            'name' => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }
}
