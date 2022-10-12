<?php


namespace Milito\ResponseGenerator;

use Milito\ResponseGenerator\Exceptions\InvalidResponseTypeException;

class Factory
{

    public static function create(string $type)
    {
        throw new InvalidResponseTypeException("Invalid response type.");
    }
}
