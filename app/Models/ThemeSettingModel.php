<?php 

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class ShopModel
 *
 * @package App\Models
 */
class ThemeSettingModel extends Model
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