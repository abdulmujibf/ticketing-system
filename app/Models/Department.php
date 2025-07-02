<?php

namespace App\Models;

use App\Models\IT\ITTicket;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
  protected $fillable = [
    'name',
    'slug',
    'description',
  ];

  public function tickets()
  {
    return $this->hasMany(Ticket::class);
  }

  public function users()
  {
    return $this->hasMany(User::class);
  }
}
