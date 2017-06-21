<?php
Route::group(['middleware' => ['web']], function () {
  Route::post('oled-msg', 'Warfehr\OmegaOledMsg\MsgController@store');
});