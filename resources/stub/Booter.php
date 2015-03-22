<?php

use Illuminate\Contracts\Foundation\Application;
use Laradic\Support\Path;

class Booter
{

    /** @var \Illuminate\Foundation\Application */
    protected static $app;
    protected static $tempDir;


    /** @return \Illuminate\Foundation\Application */
    public static function create($baseDir, $tempDir)
    {
        require $baseDir . '/bootstrap/autoload.php';

        $app = require_once $baseDir . '/bootstrap/app.php';

        $app->bind('path.public', function () use ($baseDir)
        {
            return $baseDir . '/public';
        });

        $app->bind('path.base', function () use ($baseDir)
        {
            return $baseDir;
        });


        $app->bind('path.storage', function () use ($tempDir)
        {
            return $tempDir;
        });



        $kernel = $app->make('Illuminate\Contracts\Http\Kernel');

        $response = $kernel->handle(
            $request = Illuminate\Http\Request::capture()
        );



        /** @var \Illuminate\Filesystem\Filesystem $fs */
        $fs = $app->make('Illuminate\Filesystem\Filesystem');

        $fs->makeDirectory($tempDir, 0777, true);

        $makedirs = ['app', 'framework/cache', 'framework/sessions', 'framework/views', 'logs'];
        foreach($makedirs as $d)
        {
            $fs->makeDirectory(Path::join($tempDir, $d), 0777, true);
        }

        $dbPath = Path::join($tempDir, 'database.sqlite');

        $fs->put($dbPath, '');
        $app->config->set('cache.driver', 'file');
        $app->config->set('database.default', 'sqlite');
        $app->config->set(
            'database.connections.sqlite',
            [
                'driver'   => 'sqlite',
                'database' => $dbPath,
                'prefix'   => '',
            ]
        );
        $app->config->set('mail.driver', 'log');
        $app->config->set('session.driver', 'file');

        //
        // MIGRATE
        //
        /** @var \Illuminate\Database\Migrations\Migrator $mg */
        $mg = $app->make('migrator');

        $mg->setConnection('sqlite');
        $mgr = $mg->getRepository();
        $mgr->setSource('sqlite');
        $mgr->createRepository();
        $mg->run($baseDir.'/database/migrations');

        static::$tempDir = $tempDir;
        return static::$app =$app;
    }

    public static function destroy()
    {
        $app = static::$app;
        $tempDir = static::$tempDir;

        /** @var \Illuminate\Filesystem\Filesystem $fs */
        $fs = $app->make('files');

        $app->terminate();

        if ( $fs->isDirectory($tempDir) )
        {
            $fs->deleteDirectory($tempDir);
        }
    }
}
