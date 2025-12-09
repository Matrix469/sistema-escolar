<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }
        
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .header img {
            margin-right: 10px;
        }
        
        .header-text {
            font-size: 16px;
            font-weight: bold;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        th {
            background-color: #f2f2f2;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logito.png') }}" width="50" height="50" alt="Logo">
        <span class="header-text">Instituto Tecnológico de Oaxaca<br>Reporte de Equipos</span>
    </div>

    <div style="text-align: center; margin-bottom: 15px;">
        <strong>Fecha de Generación:</strong> {{ date('d/m/Y') }} <br>
        <strong>Periodo:</strong> {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Nombre Equipo</th>
                <th>Eventos Inscritos</th>
                <th>Fecha Creación</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @if($equipos->count() > 0)
                @foreach($equipos as $equipo)
                    <tr>
                        <td>{{ $equipo->nombre }}</td>
                        <td>
                            @foreach($equipo->inscripciones as $inscripcion)
                                {{ $inscripcion->evento->nombre ?? '' }}@if(!$loop->last), @endif
                            @endforeach
                        </td>
                        <td>{{ $equipo->created_at ? $equipo->created_at->format('d/m/Y') : 'N/A' }}</td>
                        <td>{{ $equipo->descripcion }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" style="text-align: center;">En este periodo no se registró ningún equipo.</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
