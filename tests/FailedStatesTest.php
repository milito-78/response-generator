<?php
namespace Milito\ResponseGenerator\Test;

use Illuminate\Http\JsonResponse;
use Milito\ResponseGenerator\Facades\MilitoResponseGenerator;
use Milito\ResponseGenerator\States\Failed\DataState;
use Milito\ResponseGenerator\States\Failed\ErrorState;
use Milito\ResponseGenerator\States\Failed\FailedState;
use Milito\ResponseGenerator\States\Failed\MessageState;
use Milito\ResponseGenerator\States\Failed\SendState;

class FailedStatesTest extends TestCase{
    /**
     * @test
     */
    public function success_state_test(){
        $state = MilitoResponseGenerator::failed();
        $this->assertInstanceOf(FailedState::class,$state);
    }
    /**
     * @test
     */
    public function code_state_test(){
        $state = MilitoResponseGenerator::failed()->code(JsonResponse::HTTP_BAD_GATEWAY);
        $this->assertInstanceOf(MessageState::class,$state);
    }
    /**
     * @test
     */
    public function message_state_test(){
        $state = MilitoResponseGenerator::failed()->code(JsonResponse::HTTP_BAD_GATEWAY)->message("test message");
        $this->assertInstanceOf(ErrorState::class,$state);
    }
    /**
     * @test
     */
    public function data_state_test(){
        $state = MilitoResponseGenerator::failed()
                    ->code(JsonResponse::HTTP_BAD_GATEWAY)
                    ->message("test message")
                    ->errors(["error" => "error message" ])
                    ->data(["data"]);
        $this->assertInstanceOf(SendState::class,$state);
    }
    /**
     * @test
     */
    public function send_state_test(){
        $state = MilitoResponseGenerator::failed()->code(JsonResponse::HTTP_BAD_GATEWAY)->message("test message")->send();
        $this->assertInstanceOf(JsonResponse::class,$state);
    }
}
