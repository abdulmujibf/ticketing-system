<?php

namespace App\Http\Controllers\Options;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

  public function getByDepartment(Request $req)
  {
    try {
      $department = $req->get('department', '');

      $categories = Category::where('department', $department)->get();

      if (!$categories) {
        return templateError('Category not found', 404);
      }

      return templateSuccess('Category found', 200, $categories);
    } catch (Exception $e) {
      return templateError($e->getMessage());
    }
  }

  public function getBySlug(Request $req)
  {
    try {
      $slug = $req->get('slug', '');

      $categories = Category::where('slug', $slug)->get();

      if (!$categories) {
        return templateError('Category not found', 404);
      }

      return templateSuccess('Category found', 200, $categories);
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

      $newCategory = Category::create([
        'name' => $name,
        'slug' => $slug ? Str::slug($slug) : Str::slug($name),
        'department' => Str::slug($department),
        'options' => $options
      ]);

      return templateSuccess('Category has been created successfully', 201, $newCategory);
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

      $categories = Category::find($id);

      if (!$categories) {
        return templateError('Category not found', 404);
      }

      if ($name) {
        $categories->name = $name;
        $categories->slug = $slug ? Str::slug($slug) : Str::slug($name);
      }
      if ($department) {
        $categories->department = Str::slug($department);
      }
      if ($options && count($options)) {
        $categories->options = $options;
      }

      saveIsDirty($categories);

      return templateSuccess('Category has been updated successfully', 200, $categories);
    } catch (Exception $e) {
      return templateError($e->getMessage());
    }
  }

  public function destroy(Request $req, $id)
  {
    try {
      $categories = Category::find($id);

      if (!$categories) {
        return templateError('Category not found', 404);
      }

      $categories->delete();

      return templateSuccess('Category has been deleted successfully');
    } catch (Exception $e) {
      return templateError($e->getMessage());
    }
  }
}
