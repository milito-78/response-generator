<?php
namespace Milito\ResponseGenerator\Test;

use Milito\ResponseGenerator\MilitoResponseGenerator;

class TestCase extends  \Orchestra\Testbench\TestCase{
    public function setUp(): void
    {
      parent::setUp();
      // additional setup
    }

    protected function getPackageProviders($app)
    {
      return [
        MilitoResponseGenerator::class,
      ];
    }

    protected function getEnvironmentSetUp($app)
    {
      // perform environment setup
    }
}
