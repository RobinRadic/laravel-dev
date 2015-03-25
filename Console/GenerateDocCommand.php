<?php namespace Laradic\Dev\Console;

use Laradic\Support\AbstractConsoleCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class GenerateDocCommand extends AbstractConsoleCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'dev:generatedoc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->generateMethodsFromClasses(['Underscore\Methods\StringMethods', 'Stringy\Stringy']);
    }

    protected function generateMethodsFromClasses($classes)
    {
        $names       = [];
        $skipMethods = ['__construct', '__toString', '__get', '__set', '__call', '__callStatic'];
        #$classes = ['Stringy\Stringy', 'Underscore\Types\String'];
        foreach ($classes as $class)
        {
            $reflector = new \ReflectionClass($class);
            foreach ($reflector->getMethods() as $m)
            {
                $methodName = $m->getName();
                if ( in_array($methodName, $skipMethods) or in_array($methodName, $names) )
                {
                    continue;
                }
                $names[]    = $methodName;
                $params     = $m->getParameters();
                $paramCount = $m->getNumberOfParameters();
                $parameters = [];
                for ($i = 0; $i < $paramCount; $i++)
                {
                    $parameters[] = '$' . $params[$i]->getName(); #  . $params[$i]->getDeclaringClass()->getShortName();

                }
                $docParams = '';

                if ( $paramCount > 0 )
                {
                    $docParams = '(' . join(',', $parameters) . ')';
                }
                #$this->line(' * @method ' . $methodName . $docParams);
                $this->line(' * @method static mixed ' . $methodName . $docParams);
            }
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            # ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            # ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
