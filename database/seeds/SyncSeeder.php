<?php

use Illuminate\Database\Seeder;
use App\Modules\User\Database\Seeds\PermissionsTableSeeder;
use App\Modules\User\Database\Seeds\ConnectRelationshipsSeeder;

class SyncSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $this->call(PermissionsTableSeeder::class);
       $this->call(ConnectRelationshipsSeeder::class);
    }
}
