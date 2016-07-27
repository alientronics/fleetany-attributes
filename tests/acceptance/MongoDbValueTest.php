<?php

namespace Tests\MongoDb;

use Tests\AcceptanceValueTestCase;
use App\Entities\MongoDb\ValueMongoDb;

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
        $app['config']['database.default'] = 'mongodb';
        $app['config']['database.driver'] = 'mongodb';
        return $app;
    }

    /**
     * Assert that a given where condition exists in the database.
     *
     * @param  string  $table
     * @param  array  $data
     * @param  string|null $onConnection
     * @return $this
     */
    protected function seeInDatabase($table, array $data, $onConnection = null)
    {
        $Value = ValueMongoDb::where($data)->get();
        
        if (empty($Value)) {
            return sprintf(
                'Unable to find row in database table [%s] that matched attributes [%s].',
                $table,
                json_encode($data)
            );
        } else {
            return true;
        }
    }
}
