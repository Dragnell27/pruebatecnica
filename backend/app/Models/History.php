<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    // Defino la propiedad fillable para asignación masiva
    protected $fillable = [
        'param_city',
        'budget',
        'symbol',
        'coin',
        'climate',
        'exchangeRate',
    ];

    // Creo la relación para traer la info de la ciudad
    public function city()
    {
        return $this->belongsTo(Param::class, 'param_city');
    }

    // Creo la relación para traer la info del país usando
    public function country()
    {
        return $this->hasOneThrough(Param::class, Param::class, 'id', 'id', 'param_city', 'param_id');
    }
}
