<?php

namespace Warfehr\OmegaOledMsg;

use Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Warfehr\OmegaOledMsg\Exceptions\MsgException;

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
    try {

      $data = Event::fire('WarfehrMsg', [$request]);
    }
    catch (MsgException $e) {

      return redirect()
          ->back()
          ->withErrors(
            json_decode($e->getMessage())
          )
          ->withInput();
    }
    
    $social_data = Event::fire('WarfehrImg', $data);
    Event::fire('WarfehrSocial', $social_data);

    return redirect()
      ->back()
      ->with('warfehr_status', 'Message queued.')
    ;
  }
}
