<?php
namespace Milito\ResponseGenerator\Builder\Nodes;


class Message implements NodeInterface
{
    const NAME = "message";
    const SORT = 10;

    /**
     * @var NodeInterface|null
     */
    private ?NodeInterface $next;

    /**
     * @var string
     */
    private string $value;

    /**
     * Message constructor.
     * @param string $value
     * @param NodeInterface|null $next
     */
    public function __construct(string $value, ?NodeInterface $next = null)
    {
        $this->value    = $value;
        $this->next     = $next;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return self::NAME;
    }

    /**
     * @param NodeInterface|null $next
     * @return NodeInterface
     */
    public function setNext(?NodeInterface $next): NodeInterface
    {
        $this->next = $next;
        return $this;
    }

    /**
     * @return NodeInterface|null
     */
    public function next(): ?NodeInterface
    {
        return $this->next;
    }

    /**
     * @return array
     */
    public function build(): array
    {
        $field_name = $this->getFieldName();

        return [
            $field_name => $this->value
        ];
    }

    /**
     * @return int
     */
    public function sort():int
    {
        return config("response.ordered.message",self::SORT);
    }

    /**
     * @param mixed $value
     */
    public function setValue(mixed $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }


    /**
     * @return string
     */
    private function getFieldName() : string {
        $field_name = config("response.fields.message","message");
        return strlen($field_name) ? $field_name : "message";
    }
}
