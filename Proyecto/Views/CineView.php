<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="./css/AddCineView.css">
    <title>Document</title>
</head>
<body>
    
    <div class="wrapper">
        <form action="../Controllers/CineController.php" method="POST" class="form">
            <div class="input-fields-list">
                <input type="text" name="name" placeholder="Nombre..." class="input-field">
                <input type="text" name="adress" placeholder="Dirección..." class="input-field">
                <input type="number" name="capacity" placeholder="Capacidad..." class="input-field">
                <input type="number" name="price" placeholder="Valor único de entrada..." class="input-field">
                <div class="buttons">
                <button type="submit" class="btn">Aceptar</button>
                <button type="" class="btn">Cancelar</button>
                </div>
                
            </div>
        </form>
    </div>

</body>
</html>