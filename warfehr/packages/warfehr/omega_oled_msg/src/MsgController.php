<?php

namespace Warfehr\OmegaOledMsg;

use Event;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MsgController extends Controller
{
  /**
   * Validate the input and fire the creating event
   * @param  Request $request all the form data
   * @return redirect         go back with a status message
   */
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

    Event::fire('WarfehrMsg.creating', [$request]);

    return redirect()
      ->back()
      ->with('warfehr_status', 'Message queued.')
    ;
  }
}