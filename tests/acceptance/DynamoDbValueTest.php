<?php

namespace Tests\MongoDb;

use Tests\AcceptanceValueTestCase;

class MongoDbValueTest extends AcceptanceValueTestCase
{

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../bootstrap/app.php';
        $app['config']['database.default'] = 'dynamodb';
        return $app;
    }
}
