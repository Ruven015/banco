@extends('layouts.app')

@section('contenido')

    <h1 class="mb-4">Crear Cliente</h1>

    <form action="{{ route('clientes.store') }}" method="POST" class="card p-4 shadow">
        @csrf

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control">
        </div>

        <div class="mb-3">
            <label>Apellido Paterno</label>
            <input type="text" name="apellido_paterno" class="form-control">
        </div>

        <div class="mb-3">
            <label>Apellido Materno</label>
            <input type="text" name="apellido_materno" class="form-control">
        </div>

        <div class="mb-3">
            <label>CURP</label>
            <input type="text" name="curp" class="form-control">
        </div>

        <div class="mb-3">
            <label>Correo</label>
            <input type="email" name="correo" class="form-control">
        </div>

        <div class="mb-3">
            <label>Dirección</label>
            <input type="text" name="direccion" class="form-control">
        </div>

        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control">
        </div>
        
        <div class="mb-3">
            <label>Usuario Vinculado</label>

            <select name="user_id" class="form-control">
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}">
                        {{ $usuario->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Fecha Nacimiento</label>
            <input type="date" name="fecha_nacimiento" class="form-control">
        </div>

        <button class="btn btn-success">Guardar</button>

        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
            Volver
        </a>

    </form>

</div>

</body>
</html>