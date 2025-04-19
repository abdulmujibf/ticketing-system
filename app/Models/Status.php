<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
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
