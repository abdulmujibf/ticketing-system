<?php

namespace App\Http\Controllers\Options;

use App\Http\Controllers\Controller;
use App\Models\Portal;
use App\Models\Status;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Str;

class StatusController extends Controller
{
  public function getByPortal(Request $req)
  {
    try {
      $portal = $req->get('portal', '');

      $MPortal = Portal::where('slug', $portal)->first();

      if (!$MPortal) {
        return templateError('Portal not found', 404);
      }

      $statuses = Status::where('portal_id', $MPortal->id)->get();

      if (!$statuses) {
        return templateError('Status not found', 404);
      }

      return templateSuccess('Status found', 200, $statuses);
    } catch (Exception $e) {
      return templateError($e->getMessage());
    }
  }

  public function getBySlug(Request $req)
  {
    try {
      $slug = $req->get('slug', '');

      $statuses = Status::where('slug', $slug)->get();

      if (!$statuses) {
        return templateError('Status not found', 404);
      }

      return templateSuccess('Status found', 200, $statuses);
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

      $newStatus = Status::create([
        'name' => $name,
        'slug' => $slug ? Str::slug($slug) : Str::slug($name),
        'portal_id' => $MPortal->id,
        'options' => $options
      ]);

      return templateSuccess('Status has been created successfully', 201, $newStatus);
    } catch (Exception $e) {
      return templateError('', 500, $e->getMessage());
    }
  }

  public function update(Request $req, $id)
  {
    try {
      $name = $req->input('name', '');
      $slug = $req->input('slug', '');
      $department = $req->input('department', '');
      $options = $req->input('options', []);

      $statuses = Status::find($id);

      if (!$statuses) {
        return templateError('Status not found', 404);
      }

      if ($name) {
        $statuses->name = $name;
        $statuses->slug = $slug ? Str::slug($slug) : Str::slug($name);
      }
      if ($department) {
        $statuses->department = Str::slug($department);
      }
      if ($options && count($options)) {
        $statuses->options = $options;
      }

      saveIsDirty($statuses);

      return templateSuccess('Status has been updated successfully', 200, $statuses);
    } catch (Exception $e) {
      return templateError($e->getMessage());
    }
  }

  public function destroy(Request $req, $id)
  {
    try {
      $statuses = Status::find($id);

      if (!$statuses) {
        return templateError('Status not found', 404);
      }

      $statuses->delete();

      return templateSuccess('Status has been deleted successfully');
    } catch (Exception $e) {
      return templateError($e->getMessage());
    }
  }
}
