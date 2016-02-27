<?php

use Illuminate\Database\Seeder;
use App\Key;

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
        Key::create([ 
                'company_id' => '1',
                'entity_key' => 'vehicle',
                'description' => 'year',
                'type' => 'numeric',
            ]);
        Key::create([ 
                'company_id' => '1',
                'entity_key' => 'vehicle',
                'description' => 'brand',
                'type' => 'string',
            ]);
        Key::create([ 
                'company_id' => '1',
                'entity_key' => 'vehicle',
                'description' => 'hp',
                'type' => 'string',
            ]);
        
    }
}