<?php

namespace Milito\ResponseGenerator\Test;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;
use Milito\ResponseGenerator\Facades\MilitoResponseGenerator;

class ConfigTest extends TestCase{

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
    public function append_fields_test(){
        Config::set("response.appends.success",true);
        Config::set("response.appends.status_code",true);

        $response = MilitoResponseGenerator::failed()
            ->code(JsonResponse::HTTP_INTERNAL_SERVER_ERROR)
            ->message($this->message)
            ->errors($this->errors)
            ->data($this->data)
            ->send();

        $result = $response->getData(true);
        $this->assertArrayHasKey("success",$result);
        $this->assertArrayHasKey("code",$result);
    }

    /**
     * @test
     */
    public function disable_fields_test(){
        Config::set("response.appends.success",false);
        Config::set("response.appends.status_code",false);

        $response = MilitoResponseGenerator::failed()
            ->code(JsonResponse::HTTP_INTERNAL_SERVER_ERROR)
            ->message($this->message)
            ->errors($this->errors)
            ->data($this->data)
            ->send();

        $result = $response->getData(true);
        $this->assertArrayNotHasKey("success",$result);
        $this->assertArrayNotHasKey("code",$result);
    }

    /**
     * @test
     */
    public function change_fields_name_test(){
        Config::set("response.fields.message","custom_message");
        Config::set("response.fields.success","custom_success");
        Config::set("response.fields.data","custom_data");
        Config::set("response.fields.code","custom_code");
        Config::set("response.fields.error","custom_error");

        $response = MilitoResponseGenerator::failed()
            ->code(JsonResponse::HTTP_INTERNAL_SERVER_ERROR)
            ->message($this->message)
            ->errors($this->errors)
            ->data($this->data)
            ->send();

        $result = $response->getData(true);
        $this->assertArrayNotHasKey("message",$result);
        $this->assertArrayHasKey("custom_message",$result);
        $this->assertArrayNotHasKey("data",$result);
        $this->assertArrayHasKey("custom_data",$result);
        $this->assertArrayNotHasKey("success",$result);
        $this->assertArrayHasKey("custom_success",$result);
        $this->assertArrayNotHasKey("error",$result);
        $this->assertArrayHasKey("custom_error",$result);
        $this->assertArrayNotHasKey("code",$result);
        $this->assertArrayHasKey("custom_code",$result);
    }
}
