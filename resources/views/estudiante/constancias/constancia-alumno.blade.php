//Estructura de la constancia para alumnos
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constancia</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
        @page {
            margin: 3cm 2.5cm;
        }
        body {
            font-family: 'Poppins', sans-serif;
            text-align: justify;
        }
        .header {
            position: fixed;
            top: -2.5cm;
            left: -2.0cm;
            right: -2.0cm;
            text-align: center;
        }
        .header img {
            width: 100px;
            float: left;
        }
        .header h6 {
            float: right;
        }
        .content {
            text-align: justify;
        }

        .content h1 {
            text-align: center;
        }

        .footer {
            position: fixed;
            bottom: -2.5cm;
            left: -2.0cm;
            right: -2.0cm;
            text-align: center;
            font-size: 8px;
        }

    </style>
</head>
<body>
    <div class="header">
        <img src="{{public_path('images/logito.png')}}" alt="Logo">
        <h6>Instituto Tecnológico de Oaxaca</h6>
    </div>
    <div class="content">
        <h1>Constancia</h1>
        <p>El estudiante {{$user->nombre}} {{ $user->app_paterno}} {{ $user->app_materno}} con número de control {{ $estudiante->numero_control}} ha participado en el evento "{{ $evento->nombre}}" con fecha de inicio {{ ($evento->fecha_inicio)->format('d/m/Y')}} y concluido el {{ ($evento->fecha_fin)->format('d/m/Y')}}.</p>
    </div>
    <div class="footer">
        <p>Servicios Escolares</p>
    </div>
</body>
</html>