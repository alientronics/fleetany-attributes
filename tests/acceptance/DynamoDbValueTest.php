<?php

namespace Tests\DynamoDb;

use Tests\AcceptanceValueTestCase;

class DynamoDbValueTest extends AcceptanceValueTestCase
{

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../bootstrap/app.php';
        $app['config']['database.driver'] = 'dynamodb';
        return $app;
    }
}
