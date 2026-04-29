@extends('layouts.app')

@section('contenido')

<h1 class="mb-4">Empleados</h1>

<a href="{{ route('empleados.create') }}" class="btn btn-primary mb-3">
    + Crear Empleado
</a>

<table class="table table-bordered table-hover bg-white shadow">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Puesto</th>
            <th>Sucursal</th>
            <th>Usuario</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        @foreach($empleados as $emp)
        <tr>
            <td>{{ $emp->id }}</td>
            <td>{{ $emp->nombre }}</td>
            <td>{{ $emp->puesto }}</td>
            <td>{{ $emp->sucursal->nombre }}</td>
            <td>{{ optional($emp->user)->email ?? 'Sin usuario' }}</td>

            <td>
                <a href="{{ route('empleados.edit', $emp->id) }}" class="btn btn-warning btn-sm">Editar</a>

                <form action="{{ route('empleados.destroy', $emp->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar empleado?')">
                        Eliminar
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection