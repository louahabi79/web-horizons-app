<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Post</title>
</head>
<body>
    <h1>Create a New Post</h1>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <form action="{{ route('user.createPoste.submit') }}" method="POST">
        @csrf
        Title: <input type="text" name="title"><br>
        Article: <textarea name="article"></textarea><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
