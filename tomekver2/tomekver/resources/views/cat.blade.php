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
                                <th>id</th>
                                <th>created</th>
                                <th>url</th>
         
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cats as $cats)
                            <tr>
                                <td>{{ $cats->id }}</td>
                                <td>{{ $cats->created_at }}</td>
                                <td>{{ $cats->url }}</td>                             
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