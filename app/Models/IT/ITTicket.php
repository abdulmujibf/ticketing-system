<?php

namespace App\Models\IT;

use App\Models\Attachment;
use App\Models\Category;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ITTicket extends Model
{
  protected $table = 'it_tickets';

  protected $fillable = [
    'user_id',
    'assignee_id',
    'category_id',
    'status_id',
    'title',
    'description',
  ];

  protected $casts = [
    'attributes' => 'array',
    'attachment_id' => 'array',
  ];

  public function creator(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function assignee(): BelongsTo
  {
    return $this->belongsTo(User::class, 'assignee_id');
  }

  public function category(): BelongsTo
  {
    return $this->belongsTo(Category::class, 'category_id');
  }

  public function status(): BelongsTo
  {
    return $this->belongsTo(Status::class, 'status_id');
  }
  public function priority(): BelongsTo
  {
    return $this->belongsTo(Status::class, 'priority_id');
  }

  public function getAttachmentsAttribute()
  {
    return Attachment::whereIn('id', $this->attachment_id)->get();
  }
}
