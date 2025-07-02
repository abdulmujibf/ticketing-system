<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $fillable = [
    'name',
    'slug',
    'department',
    'portal_id',
    'options' // Untuk Conditional dsb
  ];

  protected $casts = [
    'options' => 'array'
  ];

  public function tickets()
  {
    return $this->hasMany(Ticket::class);
  }

  public function portal()
  {
    return $this->belongsTo(Portal::class);
  }
}
