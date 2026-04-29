@extends('layouts.app')

@section('contenido')

<h3 class="mb-4">Notificaciones</h3>

@forelse($notificaciones as $n)

<div class="card mb-3 shadow-sm p-3">

    <!-- TIPO -->
    <div>
        @switch($n->tipo)

            @case('transferencia_envio')
                <span class="badge bg-danger">Transferencia enviada</span>
                @break

            @case('transferencia_recibo')
                <span class="badge bg-success">Transferencia recibida</span>
                @break

            @case('deposito')
                <span class="badge bg-success">Depósito</span>
                @break

            @case('retiro')
                <span class="badge bg-danger">Retiro</span>
                @break

        @endswitch
    </div>

    <!-- MENSAJE -->
    <div class="mt-2">
        <strong>{{ $n->mensaje }}</strong>
    </div>

    <!-- FECHA -->
    <div class="text-muted mt-1">
        {{ $n->fecha_hora->format('d/m/Y H:i') }}
    </div>

</div>

@empty

<div class="alert alert-info">
    No tienes notificaciones
</div>

@endforelse

@endsection