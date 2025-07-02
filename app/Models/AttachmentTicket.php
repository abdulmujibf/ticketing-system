<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttachmentTicket extends Model
{
  protected $fillable = [
    'ticket_id',
    'attachment_id',
    'file_name',
    'file_size',
    'file_type',
    'file_location'
  ];

  public function ticket()
  {
    return $this->belongsTo(Ticket::class);
  }

  public function attachment()
  {
    return $this->belongsTo(Attachment::class);
  }
}
