<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
  protected $fillable = [
    'creator_id',
    'assignee_id',
    'category_id',
    'priority_id',
    'status_id',
    'department_id',
    'title',
    'description',
    'attributes',
    'time_worked',
    'time_spent',
    'response_time',
  ];

  protected $casts = [
    'attributes' => 'array',
    'time_worked' => 'datetime',
  ];

  public function creator()
  {
    return $this->belongsTo(User::class, 'creator_id');
  }

  public function assignee()
  {
    return $this->belongsTo(User::class, 'assignee_id');
  }

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function priority()
  {
    return $this->belongsTo(Priority::class);
  }

  public function status()
  {
    return $this->belongsTo(Status::class);
  }

  public function department()
  {
    return $this->belongsTo(Department::class);
  }

  public function comments()
  {
    return $this->hasMany(CommentTicket::class);
  }

  public function attachments()
  {
    return $this->hasMany(AttachmentTicket::class);
  }
}
