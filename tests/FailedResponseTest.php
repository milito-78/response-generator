<?php
namespace Milito\ResponseGenerator\Test;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;
use Milito\ResponseGenerator\Facades\MilitoResponseGenerator;

class FailedResponseTest extends TestCase{

    private string $message = "Success response message";
    private array $errors = [
        "error" => [
            "This is error"
        ]
    ];
    protected array $data = [
        "body" => "Failed response body"
    ];

    /**
     * @test
    */
    public function failed_response_with_appends_fields_test() {
        Config::set("response.appends.success",true);
        Config::set("response.appends.status_code",true);
        Config::set("response.array_errors",true);

        $response = MilitoResponseGenerator::failed()
            ->code(JsonResponse::HTTP_INTERNAL_SERVER_ERROR)
            ->message($this->message)
            ->errors($this->errors)
            ->data($this->data)
            ->send();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($response->getStatusCode(),JsonResponse::HTTP_INTERNAL_SERVER_ERROR,"Status code is not equals");
        $result = $response->getData(true);
        $this->assertIsArray($result);
        $this->assertArrayHasKey("message",$result);
        $this->assertArrayHasKey("data",$result);
        $this->assertArrayHasKey("success",$result);
        $this->assertArrayHasKey("error",$result);
        $this->assertArrayHasKey("errors",$result);
        $this->assertArrayHasKey("code",$result);
    }

    /**
     * @test
    */
    public function failed_response_without_arrays_field_test() {
        Config::set("response.array_errors",false);

        $response = MilitoResponseGenerator::failed()
            ->code(JsonResponse::HTTP_INTERNAL_SERVER_ERROR)
            ->message($this->message)
            ->errors($this->errors)
            ->data($this->data)
            ->send();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($response->getStatusCode(),JsonResponse::HTTP_INTERNAL_SERVER_ERROR,"Status code is not equals");
        $result = $response->getData(true);
        $this->assertIsArray($result);
        $this->assertArrayHasKey("message",$result);
        $this->assertArrayHasKey("data",$result);
        $this->assertArrayHasKey("success",$result);
        $this->assertArrayHasKey("error",$result);
        $this->assertArrayNotHasKey("errors",$result);
        $this->assertArrayHasKey("code",$result);
    }

    /**
     * @test
    */
    public function failed_response_without_appends_fields_test() {
        Config::set("response.appends.success",false);
        Config::set("response.appends.status_code",false);

        $response = MilitoResponseGenerator::failed()
            ->code(JsonResponse::HTTP_INTERNAL_SERVER_ERROR)
            ->message($this->message)
            ->errors($this->errors)
            ->data($this->data)
            ->send();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($response->getStatusCode(),JsonResponse::HTTP_INTERNAL_SERVER_ERROR,"Status code is not equals");
        $result = $response->getData(true);
        $this->assertIsArray($result);
        $this->assertArrayHasKey("message",$result);
        $this->assertArrayHasKey("data",$result);
        $this->assertArrayHasKey("error",$result);
        $this->assertArrayNotHasKey("success",$result);
        $this->assertArrayNotHasKey("code",$result);
    }
}
