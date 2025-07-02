<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentTicket extends Model
{
  protected $fillable = [
    'user_id',
    'ticket_id',
    'attachment_id',
    'comment'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function ticket()
  {
    return $this->belongsTo(Ticket::class);
  }

  public function attachment()
  {
    return $this->belongsTo(Attachment::class);
  }
}
