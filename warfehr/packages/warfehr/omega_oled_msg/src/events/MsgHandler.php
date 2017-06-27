<?php

namespace Warfehr\OmegaOledMsg\Events;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Warfehr\OmegaOledMsg\MsgModel;

class MsgHandler 
{
  private $msg_array = [];
  /**
   * Store the new msg
   * 
   * @param Request $request
   */
  public function handle(Request $request)
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
        ->implode('')
      ;
      
      $this->msg_array = [
        'columns' => $columns,
        'author' => $request->input('author', ''),
        'content' => $picture
      ];

      MsgModel::create($this->msg_array);

    });
    return $this->msg_array;
  }
}
