<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    use HasFactory;

    //Creo la relación country para usarla al traer el historial
    public function country()
    {
        return $this->belongsTo(Param::class, 'param_id');
    }
}
