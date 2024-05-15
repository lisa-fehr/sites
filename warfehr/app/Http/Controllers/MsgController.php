<?php

namespace App\Http\Controllers;

use Warfehr\OmegaOledMsg\MsgModel;

class MsgController
{

    public function show() {
        $images = MsgModel::whereNotNull('image')->orderBy('created_at', 'desc')->get();
        return view('msg', ['images' => $images]);
    }
}