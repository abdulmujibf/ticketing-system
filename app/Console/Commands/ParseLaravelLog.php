<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ParseLaravelLog extends Command
{
  protected $signature = 'log:parse';
  protected $description = 'Parse Laravel log file and output structured JSON';

  public function handle()
  {
    $logPath = storage_path('logs/laravel.log');

    if (!file_exists($logPath)) {
      $this->error('Log file not found.');
      return;
    }

    $logContent = file_get_contents($logPath);

    // Pisah berdasarkan setiap error block (dipisahkan oleh [stacktrace])
    $logEntries = preg_split('/^\[stacktrace\]/m', $logContent);
    foreach ($logEntries as $entry) {
      if (preg_match('/\(([^\\)]+)\(code: (\d+)\): (.+?) at (.+):(\d+)/', $entry, $matches)) {
        $error = [
          'error_type' => trim($matches[1]),
          'code' => (int) $matches[2],
          'message' => trim($matches[3]),
          'file' => str_replace('\\\\', "->", $matches[4]),
          'line' => (int) $matches[5],
          'stacktrace' => []
        ];

        // Stacktrace handler
        if (preg_match_all('/#\d+\s(.+?)\((\d+)\):\s(.+?)\(/', $entry, $traceMatches, PREG_SET_ORDER)) {
          foreach ($traceMatches as $trace) {
            $error['stacktrace'][] = [
              'file' => str_replace("\\\\", " -> ", $trace[1]), // Remove backslashes from file path
              'line' => (int) $trace[2],
              'function' => $trace[3]
            ];
          }
        }

        $this->line(json_encode($error, JSON_PRETTY_PRINT));
      }
    }
  }
}
