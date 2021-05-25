<?php

use Illuminate\Database\Seeder;
use App\Http\Models\Pieza;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(Pieza::class)->times(5000)->create();
    }
}
