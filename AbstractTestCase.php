<?php namespace Laradic\Dev;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Laradic\Dev\Traits\HelperTestCaseTrait;
use Laradic\Dev\Traits\LaravelTestCaseTrait;


abstract class AbstractTestCase extends OrchestraTestCase
{
    use HelperTestCaseTrait, LaravelTestCaseTrait;

    /** @var array */
    public static $data;

    /**
     * @return DataGenerator
     */
    public static function getData()
    {
        if(!isset(static::$data))
        {
            static::$data = new DataGenerator();
        }
        return static::$data;
    }

    /** @inheritdoc */
    public function setUp()
    {
        parent::setUp();
    }

    /** Run an assert that always  */
    public function testMeOk()
    {
        $this->assertTrue(true);
    }

    /**
     * @return \Illuminate\Filesystem\Filesystem
     */
    protected function getFiles()
    {
        return $this->app->make('files');
    }

    /** @return \Illuminate\Config\Repository */
    protected function getConfig()
    {
        return $this->app->make('config');
    }

    /** @return \Illuminate\View\Factory */
    protected function getViews()
    {
        return $this->app->make('config');
    }

    /** @return \Illuminate\Contracts\Console\Kernel */
    protected function getKernel()
    {
        return $this->app->make('Illuminate\Contracts\Console\Kernel');
    }

    /**
     * Adds assertion directives to blade and removes cached views
     */
    protected function cleanViews()
    {
        $this->getFiles()->delete($this->getFiles()->glob(base_path('storage/framework/views') . '/*'));
    }

    /**
     * Executes a kernel command
     *
     * @param string $command
     */
    protected function command($command)
    {
        $this->getKernel()->call($command);
    }

    /**
     * Setup the application environment.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $config = $this->getConfig();
        $config->set('cache.driver', 'array');
        $config->set('database.default', 'sqlite');
        $config->set(
            'database.connections.sqlite',
            [
                'driver'   => 'sqlite',
                'database' => ':memory:',
                'prefix'   => '',
            ]
        );
        $config->set('mail.driver', 'log');
        $config->set('session.driver', 'array');


        $this->command('migrate');
        $app->make('mailer')->pretend(true);
    }
}
