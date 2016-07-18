<?php

namespace Tests\MongoDb;

use Tests\AcceptanceKeyTestCase;

class MongoDbKeyTest extends AcceptanceKeyTestCase
{

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../bootstrap/app.php';
        $app['config']['database.default'] = 'mongodb';
        $app['config']['database.driver'] = 'mongodb';
        return $app;
    }
}
