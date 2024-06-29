<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Author::query()->create(['firstname' => 'Dante', 'lastname' => 'Alighieri']);
        Author::query()->create(['firstname' => 'Alessandro', 'lastname' => 'Manzoni']);
        Author::query()->create(['firstname' => 'Giovanni', 'lastname' => 'Verga']);
        Author::query()->create(['firstname' => 'Italo', 'lastname' => 'Calvino']);
        Author::query()->create(['firstname' => 'Umberto', 'lastname' => 'Eco']);
    }
}
