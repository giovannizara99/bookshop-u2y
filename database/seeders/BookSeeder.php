<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::query()->create(['title' => 'La Divina Commedia', 'subtitle' => null, 'publisher' => 'Aldine Press', 'description' => 'Un poema epico scritto da Dante Alighieri.']);
        Book::query()->create(['title' => 'I Promessi Sposi', 'subtitle' => null, 'publisher' => 'F. Colombo', 'description' => 'Un romanzo storico scritto da Alessandro Manzoni.']);
        Book::query()->create(['title' => 'I Malavoglia', 'subtitle' => null, 'publisher' => 'Treves', 'description' => 'Un romanzo scritto da Giovanni Verga.']);
        Book::query()->create(['title' => 'Il Barone Rampante', 'subtitle' => null, 'publisher' => 'Einaudi', 'description' => 'Un romanzo scritto da Italo Calvino.']);
        Book::query()->create(['title' => 'Il Nome della Rosa', 'subtitle' => null, 'publisher' => 'Bompiani', 'description' => 'Un romanzo storico scritto da Umberto Eco.']);
    }
}
