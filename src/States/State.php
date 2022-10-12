<?php
namespace Milito\ResponseGenerator\States;


use Milito\ResponseGenerator\Builder\Nodes\NodeInterface;

class State
{
    /**
     * @var NodeInterface
     */
    protected NodeInterface $node;

    /**
     * State constructor.
     * @param NodeInterface $node
     */
    public function __construct(NodeInterface $node)
    {
        $this->node = $node;
    }

    /**
     * @param NodeInterface $node
     */
    protected function addNode(NodeInterface $node)
    {
        $head = $this->node;
        if (!$head) {
            $this->node = $node;
            return;
        }

        while ($head->next()){
            $head = $head->next();
        }

        $head->setNext($node);
    }

    /**
     * @return NodeInterface
     */
    protected function getNode(): NodeInterface
    {
        return $this->node;
    }
}
