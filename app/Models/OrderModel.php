<?php
declare(strict_types=1);

namespace App\Models;


use App\Helpers\SettingHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderModel extends Model
{
    use SoftDeletes;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $table = 'order';

    /**
     * @var array
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'order_number',
        'order_name',
        'shop_id',
        // 'note',
        // 'first_name',
        // 'last_name',
        // 'city',
        // 'country',
        // 'province',
        // 'country_code',
        // 'province_code',
        // 'address1',
        // 'address2',
        // 'zip',
        // 'phone',
        // 'email',
        // 'financial_status',
        // 'fulfillment_status',
        // 'flag',
        // 'currency',
        // 'total_price',
        // 'subtotal_price',
        // 'total_tax',
        // 'total_discounts',
        'product_ids'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shop()
    {
        return $this->belongsTo('App\Models\ShopModel', 'shop_id', 'id');
    }
}
