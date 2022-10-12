<?php


namespace Milito\ResponseGenerator;

use Milito\ResponseGenerator\Builder\Nodes\Status;
use Milito\ResponseGenerator\Exceptions\InvalidResponseTypeException;
use Milito\ResponseGenerator\States\Failed\FailedState;
use Milito\ResponseGenerator\States\Success\SuccessState;

class Factory
{

    /**
     * @param string $type
     * @return SuccessState|FailedState
     * @throws InvalidResponseTypeException
     */
    public static function create(string $type) : SuccessState|FailedState
    {
        if (preg_match("/success/i",$type))
        {
            return new SuccessState(new Status(true));
        }
        elseif(preg_match("/failed/i",$type))
        {
            return new FailedState(new Status(false));
        }

        throw new InvalidResponseTypeException("Invalid response type.");
    }
}
