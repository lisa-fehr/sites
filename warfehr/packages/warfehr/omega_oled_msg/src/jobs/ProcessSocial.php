<?php

namespace Warfehr\OmegaOledMsg\Jobs;

use Carbon\Carbon;
use Exception;
use Log;
use Thujohn\Twitter\Facades\Twitter;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Warfehr\OmegaOledMsg\MsgModel;

class ProcessSocial implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $msg;

    /**
     * Create a new job instance.
     *
     * @param MsgModel $msg
     */
    public function __construct(MsgModel $msg)
    {
        $this->msg = $msg;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Tweet only if the image has been created
        if (! file_exists($this->msg->img_path)) {

            throw new Exception("Failed to create tweet for: " . $this->msg->img_path);
        }

        $uploaded_media = Twitter::uploadMedia(['media' => File::get($this->msg->img_path)]);
        Twitter::postTweet([
            'status' => 'Credit: ' . $this->msg->author,
            'media_ids' => $uploaded_media->media_id_string
        ]);

        MsgModel::where('id', '=', $this->msg->id)->update(['tweet_created_at' => Carbon::now()]);
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