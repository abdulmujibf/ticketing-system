<?php

namespace App\Models;

use App\Models\IT\ITTicket;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
  protected $fillable = [
    'name',
    'description',
  ];

  public function tickets()
  {
    return $this->hasMany(ITTicket::class);
  }
}
