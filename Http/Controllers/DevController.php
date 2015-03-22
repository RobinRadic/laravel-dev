<?php namespace Laradic\Dev\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Controller as BaseController;
use Barryvdh\Debugbar\LaravelDebugbar;
use ChromePhp;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Redirect;
use Response;
use View;

class DevController extends BaseController
{

    use DispatchesCommands, ValidatesRequests;

    /** @var \Illuminate\Contracts\Foundation\Application  */
    protected $app;

    function __construct(Application $app)
    {
        $this->app = $app;
    }


    /**
     * Show the root documentation page.
     *
     * @return Redirect
     */
    public function index()
    {

    }

    public function get()
    {
        /** @var \Barryvdh\Debugbar\LaravelDebugBar $debugbar */
        $debugbar = $this->app->make('debugbar');

        #$debugbar->
    }


}
