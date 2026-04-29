@extends('layouts.app')

@section('contenido')

<h1>Crear Cuenta</h1>

<form action="{{ route('cuentas.store') }}" method="POST" class="card p-4 shadow">
    @csrf

    <input type="text" name="numero_cuenta" class="form-control mb-2" placeholder="Número de cuenta">
    <input type="number" name="saldo" class="form-control mb-2" placeholder="Saldo inicial">

    <!-- CLIENTE -->
    <select name="cliente_id" class="form-control mb-2">
        <option value="">Selecciona cliente</option>
        @foreach($clientes as $c)
            <option value="{{ $c->id }}">{{ $c->nombre }}</option>
        @endforeach
    </select>

    <!-- TIPO -->
    <select name="tipo_cuenta_id" class="form-control mb-2">
        <option value="">Selecciona tipo</option>
        @foreach($tipos as $t)
            <option value="{{ $t->id }}">{{ $t->nombre }}</option>
        @endforeach
    </select>

    <!-- SUCURSAL -->
    <select name="sucursal_id" class="form-control mb-2">
        <option value="">Selecciona sucursal</option>
        @foreach($sucursales as $s)
            <option value="{{ $s->id }}">{{ $s->nombre }}</option>
        @endforeach
    </select>

    <button class="btn btn-success">Guardar</button>

</form>

@endsection