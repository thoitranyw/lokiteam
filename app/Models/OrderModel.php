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
        'note',
        'first_name',
        'last_name',
        'city',
        'country',
        'province',
        'country_code',
        'province_code',
        'address1',
        'address2',
        'zip',
        'phone',
        'email',
        'financial_status',
        'fulfillment_status',
        'flag',
        'created_at',
        'updated_at',
        'currency',
        'total_price',
        'subtotal_price',
        'total_tax',
        'total_discounts',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'phone_code',
        'full_name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shop()
    {
        return $this->belongsTo('App\Models\ShopModel', 'shop_id', 'id');
    }

    /**
     * Accessor FullName
     * @return string
     */
    public function getFullNameAttribute()
    {
        $lastName = isset($this->attributes['last_name']) ? ucfirst($this->attributes['last_name']) : '';
        $firstName = isset($this->attributes['first_name']) ? ucfirst($this->attributes['first_name']) : '';
        return $firstName.' '.$lastName;
    }

    /**
     * @return mixed
     */
    public function getPhoneAttribute($value)
    {
        return SettingHelper::splitPhoneNumberCode($value)['phone'];
    }

    /**
     * @return mixed
     */
    public function getPhoneCodeAttribute($value)
    {
        return SettingHelper::splitPhoneNumberCode($value)['phone_code'];
    }

    public function getFlagAttribute($value)
    {
        return (! empty($value)) ? $value : 'none';
    }


    /**
     * Accessor Order ID
     * @return string
     */
    public function getIdAttribute()
    {
        return (string) $this->attributes['id'];
    }
}
