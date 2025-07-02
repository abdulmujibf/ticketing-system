<?php

namespace App\Http\Controllers\Options;

use App\Http\Controllers\Controller;
use App\Models\Portal;
use App\Models\Satisfaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SatisfactionController extends Controller
{
  public function getByPortal(Request $req)
  {
    try {
      $portal = $req->get('portal');

      $MPortal = Portal::where('slug', $portal)->first();

      if (!$MPortal) {
        return templateError('Portal not found', 404);
      }

      $satisfactions = Satisfaction::where('portal_id', $MPortal->id)->get();

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
      $portal = Portal::where('slug', $req->input('portal'))->first();

      $newSatisfaction = Satisfaction::create([
        'questions' => $questions,
        'portal_id' => $portal->id
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

      $satisfactions = Satisfaction::find($id);

      if (!$satisfactions) {
        return templateError('Satisfaction question not found');
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
