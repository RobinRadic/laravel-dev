<?php namespace Laradic\Dev\Providers;

use Laradic\Console\AggregateConsoleProvider;

class ConsoleServiceProvider extends AggregateConsoleProvider
{
    protected $namespace = 'Laradic\Dev\Console';
    protected $commands = [
        'Dev' => 'commands.laradic.dev',
        'GenerateDoc' => 'commands.laradic.generatedoc'
    ];
}
