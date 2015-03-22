<?php

namespace Laradic\Dev;

use Illuminate\Foundation\Application;
use Laradic\Support\Str;

abstract class AbstractTestPackage
{
    protected $app;
    protected $destroyed = false;
    function __construct(Application $app)
    {
        $this->app = $app;

        foreach(get_class_methods($this) as $method)
        {
            if($this->destroyed) break;


            if(Str::startsWith($method, 'test')){
                $this->$method();
            }
        }
    }

    function destroy()
    {
        $this->destroyed = true;
        \Booter::destroy();
    }
}
