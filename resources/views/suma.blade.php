<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Suma de 2 numeros</title>
</head>
<body>
    
    <form action="/suma" method="post">
        @csrf
        <h2>numero 1</h2>
        <input type="number" name="num1" id="num1" required>
        <h2>numero 2</h2>
        <input type="number" name="num2" id="num2" required>
        <br>
        <button type="submit">Sumar</button>
    </form>
</body>
</html>