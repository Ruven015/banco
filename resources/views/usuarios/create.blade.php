@extends('layouts.app')

@section('contenido')

<h2>Crear Usuario</h2>
@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
<form method="POST" action="{{ route('usuarios.store') }}">
    @csrf

    <input type="text" name="name" placeholder="Nombre" class="form-control mb-2">

    <input type="email" name="email" placeholder="Email" class="form-control mb-2">

    <input type="password" name="password" placeholder="Password" class="form-control mb-2">

  
   

    <!-- Rol -->
    <select name="rol_id" class="form-control mb-2">
        @foreach($roles as $rol)
            <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
        @endforeach
    </select>

    <button class="btn btn-success">Guardar</button>

</form>

@endsection