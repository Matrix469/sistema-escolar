@extends('jurado.layouts.app')

@section('content')
    <div class="container">
        <h1>Equipos</h1>
        <div class="row">
            @foreach ($equipo as $equipo)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $equipo->nombre }}</h5>
                            <p class="card-text">{{ $equipo->descripcion }}</p>
                            <!-- <a href="{{ route('jurado.equipos.show', $equipo) }}" class="btn btn-primary">Ver</a> -->
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
