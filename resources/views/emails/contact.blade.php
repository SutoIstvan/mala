<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajánlatkérés</title>
</head>
<body>
    <h1>Új üzenet az ajánlatkérés űrlapról</h1>
    <p><strong>Név:</strong> {{ $data['name'] }} {{ $data['surname'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Rövid leírása, üzenet:</strong> {{ $data['message'] }}</p>
</body>
</html>
