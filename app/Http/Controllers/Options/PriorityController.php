<?php

namespace App\Http\Controllers\Options;

use App\Http\Controllers\Controller;
use App\Models\Priority;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Str;

class PriorityController extends Controller
{
  public function getByDepartment(Request $req)
  {
    try {
      $department = $req->get('department', '');

      $priorities = Priority::where('department', $department)->get();

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
      $department = $req->input('department', '');
      $options = $req->input('options', []);

      if (!$name || !$department) {
        return templateError('Name and Department can\'t be empty', 404);
      }

      $newPriority = Priority::create([
        'name' => $name,
        'slug' => $slug ? Str::slug($slug) : Str::slug($name),
        'department' => Str::slug($department),
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
      $department = $req->input('department', '');
      $options = $req->input('options', []);

      $priorities = Priority::find($id);

      if (!$priorities) {
        return templateError('Priority not found', 404);
      }

      if ($name) {
        $priorities->name = $name;
        $priorities->slug = $slug ? Str::slug($slug) : Str::slug($name);
      }
      if ($department) {
        $priorities->department = Str::slug($department);
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
