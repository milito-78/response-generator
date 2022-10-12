<?php
namespace Milito\ResponseGenerator\States\Failed;


use Milito\ResponseGenerator\Builder\Nodes\Error;

class ErrorState extends SendState
{
    /**
     * @param mixed $errors
     * @return DataState
     */
    public function errors(mixed $errors) : DataState
    {
        $this->addNode(new Error($errors));
        return new DataState($this->getNode());
    }
}
