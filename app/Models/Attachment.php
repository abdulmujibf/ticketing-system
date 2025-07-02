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

  public function attachmentTickets()
  {
    return $this->hasMany(AttachmentTicket::class, 'attachment_id');
  }

  public function comments()
  {
    return $this->hasMany(CommentTicket::class, 'attachment_id');
  }
}
