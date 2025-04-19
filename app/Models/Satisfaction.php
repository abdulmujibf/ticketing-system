<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Satisfaction extends Model
{
  protected $fillable = [
    'department',
    'questions'
  ];

  protected $casts = [
    'questions' => 'array'
  ];
}
