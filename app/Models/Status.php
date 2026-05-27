<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    use HasFactory;

    const int PENDING = 1;
    const int PREPARING = 2;
    const int DELIVERING = 3;
    const int DELIVERED = 4;
    public $timestamps = false;

    public function orders():HasMany
    {
        return $this->hasMany(Order::class);
    }
}
