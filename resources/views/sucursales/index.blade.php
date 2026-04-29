@extends('layouts.app')

@section('contenido')

<h1 class="mb-4">Sucursales</h1>

<a href="{{ route('sucursales.create') }}" class="btn btn-primary mb-3">
    + Crear Sucursal
</a>

<table class="table table-bordered table-hover bg-white shadow">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Ciudad</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        @foreach($sucursales as $sucursal)
        <tr>
            <td>{{ $sucursal->id }}</td>
            <td>{{ $sucursal->nombre }}</td>
            <td>{{ $sucursal->ciudad }}</td>

            <td>
                <a href="{{ route('sucursales.edit', $sucursal->id) }}" class="btn btn-warning btn-sm">
                    Editar
                </a>

                <form action="{{ route('sucursales.destroy', $sucursal->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Eliminar sucursal?')">
                        Eliminar
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>

@endsection