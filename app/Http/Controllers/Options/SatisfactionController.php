<?php

namespace App\Http\Controllers\Options;

use App\Http\Controllers\Controller;
use App\Models\Satisfaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SatisfactionController extends Controller
{
  public function getByDepartment(Request $req)
  {
    try {
      $department = $req->get('department');

      $satisfactions = Satisfaction::where('department', $department)->get();

      if (!$satisfactions) {
        return templateError('Satisfaction question not found');
      }

      return templateSuccess('Satisfaction question found', 200, $satisfactions);
    } catch (Exception $e) {
      return templateError($e->getMessage());
    }
  }

  public function store(Request $req)
  {
    try {
      $questions = $req->input('questions');

      $newSatisfaction = Satisfaction::create([
        'questions' => $questions,
        'department' => Str::slug($req->input('department'))
      ]);

      if (!$newSatisfaction) {
        return templateError('Satisfaction question not saved');
      }

      return templateSuccess('Satisfaction question has been saved successfully', 200, $newSatisfaction);
    } catch (Exception $e) {
      return templateError($e->getMessage());
    }
  }

  public function update(Request $req, $id)
  {
    try {
      $questions = $req->input('questions');
      $department = $req->input('department');

      $satisfactions = Satisfaction::find($id);

      if (!$satisfactions) {
        return templateError('Satisfaction question not found');
      }

      if ($department) {
        $satisfactions->department = Str::slug($department);
      }

      if ($questions && count($questions)) {
        $satisfactions->questions = $questions;
      }


      saveIsDirty($satisfactions);

      return templateSuccess('Satisfaction question has been updated successfully', 200, $satisfactions);
    } catch (Exception $e) {
      return templateError($e->getMessage());
    }
  }

  public function destroy(Request $req, $id)
  {
    try {
      $satisfactions = Satisfaction::find($id);

      if (!$satisfactions) {
        return templateError('Satisfaction question not found');
      }

      $satisfactions->delete();

      return templateSuccess('Satisfaction question has been deleted successfully', 200);
    } catch (Exception $e) {
      return templateError($e->getMessage());
    }
  }
}
