<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

   
        protected $fillable = [
            'name',
            'email',
            'tel',
            'address',
            'latitude',
            'longitude',
            'description',
            'okPetSize',
            'category',
            'website',
            'photos',
            'prefecture',
            'registrant_id',

        ];
  
        public function reviews()
    {
        return $this->hasMany(Review::class, 'institution_id');
    }
}