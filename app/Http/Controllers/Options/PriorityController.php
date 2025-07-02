<?php

namespace App\Http\Controllers\Options;

use App\Http\Controllers\Controller;
use App\Models\Portal;
use App\Models\Priority;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Str;

class PriorityController extends Controller
{
  public function getByPortal(Request $req)
  {
    try {
      $portal = $req->get('portal', '');

      $MPortal = Portal::where('slug', $portal)->first();

      if (!$MPortal) {
        return templateError('Portal not found', 404);
      }

      $priorities = Priority::where('portal_id', $MPortal->id)->get();

      if (!$priorities) {
        return templateError('Priority not found', 404);
      }

      return templateSuccess('Priority found', 200, $priorities);
    } catch (Exception $e) {
      return templateError($e->getMessage());
    }
  }

  public function getBySlug(Request $req)
  {
    try {
      $slug = $req->get('slug', '');

      $priorities = Priority::where('slug', $slug)->get();

      if (!$priorities) {
        return templateError('Priority not found', 404);
      }

      return templateSuccess('Priority found', 200, $priorities);
    } catch (Exception $e) {
      return templateError($e->getMessage());
    }
  }

  public function store(Request $req)
  {
    try {
      $name = $req->input('name', '');
      $slug = $req->input('slug', '');
      $portal = $req->input('portal', '');
      $options = $req->input('options', []);

      if (!$name || !$portal) {
        return templateError('Name and Portal can\'t be empty', 404);
      }

      $MPortal = Portal::where('slug', $portal)->first();

      $newPriority = Priority::create([
        'name' => $name,
        'slug' => $slug ? Str::slug($slug) : Str::slug($name),
        'portal_id' => $MPortal->id,
        'options' => $options
      ]);

      return templateSuccess('Priority has been created successfully', 201, $newPriority);
    } catch (Exception $e) {
      return templateError('', 500, $e->getMessage());
    }
  }

  public function update(Request $req, $id)
  {
    try {
      $name = $req->input('name', '');
      $slug = $req->input('slug', '');
      $options = $req->input('options', []);

      $priorities = Priority::find($id);

      if (!$priorities) {
        return templateError('Priority not found', 404);
      }

      if ($name) {
        $priorities->name = $name;
        $priorities->slug = $slug ? Str::slug($slug) : Str::slug($name);
      }
      if ($options && count($options)) {
        $priorities->options = $options;
      }

      saveIsDirty($priorities);

      return templateSuccess('Priority has been updated successfully', 200, $priorities);
    } catch (Exception $e) {
      return templateError($e->getMessage());
    }
  }

  public function destroy(Request $req, $id)
  {
    try {
      $priorities = Priority::find($id);

      if (!$priorities) {
        return templateError('Priority not found', 404);
      }

      $priorities->delete();

      return templateSuccess('Priority has been deleted successfully');
    } catch (Exception $e) {
      return templateError($e->getMessage());
    }
  }
}
