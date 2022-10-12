<?php
namespace Milito\ResponseGenerator\Facades;

use Illuminate\Support\Facades\Facade;

class MilitoResponseGenerator extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'militoresponsegenerator';
    }
}
