@extends('layouts.lay')

@section('content')
    <!-- Sekcja wyszukiwania -->
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Wyszukiwanie</h6>
        </div>
        <div class="card-body">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        @if (isset($movies) && $movies->isNotEmpty())
                            <ul>
                                @foreach ($movies as $movie)
                                    <li>
                                        <a
                                            href="{{ route('movies.show', ['id' => $movie['id'], 'source' => $movie['source'] ?? 'local']) }}">
                                            {{ $movie['title'] }} ({{ $movie['release_year'] ?? 'brak danych' }})
                                        </a>

                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>Brak filmów do wyświetlenia</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela FILM wew (tylko jedna wersja) -->
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Tabela FILM wew</h6>
        </div>
        <div class="card-body">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTablewWew" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Gatunek</th>
                                    <th>Średnia</th>
                                    <th>Ocena</th>
                                    <th>Dodano przez</th>
                                    <th>Rok premiery</th>
                                    <th>Komentarz</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if ($moviesWew->isNotEmpty())
                                    <pre>
        {{ print_r(array_keys(get_object_vars($moviesWew->first())), true) }}
    </pre>
                                @endif
                                @foreach ($moviesWew as $movie)
                                    <tr>
                                        <td>
                                            <a
                                                href="{{ route('movies.show', ['id' => $movie->id, 'source' => $movie->source ?? 'wew']) }}">
                                                {{ $movie->title ?? '' }}
                                            </a>
                                        </td>
                                        <td>
                                            @if (is_array($movie->genre_ids))
                                                {{ implode(', ', $movie->genre_ids) }}
                                            @else
                                                {{ $movie->genre_ids ?? '' }}
                                            @endif
                                        </td>
                                        <td>{{ $movie->vote_average ?? '' }}</td>
                                        <td>{{ $movie->vote_count ?? '' }}</td>
                                        <td>{{ $movie->original_language ?? '' }}</td>
                                        <td>{{ $movie->release_date ?? '' }}</td>
                                        <td>{{ $movie->overview ?? '' }}</td>
                                        <td>
                                            @if (!empty($movie->poster_path))
                                                <img src="https://image.tmdb.org/t/p/w200{{ $movie->poster_path }}"
                                                    alt="{{ $movie->title ?? '' }}" style="width: 100px;">
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <canvas id="myChart"></canvas>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('myChart');
            if (ctx) {
                new Chart(ctx, {
                    // Konfiguracja wykresu
                });
            }
        });
    </script>

@endsection
