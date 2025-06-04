@extends('layouts.lay')

@section('content')
    @auth
        {{-- Sekcja danych użytkownika --}}
        <div class="mb-4 shadow card">
            <div class="py-3 card-header">
                <h6 class="m-0 font-weight-bold text-primary">Mój Profil</h6>
            </div>
            <div class="card-body">
                <p><strong>Nazwa użytkownika:</strong> {{ Auth::user()->name }}</p>
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                @if(Auth::user()->created_at)
                    <p><strong>Data dołączenia:</strong> {{ Auth::user()->created_at->format('d-m-Y H:i') }}</p>
                @endif
            </div>
        </div>

        {{-- Sekcja ulubionych filmów i ocen --}}
        <div class="mb-4 shadow card">
            <div class="py-3 card-header">
                <h6 class="m-0 font-weight-bold text-primary">Moje Ulubione Filmy i Oceny</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="userFavoritesTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tytuł Filmu</th>
                                <th>Moja Ocena</th>
                                
                                <th>Link do Filmu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($userFavorites) && $userFavorites->count() > 0)
                                @foreach ($userFavorites as $favorite)
                                    <tr>
                                        <td>{{ $favorite->movie_title }}</td>
                                        <td>{{ $favorite->rating ?? 'Brak oceny' }}</td>
                                        <td>
                                            <a href="{{ route('movies.show', ['id' => $favorite->movie_id, 'source' => 'local']) }}" class="btn btn-sm btn-info">
                                                Szczegóły Filmu
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">Nie masz jeszcze polubionych ani ocenionych filmów.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning text-center">
            Musisz być zalogowany, aby zobaczyć swój profil. <a href="{{ route('login') }}">Zaloguj się</a>.
        </div>
    @endauth
@endsection