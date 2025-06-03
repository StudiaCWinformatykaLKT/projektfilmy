@extends('layouts.lay')

@section('content')
    <!-- Approach -->
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Tabela user</h6>
        </div>
        <div class="card-body">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Email Verified At</th>
                                    <th>Password</th>
                                    <th>Remember Token</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->email_verified_at }}</td>
                                        <td>{{ $user->password }}</td>
                                        <td>{{ $user->remember_token }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>{{ $user->updated_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- Tabela Ulubionych Filmów Użytkowników -->
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Tabela Ulubionych Filmów (fav_user_movie)</h6>
        </div>
        <div class="card-body">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="favMoviesTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID Wpisu</th>
                                    <th>Nazwa Użytkownika</th>
                                    <th>Tytuł Filmu</th>
                                    <th>Ocena</th>
                                    <th>Data Dodania</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($favUserMovies) && $favUserMovies->count() > 0)
                                    @foreach ($favUserMovies as $fav)
                                        <tr>
                                            <td>{{ $fav->fav_id }}</td>
                                            <td>{{ $fav->user_name }}</td>
                                            <td>{{ $fav->movie_title }}</td>
                                            <td>{{ $fav->rating ?? 'Brak oceny' }}</td>
                                            <td>{{ $fav->fav_created_at }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">Brak danych o ulubionych filmach.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
