<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form method="post" action="/auth">
        <input type="text" name="username" id="username" placeholder="Username" required>
        <br>
        <input type="password" name="password" id="password" placeholder="Paswsword" required>
        <br>
        <input type="submit" value="submit">
    </form>
</body>
</html>