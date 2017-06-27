<?php

namespace Warfehr\OmegaOledMsg;

use Event;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MsgController extends Controller
{

  /**
   * Feed for the microcontroller
   * @return json
   */
  public function show() {

    return MsgModel::select('content', 'columns')
      ->whereNotNull('created_at')
      ->orderBy('created_at', 'desc')
      ->take(5)
      ->get()
      ->toJson();
  }
  /**
   * Validate the input and fire the creating event
   * @param  Request $request all the form data
   * @return redirect         go back with a status message
   */
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
        'author' => 'required|max:255|regex:/(^[A-Za-z0-9 \'",-_@#]+$)+/',
        'block' => 'required|array',
      ],
      ['regex' => 'The :attribute field may only contain alphanumeric characters, quotes, commas, dashes and underscores, @ and #.']
    );
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
