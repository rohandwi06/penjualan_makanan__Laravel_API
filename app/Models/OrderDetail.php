<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';

    protected $primaryKey = 'id';

    protected $fillable = [
        'order_id',
        'item_id',
        'price',
        'qty',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

}
