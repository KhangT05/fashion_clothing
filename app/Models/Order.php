<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', // Tên người nhận (thường lấy từ sdtnhan hoặc user)
        'email',
        'phone',

        // địa chỉ
        'province_code',
        'ward_code',
        'address',
        'payment_method',
        'publish', // 0: Hủy, 1: Chờ xác nhận, 2: Đã xác nhận...
        'payment_status',
        'total_amount',
        'user_id',
        'note',
    ];
    // Định nghĩa hằng số trạng thái để code dễ đọc hơn (Optional)
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_PREPARING = 'preparing';
    const STATUS_SHIPPING = 'shipping';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_COMPLETED = 'completed';

    const PAYMENT_STATUS_UNPAID = 'unpaid';
    const PAYMENT_STATUS_PAID = 'paid';
    const PAYMENT_STATUS_REFUNDED = 'refunded';
    // 1. Quan hệ nghịch đảo: Hóa đơn thuộc về 1 User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    // 2. Quan hệ 1-Nhiều: Một hóa đơn có nhiều chi tiết
    public function order_detail()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }
    public function province(): BelongsTo
    {
        return $this->belongsTo('provinces', 'province_code', 'province_code');
    }
    public function ward(): BelongsTo
    {
        return $this->belongsTo('provinces', 'ward_code', 'ward_code');
    }
    public $relationable = ['order_detail'];
}
