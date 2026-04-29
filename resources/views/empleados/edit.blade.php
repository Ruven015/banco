<select name="sucursal_id">
    @foreach($sucursales as $s)
        <option value="{{ $s->id }}" {{ $empleado->sucursal_id == $s->id ? 'selected' : '' }}>
            {{ $s->nombre }}
        </option>
    @endforeach
</select>