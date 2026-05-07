<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'user_id', 'invoice_no', 'date', 'total',
        'discount', 'grand_total', 'payment_method',
        'amount_paid', 'change', 'status', 'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}