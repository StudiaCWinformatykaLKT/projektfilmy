@extends('layouts.lay')

@section('content')

    <!-- Tabela FILM wew (tylko jedna wersja) -->
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Baza danych Kitty movies</h6>
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
                                    <th>Opis filmu</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{--  filmy zapisane jako obiekty 
                                @if ($moviesWew->isNotEmpty())
                                <pre>
                                {{ print_r(array_keys(get_object_vars($moviesWew->first())), true) }}
                                </pre>
                                @endif --}}


                                {{-- Debug: Sprawdź wartość zmiennej $movie (termin wyszukiwania)
                                <p style="color: red; font-weight: bold;">Debug: Wartość $movies:
                                    '{{ var_export($movies ?? 'NULL lub nieustawiona', true) }}'</p>
                                <p style="color: red; font-weight: bold;">Debug: Czy $movies jest puste po trim?:
                                    {{ empty(trim($movies ?? '')) ? 'Tak' : 'Nie' }}</p>
                                <p style="color: red; font-weight: bold;">Debug: Oryginalny termin wyszukiwania ($movies):
                                    '{{ var_export($movies ?? 'NULL lub nieustawiona', true) }}'</p>
                                --}}
                               @php
                                    $searchTermForWew = $movies;
                                    $foundInWew = false;
                                    $searchTermForWew = $movies;
                                    if (isset($movies) && $movies->isNotEmpty()) {
                                        $firstApiResult = $movies->first();
                                        if ($firstApiResult && !empty($firstApiResult['title'])) {
                                            $searchTermForWew = $firstApiResult['title'];
                                        }
                                    }
                                @endphp
                                @foreach ($moviesWew as $item)
                                    @if (empty(trim($searchTermForWew ?? '')) ||
                                            (isset($item->title) && str_contains(strtolower($item->title), strtolower(trim($searchTermForWew ?? '')))))
                                        @php $foundInWew = true; @endphp
                                        <tr>
                                            <td>
                                                <a
                                                    href="{{ route('movies.show', ['id' => $item->id, 'source' => $item->source ?? 'local']) }}">
                                                    {{ $item->title ?? '' }}
                                                </a>
                                            </td>
                                            <td>
                                                @if (is_array($item->genre_ids))
                                                    {{ implode(', ', $item->genre_ids) }}
                                                @else
                                                    {{ $item->genre_ids ?? '' }}
                                                @endif
                                            </td>
                                            <td>{{ $item->vote_average ?? '' }}</td>
                                            <td>{{ $item->vote_count ?? '' }}</td>
                                            <td>{{ $item->original_language ?? '' }}</td>
                                            <td>{{ $item->release_date ?? '' }}</td>
                                            <td>{{ $item->overview ?? '' }}</td>
                                            <td>
                                                @if (!empty($item->poster_path))
                                                    <img src="https://image.tmdb.org/t/p/w200{{ $item->poster_path }}"
                                                        alt="{{ $item->title ?? '' }}" style="width: 100px;">
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                                @if (!$foundInWew && !empty(trim($searchTermForWew ?? '')))
                                    <tr>
                                        <td colspan="8" class="text-center">Nie znaleziono filmu o takiej nazwie w wew.
                                            bazie danych.</td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Sekcja wyszukiwania -->
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Filmy z bazy zewnętrznej</h6>
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
    {{-- blok wykresy dla layputu strony   
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
    </script> --}}

@endsection
