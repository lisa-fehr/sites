<?php

namespace Warfehr\OmegaOledMsg\Events;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Warfehr\OmegaOledMsg\Exceptions\MsgException;
use Warfehr\OmegaOledMsg\MsgModel;

class MsgHandler 
{
  /**
   * Store the new pixel message or throw an exception
   * 
   * @param Request $request
   * @throws Exception from validation errors
   */
  public function handle(Request $request)
  {

    DB::transaction(function () use($request) {

      $pixel_string = $this->collectBlocksAsString($request->input('block', []));
      
      $message_array = [
        'columns' => config('config.columns'),
        'author' => $request->input('author', ''),
        'content' => $pixel_string
      ];

      $message = new MsgModel();

      if($message->validate($message_array)) {

        $message::create($message_array);
        return $message_array;
      }

      throw new MsgException($message->errors());
      
    });
  }

  /**
   * A string that can be saved, converted to a png and read by the microcontroller screen
   * @param  array  $blocks   an array of keys with the block position and a value of 1
   * @return bool|string
   */
  private function collectBlocksAsString(array $blocks)
  {
    // fail for validation check
    if (empty($blocks)) {
      return false;
    }

    $total = config('config.rows') * config('config.columns');

    $picture = collect($blocks);
    
    return $picture
      // fill in the empty space with 0s
      ->union(array_fill(0, $total, 0))
      // re-sort keys so they are in the correct position
      ->sortBy(function ($p, $key) {
        return $key;
      })
      // turn into a string
      ->implode('')
    ;
  }
}
