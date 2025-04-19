<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $fillable = [
    'name',
    'slug',
    'department',
    'options'
  ];

  protected $casts = [
    'options' => 'array'
  ];
}
