@extends('layouts.app')

@section('contenido')

<h1>Editar Cuenta</h1>

<form action="{{ route('cuentas.update', $cuenta->id) }}" method="POST" class="card p-4 shadow">
    @csrf
    @method('PUT')

    <input type="text" name="numero_cuenta" value="{{ $cuenta->numero_cuenta }}" class="form-control mb-2">
    <input type="number" name="saldo" value="{{ $cuenta->saldo }}" class="form-control mb-2">

    <!-- CLIENTE -->
    <select name="cliente_id" class="form-control mb-2">
        @foreach($clientes as $c)
            <option value="{{ $c->id }}" {{ $cuenta->cliente_id == $c->id ? 'selected' : '' }}>
                {{ $c->nombre }}
            </option>
        @endforeach
    </select>

    <!-- TIPO -->
    <select name="tipo_cuenta_id" class="form-control mb-2">
        @foreach($tipos as $t)
            <option value="{{ $t->id }}" {{ $cuenta->tipo_cuenta_id == $t->id ? 'selected' : '' }}>
                {{ $t->nombre }}
            </option>
        @endforeach
    </select>

    <!-- SUCURSAL -->
    <select name="sucursal_id" class="form-control mb-2">
        @foreach($sucursales as $s)
            <option value="{{ $s->id }}" {{ $cuenta->sucursal_id == $s->id ? 'selected' : '' }}>
                {{ $s->nombre }}
            </option>
        @endforeach
    </select>

    <button class="btn btn-success">Actualizar</button>

    <a href="{{ route('cuentas.index') }}" class="btn btn-secondary">Volver</a>

</form>

@endsection