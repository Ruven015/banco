@extends('layouts.app')

@section('contenido')

<h1 class="mb-4">Tipos de Cuenta</h1>

<a href="{{ route('tipo-cuentas.create') }}" class="btn btn-primary mb-3">
    + Crear Tipo
</a>

<table class="table table-bordered table-hover bg-white shadow">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Saldo mínimo</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        @foreach($tipos as $tipo)
        <tr>
            <td>{{ $tipo->id }}</td>
            <td>{{ $tipo->nombre }}</td>
            <td>{{ $tipo->saldo_minimo }}</td>

            <td>
                <a href="{{ route('tipo-cuentas.edit', $tipo->id) }}" class="btn btn-warning btn-sm">
                    Editar
                </a>

                <form action="{{ route('tipo-cuentas.destroy', $tipo->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Eliminar tipo de cuenta?')">
                        Eliminar
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>

@endsection