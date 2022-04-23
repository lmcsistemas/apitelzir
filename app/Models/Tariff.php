<?php 

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Tariff extends Model {
    protected $table = 'tariffs';

    protected $fillable = [
        'origin',
        'destination',
        'price_minute'
    ];
}