<?php
namespace Milito\ResponseGenerator\States\Success;


use Illuminate\Http\JsonResponse;
use Milito\ResponseGenerator\Builder\Builder;
use Milito\ResponseGenerator\States\State;

/**
 * Final State for success response.
 */
class SendState extends State
{
    /**
     * @param array $headers
     * @return JsonResponse
     */
    public function send(array $headers = []): JsonResponse
    {
        $builder = new Builder($this->getNode(),$headers);
        return $builder->response();
    }
}
