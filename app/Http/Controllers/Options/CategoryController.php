<?php

namespace App\Http\Controllers\Options;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Portal;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
  public function getByPortal(Request $req)
  {
    try {
      $portal = $req->get('portal', '');

      $MPortal = Portal::where('slug', $portal)->first();

      if (!$MPortal) {
        return templateError('Portal not found', 404);
      }

      $categories = Category::where('portal_id', $MPortal->id)->get();

      if (empty($categories)) {
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
      $portal = $req->input('portal', '');
      $options = $req->input('options', []);

      if (!$name || !$portal) {
        return templateError('Name and Portal can\'t be empty', 404);
      }

      $MPortal = Portal::where('slug', $portal)->first();

      $newCategory = Category::create([
        'name' => $name,
        'slug' => $slug ? Str::slug($slug) : Str::slug($name),
        'portal_id' => $MPortal->id,
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
      $options = $req->input('options', []);

      $categories = Category::find($id);

      if (!$categories) {
        return templateError('Category not found', 404);
      }

      if ($name) {
        $categories->name = $name;
        $categories->slug = $slug ? Str::slug($slug) : Str::slug($name);
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
