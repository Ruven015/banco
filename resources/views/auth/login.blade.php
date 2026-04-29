<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="col-md-4 offset-md-4">

        <h3 class="text-center">Iniciar Sesión</h3>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <input type="email" name="email" class="form-control mb-2" placeholder="Email">

            <input type="password" name="password" class="form-control mb-2" placeholder="Contraseña">

            <button class="btn btn-primary w-100">Entrar</button>
        </form>

    </div>
</div>

</body>
</html>