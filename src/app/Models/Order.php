<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['client_name', 'client_phone', 'tariff_id', 'schedule_type', 'comment', 'first_date', 'last_date'];

    public static function getTariffs(): Collection
    {
        return Tariff::all();
    }

    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }
}
