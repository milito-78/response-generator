<?php
namespace Milito\ResponseGenerator\Builder\Nodes;


use Illuminate\Http\Response;

class Code implements NodeInterface
{
    const NAME = "code";
    const SORT = 30;

    /**
     * @var NodeInterface|null
     */
    private ?NodeInterface $next;

    /**
     * @var int
     */
    private int $value;

    /**
     * Code constructor.
     * @param int $value
     * @param NodeInterface|null $next
     */
    public function __construct(int $value = Response::HTTP_OK, ?NodeInterface $next = null)
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
    public function build() : array
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
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function sort() : int
    {
        return config("response.ordered.code",self::SORT);
    }


    /**
     * @return string
     */
    private function getFieldName() : string {
        $field_name = config("response.fields.code","code");
        return strlen($field_name) ? $field_name : "code";
    }
}
