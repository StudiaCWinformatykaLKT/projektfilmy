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
                                <h3>{{ $movie['title'] }}</h3>
                                <p><strong>Opis:</strong> {{ $movie['overview'] }}</p>
                                <p><strong>Data premiery:</strong> {{ $movie['release_date'] }}</p>
                                <p><strong>Średnia ocena:</strong> {{ $movie['vote_average'] }}</p>
                                <p><strong>Liczba głosów:</strong> {{ $movie['vote_count'] }}</p>
                                @if(isset($movie['poster_path']))
                                    <img src="https://image.tmdb.org/t/p/w200{{ $movie['poster_path'] }}" alt="{{ $movie['title'] }}">
                                @endif
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
                            @foreach($films as $film)
                            <tr>
                                <td>{{ $film->name }}</td>
                                <td>{{ $film->gatunek }}</td>
                                <td>{{ $film->srednia }}</td>
                                <td>{{ $film->ocena }}</td>
                                <td>{{ $film->dodanoprzez }}</td>
                                <td>{{ $film->rokpremiery }}</td>
                                <td>{{ $film->komentarz }}</td>
                                <td><img src="{{ $film->image }}" alt="{{ $film->name }}" style="width: 100px;"></td>
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