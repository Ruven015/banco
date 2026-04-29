@extends('layouts.app')

@section('contenido')

<form action="{{ route('empleados.update', $empleado->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Asignar Usuario</label>
        <select name="user_id" class="form-select">
            <option value="">-- Sin usuario --</option>

            @foreach($usuarios as $u)
                <option value="{{ $u->id }}"
                    {{ old('user_id', $empleado->user_id ?? '') == $u->id ? 'selected' : '' }}>
                    {{ $u->name }} ({{ $u->email }})
                </option>
            @endforeach
        </select>
    </div>

    <!-- 🔥 BOTONES -->
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">
            Guardar
        </button>

        <a href="{{ route('empleados.index') }}" class="btn btn-secondary">
            Regresar
        </a>
    </div>

</form>

@endsection