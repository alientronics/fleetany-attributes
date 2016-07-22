<?php

namespace Tests\DynamoDb;

use Tests\AcceptanceKeyTestCase;

class DynamoDbKeyTest extends AcceptanceKeyTestCase
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
        if(!empty($data)) {
            foreach($data as $index => $element) {
                if(is_numeric($element)) {
                    $data[$index] = (int) $element;
                }
            }
        }
        
        $entity = $this->getEntity();
        $Key = $entity::where($data);
        $Key = $Key->get()->first();
        
        if (!empty($Key)) {
            return sprintf(
                'Found unexpected records in database table [%s] that matched attributes [%s].',
                $table,
                json_encode($data)
            );
        } else {
            return true;
        }
    }
}
