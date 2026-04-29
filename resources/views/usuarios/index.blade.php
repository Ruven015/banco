@extends('layouts.app')

@section('contenido')

<h2>Usuarios</h2>

<a href="{{ route('usuarios.create') }}" class="btn btn-primary mb-3">Nuevo</a>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Empleado</th>
        <th>Rol</th>
    </tr>

    @foreach($usuarios as $u)
    <tr>
        <td>{{ $u->id }}</td>
        <td>{{ $u->name }}</td>
        <td>{{ $u->email }}</td>
        <td>{{ $u->empleado->nombre ?? 'Sin empleado' }}</td>
        <td>{{ $u->rol->nombre ?? 'Sin rol' }}</td>
    </tr>
    @endforeach

</table>

@endsection