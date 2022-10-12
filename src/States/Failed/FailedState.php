<?php


namespace Milito\ResponseGenerator\States\Failed;


use Milito\ResponseGenerator\Builder\Nodes\Code;
use Milito\ResponseGenerator\States\State;

/**
 * Start State for failed response.
 */
class FailedState extends State
{
    /**
     * @param int $code
     * @return MessageState
     */
    public function code(int $code) : MessageState
    {
        $this->addNode(new Code($code));
        return new MessageState($this->getNode());
    }
}
