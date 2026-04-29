@extends('layouts.app')

@section('contenido')
<select name="user_id" class="form-select">
    <option value="">-- Sin usuario --</option>

    @foreach($usuarios as $u)
        <option value="{{ $u->id }}"
            {{ old('user_id', $empleado->user_id ?? '') == $u->id ? 'selected' : '' }}>
            {{ $u->name }} ({{ $u->email }})
        </option>
    @endforeach
</select>
@endsection