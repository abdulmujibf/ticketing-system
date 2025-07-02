<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portal extends Model
{
  protected $fillable = [
    'title',
    'description',
    'slug',
  ];
}
