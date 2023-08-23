<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Review extends Model
{
    use HasFactory;

   
    protected $fillable = [
        'user_id',
        'nickname',
        'evaluation',
        'comment',
        'photos',
        'pet_size',
        'institution_id',
        'created',
        'updated',
        'del_flg',
    ];


    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }
        
}