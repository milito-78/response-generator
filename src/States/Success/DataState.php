<?php
namespace Milito\ResponseGenerator\States\Success;


use Milito\ResponseGenerator\Builder\Nodes\Data;

class DataState extends SendState
{
    /**
     * @param mixed $data
     * @return SendState
     */
    public function data(mixed $data): SendState
    {
        $this->addNode(new Data($data));
        return new DataState($this->getNode());
    }
}
