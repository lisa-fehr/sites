<?php
Route::group(['middleware' => ['web']], function () {
  Route::post('omega-oled', 'Warfehr\OmegaOledMsg\OmegaOledMsgController@store');
});