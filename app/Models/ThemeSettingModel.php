<?php 

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class ShopModel
 *
 * @package App\Models
 */
<<<<<<< HEAD
class ThemeSettingModel extends Model
=======
class Slider extends Model
>>>>>>> 2c864502033caa89c14d632c022033d97ebe627c
{
    /**
     * @var string
     */
    protected $table = 'theme_setting';

 
    /**
     * @var array
     */

   
    protected $fillable = [
        'shop_id', 'settings'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

   
}