<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
class Cart extends Model { use HasFactory; protected $fillable = ['user_id']; public function items(): HasMany { return $this->hasMany(CartItem::class); } public function order(): HasOne { return $this->hasOne(Order::class); } public function getTotalAmountAttribute(): float { return (float) $this->items->sum(fn ($item) => (float) $item->product->price * $item->quantity); } public function getFormattedTotalAmountAttribute(): string { return number_format($this->total_amount, 0, ',', '.') . ' ' . Product::DEFAULT_CURRENCY; } }
