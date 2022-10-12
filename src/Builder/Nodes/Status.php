<?php
namespace Milito\ResponseGenerator\Builder\Nodes;

class Status implements NodeInterface
{
    const NAME = "status";
    const SORT = 20;

    /**
     * @var NodeInterface|null
     */
    private ?NodeInterface $next;

    /**
     * @var bool
     */
    private bool $value;

    /**
     * Status constructor.
     * @param bool $value
     * @param NodeInterface|null $next
     */
    public function __construct(bool $value, ?NodeInterface $next = null)
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
     * @param mixed $value
     */
    public function setValue(mixed $value)
    {
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function getValue(): bool
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function sort(): int
    {
        return config("response.ordered.success",self::SORT);
    }

    /**
     * @return string
     */
    private function getFieldName() : string {
        $field_name = config("response.fields.success","success");
        return strlen($field_name) ? $field_name : "success";
    }

}
