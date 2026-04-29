@extends('layouts.app')

@section('contenido')

<h2 class="mb-4">Dashboard</h2>
<div class="row mb-4">

    <div class="col-md-3">
        <div class="card p-3 text-center shadow-sm">
            <h6>Clientes</h6>
            <h3>{{ $clientes }}</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 text-center shadow-sm">
            <h6>Cuentas</h6>
            <h3>{{ $cuentas }}</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 text-center shadow-sm">
            <h6>Empleados</h6>
            <h3>{{ $empleados }}</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 text-center shadow-sm bg-success text-white">
            <h6>Dinero en banco</h6>
            <h3>${{ number_format($total_dinero, 2) }}</h3>
        </div>
    </div>

</div>
@if($cuentas_bajas > 0)
    <div class="alert alert-warning">
        ⚠️ Hay {{ $cuentas_bajas }} cuentas con saldo menor a $100
    </div>
@endif


<div class="card shadow-sm">
    <div class="card-header">
        Últimas Transacciones
    </div>

    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Monto</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transacciones as $t)
                    <tr>
                        <td>
                            @if($t->tipo == 'deposito')
                                <span class="badge bg-success">Depósito</span>
                            @elseif($t->tipo == 'retiro')
                                <span class="badge bg-danger">Retiro</span>
                            @else
                                <span class="badge bg-primary">Transferencia</span>
                            @endif
                        </td>
                        <td>${{ $t->monto }}</td>
                        <td>{{ $t->fecha_hora }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Sin transacciones</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card shadow-sm mt-4">
    <div class="card-header">
        Actividad de Transacciones
    </div>

    <div class="card-body">
        <canvas id="graficaTransacciones" height="120"></canvas>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const data = @json($transacciones_por_dia);

    const labels = data.map(item => item.fecha);
    const valores = data.map(item => item.total);

    const canvas = document.getElementById('graficaTransacciones');

    if (!canvas) {
        console.log("Canvas no encontrado");
        return;
    }

    const ctx = canvas.getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Transacciones por día',
                data: valores,
                borderWidth: 2,
                tension: 0.3,
                fill: true,
                pointRadius: 5
            }]
        }
    });

});
</script>

@endsection