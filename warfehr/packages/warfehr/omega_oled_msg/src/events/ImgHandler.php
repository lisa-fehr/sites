<?php

namespace Warfehr\OmegaOledMsg\Events;

use Warfehr\OmegaOledMsg\MsgModel;

class ImgHandler
{
  /**
   * x starting axis
   * @var integer
   */
  private $x = 0;

  /**
   * y starting axis
   * @var integer
   */
  private $y = 0;

  /**
   * color for each pixel via imagecolorallocate
   */
  private $color;

  /**
   * @var string
   */
  private $picture_path;

  /**
   * Store the new msg
   * 
   * @param array $data
   */
  public function handle(MsgModel $data)
  {

    $width = config('config.columns');
    $height = config('config.rows');

    $image = imagecreate($width, $height);
    imagecolorallocate($image, 0, 0, 0);
    $this->color = imagecolorallocate($image, 233, 14, 91);
    
    $text = collect(str_split($data->content))
      ->each(function($digit) use ($image, $width) {
      
      // add a pixel for each 1 in the array
      if($digit == 1) {
        imagesetpixel($image, $this->x, $this->y, $this->color);
      }
      
      $this->x++;

      // reset the x axis when it hits the max and move to the next row of pixels
      if($this->x == $width) {
        $this->x = 0;
        $this->y++;
      }
    });

    $dst = imagecreatetruecolor($width * 100, $height * 100);
    imagecopyresampled($dst, $image, 0, 0, 0, 0, $width * 100, $height * 100, $width, $height);


    $this->picture_path = date('YmdHis') . 'msg.png';

    imagepng(
      $dst,
      config('config.image-path') . '/' . date('YmdHis') . 'msg.png'
    );
    imagedestroy($image);

    if ($data->id) {
        MsgModel::where(['id' => $data->id])->update(['image' => $this->picture_path]);
    }
  
    return [
      'picture_path' => $this->picture_path,
      'author' => $data->author
    ];
  }
}
