<?php

namespace Warfehr\OmegaOledMsg;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OmegaOledMsgController extends Controller
{
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
        'author' => 'required|max:255',
        'block' => 'required',
    ]);
    if ($validator->fails()) {
        return redirect()
          ->back()
          ->withErrors($validator)
          ->withInput();
    }

    $rows = config('config.rows');
    $columns = config('config.columns');

    $total = $rows * $columns;

    // turm block array into a collection
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

    return redirect()
      ->back()
      ->with('warfehr_status', 'Message queued.')
    ;
  }
}