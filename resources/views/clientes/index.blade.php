@extends('layouts.app')

@section('contenido')

<h1 class="mb-4">Clientes</h1>

@if(auth()->user()->tienePermiso('crear_clientes'))
    <a href="{{ route('clientes.create') }}" class="btn btn-primary">Nuevo</a>
@endif

<table class="table table-bordered table-hover bg-white shadow">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        @foreach($clientes as $cliente)
        <tr>
            <td>{{ $cliente->id }}</td>
            <td>{{ $cliente->nombre }}</td>
            <td>{{ $cliente->correo }}</td>

            <td>
                @if(auth()->user()->tienePermiso('editar_clientes'))
                <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning btn-sm">Editar</a>
                @endif

                @if(auth()->user()->tienePermiso('eliminar_clientes'))
                <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Eliminar cliente?')">
                        Eliminar
                    </button>
                </form>
                @endif
                
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection