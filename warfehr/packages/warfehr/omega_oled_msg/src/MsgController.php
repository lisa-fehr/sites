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
        'author' => 'required|max:255|alpha_dash',
        'block' => 'required|array',
    ]);
    if ($validator->fails()) {
        return redirect()
          ->back()
          ->withErrors($validator)
          ->withInput();
    }

    $data = Event::fire('WarfehrMsg', [$request]);
    $social_data = Event::fire('WarfehrImg', $data);
    Event::fire('WarfehrSocial', $social_data);

    return redirect()
      ->back()
      ->with('warfehr_status', 'Message queued.')
    ;
  }
}
