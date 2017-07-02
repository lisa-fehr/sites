<?php

namespace Warfehr\OmegaOledMsg\Exceptions;

/**
 * Custom exception named for this package.
 */
class MsgException extends \Exception {
  
  public function __construct($message = null, $code = null, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
