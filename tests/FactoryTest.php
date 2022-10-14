<?php

namespace Milito\ResponseGenerator\Test;

use Milito\ResponseGenerator\Exceptions\InvalidResponseTypeException;
use Milito\ResponseGenerator\Factory;
use Milito\ResponseGenerator\States\Failed\FailedState;
use Milito\ResponseGenerator\States\Success\SuccessState;

class FactoryTest extends TestCase{
    /**
     *  @test
    */
    public function factory_create_success_response_test(){
        $object = Factory::create("success");
        $this->assertInstanceOf(SuccessState::class,$object);
    }

    /**
     *  @test
    */
     public function factory_create_failed_response_test(){
        $object = Factory::create("failed");
        $this->assertInstanceOf(FailedState::class,$object);
    }

    /**
     *  @test
    */
     public function factory_invalid_type_test_test(){
        $this->expectException(InvalidResponseTypeException::class);
        Factory::create("invalid");
    }
}
