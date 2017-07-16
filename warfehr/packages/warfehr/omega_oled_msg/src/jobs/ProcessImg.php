<?php

namespace Warfehr\OmegaOledMsg\Jobs;

use Carbon\Carbon;
use Exception;
use Log;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Warfehr\OmegaOledMsg\MsgModel;

class ProcessImg implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The message
     * @var MsgModel
     */
    public $msg;

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
     * Create a new job instance.
     *
     * @param  MsgModel $msg
     */
    public function __construct(MsgModel $msg)
    {
        $this->msg = $msg;
    }

    /**
    * Store the new image
    */
    public function handle()
    {

        $width = config('config.columns');
        $height = config('config.rows');

        $image = imagecreate($width, $height);
        imagecolorallocate($image, 0, 0, 0);
        $this->color = imagecolorallocate($image, 233, 14, 91);

        // loop through the digits
        $text = collect(str_split($this->msg->content))
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

        // the original image is small, so create a larger version by stretching it
        $dst = imagecreatetruecolor($width * 100, $height * 100);
        imagecopyresampled($dst, $image, 0, 0, 0, 0, $width * 100, $height * 100, $width, $height);

        // keep a copy of the png
        imagepng(
            $dst,
            $this->msg->img_path
        );
        imagedestroy($image);

        if (file_exists($this->msg->img_path)) {
            MsgModel::where('id', '=', $this->msg->id)->update(['img_created_at' => Carbon::now()]);
        }
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     */
    public function failed(Exception $exception)
    {
        Log::error($exception);
    }
}