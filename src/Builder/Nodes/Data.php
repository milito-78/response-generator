<?php
namespace Milito\ResponseGenerator\Builder\Nodes;


use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class Data implements NodeInterface
{
    const NAME = "data";
    const SORT = 40;

    /**
     * @var NodeInterface|null
     */
    private ?NodeInterface $next;

    /**
     * @var mixed
     */
    private mixed $value;

    /**
     * Data constructor.
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

        return [
            $field_name => $this->parseData($this->value)
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
        return config("response.ordered.data",self::SORT);
    }


    /**
     * @return string
     */
    private function getFieldName() : string {
        $field_name = config("response.fields.data","data");
        return strlen($field_name) ? $field_name : "data";
    }

    /**
     * @param mixed $data
     * @return mixed
     */
    private function parseData(mixed $data): mixed
    {
        if ($data instanceof ResourceCollection){
            $data = $this->parseDataResourceCollection($data);
        }
        elseif ($data instanceof LengthAwarePaginator)
        {
            $data = $this->paginateData($data->toArray());
        }
        elseif ($data instanceof Paginator){
            $data = $this->simplePaginateData($data->toArray());

        }
        elseif ($data instanceof JsonResource)
        {
            $data = $data->toArray(request());
        }

        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    private function simplePaginateData(array $data):array
    {
        $items = $data["data"];
        unset($data["data"]);

        return [
            "items"     => $items,
            "paginate"  => array_merge([
                "is_simple_paginate"    => true,
            ],$data)
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    private function paginateData(array $data): array
    {
        $items = $data["data"];
        unset($data["data"]);

        return [
            "items"     => $items,
            "paginate"  => array_merge([
                "is_simple_paginate"    => false,
            ],$data)
        ];
    }

    /**
     * @param ResourceCollection $data
     * @return array
     */
    private function parseDataResourceCollection(ResourceCollection $data): array
    {
        $data = $data->response()->getData(true);
        if (!key_exists('meta',$data)){
            return [
                "items"     => $data["data"],
            ];
        }
        if ($this->checkResourceCollectionPaginateIsMinimal($data)) {
            return $this->simpleResourceCollectionPaginateData($data);
        }

        return $this->paginateResourceCollectionData($data);
    }

    /**
     * @param array $data
     * @return bool
     */
    private function checkResourceCollectionPaginateIsMinimal(array $data) : bool
    {
        if (key_exists("meta",$data) && isset($data['meta']['total'])){
            return false;
        }
        return  true;
    }

    /**
     * @param array $data
     * @return array
     */
    private function simpleResourceCollectionPaginateData(array $data):array
    {
        return  [
            "items"     => $data["data"],
            "paginate"  => [
                "is_simple_paginate"    => true,
                "current_page"          => $data['meta']["current_page"],
                "first_page_url"        => $data['links']["first"],
                "next_page_url"         => $data['links']["next"],
                "prev_page_url"         => $data['links']["prev"],
                "path"                  => $data['meta']["path"],
                "per_page"              => $data['meta']['per_page'],
                "from"                  => $data['meta']['from'],
                "to"                    => $data['meta']['to'],
            ]
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    private function paginateResourceCollectionData(array $data): array
    {
        return [
            "items"     => $data["data"],
            "paginate"  => [
                "is_simple_paginate"    => false,
                "total_data"            => $data['meta']['total'],
                "current_page"          => $data['meta']['current_page'],
                "from"                  => $data['meta']['from'],
                "to"                    => $data['meta']['to'],
                "first_page_url"        => $data["links"]["first"],
                "last_page"             => $data['meta']['last_page'],
                "last_page_url"         => $data["links"]["last"],
                "next_page_url"         => $data["links"]["next"],
                "prev_page_url"         => $data["links"]["prev"],
                "path"                  => $data["meta"]["path"],
                "per_page"              => $data['meta']['per_page'],
            ]
        ];
    }

}
