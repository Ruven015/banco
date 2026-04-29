@extends('layouts.app')

@section('contenido')

<h1>Crear Empleado</h1>

<form action="{{ route('empleados.store') }}" method="POST" class="card p-4 shadow">
    @csrf

    <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre">
    <input type="text" name="apellidos" class="form-control mb-2" placeholder="Apellidos">
    <input type="text" name="puesto" class="form-control mb-2" placeholder="Puesto">

    <!-- SELECT SUCURSAL -->
    <select name="sucursal_id" class="form-select" required>
    <option value="">-- Selecciona una sucursal --</option>

    @foreach($sucursales as $s)
        <option value="{{ $s->id }}"
            {{ old('sucursal_id', $empleado->sucursal_id ?? '') == $s->id ? 'selected' : '' }}>
            {{ $s->nombre }}
        </option>
    @endforeach
</select>

    
    

    <button class="btn btn-success">Guardar</button>

</form>

@endsection