<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
  protected $fillable = [
    'file_name',
    'file_size',
    'file_type',
    'file_location',
  ];
}
