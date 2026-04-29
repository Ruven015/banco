@extends('layouts.app')

@section('contenido')

<h1>Crear Sucursal</h1>

<form action="{{ route('sucursales.store') }}" method="POST" class="card p-4 shadow">
    @csrf

    <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre">
    <input type="text" name="direccion" class="form-control mb-2" placeholder="Dirección">
    <input type="text" name="telefono" class="form-control mb-2" placeholder="Teléfono">
    <input type="text" name="ciudad" class="form-control mb-2" placeholder="Ciudad">

    <button class="btn btn-success">Guardar</button>
</form>

@endsection