<?php


namespace Milito\ResponseGenerator\States\Success;


use Illuminate\Http\Response;
use Milito\ResponseGenerator\Builder\Nodes\Code;
use Milito\ResponseGenerator\Builder\Nodes\NodeInterface;
use Milito\ResponseGenerator\States\State;

/**
 * Start State for success response.
 */
class SuccessState extends State
{
    /**
     * @return SendState
     */
    public function updated(): SendState
    {
        $this->addNode(new Code(Response::HTTP_NO_CONTENT));

        return new SendState($this->getNode());
    }

    /**
     * @return MessageState
     */
    public function created(): MessageState
    {
        $this->addNode(new Code(Response::HTTP_CREATED));
        return $this->createMessage($this->getNode());
    }

    /**
     * @return MessageState
     */
    public function accepted() : MessageState
    {
        $this->addNode(new Code(Response::HTTP_ACCEPTED));
        return $this->createMessage($this->getNode());
    }

    /**
     * @return MessageState
     */
    public function succeeded() : MessageState
    {
        $this->addNode(new Code(Response::HTTP_OK));
        return $this->createMessage($this->getNode());
    }

    /**
     * @param int $code
     * @return MessageState
     */
    public function code(int $code) : MessageState
    {
        $this->addNode(new Code($code));
        return $this->createMessage($this->getNode());
    }

    /**
     * @param NodeInterface $node
     * @return MessageState
     */
    private function createMessage(NodeInterface $node): MessageState
    {
        return new MessageState($node);
    }
}
