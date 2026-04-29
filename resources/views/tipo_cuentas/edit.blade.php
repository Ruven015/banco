@extends('layouts.app')

@section('contenido')

<h1>Editar Tipo de Cuenta</h1>

<form action="{{ route('tipo-cuentas.update', $tipo->id) }}" method="POST" class="card p-4 shadow">
    @csrf
    @method('PUT')

    <input type="text" name="nombre" value="{{ $tipo->nombre }}" class="form-control mb-2">
    <input type="number" name="saldo_minimo" value="{{ $tipo->saldo_minimo }}" class="form-control mb-2">
    <input type="number" name="comision_manejo" value="{{ $tipo->comision_manejo }}" class="form-control mb-2">
    <input type="number" name="limite_retiro" value="{{ $tipo->limite_retiro }}" class="form-control mb-2">

    <button class="btn btn-success">Actualizar</button>
</form>

@endsection