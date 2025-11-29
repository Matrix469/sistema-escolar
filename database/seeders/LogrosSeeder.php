<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LogrosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $logros = [
            // Logros de Participación
            [
                'nombre' => '🎯 Primer Paso',
                'descripcion' => 'Participa en tu primer evento',
                'icono' => '🎯',
                'tipo' => 'bronce',
                'condicion' => 'primer_evento',
                'puntos_xp' => 50
            ],
            [
                'nombre' => '🏃 Veterano',
                'descripcion' => 'Participa en 3 eventos diferentes',
                'icono' => '🏃',
                'tipo' => 'plata',
                'condicion' => 'participacion_3_eventos',
                'puntos_xp' => 150
            ],
            [
                'nombre' => '⭐ Leyenda',
                'descripcion' => 'Participa en 5 o más eventos',
                'icono' => '⭐',
                'tipo' => 'oro',
                'condicion' => 'participacion_5_eventos',
                'puntos_xp' => 300
            ],
            
            // Logros de Liderazgo
            [
                'nombre' => '👑 Primer Líder',
                'descripcion' => 'Crea y lidera tu primer equipo',
                'icono' => '👑',
                'tipo' => 'bronce',
                'condicion' => 'primer_lider',
                'puntos_xp' => 100
            ],
            [
                'nombre' => '🎖️ Líder Nato',
                'descripcion' => 'Lidera 3 equipos diferentes',
                'icono' => '🎖️',
                'tipo' => 'plata',
                'condicion' => 'lider_3_veces',
                'puntos_xp' => 200
            ],
            [
                'nombre' => '🔱 Comandante',
                'descripcion' => 'Lidera 5 o más equipos',
                'icono' => '🔱',
                'tipo' => 'oro',
                'condicion' => 'lider_5_veces',
                'puntos_xp' => 350
            ],
            
            // Logros de Éxito
            [
                'nombre' => '🥉 Tercer Lugar',
                'descripcion' => 'Obtén el 3er lugar en un evento',
                'icono' => '🥉',
                'tipo' => 'bronce',
                'condicion' => 'tercer_lugar',
                'puntos_xp' => 200
            ],
            [
                'nombre' => '🥈 Subcampeón',
                'descripcion' => 'Obtén el 2do lugar en un evento',
                'icono' => '🥈',
                'tipo' => 'plata',
                'condicion' => 'segundo_lugar',
                'puntos_xp' => 300
            ],
            [
                'nombre' => '🥇 Campeón',
                'descripcion' => 'Obtén el 1er lugar en un evento',
                'icono' => '🥇',
                'tipo' => 'oro',
                'condicion' => 'primer_lugar',
                'puntos_xp' => 500
            ],
            [
                'nombre' => '💎 Máximo Ganador',
                'descripcion' => 'Gana 3 o más eventos',
                'icono' => '💎',
                'tipo' => 'platino',
                'condicion' => 'ganar_3_eventos',
                'puntos_xp' => 1000
            ],
            
            // Logros de Colaboración
            [
                'nombre' => '🤝 Colaborador',
                'descripcion' => 'Únete a un equipo existente',
                'icono' => '🤝',
                'tipo' => 'bronce',
                'condicion' => 'unirse_equipo',
                'puntos_xp' => 30
            ],
            [
                'nombre' => '🌟 Team Player',
                'descripcion' => 'Completa un proyecto en equipo',
                'icono' => '🌟',
                'tipo' => 'plata',
                'condicion' => 'proyecto_completado',
                'puntos_xp' => 150
            ],
            
            // Logros de Progreso
            [
                'nombre' => '📈 En Progreso',
                'descripcion' => 'Completa 5 hitos de proyecto',
                'icono' => '📈',
                'tipo' => 'bronce',
                'condicion' => 'completar_5_hitos',
                'puntos_xp' => 100
            ],
            [
                'nombre' => '🚀 Productivo',
                'descripcion' => 'Completa 10 hitos de proyecto',
                'icono' => '🚀',
                'tipo' => 'plata',
                'condicion' => 'completar_10_hitos',
                'puntos_xp' => 200
            ],
            
            // Logros Especiales
            [
                'nombre' => '🎨 Innovador',
                'descripcion' => 'Utiliza 5 o más tecnologías diferentes en tus proyectos',
                'icono' => '🎨',
                'tipo' => 'especial',
                'condicion' => 'usar_5_tecnologias',
                'puntos_xp' => 250
            ],
            [
                'nombre' => '📚 Experto',
                'descripcion' => 'Alcanza nivel Experto en 3 habilidades',
                'icono' => '📚',
                'tipo' => 'especial',
                'condicion' => 'experto_3_habilidades',
                'puntos_xp' => 300
            ],
            [
                'nombre' => '⚡ Rayo Veloz',
                'descripcion' => 'Completa un proyecto en menos de 24 horas',
                'icono' => '⚡',
                'tipo' => 'especial',
                'condicion' => 'proyecto_24h',
                'puntos_xp' => 400
            ],
        ];

        foreach ($logros as $logro) {
            DB::table('logros')->insert(array_merge($logro, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
