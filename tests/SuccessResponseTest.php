<?php
namespace Milito\ResponseGenerator\Test;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;
use Milito\ResponseGenerator\Facades\MilitoResponseGenerator;

class SuccessResponseTest extends TestCase{

    protected string $message = "Success response message";
    protected array $data = [
        "body" => "Success response body"
    ];

    /**
     * @test
    */
    public function ok_response_with_appends_fields_test() {
        Config::set("response.appends.success",true);
        Config::set("response.appends.status_code",true);

        $response = MilitoResponseGenerator::success()
            ->succeeded()
            ->message($this->message)
            ->data($this->data)
            ->send();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($response->getStatusCode(),JsonResponse::HTTP_OK,"Status code is not equals");
        $result = $response->getData(true);
        $this->assertIsArray($result);
        $this->assertArrayHasKey("message",$result);
        $this->assertArrayHasKey("data",$result);
        $this->assertArrayHasKey("success",$result);
        $this->assertArrayHasKey("code",$result);
    }
    /**
     * @test
    */
    public function ok_response_without_appends_fields_test() {
        Config::set("response.appends.success",false);
        Config::set("response.appends.status_code",false);

        $response = MilitoResponseGenerator::success()
            ->succeeded()
            ->message($this->message)
            ->data($this->data)
            ->send();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($response->getStatusCode(),JsonResponse::HTTP_OK,"Status code is not equals");
        $result = $response->getData(true);
        $this->assertIsArray($result);
        $this->assertArrayHasKey("message",$result);
        $this->assertArrayHasKey("data",$result);
        $this->assertArrayNotHasKey("success",$result);
        $this->assertArrayNotHasKey("code",$result);
    }
    /**
     * @test
    */
    public function ok_response_with_default_config_test() {
        $response = MilitoResponseGenerator::success()
            ->succeeded()
            ->message($this->message)
            ->data($this->data)
            ->send();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($response->getStatusCode(),JsonResponse::HTTP_OK,"Status code is not equals");
        $result = $response->getData(true);
        $this->assertIsArray($result);
        $this->assertArrayHasKey("message",$result);
        $this->assertArrayHasKey("data",$result);
        $this->assertArrayHasKey("success",$result);
        $this->assertArrayHasKey("code",$result);
    }
    /**
     * @test
    */
    public function accept_response_with_default_config_test() {
        $response = MilitoResponseGenerator::success()
            ->accepted()
            ->message($this->message)
            ->data($this->data)
            ->send();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($response->getStatusCode(),JsonResponse::HTTP_ACCEPTED,"Status code is not equals");
        $result = $response->getData(true);
        $this->assertIsArray($result);
        $this->assertArrayHasKey("message",$result);
        $this->assertArrayHasKey("data",$result);
        $this->assertArrayHasKey("success",$result);
        $this->assertArrayHasKey("code",$result);
    }
    /**
     * @test
    */
    public function accept_response_without_appends_fields_test() {
        Config::set("response.appends.success",false);
        Config::set("response.appends.status_code",false);

        $response = MilitoResponseGenerator::success()
            ->accepted()
            ->message($this->message)
            ->data($this->data)
            ->send();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($response->getStatusCode(),JsonResponse::HTTP_ACCEPTED,"Status code is not equals");
        $result = $response->getData(true);
        $this->assertIsArray($result);
        $this->assertArrayHasKey("message",$result);
        $this->assertArrayHasKey("data",$result);
        $this->assertArrayNotHasKey("success",$result);
        $this->assertArrayNotHasKey("code",$result);
    }
    /**
     * @test
    */
    public function accept_response_with_appends_fields_test() {
        Config::set("response.appends.success",true);
        Config::set("response.appends.status_code",true);

        $response = MilitoResponseGenerator::success()
            ->accepted()
            ->message($this->message)
            ->data($this->data)
            ->send();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($response->getStatusCode(),JsonResponse::HTTP_ACCEPTED,"Status code is not equals");
        $result = $response->getData(true);
        $this->assertIsArray($result);
        $this->assertArrayHasKey("message",$result);
        $this->assertArrayHasKey("data",$result);
        $this->assertArrayHasKey("success",$result);
        $this->assertArrayHasKey("code",$result);
    }
    /**
     * @test
    */
    public function created_response_with_appends_fields_test() {
        Config::set("response.appends.success",true);
        Config::set("response.appends.status_code",true);

        $response = MilitoResponseGenerator::success()
            ->created()
            ->message($this->message)
            ->data($this->data)
            ->send();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($response->getStatusCode(),JsonResponse::HTTP_CREATED,"Status code is not equals");
        $result = $response->getData(true);
        $this->assertIsArray($result);
        $this->assertArrayHasKey("message",$result);
        $this->assertArrayHasKey("data",$result);
        $this->assertArrayHasKey("success",$result);
        $this->assertArrayHasKey("code",$result);
    }
    /**
     * @test
    */
    public function created_response_without_appends_fields_test() {
        Config::set("response.appends.success",false);
        Config::set("response.appends.status_code",false);

        $response = MilitoResponseGenerator::success()
            ->created()
            ->message($this->message)
            ->data($this->data)
            ->send();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($response->getStatusCode(),JsonResponse::HTTP_CREATED,"Status code is not equals");
        $result = $response->getData(true);
        $this->assertIsArray($result);
        $this->assertArrayHasKey("message",$result);
        $this->assertArrayHasKey("data",$result);
        $this->assertArrayNotHasKey("success",$result);
        $this->assertArrayNotHasKey("code",$result);
    }

    /**
     * @test
    */
    public function created_response_with_default_config_test() {
        $response = MilitoResponseGenerator::success()
            ->created()
            ->message($this->message)
            ->data($this->data)
            ->send();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($response->getStatusCode(),JsonResponse::HTTP_CREATED,"Status code is not equals");
        $result = $response->getData(true);
        $this->assertIsArray($result);
        $this->assertArrayHasKey("message",$result);
        $this->assertArrayHasKey("data",$result);
        $this->assertArrayHasKey("success",$result);
        $this->assertArrayHasKey("code",$result);
    }

    /**
     * @test
    */
    public function updated_response_test() {
        $response = MilitoResponseGenerator::success()
            ->updated()
            ->send();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($response->getStatusCode(),JsonResponse::HTTP_NO_CONTENT,"Status code is not equals");
        $result = $response->getData(true);
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    /**
     * @test
    */
    public function custom_code_response_test() {
        $response = MilitoResponseGenerator::success()
            ->code(JsonResponse::HTTP_OK)
            ->message($this->message)
            ->data($this->data)
            ->send();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($response->getStatusCode(),JsonResponse::HTTP_OK,"Status code is not equals");
        $result = $response->getData(true);
        $this->assertArrayHasKey("message",$result);
        $this->assertArrayHasKey("data",$result);
        $this->assertArrayHasKey("success",$result);
        $this->assertArrayHasKey("code",$result);
    }

    /**
     * @test
    */
    public function without_data_with_custom_code_response_test() {
        $response = MilitoResponseGenerator::success()
            ->code(JsonResponse::HTTP_OK)
            ->message($this->message)
            ->send();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($response->getStatusCode(),JsonResponse::HTTP_OK,"Status code is not equals");
        $result = $response->getData(true);
        $this->assertArrayHasKey("message",$result);
        $this->assertArrayNotHasKey("data",$result);
        $this->assertArrayHasKey("success",$result);
        $this->assertArrayHasKey("code",$result);
    }
}
