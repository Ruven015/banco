@extends('layouts.app')

@section('contenido')

<h1>Editar Sucursal</h1>

<form action="{{ route('sucursales.update', $sucursal->id) }}" method="POST" class="card p-4 shadow">
    @csrf
    @method('PUT')

    <input type="text" name="nombre" value="{{ $sucursal->nombre }}" class="form-control mb-2">
    <input type="text" name="direccion" value="{{ $sucursal->direccion }}" class="form-control mb-2">
    <input type="text" name="telefono" value="{{ $sucursal->telefono }}" class="form-control mb-2">
    <input type="text" name="ciudad" value="{{ $sucursal->ciudad }}" class="form-control mb-2">

    <button class="btn btn-success">Actualizar</button>
</form>

@endsection