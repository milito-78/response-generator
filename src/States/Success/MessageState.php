<?php
namespace Milito\ResponseGenerator\States\Success;


use Milito\ResponseGenerator\Builder\Nodes\Message;
use Milito\ResponseGenerator\States\State;

class MessageState extends State
{
    /**
     * @param string $message
     * @return DataState
     */
    public function message(string $message) : DataState
    {
        $this->addNode(new Message($message));
        return new DataState($this->getNode());
    }
}
