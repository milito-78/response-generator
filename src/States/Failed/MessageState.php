<?php
namespace Milito\ResponseGenerator\States\Failed;


use Milito\ResponseGenerator\Builder\Nodes\Message;
use Milito\ResponseGenerator\States\State;

class MessageState extends State
{
    /**
     * @param string $message
     * @return ErrorState
     */
    public function message(string $message) : ErrorState
    {
        $this->addNode(new Message($message));
        return new ErrorState($this->getNode());
    }
}
