<?php

namespace App\Models;

use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_pelanggan',
        'no_meja',
        'order_date',
        'order_time',
        'status',
        'total',
        'user_id',
    ];


    //fungsi untuk menghitung total harga dari semua barang-barang yang dibeli
    // public function sumOrderPrice() {

    //     $orderDetail = OrderDetail::where('order_id', $this->id)->pluck('price');

    //     $sum = $orderDetail->sum(function ($detail) {

    //         return $detail->price * $detail->qty;

    //     });

    //     return $sum;

    // }

    public function sumOrderPrice() {
        $orderDetails = OrderDetail::where('order_id', $this->id)->get(['price', 'qty']);

        $sum = $orderDetails->sum(function ($detail) {
            return $detail->price * $detail->qty; // Mengalikan harga dengan quantity
        });

        return $sum;
    }


    public function orderDetail(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
