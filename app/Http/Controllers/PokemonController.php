<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Pool;

class PokemonController extends Controller
{
    // Función principal: obtiene los Pokémon y envía los datos a la vista
    public function index()
    {
        $pokemons = $this->getPokemons();

        return view('index', compact('pokemons'));
    }

    // Obtiene la lista de los primeros 20 Pokémon
    private function getPokemons()
    {
        $response = Http::get(
            'https://pokeapi.co/api/v2/pokemon?limit=20'
        );

        // Comprobamos que la petición haya funcionado
        if ($response->failed()) {
            abort(502, 'No se ha podido conectar con PokéAPI');
        }

        $data = $response->json();
        $pokemons = [];

        // Recorremos la lista y completamos los datos de cada Pokémon
        foreach ($data['results'] as $pokemon) {
            $pokemonData = $this->getPokemonData($pokemon['url']);

            // Si no hemos podido obtener los datos, lo saltamos
            if ($pokemonData === null) {
                continue;
            }

            $id = $pokemonData['id'];

            $pokemons[] = [
                'id' => $id,
                'name' => ucfirst($pokemonData['name']),
                'image' => $this->getPokemonImage($id),
                'description' => $this->getPokemonDescription($id),
            ];
        }

        return $pokemons;
    }

    // Obtiene los datos de un Pokémon usando la URL que nos da la API
    private function getPokemonData($url)
    {
        $response = Http::get($url);

        if ($response->failed()) {
            return null;
        }

        return $response->json();
    }

    // Construye la URL de la imagen a partir del número del Pokémon
    private function getPokemonImage($id)
    {
        return 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/'
            . $id . '.png';
    }

    // Obtiene la descripción en español de un Pokémon
    private function getPokemonDescription($id)
    {
        $url = 'https://pokeapi.co/api/v2/pokemon-species/' . $id;

        $response = Http::get($url);

        // Si falla la petición, devolvemos una descripción por defecto
        if ($response->failed()) {
            return 'No hay descripción disponible.';
        }

        $descriptions = $response->json('flavor_text_entries', []);

        // Buscamos la primera descripción que esté en español
        foreach ($descriptions as $entry) {
            if ($entry['language']['name'] === 'es') {
                return $this->cleanDescription($entry['flavor_text']);
            }
        }

        return 'No hay descripción disponible en español.';
    }

    // Limpia los saltos de línea que aparecen en algunas descripciones
    private function cleanDescription($description)
    {
        return str_replace(
            ["\n", "\r", "\f"],
            ' ',
            $description
        );
    }
}