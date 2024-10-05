<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Categoría</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('https://www.orientacionandujar.es/wp-content/uploads/2020/08/fondos-para-clases-virtuales-1.jpg') no-repeat center center fixed;
            background-size: cover;
            background-position: center;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.8); /* Fondo blanco con opacidad */
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 500px;
            margin: 0 auto;
            margin-top: 50px; /* Espacio superior para centrar verticalmente */
        }

        .form-container h2 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 1.5em;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 1em;
            color: #333;
            margin-bottom: 5px;
        }

        .form-group input, .form-group select {
            width: calc(100% - 70px); /* Ajustar el ancho para el texto y el sufijo */
            padding: 8px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 4px;
            display: inline-block;
        }

        .form-group .suffix {
            display: inline-block;
            font-size: 1em;
            padding: 8px;
            border: 1px solid #ccc;
            border-left: none;
            border-radius: 0 4px 4px 0;
            background-color: #f0f0f0;
            color: #333;
            line-height: 1.5em;
            vertical-align: top;
        }

        .btn-submit, .btn-cancel {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            color: #fff;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: inline-block;
            margin-top: 10px;
        }

        .btn-submit {
            background-color: #28a745;
        }

        .btn-submit:hover {
            background-color: #218838;
        }

        .btn-cancel {
            background-color: #dc3545;
            margin-left: 10px;
        }

        .btn-cancel:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Crear Categoría</h2>
        <form action="{{ route('categorias.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="hrs_trabajo">Horas de Trabajo</label>
                <input type="text" id="hrs_trabajo" name="hrs_trabajo" required>
                <span class="suffix">hrs</span>
            </div>
            <div class="form-group">
                <label for="dias_libres">Días Libres</label>
                <input type="text" id="dias_libres" name="dias_libres">
            </div>
            <button type="submit" class="btn-submit">Guardar</button>
            <a href="{{ route('categorias.index') }}" class="btn-cancel">Cancelar</a>
        </form>
    </div>
</body>
</html>
