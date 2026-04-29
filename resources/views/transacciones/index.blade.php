@extends('layouts.app')

@section('contenido')

<h1>Transacciones</h1>

<table class="table">
    <tr>
        <th>Tipo</th>
        <th>Monto</th>
        <th>Origen</th>
        <th>Destino</th>
    </tr>

    @foreach($transacciones as $t)
    <tr>
        <td>{{ $t->tipo }}</td>
        <td>{{ $t->monto }}</td>
        <td>{{ $t->cuentaOrigen->numero_cuenta ?? '-' }}</td>
        <td>{{ $t->cuentaDestino->numero_cuenta ?? '-' }}</td>
    </tr>
    @endforeach

</table>

@endsection