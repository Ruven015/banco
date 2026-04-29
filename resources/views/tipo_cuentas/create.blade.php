@extends('layouts.app')

@section('contenido')

<h1>Crear Tipo de Cuenta</h1>

<form action="{{ route('tipo-cuentas.store') }}" method="POST" class="card p-4 shadow">
    @csrf

    <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre">
    <input type="number" name="saldo_minimo" class="form-control mb-2" placeholder="Saldo mínimo">
    <input type="number" name="comision_manejo" class="form-control mb-2" placeholder="Comisión">
    <input type="number" name="limite_retiro" class="form-control mb-2" placeholder="Límite retiro">

    <button class="btn btn-success">Guardar</button>
</form>

@endsection