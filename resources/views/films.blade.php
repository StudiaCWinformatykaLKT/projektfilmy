@extends('layouts.lay')

@section('content')

<!-- Approach -->
<div class="mb-4 shadow card">
    <div class="py-3 card-header">
        <h6 class="m-0 font-weight-bold text-primary">Wyszukiwanie</h6>
    </div>
    <div class="card-body">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    
                
                    @if(isset($movies))
                    <ul>
                        @foreach($movies as $movie)
                            <li>
                            <a href="{{ route('movies.show', ['id' => $movie['id'], 'source' => $movie['source'] ?? 'local']) }}">
                            {{ $movie['title'] }} ({{ $movie['release_year'] }})
                            </a>
                            </li>
                        @endforeach
                    </ul>
                    @endif
                </div> 
            </div> 
        </div>
    </div>
</div>   

<div class="mb-4 shadow card">
    <div class="py-3 card-header">
        <h6 class="m-0 font-weight-bold text-primary">Tabela FILM</h6>
    </div>
    <div class="card-body">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Gatunek</th>
                                <th>Średnia</th>
                                <th>Ocena</th>
                                <th>Dodano przez</th>
                                <th>Rok premiery</th>
                                <th>Komentarz</th>
                                <th>Imange</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($movies as $movie)
                            <tr>
                            <td>{{ $movie['title'] ?? '' }}</td>
                            <td>{{ $movie['genre_ids'] ?? '' }}</td>
                            <td>{{ $movie['vote_average'] ?? '' }}</td>
                            <td>{{ $movie['vote_count'] ?? '' }}</td>
                            <td>{{ $movie['original_language'] ?? '' }}</td>
                            <td>{{ $movie['release_date'] ?? '' }}</td>
                            <td>{{ $movie['overview'] ?? '' }}</td>
                        <td>
                        @if(!empty($movie['poster_path']))
                        <img src="https://image.tmdb.org/t/p/w200{{ $movie['poster_path'] }}" alt="{{ $movie['title'] ?? '' }}" style="width: 100px;">
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

@endsection