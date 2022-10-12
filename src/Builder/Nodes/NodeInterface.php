<?php


namespace Milito\ResponseGenerator\Builder\Nodes;


interface NodeInterface
{
    /**
     * @return string
     */
    public function name() : string;

    /**
     * @param NodeInterface|null $next
     * @return NodeInterface
     */
    public function setNext(?NodeInterface $next) : NodeInterface;

    /**
     * @return NodeInterface|null
     */
    public function next(): ?NodeInterface;

    /**
     * @return array
     */
    public function build() : array;

    /**
     * @param mixed $value
     */
    public function setValue(mixed $value);

    /**
     * @return mixed
     */
    public function getValue(): mixed;

    /**
     * @return int
     */
    public function sort(): int;
}
