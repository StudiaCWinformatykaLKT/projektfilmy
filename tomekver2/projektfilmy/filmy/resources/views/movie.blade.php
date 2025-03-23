<!DOCTYPE html>
<html>
<head>
    <title>{{ $movieData['title'] ?? 'Movie Details' }}</title>
</head>
<body>
<h2>{{ $movieData['title'] }}</h2>
<p><strong>Overview:</strong> {{ $movieData['overview'] }}</p>
<p><strong>Release Date:</strong> {{ $movieData['release_date'] }}</p>
<p><strong>Runtime:</strong> {{ $movieData['runtime'] }} minutes</p>
<p><strong>Genres:</strong>
    {{ implode(', ', array_column($movieData['genres'] ?? [], 'name')) }}
</p>
<p><strong>Rating:</strong> {{ $movieData['vote_average'] }}</p>
<p><strong>Production Companies:</strong>
    {{ implode(', ', array_column($movieData['production_companies'] ?? [], 'name')) }}
</p>

@if(isset($movieData['poster_path']))
    <img src="{{ $imageBaseUrl . $movieData['poster_path'] }}" alt="Poster">
@endif
</body>
</html>
