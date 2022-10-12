<?php
namespace Milito\ResponseGenerator\Builder;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Milito\ResponseGenerator\Builder\Nodes\NodeInterface;

class Builder
{
    /**
     * @var NodeInterface
     */
    private NodeInterface $nodes;

    /**
     * @var array
     */
    private array $headers;

    /**
     * Builder constructor.
     * @param NodeInterface $nodes
     * @param array $headers
     */
    public function __construct(NodeInterface $nodes, array $headers = [])
    {
        $this->nodes = $nodes;
        $this->headers = $headers;
    }

    /**
     * @return JsonResponse
     */
    public function response() : JsonResponse
    {
        $code       = Response::HTTP_OK;
        $response   = [];
        $node       = $this->nodes;

        do{
            if ( $this->checkNodeIsCode($node) ) {
                $code = $node->getValue();

                if ( $this->checkResponseIsNoContent($code) )
                    return response()->json( null, $code, $this->headers );

                if ( !$this->checkCanAddStatusCode() )
                    continue;
            }

            if ( $this->checkNodeIsStatus($node) && !$this->checkCanAddStatus() )
                continue;

            $response[$node->sort()] = $node->build();
        }while($node = $node->next());

        return response()->json(
            $this->getResponse($response),
            $code,
            $this->headers
        );
    }


    /**
     * @return bool
     */
    private function checkNodeIsCode(NodeInterface $node) : bool {
        return $node->name() == "code";
    }

    /**
     * @return bool
     */
    private function checkResponseIsNoContent(int $code) : bool {
        return $code == Response::HTTP_NO_CONTENT;
    }

    /**
     * @return bool
     */
    private function checkCanAddStatusCode() : bool {
        return config("response.appends.status_code",false);
    }

    /**
     * @return bool
     */
    private function checkNodeIsStatus(NodeInterface $node) : bool {
        return $node->name() == "status";
    }

    /**
     * @return bool
     */
    private function checkCanAddStatus() : bool {
        return config("response.appends.success",true);
    }

    /**
     * @return array
     */
    private function getResponse(array $response) : array {
        ksort($response);
        return array_merge(
            ...array_values($response)
        );
    }

}
