
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pokédex | Mis Pokémon</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #f4f6f9;
        }

        .hero {
            background: linear-gradient(135deg, #dc3545, #a71d2a);
            color: white;
            padding: 3rem 1rem;
            border-radius: 0 0 2rem 2rem;
        }

        .pokemon-card {
            border: none;
            border-radius: 1rem;
            overflow: hidden;
            transition: transform 0.2s ease,
                        box-shadow 0.2s ease;
            height: 100%;
        }

        .pokemon-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.12);
        }

        .pokemon-image {
            height: 180px;
            width: 100%;
            object-fit: contain;
            padding: 1rem;
            background: #f8f9fa;
        }

        .pokemon-number {
            color: #6c757d;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .pokemon-name {
            font-weight: 700;
            text-transform: capitalize;
        }
    </style>
</head>

<body>

    <header class="hero text-center shadow-sm">
        <div class="container">
            <h1 class="display-4 fw-bold">Pokédex</h1>

            <p class="lead mb-0">
                Descubre los primeros 20 Pokémon
            </p>
        </div>
    </header>

    <main class="container py-5">

        <div class="d-flex justify-content-between
                    align-items-center mb-4">
            <h2 class="h4 fw-bold mb-0">
                Lista de Pokémon
            </h2>

            <span class="badge text-bg-danger rounded-pill">
                {{ count($pokemons) }} Pokémon
            </span>
        </div>

        <div class="row row-cols-1 row-cols-sm-2
                    row-cols-lg-3 row-cols-xl-4 g-4">

            @foreach ($pokemons as $pokemon)
                <div class="col">
                    <article class="card pokemon-card shadow-sm">

                        <div class="position-relative">
                            <span class="badge text-bg-secondary
                                         position-absolute top-0
                                         start-0 m-3">
                                #{{ str_pad($pokemon['id'], 3, '0', STR_PAD_LEFT) }}
                            </span>

                            <img
                                src="{{ $pokemon['image'] }}"
                                class="pokemon-image"
                                alt="{{ $pokemon['name'] }}"
                                loading="lazy"
                            >
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h3 class="h5 pokemon-name mb-3">
                                {{ $pokemon['name'] }}
                            </h3>

                            <p class="card-text text-secondary mb-0">
                                {{ $pokemon['description'] }}
                            </p>
                        </div>

                    </article>
                </div>
            @endforeach

        </div>
    </main>

    <footer class="text-center text-secondary py-4">
        <small>Datos proporcionados por PokéAPI</small>
    </footer>

</body>
</html>
