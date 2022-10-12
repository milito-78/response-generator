<?php
namespace Milito\ResponseGenerator;

use Milito\ResponseGenerator\Exceptions\InvalidResponseTypeException;
use Milito\ResponseGenerator\States\Failed\FailedState;
use Milito\ResponseGenerator\States\Success\SuccessState;

class MilitoResponseGenerator
{
    /**
     * @return SuccessState
     * @throws InvalidResponseTypeException
     */
    public function success() : SuccessState
    {
        return $this->start("success");
    }

    /**
     * @return FailedState
     * @throws InvalidResponseTypeException
     */
    public function failed() : FailedState
    {
        return $this->start("failed");
    }

    /**
     * @param string $type
     * @return FailedState|SuccessState
     * @throws InvalidResponseTypeException
     */
    private function start(string $type): FailedState|SuccessState
    {
        return Factory::create($type);
    }
}
