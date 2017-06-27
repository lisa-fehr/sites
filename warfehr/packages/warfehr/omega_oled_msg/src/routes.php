<?php
Route::group(['middleware' => ['web']], function () {
  Route::post('oled-msg', 'Warfehr\OmegaOledMsg\MsgController@store');
  Route::get('oled-msg', 'Warfehr\OmegaOledMsg\MsgController@show');
});