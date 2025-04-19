<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\IT\ITTicket;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class ITTicketController extends Controller
{
  public function get()
  {
    try {
      $tickets = ITTicket::with('creator', 'assignee', 'category', 'status', 'priority')->get();

      if (!$tickets) {
        return templateError('Ticket not found', 404);
      }

      return templateSuccess("Ticket found", 200, $tickets);
    } catch (Exception $e) {
      return templateError($e->getMessage());
    }
  }

  public function getById($id)
  {
    try {
      $ticket = ITTicket::with('creator', 'assignee', 'category', 'status', 'priority')->find($id);

      if (!$ticket) {
        return templateError('Ticket not found', 404);
      }

      $ticket['attachments'] = $ticket->attachments;

      return templateSuccess('Ticket found', 200, $ticket);
    } catch (Exception $e) {
      return templateError();
    }
  }

  public function store(Request $req)
  {
    try {
      $title = $req->input('title');
      $description = $req->input('description');
      $user_id = $req->input('user_id');
      $assignee_id = $req->input('assignee_id');
      $category_id = $req->input('category_id');
      $attributes = $req->input('attributes');

      $user = User::find($user_id);
      if (!$user) {
        return templateError('User not found', 404);
      }

      $ticket = ITTicket::create([
        'title' => $title,
        'description' => $description,
        'user_id' => $user_id,
        'assignee_id' => $assignee_id,
        'category_id' => $category_id,
        'attributes' => $attributes,
      ]);

      if (!$ticket) {
        return templateError('Failed to create ticket.', 404);
      }

      // Read Multiple Attachment
      $files = [];
      if ($req->hasFile('files')) {
        foreach ($req->file('files') as $file) {
          $fileName = $file->getClientOriginalName();
          $customPath = Carbon::now()->format('Y/m') . "/" . $ticket->id;
          $path = $file->storePubliclyAs($customPath, $fileName, 'public');

          $newAttachment = Attachment::create([
            'file_name' => $fileName,
            'file_location' => $path,
            'file_size' => $file->getSize(),
            'file_type' => $file->getClientMimeType()
          ]);

          $files[] = $newAttachment->id;
        }

        $ticket->attachment_id = $files;
        $ticket->save();
      }


      return templateSuccess("Ticket has been created successfully", 200, $ticket);
    } catch (Exception $e) {
      return templateError($e->getMessage());
    }
  }

  public function update(Request $req, $id)
  {
    try {
      $title = $req->input('title');
      $description = $req->input('description');
      $assignee_id = $req->input('assignee_id');
      $category_id = $req->input('category_id');
      $attributes = $req->input('attributes');

      $ticket = ITTicket::find($id);
      if (!$ticket) {
        return templateError('Ticket not found', 404);
      }

      isEmpty($ticket, 'title', $title);
      isEmpty($ticket, 'description', $description);
      isEmpty($ticket, 'assignee_id', $assignee_id);
      isEmpty($ticket, 'category_id', $category_id);
      isEmpty($ticket, 'attributes', $attributes);

      saveIsDirty($ticket);

      return templateSuccess("Ticket has been updated successfully", 200, $ticket);
    } catch (Exception $e) {
      return templateError($e->getMessage());
    }
  }

  public function destroy($id)
  {
    try {
      $ticket = ITTicket::find($id);
      if (!$ticket) {
        return templateError('Ticket not found', 404);
      }

      $ticket->delete();

      return templateSuccess("Ticket has been deleted successfully", 200);
    } catch (Exception $e) {
      return templateError($e->getMessage());
    }
  }
}
