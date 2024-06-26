<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function barbers()
    {
        return $this->belongsToMany(Barber::class, 'barber_service')->withPivot('price');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}