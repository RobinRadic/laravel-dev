<?php namespace Laradic\Dev\Traits;

use Laradic\Dev\Assert;
use ReflectionClass;

trait ServiceProviderTestCaseTrait
{
    /**
     * Get the service provider class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return string
     */
    abstract protected function getServiceProviderClass($app);

    public function testIsAServiceProvider()
    {
        $class = $this->getServiceProviderClass($this->app);

        $reflection = new ReflectionClass($class);

        $serviceprovider = new ReflectionClass('Illuminate\Support\ServiceProvider');

        $msg = "Expected class '$class' to be a service provider.";

        $this->assertTrue($reflection->isSubclassOf($serviceprovider), $msg);
    }

    public function testProvides()
    {
        $class = $this->getServiceProviderClass($this->app);
        $reflection = new ReflectionClass($class);

        $method = $reflection->getMethod('provides');
        $method->setAccessible(true);

        $msg = "Expected class '$class' to provide a valid list of services.";

        $this->assertInternalType('array', $method->invoke(new $class($this->app)), $msg);
    }

    public function runServiceProviderRegisterTest($class)
    {
        #Assert::type('string', $class,  'The service provider class has to be a string, for runServiceProviderRegisterTest');
        #$this->assertThat($class, \PHPUnit_Framework_Constraint_IsType::TYPE_STRING, 'The service provider class has to be a string, for runServiceProviderRegisterTest');

        $this->app->register($class);
        $providers = $this->app->getLoadedProviders();
        #var_dump($providers);

        $this->assertArrayHasKey($class, $providers);
        $this->assertTrue($providers[$class]);
    }
}
