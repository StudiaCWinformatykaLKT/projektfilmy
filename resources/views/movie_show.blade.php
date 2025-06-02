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
            <form action="{{ route('movies.addToLocal') }}" method="POST" style="display:inline;">
                @csrf
                <input type="hidden" name="movie" value="{{ htmlentities(json_encode((array) $movie)) }}">
                <br><br>
                <button type="submit" class="btn btn-success" style="padding:10px; margin-left:20px;">Dodaj film do
                    bazy</button>
            </form><br><br>
        @endif
    </div>
@endsection
