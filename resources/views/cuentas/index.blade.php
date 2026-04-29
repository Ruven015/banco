@extends('layouts.app')

@section('contenido')

<h1 class="mb-4">Cuentas</h1>

<a href="{{ route('cuentas.create') }}" class="btn btn-primary mb-3">
    + Crear Cuenta
</a>

<table class="table table-bordered table-hover bg-white shadow">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Número</th>
            <th>Cliente</th>
            <th>Tipo</th>
            <th>Sucursal</th>
            <th>Saldo</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        @foreach($cuentas as $c)
        <tr>
            <td>{{ $c->id }}</td>
            <td>{{ $c->numero_cuenta }}</td>
            <td>{{ $c->cliente->nombre }}</td>
            <td>{{ $c->tipoCuenta->nombre }}</td>
            <td>{{ $c->sucursal->nombre }}</td>
            <td>{{ $c->saldo }}</td>

            <td>
                <a href="{{ route('cuentas.edit', $c->id) }}" class="btn btn-warning btn-sm">Editar</a>

                <form action="{{ route('cuentas.destroy', $c->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar cuenta?')">
                        Eliminar
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>

@endsection