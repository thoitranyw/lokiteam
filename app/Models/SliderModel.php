<?php 

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class ShopModel
 *
 * @package App\Models
 */
class Slider extends Model
{
    /**
     * @var string
     */
    protected $table = 'slider';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */

   
    protected $fillable = [
        'id', 'product_id', 'shop_id' 
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

   
}