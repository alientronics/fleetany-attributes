<?php

class TestCase extends Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
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
        $database = $this->app->make('db');
    
        $connection = $connection ?: $database->getDefaultConnection();
    
        $count = $database->connection($connection)
            ->table($table)
            ->where($data)
            ->whereNotNull('deleted_at')
            ->count();
    
        $this->assertGreaterThan(0, $count, sprintf(
            'Found unexpected records in database table [%s] that matched attributes [%s].',
            $table,
            json_encode($data)
        ));
    
        return $this;
    }
}
