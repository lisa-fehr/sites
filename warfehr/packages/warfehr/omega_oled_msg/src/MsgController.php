<?php

namespace Warfehr\OmegaOledMsg;

use Event;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Warfehr\OmegaOledMsg\Exceptions\MsgException;
use Warfehr\OmegaOledMsg\Jobs\ProcessImg;
use Warfehr\OmegaOledMsg\Jobs\ProcessSocial;

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

      $msg_array = Event::fire('WarfehrMsg', [$request]);
    }
    catch (MsgException $e) {

      return redirect()
          ->back()
          ->withErrors(
            json_decode($e->getMessage())
          )
          ->withInput();
    }
    $msg_model = array_first($msg_array);

    if(! $msg_model) {
      return redirect()
        ->back()
        ->with('warfehr_status', 'Error: Message was not queued.')
      ;
    }
    
    // processing_img should have a higher priority than processing_social
    dispatch((new ProcessImg($msg_model))->onQueue('processing_img'));
    dispatch((new ProcessSocial($msg_model))->onQueue('processing_social'));

    return redirect()
      ->back()
      ->with('warfehr_status', 'Message queued.')
    ;
  }
}
