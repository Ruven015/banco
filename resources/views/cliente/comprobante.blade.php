@extends('layouts.app')

@section('contenido')

<div class="card shadow p-4 mx-auto" style="max-width: 500px;">

    <h3 class="text-success text-center">✔ Transferencia exitosa</h3>

    <hr>

    <div class="mb-3">
        <strong>Folio:</strong>
        TX-{{ str_pad($transaccion->id, 6, '0', STR_PAD_LEFT) }}
    </div>

    <div class="mb-3">
        <strong>Fecha:</strong><br>
        {{ \Carbon\Carbon::parse($transaccion->fecha_hora)->format('d/m/Y H:i') }}
    </div>

    <div class="mb-3">
        <strong>Cuenta origen:</strong><br>
        {{ $cuentaOrigen->numero_cuenta }}
    </div>

    <div class="mb-3">
        <strong>Cuenta destino:</strong><br>
        {{ $cuentaDestino->numero_cuenta }}
    </div>

    <div class="mb-3">
        <strong>Monto:</strong><br>
        <span class="text-primary fs-4 fw-bold">
            ${{ number_format($transaccion->monto, 2) }}
        </span>
    </div>

    <hr>

    <div class="text-center">
        <a href="{{ route('cliente.dashboard') }}" class="btn btn-primary">
            Volver al inicio
        </a>
    </div>

</div>

@endsection