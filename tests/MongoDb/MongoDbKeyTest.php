<?php

namespace Tests\MongoDb;

use Tests\KeyTestCase;

class MongoDbKeyTest extends KeyTestCase
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
