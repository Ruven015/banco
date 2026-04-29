@extends('layouts.app')

@section('contenido')

<h2>Mi Cuenta</h2>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif

<div class="card p-3 mb-3">
    <h5>{{ $cliente->nombre }} {{ $cliente->apellido_paterno }}</h5>
</div>

<div class="row">
    @foreach($cuentas as $c)
        <div class="col-md-4">
            <div class="card p-3 mb-3">
            <h6>
                <a href="{{ route('cliente.cuenta', $c->id) }}">
                    Cuenta: {{ $c->numero_cuenta }}
                </a>
            </h6>
                <h4>${{ $c->saldo }}</h4>
            </div>
        </div>
    @endforeach
</div>

<div class="card mt-4">
    <div class="card-header">Transferir dinero</div>

    <div class="card-body">
        <form method="POST" action="{{ route('cliente.transferir') }}">
            @csrf

            <!-- Cuenta origen -->
            <label>Cuenta origen</label>
            <select name="cuenta_origen_id" class="form-control mb-2">
                @foreach($cuentas as $c)
                    <option value="{{ $c->id }}">
                        {{ $c->numero_cuenta }} (${{ $c->saldo }})
                    </option>
                @endforeach
            </select>

            <!-- Cuenta destino -->
            <label>Cuenta destino</label>
<input type="text" name="numero_cuenta_destino" class="form-control mb-2" required>

            <!-- Monto -->
            <label>Monto</label>
            <input type="number" name="monto" class="form-control mb-2" min="1" required>

            <button class="btn btn-primary">Transferir</button>
        </form>
    </div>
</div>

<div class="row mt-4">

    <!-- DEPÓSITO -->
    <div class="col-md-6">
        <div class="card p-3">
            <h5>Depositar</h5>

            <form method="POST" action="{{ route('cliente.depositar') }}">
                @csrf

                <select name="cuenta_id" class="form-control mb-2">
                    @foreach($cuentas as $c)
                        <option value="{{ $c->id }}">
                            {{ $c->numero_cuenta }}
                        </option>
                    @endforeach
                </select>

                <input type="number" name="monto" class="form-control mb-2" min="1" required>

                <button class="btn btn-success">Depositar</button>
            </form>
        </div>
    </div>

    <!-- RETIRO -->
    <div class="col-md-6">
        <div class="card p-3">
            <h5>Retirar</h5>

            <form method="POST" action="{{ route('cliente.retirar') }}">
                @csrf

                <select name="cuenta_id" class="form-control mb-2">
                    @foreach($cuentas as $c)
                        <option value="{{ $c->id }}">
                            {{ $c->numero_cuenta }}
                        </option>
                    @endforeach
                </select>

                <input type="number" name="monto" class="form-control mb-2" min="1" required>

                <button class="btn btn-danger">Retirar</button>
            </form>
        </div>
    </div>

</div>

<div class="card">
    <div class="card-header">Movimientos recientes</div>

    <div class="card p-3 mb-3">
    <h4>Saldo actual:</h4>
    <h2 class="text-primary">
    @php
    $saldoTotal = $cuentas->sum('saldo');
@endphp

<div class="card p-3 mb-3">
    <h4>Saldo total:</h4>
    <h2 class="text-primary">
        ${{ number_format($saldoTotal, 2) }}
    </h2>
</div>
    </h2>
</div>

    <table class="table table-striped">
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
                <!-- TIPO -->
                <td>
                    @if($t->tipo_movimiento == 'ingreso')
                        <span class="badge bg-success">Ingreso</span>
                    @else
                        <span class="badge bg-danger">Egreso</span>
                    @endif
                </td>

                <!-- MONTO -->
                <td>
                    @if($t->tipo_movimiento == 'ingreso')
                        <span class="text-success fw-bold">
                            +${{ number_format($t->monto, 2) }}
                        </span>
                    @else
                        <span class="text-danger fw-bold">
                            -${{ number_format($t->monto, 2) }}
                        </span>
                    @endif
                </td>

                

                <!-- FECHA -->
                <td>
                    {{ \Carbon\Carbon::parse($t->fecha_hora)->format('d/m/Y H:i') }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">
                    Sin movimientos
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>

@endsection