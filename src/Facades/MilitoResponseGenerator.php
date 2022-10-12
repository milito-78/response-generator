<?php
namespace Milito\ResponseGenerator\Facades;

use Illuminate\Support\Facades\Facade;
use Milito\ResponseGenerator\States\Failed\FailedState;
use Milito\ResponseGenerator\States\Success\SuccessState;

/**
 * @method static SuccessState success()
 * @method static FailedState failed()
 *
 * @see \Milito\ResponseGenerator\MilitoResponseGenerator
 */
class MilitoResponseGenerator extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'militoresponsegenerator';
    }
}
