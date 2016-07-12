<?php

namespace Tests\MongoDb;

use Tests\ValueTestCase;

class MongoDbEntityValueTest extends ValueTestCase
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
        return $app;
    }
}
