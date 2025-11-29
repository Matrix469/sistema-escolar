# Script para arreglar todos los layouts
$files = @(
    "resources\views\estudiante\eventos\show.blade.php",
    "resources\views\estudiante\equipos\create.blade.php",
    "resources\views\estudiante\equipos\edit.blade.php",
    "resources\views\estudiante\equipo\show.blade.php",
    "resources\views\estudiante\equipos\index.blade.php",
    "resources\views\estudiante\equipos\show.blade.php",
    "resources\views\jurado\dashboard.blade.php",
    "resources\views\admin\dashboard.blade.php",
    "resources\views\admin\equipos\index.blade.php",
    "resources\views\admin\users\edit.blade.php",
    "resources\views\admin\eventos\create.blade.php",
    "resources\views\admin\eventos\asignar-jurados.blade.php",
    "resources\views\admin\users\index.blade.php",
    "resources\views\admin\eventos\edit.blade.php",
    "resources\views\admin\equipos\show.blade.php",
    "resources\views\admin\eventos\show.blade.php",
    "resources\views\admin\eventos\index.blade.php",
    "resources\views\profile\edit.blade.php"
)

foreach ($file in $files) {
    if (Test-Path $file) {
        Write-Host "Procesando: $file"
        $content = Get-Content $file -Raw -Encoding UTF8
        
        # Reemplazar apertura
        $content = $content -replace '(?s)<x-app-layout>\s*<x-slot name="header">\s*<h2[^>]*>([^<]+)</h2>\s*</x-slot>\s*<div class="py-12">\s*<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">', "@extends('layouts.app')`r`n`r`n@section('content')`r`n<div class=`"py-12`">`r`n    <div class=`"max-w-7xl mx-auto sm:px-6 lg:px-8`">`r`n        <h2 class=`"font-semibold text-xl text-gray-800 mb-6`">`$1</h2>"
        
        # Reemplazar cierre
        $content = $content -replace '</x-app-layout>', '@endsection'
        
        # Guardar
        Set-Content -Path $file -Value $content -Encoding UTF8 -NoNewline
        Write-Host "✓ Arreglado: $file"
    } else {
        Write-Host "✗ No existe: $file" -ForegroundColor Yellow
    }
}

Write-Host "`n✅ Proceso completado" -ForegroundColor Green
