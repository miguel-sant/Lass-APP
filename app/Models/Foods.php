<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Foods extends Model
{
    protected $fillable = ['name', 'serving_size', 'calories', 'protein', 'carbs', 'fat'];

    protected $casts = [
        'portions' => 'array',
    ];
}