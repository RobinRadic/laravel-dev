<?php namespace Laradic\Dev\Traits;

use Laradic\BladeExtensions\BladeExtensionsServiceProvider;

/**
 * Adds functionality to test blade views in PHPUnit Tests
 *
 * @package        Laradic\BladeExtensions
 * @subpackage     Traits
 * @version        2.0.0
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright  (c) 2011-2014, Robin Radic - Radic Technologies
 * @link           http://robin.radic.nl/blade-extensions
 *
 */
trait BladeViewTestingTrait
{

    /**
     * The View factory's blade compiler
     *
     * @var \Illuminate\View\Compilers\BladeCompiler
     */
    protected $blade;

    /**
     * Adds all class methods prefixed with assert* as blade view directives
     * and assigns the $view and $blade class properties
     *
     * @param string $viewDirectoryPath The path to the directory containing test views
     */
    public function addBladeViewTesting($viewDirectoryPath = null)
    {
        /** @var \Illuminate\View\Factory $view */
        $view = $this->app['view'];

        // Add instance of current test class, this enable to call assert functions in views
        $view->share('testClassInstance', $this);

        // Lets make those assertions callable by fancy blade directives, nom nom nom
        $this->blade = $view->getEngineResolver()->resolve('blade')->getCompiler();

        $this->blade->extend(
            function ($value) {
                return preg_replace('/@assert(\w*)\((.*)\)/', "<?php \$testClassInstance->assert$1($2); ?>", $value);
            }
        );

        if ($viewDirectoryPath !== null) {
            $view->addLocation($viewDirectoryPath);
        }
    }

}
