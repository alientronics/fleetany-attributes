<?php

use Illuminate\Database\Seeder;
use App\Entities\MySql\KeyMySql;

class KeyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('keys')->delete();
        KeyMySql::create([ 
                'company_id' => '1',
                'entity_key' => 'vehicle',
                'description' => 'year',
                'type' => 'numeric',
            ]);
        KeyMySql::create([ 
                'company_id' => '1',
                'entity_key' => 'vehicle',
                'description' => 'brand',
                'type' => 'string',
            ]);
        KeyMySql::create([ 
                'company_id' => '1',
                'entity_key' => 'vehicle',
                'description' => 'hp',
                'type' => 'string',
            ]);
        KeyMySql::create([ 
                'company_id' => '1',
                'entity_key' => 'vehicle',
                'description' => 'doc',
                'type' => 'file',
            ]);
        
    }
}