<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
</head>
<body>
    <h1>Welcome to the User Dashboard</h1>
    <p>You are logged in as a user.</p>

    <form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
    <a href="{{route("createPoste.submit")}}"></a>
</form>
</body>
</html>
