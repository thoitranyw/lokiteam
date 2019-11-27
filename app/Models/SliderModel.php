<?php 

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class ShopModel
 *
 * @package App\Models
 */
class SliderModel extends Model
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
        'id', 'product_id', 'shop_id', 'position'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function product()
    {
        return $this->hasOne('App\Models\ProductModel', 'id', 'product_id');
    }
}