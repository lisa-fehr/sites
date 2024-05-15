<?php

namespace Warfehr\OmegaOledMsg\Events;

use Illuminate\Support\Facades\File;
use Thujohn\Twitter\Facades\Twitter;

class SocialHandler 
{
    /**
   * Store the new msg
   * 
   * @param array $data
   */
  public function handle(array $data)
  {
    //$uploaded_media = Twitter::uploadMedia(['media' => File::get(public_path($data['picture_path']))]);
    //Twitter::postTweet(['status' => 'Credit: ' . $data['author'], 'media_ids' => $uploaded_media->media_id_string]);
  }
}
