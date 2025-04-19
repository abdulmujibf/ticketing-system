<?php

function templateSuccess($message = false, $status = 200, $data = [])
{
  $defaultMessage = 'Request Success';

  if (empty($data)) {
    return response()->json([
      'success' => true,
      'message' => $message ?? $defaultMessage
    ], $status);
  } else {
    return response()->json([
      'success' => true,
      'message' => $message ?? $defaultMessage,
      'data' => $data
    ], $status);
  }
}

function templateError($message = false, $status = 500, $error = [])
{
  $defaultMessage = 'Internal server error';
  if (!empty($error)) {
    $obj = [
      'success' => false,
      'message' => $message ?? $defaultMessage,
      'error' => $error
    ];
  } else {
    $obj = [
      'success' => false,
      'message' => $message ?? $defaultMessage,
    ];
  }


  return response()->json($obj, $status);
}

function saveIsDirty($model)
{
  if ($model->isDirty()) {
    $model->save();
  }
}

function isEmpty($model, $column, $value)
{
  if (isset($value)) {
    $model->{$column} = $value;
  }
}
