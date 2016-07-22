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
    
    /**
     * Assert that a given where condition matches a soft deleted record
     *
     * @param  string $table
     * @param  array  $data
     * @param  string $connection
     * @return $this
     */
    protected function seeIsSoftDeletedInDatabase($table, array $data, $connection = null)
    {
        $entity = $this->getEntity();
        $register = $entity::find($data['id']);
        $count = !empty($register->deleted_at) ? 0 : 1;
    
        $this->assertGreaterThan(0, $count, sprintf(
            'Found unexpected records in database table [%s] that matched attributes [%s].',
            $table,
            json_encode($data)
            ));
    
        return $this;
    }
}
