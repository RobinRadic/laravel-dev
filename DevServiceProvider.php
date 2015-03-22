<?php namespace Laradic\Dev;

use App;
use Config;
use DebugBar\DebugBar;
use Illuminate\Foundation\AliasLoader;
use Laradic\Dev\Console\IdeHelperGeneratorCommand;
use Log;
use Laradic\Support\ServiceProvider;

class DevServiceProvider extends ServiceProvider
{

    /** @inheritdoc */
    protected $configFiles = ['radic_dev'];

    /** @inheritdoc */
    protected $dir = __DIR__;

    /** @inheritdoc */
    public function boot()
    {
        parent::boot();
    }


    /** @inheritdoc */
    public function register()
    {
        parent::register();


        if(Config::get('radic_dev.provide.console'))
        {
            $this->app->register('Laradic\Dev\Providers\ConsoleServiceProvider');
        }

        if(Config::get('radic_dev.provide.route'))
        {
            $this->app->register('Laradic\Dev\Providers\RouteServiceProvider');
        }

        # @todo implement debug ajax

    }
}
