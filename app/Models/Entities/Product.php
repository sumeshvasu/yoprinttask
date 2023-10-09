<?php
/**
 * Model : Product.
 *
 * This file used to handle products table
 *
 * @author Sumesh K V <sumeshvasu@gmail.com>
 *
 * @version 1.0
 */

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'UNIQUE_KEY',
        'PRODUCT_TITLE',
        'PRODUCT_DESCRIPTION',
        'STYLE#',
        'SANMAR_MAINFRAME_COLOR',
        'SIZE',
        'COLOR_NAME',
        'PIECE_PRICE',
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
