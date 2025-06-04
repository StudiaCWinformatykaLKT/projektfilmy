@extends('layouts.lay')

@section('content')
    <div class="mb-4 shadow card">
        <div class="container mt-4">
            <h2>{{ data_get($movie, 'title', 'Brak tytułu') }}</h2>
            <p><strong>Rok premiery:</strong> {{ data_get($movie, 'release_date', 'brak danych') }}</p>
            <p><strong>Opis:</strong> {{ data_get($movie, 'overview', 'brak opisu') }}</p>
            {{-- Wyświetlanie statystyk ocen --}}

            @if (!empty(data_get($movie, 'poster_path')))
                <img src="https://image.tmdb.org/t/p/w300{{ data_get($movie, 'poster_path') }}"
                    alt="{{ data_get($movie, 'title', '') }}">
            @endif
            <br><br>
            @if (isset($ratingStats) && $ratingStats->rating_count > 0)
                <p>
                    <strong>Średnia ocena użytkowników KITTY MOVIES:</strong>
                    {{ number_format($ratingStats->average_rating, 1) }} (na podstawie {{ $ratingStats->rating_count }}
                    ocen)
                </p>
            @endif
        </div>


        @if ($source === 'api')
            @if ($movieExistsInLocalDb)
                <div class="alert alert-info" style="margin: 20px;">
                    Ten film już istnieje w bazie danych Kitty movies. Kliknięcie przycisku poniżej zaktualizuje jego
                    dane.
                </div>
            @else
                <div class="alert alert-light" style="margin: 20px;">
                    Możesz dodać ten film do swojej lokalnej bazy danych.
                </div>
            @endif
            {{-- Przycisk dodania/aktualizacji w bazie - widoczny tylko dla zalogowanych --}}
            @auth
                <!-- Kontener na przyciski -->
                <div style="margin-left: 20px;">
                    <form action="{{ route('movies.addToLocal') }}" method="POST"
                        style="display: inline-block; margin-right: 10px; vertical-align: top;">
                        @csrf
                        <input type="hidden" name="movie" value="{{ htmlentities(json_encode((array) $movie)) }}">
                        {{-- Usunięto margin-left z przycisku, ponieważ kontener div ma już margin-left --}}
                        <button type="submit" class="btn btn-{{ $movieExistsInLocalDb ? 'warning' : 'success' }}"
                            style="padding:10px;">
                            {{ $movieExistsInLocalDb ? 'Aktualizuj film w bazie' : 'Dodaj film do bazy' }}
                        </button>
                    </form>
            @endauth
                    {{-- Nowy przycisk do przeglądania filmu w lokalnej bazie --}}
                    @if ($movieExistsInLocalDb && isset($localMovieId) && $localMovieId)
                        <a href="{{ route('movies.show', $localMovieId) }}" class="btn btn-info"
                            style="padding:10px; display: inline-block; vertical-align: top;">
                            Zobacz w lokalnej bazie
                        </a>
                    @endif
                </div>
            
        @endif {{-- Koniec bloku dla $source === 'api' --}}

        {{-- Sekcja Ulubionych i Oceniania - TYLKO DLA WIDOKU LOKALNEGO --}}
        @if ($source === 'local')
            @auth
                @if (isset($movie_id_for_actions) && $movie_id_for_actions)
                    <div
                        style="margin-top: 20px; margin-left: 20px; padding-bottom: 20px; border-top: 1px solid #e3e6f0; padding-top:20px;">
                        <h5 class="text-primary">Twoje Akcje dla tego Filmu:</h5>

                        @if ($currentUserFavorite)
                            {{-- Formularz do Usunięcia z Ulubionych --}}
                            <form action="{{ route('movies.removeFromFavorites') }}" method="POST"
                                style="display: inline-block; margin-right: 10px; vertical-align: top;">
                                @csrf
                                <input type="hidden" name="movie_id" value="{{ $movie_id_for_actions }}">
                                <button type="submit" class="btn btn-danger" style="padding:10px;">
                                    <i class="fas fa-heart-broken"></i> Usuń z ulubionych
                                </button>
                            </form>
                        @else
                            {{-- Formularz do Dodania do Ulubionych (bez natychmiastowej oceny) --}}
                            <form action="{{ route('movies.rateOrFavorite') }}" method="POST"
                                style="display: inline-block; margin-right: 10px; vertical-align: top;">
                                @csrf
                                <input type="hidden" name="movie_id" value="{{ $movie_id_for_actions }}">

                                <button type="submit" class="btn btn-primary" style="padding:10px;">
                                    <i class="fas fa-heart"></i> Dodaj do ulubionych
                                </button>
                            </form>
                        @endif

                        {{-- Formularz do Oceniania --}}
                        <form action="{{ route('movies.rateOrFavorite') }}" method="POST"
                            style="display: inline-block; vertical-align: top; margin-top: 10px;">
                            @csrf
                            <input type="hidden" name="movie_id" value="{{ $movie_id_for_actions }}">
                            <input type="hidden" name="rating_action" value="1"> {{-- Sygnalizuje, że kliknięto przycisk oceny --}}

                            <label for="rating" style="display: block; margin-bottom: 5px;">
                                <strong>Oceń film</strong> (Twoja ocena: {{ $currentUserFavorite->rating ?? 'Brak' }}):
                            </label>
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="submit" name="rating" value="{{ $i }}"
                                    class="btn btn-sm {{ $currentUserFavorite && $currentUserFavorite->rating == $i ? 'btn-warning fas fa-star' : 'btn-outline-warning far fa-star' }}"
                                    style="margin-right: 5px; min-width: 40px;">
                                    {{ $i }}
                                </button>
                            @endfor
                            @if ($currentUserFavorite && $currentUserFavorite->rating)
                                <button type="submit" name="rating" value="" class="btn btn-sm btn-outline-secondary"
                                    title="Usuń ocenę"><i class="fas fa-times-circle"></i> Usuń ocenę</button>
                            @endif
                        </form>
                    </div>
                @endif {{-- Koniec bloku @if (isset($movie_id_for_actions) && $movie_id_for_actions) --}}
            @endauth
        @endif {{-- Koniec bloku dla $source === 'local' --}}
        <br><br>
    </div>
@endsection
