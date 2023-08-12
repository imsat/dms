<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
        .form-signin {
            max-width: 330px;
            padding: 1rem;
        }
    </style>

</head>
<body>
<div class="container-fluid">
    <div class="row">
        <main class="form-signin w-100 m-auto">
            <form action="{{ route('auth.login') }}" method="post">
                @csrf
                <div class="text-center">
                    <img class="mb-4" src="https://lh3.googleusercontent.com/p/AF1QipPBUzkWOOdGaqIO9PrOrukjN_tNUx-kzYg8CF6z=s680-w680-h510" alt="" width="72" height="57">
                </div>
                <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

                <div class="form-floating">
                    <input type="text" class="form-control" name="username" id="floatingInput" placeholder="User name">
                    <label for="floatingInput">User Name</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password" value="password">
                    <label for="floatingPassword">Password</label>
                </div>

                <button class="btn btn-primary w-100 py-2 my-3" type="submit">Sign in</button>
            </form>
    </div>
</div>
</body>
</html>
