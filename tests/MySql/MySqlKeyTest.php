<?php

namespace Tests\MySql;

use Tests\KeyTestCase;

class MySqlKeyTest extends KeyTestCase
{

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../bootstrap/app.php';
        $app['config']['database.default'] = 'mysql';
        return $app;
    }
}
