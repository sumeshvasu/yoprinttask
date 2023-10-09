<?php
/**
 * Model : UploadHistory
 *
 * This file used to handle upload histories table
 *
 * @author Sumesh K V <sumeshvasu@gmail.com>
 *
 * @version 1.0
 */

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadHistory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'upload_histories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_name',
        'storage_file_name',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    /**
     * Created at & Updated at add.
     */
    public $timestamps = true;
}
