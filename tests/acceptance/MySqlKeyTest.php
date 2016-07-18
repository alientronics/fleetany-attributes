<?php

namespace Tests\MySql;

use Tests\AcceptanceKeyTestCase;

class MySqlKeyTest extends AcceptanceKeyTestCase
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
        $app['config']['database.driver'] = 'mysql';
        return $app;
    }
}
