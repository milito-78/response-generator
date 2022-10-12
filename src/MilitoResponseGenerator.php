<?php
namespace Milito\ResponseGenerator;

class MilitoResponseGenerator
{
    public function success()
    {
        return $this->start("success");
    }

    public function failed()
    {
        return $this->start("failed");
    }

    private function start(string $type)
    {
        return Factory::create($type);
    }
}
