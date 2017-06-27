<?php

namespace Warfehr\OmegaOledMsg;

use Illuminate\Database\Eloquent\Model;

class MsgModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'oled_msg';

    /**
     * Fillable fields
     * @var array
     */
    protected $fillable = [
      'author',
      'content',
      'columns'
    ];
}
