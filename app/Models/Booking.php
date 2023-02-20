<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hotel_id',
        'customer_id',
        'sales_price',
        'purchase_price',
        'arrival_date',
        'purchase_date',
        'nights',
        'status',
    ];

    protected $casts = [
        'arrival_date' => 'datetime:Y-m-d',
        'purchase_date' => 'datetime:Y-m-d',
    ];



    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

}
