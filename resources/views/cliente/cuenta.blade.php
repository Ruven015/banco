@extends('layouts.app')

@section('contenido')

<h2>Cuenta {{ $cuenta->numero_cuenta }}</h2>

<div class="card p-3 mb-3">
    <h4>Saldo: ${{ number_format($cuenta->saldo, 2) }}</h4>
</div>

<div class="card">
    <div class="card-header">Movimientos</div>

    <form method="GET" class="row mb-3">

    <div class="col-md-4">
        <label>Desde</label>
        <input type="date" name="desde" class="form-control"
            value="{{ request('desde') }}">
    </div>

    <div class="col-md-4">
        <label>Hasta</label>
        <input type="date" name="hasta" class="form-control"
            value="{{ request('hasta') }}">
    </div>

    <div class="col-md-4 d-flex align-items-end">
        <button class="btn btn-primary w-100">Filtrar</button>
    </div>

</form>

    <table class="table">
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

        <!-- ✅ TIPO -->
        <td>
            @if($t->tipo_movimiento == 'ingreso')
                <span class="badge bg-success">Ingreso</span>
            @else
                <span class="badge bg-danger">Egreso</span>
            @endif
        </td>

        <!-- ✅ MONTO -->
        <td>
            @if($t->tipo_movimiento == 'ingreso')
                <span class="text-success">+${{ number_format($t->monto, 2) }}</span>
            @else
                <span class="text-danger">-${{ number_format($t->monto, 2) }}</span>
            @endif
        </td>

        <!-- ✅ FECHA -->
        <td>{{ $t->fecha_hora }}</td>

    </tr>
@empty
    <tr>
        <td colspan="3" class="text-center">
            Sin movimientos
        </td>
    </tr>
@endforelse
</tbody>
    </table>
</div>

@endsection