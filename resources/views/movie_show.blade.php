@extends('layouts.lay')

@section('content')
    <div class="mb-4 shadow card">
        <div class="container mt-4">
            <h2>{{ data_get($movie, 'title', 'Brak tytułu') }}</h2>
            <p><strong>Rok premiery:</strong> {{ data_get($movie, 'release_date', 'brak danych') }}</p>
            <p><strong>Opis:</strong> {{ data_get($movie, 'overview', 'brak opisu') }}</p>
            @if (!empty(data_get($movie, 'poster_path')))
                <img src="https://image.tmdb.org/t/p/w300{{ data_get($movie, 'poster_path') }}"
                    alt="{{ data_get($movie, 'title', '') }}">
            @endif
        </div>


        @if ($source === 'api')
            @if ($movieExistsInLocalDb)
                <div class="alert alert-info" style="margin: 20px;">
                    Ten film już istnieje w Twojej lokalnej bazie danych. Kliknięcie przycisku poniżej zaktualizuje jego
                    dane.
                </div>
            @else
                <div class="alert alert-light" style="margin: 20px;">
                    Możesz dodać ten film do swojej lokalnej bazy danych.
                </div>
            @endif
            <form action="{{ route('movies.addToLocal') }}" method="POST" style="display:inline;">
                @csrf
                <input type="hidden" name="movie" value="{{ htmlentities(json_encode((array) $movie)) }}">
                <br><br>
                <button type="submit" class="btn btn-{{ $movieExistsInLocalDb ? 'warning' : 'success' }}"
                    style="padding:10px; margin-left:20px;">
                    {{ $movieExistsInLocalDb ? 'Aktualizuj film w bazie' : 'Dodaj film do bazy' }}</button>
            </form><br><br>
        @endif
    </div>
@endsection
