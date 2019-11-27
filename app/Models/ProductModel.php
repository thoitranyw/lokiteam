<?php
declare(strict_types=1);

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductModel extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'product';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'handle',
        'body_html',
        // 'image',
        // 'custom_collection',
        // 'tag',
        // 'status',
        'shop_id',
        // 'auto_update_price',
        'total_quantity',
        // 'options',
        'deleted_at',
        'view',
        'add_to_cart',
        'checkout'
    ];

    /**
     * @var array
     */
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

    public function getIdAttribute($id)
    {
        return (string) $id;
    }
}
