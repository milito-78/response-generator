<?php
namespace Milito\ResponseGenerator\Builder\Nodes;


class Error implements NodeInterface
{
    const NAME = "error";
    const SORT = 50;
    const SORT_ERRORS = 60;

    /**
     * @var NodeInterface|null
     */
    private ?NodeInterface $next;

    /**
     * @var mixed
     */
    private mixed $value;

    /**
     * Error constructor.
     * @param mixed $value
     * @param NodeInterface|null $next
     */
    public function __construct(mixed $value, ?NodeInterface $next = null)
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
        $result = [
            $field_name => $this->parseError($this->value),
        ];

        if ($this->showErrors()) {
            $errors = $this->getErrorsFieldName();
            if ($this->isErrorsBeforeError())
                $result =  [ $errors => $this->parseErrors($this->value)] + $result;
            else
                $result[$errors] = $this->parseErrors($this->value);
        }

        return $result;
    }

    /**
     * @param mixed $value
     */
    public function setValue(mixed $value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function sort(): int
    {
        return config("response.ordered.error",self::SORT);
    }


    /**
     * @return string
     */
    private function getFieldName() : string {
        $field_name = config("response.fields.error","error");
        return strlen($field_name) ? $field_name : "error";
    }

    /**
     * @return string
     */
    private function getErrorsFieldName() : string {
        $field_name = config("response.fields.errors", "errors");
        return strlen($field_name) ? $field_name : "errors";
    }

    /**
     * @return bool
     */
    private function showErrors() : bool {
        return config("response.array_errors",false);
    }

    /**
     * @return bool
     */
    private function isErrorsBeforeError() : bool{
        return config("response.ordered.errors",self::SORT_ERRORS) < config("response.ordered.error",self::SORT);
    }

    /**
     * @param $errors
     * @return string
     */
    private function parseError($errors): string
    {
        if (is_array($errors))
        {
            $temp = "";
            if ($this->isAssociateArray($errors))
                foreach ($errors as $key => $err)
                {
                    if (is_array($err))
                        $temp .= implode(' ',$err);
                    else
                        $temp .= " " . $err;
                }
            else
                $temp .= implode(' ',$errors);

            return  $temp;
        }

        if (is_string($errors))
        {
            return __($errors);
        }

        return __("Server error.");
    }

    /**
     * @param $errors
     * @return array
     */
    private function parseErrors($errors): array
    {
        if (is_array($errors))
        {
            if ($this->isAssociateArray($errors))
                return $errors;
            return [
                "all" => $errors
            ];
        }

        if (is_string($errors))
        {
            return [
                "all" => [
                    __($errors)
                ]
            ];
        }

        return [
            "all" => [
                __("Server error.")
            ]
        ];
    }

    /**
     * @param array $arr
     * @return bool
     */
    private function isAssociateArray(array $arr): bool
    {
        if (array() === $arr)
            return false;

        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
