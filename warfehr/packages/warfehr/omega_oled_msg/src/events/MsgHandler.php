<?php

namespace Warfehr\OmegaOledMsg\Events;

use Warfehr\OmegaOledMsg\OmegaOledMsg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MsgHandler 
{
  /**
   * Store the new msg
   * 
   * @param Request $request
   */
  public function creating(Request $request)
  {
    DB::transaction(function () use($request) {
      $rows = config('config.rows');
      $columns = config('config.columns');

      $total = $rows * $columns;

      // turn block array into a collection
      $picture = collect($request->input('block', []));
      // fill in the empty space with 0s, re-sort and turn into a string
      $picture = $picture
        ->union(array_fill(0, $total, 0))
        ->sortBy(function ($p, $key) {
          return $key;
        })
        ->implode(',')
      ;

      DB::table('oled_msg')->insert([
        'columns' => $columns,
        'author' => $request->input('author', ''),
        'content' => $picture
      ]);
    });
  }
}