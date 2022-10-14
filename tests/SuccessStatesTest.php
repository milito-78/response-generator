<?php
namespace Milito\ResponseGenerator\Test;

use Illuminate\Http\JsonResponse;
use Milito\ResponseGenerator\Facades\MilitoResponseGenerator;
use Milito\ResponseGenerator\States\Success\DataState;
use Milito\ResponseGenerator\States\Success\MessageState;
use Milito\ResponseGenerator\States\Success\SendState;
use Milito\ResponseGenerator\States\Success\SuccessState;

class SuccessStatesTest extends TestCase{
    /**
     * @test
     */
    public function success_state_test(){
        $state = MilitoResponseGenerator::success();
        $this->assertInstanceOf(SuccessState::class,$state);
    }
    /**
     * @test
     */
    public function code_state_test(){
        $state = MilitoResponseGenerator::success()->created();
        $this->assertInstanceOf(MessageState::class,$state);
    }
    /**
     * @test
     */
    public function message_state_test(){
        $state = MilitoResponseGenerator::success()->created()->message("test message");
        $this->assertInstanceOf(DataState::class,$state);
    }
    /**
     * @test
     */
    public function data_state_test(){
        $state = MilitoResponseGenerator::success()->created()->message("test message")->data(["data"]);
        $this->assertInstanceOf(SendState::class,$state);
    }
    /**
     * @test
     */
    public function send_state_test(){
        $state = MilitoResponseGenerator::success()->created()->message("test message")->send();
        $this->assertInstanceOf(JsonResponse::class,$state);
    }
    /**
     * @test
     */
    public function no_content_state_test(){
        $state = MilitoResponseGenerator::success()->updated();
        $this->assertInstanceOf(SendState::class,$state);
    }
}
