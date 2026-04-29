@extends('layouts.app')

@section('contenido')

    <h1 class="mb-4">Editar Cliente</h1>

    <form action="{{ route('clientes.update', $cliente->id) }}" method="POST" class="card p-4 shadow">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ $cliente->nombre }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Apellido Paterno</label>
            <input type="text" name="apellido_paterno" value="{{ $cliente->apellido_paterno }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Apellido Materno</label>
            <input type="text" name="apellido_materno" value="{{ $cliente->apellido_materno }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>CURP</label>
            <input type="text" name="curp" value="{{ $cliente->curp }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Correo</label>
            <input type="email" name="correo" value="{{ $cliente->correo }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Dirección</label>
            <input type="text" name="direccion" value="{{ $cliente->direccion }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="telefono" value="{{ $cliente->telefono }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Fecha Nacimiento</label>
            <input type="date" name="fecha_nacimiento" value="{{ $cliente->fecha_nacimiento }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Activo</label><br>
            <input type="checkbox" name="estatus" value="1" 
                {{ $cliente->estatus ? 'checked' : '' }}>
        </div>

        <button class="btn btn-success">Actualizar</button>

        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
            Volver
        </a>

    </form>

</div>

</body>
