<!DOCTYPE html>
<html>
<head>
    <title>{{ $movieData['title'] }}</title>
</head>
<body>
<h2>{{ $movieData['title'] }}</h2>
<p><strong>Overview:</strong> {{ $movieData['overview'] }}</p>
<p><strong>Release Date:</strong> {{ $movieData['release_date'] }}</p>
<p><strong>Runtime:</strong> {{ $movieData['runtime'] }} minutes</p>
<p><strong>Genres:</strong>
    @if(isset($movieData['genres']) && is_array($movieData['genres']))
        {{ implode(', ', array_column($movieData['genres'], 'name')) }}
    @endif
</p>
<p><strong>Rating:</strong> {{ $movieData['vote_average'] }}</p>
<p><strong>Production Companies:</strong>
    @if(isset($movieData['production_companies']) && is_array($movieData['production_companies']))
        {{ implode(', ', array_column($movieData['production_companies'], 'name')) }}
    @endif
</p>
@if(isset($movieData['poster_path']))
    <img src="https://image.tmdb.org/t/p/w500{{ $movieData['poster_path'] }}" alt="Poster">
@endif
</body>
</html>
