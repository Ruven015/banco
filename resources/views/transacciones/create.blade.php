@extends('layouts.app')

@section('contenido')

<h1>Realizar Transacción</h1>

<form action="/transacciones/store" method="POST" class="card p-4 shadow">
    @csrf

    <!-- Tipo -->
    <label>Tipo</label>
    <select name="tipo" id="tipo" class="form-control mb-2" onchange="toggleDestino()">
        <option value="deposito">Depósito</option>
        <option value="retiro">Retiro</option>
        <option value="transferencia">Transferencia</option>
    </select>

    <!-- Monto -->
    <label>Monto</label>
    <input type="number" name="monto" class="form-control mb-2" placeholder="Monto" required min="1">

    <!-- Cuenta origen -->
    <label>Cuenta Origen</label>
    <select name="cuenta_origen_id" class="form-control mb-2" required>
        @foreach($cuentas as $c)
            <option value="{{ $c->id }}">{{ $c->numero_cuenta }}</option>
        @endforeach
    </select>

    <!-- Cuenta destino -->
    <div id="destinoDiv">
        <label>Cuenta Destino</label>
        <select name="cuenta_destino_id" class="form-control mb-2">
            <option value="">(Solo transferencia)</option>
            @foreach($cuentas as $c)
                <option value="{{ $c->id }}">{{ $c->numero_cuenta }}</option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-success">Ejecutar</button>
</form>

<script>
function toggleDestino() {
    let tipo = document.getElementById('tipo').value;
    let destinoDiv = document.getElementById('destinoDiv');

    if (tipo === 'transferencia') {
        destinoDiv.style.display = 'block';
    } else {
        destinoDiv.style.display = 'none';
    }
}

// Ejecutar al cargar
window.onload = toggleDestino;
</script>

@endsection