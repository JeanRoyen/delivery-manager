<?php

namespace App\Models;

use App\States\Order\OrderState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStates\HasStates;

class Order extends Model
{
    use HasFactory, SoftDeletes, HasStates;

    protected $casts = [
        'state' => OrderState::class,
    ];
    protected $fillable = [
        'status',
        'total_amount',
        'customer_id',
        'total',
        'items',
        'orders',
        'code',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items():HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
