<?php

namespace Dansrocks\Slimpoc\Service;

class Configuration
{
    private String $appName;

    public function __construct(String $appName)
    {
        $this->appName = $appName;
    }

    public function getHost() : String
    {
        return $_SERVER['HTTP_HOST'];
    }

    public function getAppName() : String
    {
        return $this->appName;
    }
}