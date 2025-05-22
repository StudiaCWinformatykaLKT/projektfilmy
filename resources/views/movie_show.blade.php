@extends('layouts.lay')

@section('content')
    <div class="container mt-4">
        <h2>{{ $movie['title'] ?? ($movie->title ?? 'Brak tytułu') }}</h2>
        <p><strong>Rok premiery:</strong> {{ $movie['release_date'] ?? ($movie->release_date ?? 'brak danych') }}</p>
        <p><strong>Opis:</strong> {{ $movie['overview'] ?? ($movie->overview ?? 'brak opisu') }}</p>
        @if (!empty($movie['poster_path']))
            <img src="https://image.tmdb.org/t/p/w300{{ $movie['poster_path'] }}" alt="{{ $movie['title'] ?? '' }}">
        @endif
    </div>


    @if ($source === 'api')
        <form action="{{ route('movies.addToLocal') }}" method="POST" style="display:inline;">
            @csrf
            <input type="hidden" name="movie" value="{{ htmlentities(json_encode($movie)) }}">
            <button type="submit" class="btn btn-success">Dodaj film do bazy</button>
        </form><br><br>
    @endif
@endsection
