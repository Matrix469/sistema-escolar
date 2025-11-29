<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HabilidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $habilidades = [
            // Frontend
            ['nombre' => 'HTML/CSS', 'categoria' => 'Frontend', 'icono' => 'code', 'color' => '#E34F26'],
            ['nombre' => 'JavaScript', 'categoria' => 'Frontend', 'icono' => 'js', 'color' => '#F7DF1E'],
            ['nombre' => 'React', 'categoria' => 'Frontend', 'icono' => 'react', 'color' => '#61DAFB'],
            ['nombre' => 'Vue.js', 'categoria' => 'Frontend', 'icono' => 'vuejs', 'color' => '#4FC08D'],
            ['nombre' => 'Angular', 'categoria' => 'Frontend', 'icono' => 'angular', 'color' => '#DD0031'],
            ['nombre' => 'Tailwind CSS', 'categoria' => 'Frontend', 'icono' => 'tailwind', 'color' => '#06B6D4'],
            
            // Backend
            ['nombre' => 'PHP', 'categoria' => 'Backend', 'icono' => 'php', 'color' => '#777BB4'],
            ['nombre' => 'Laravel', 'categoria' => 'Backend', 'icono' => 'laravel', 'color' => '#FF2D20'],
            ['nombre' => 'Node.js', 'categoria' => 'Backend', 'icono' => 'nodejs', 'color' => '#339933'],
            ['nombre' => 'Python', 'categoria' => 'Backend', 'icono' => 'python', 'color' => '#3776AB'],
            ['nombre' => 'Java', 'categoria' => 'Backend', 'icono' => 'java', 'color' => '#007396'],
            ['nombre' => 'C#', 'categoria' => 'Backend', 'icono' => 'csharp', 'color' => '#239120'],
            ['nombre' => 'Ruby on Rails', 'categoria' => 'Backend', 'icono' => 'rails', 'color' => '#CC0000'],
            
            // Mobile
            ['nombre' => 'React Native', 'categoria' => 'Mobile', 'icono' => 'mobile', 'color' => '#61DAFB'],
            ['nombre' => 'Flutter', 'categoria' => 'Mobile', 'icono' => 'flutter', 'color' => '#02569B'],
            ['nombre' => 'Swift', 'categoria' => 'Mobile', 'icono' => 'swift', 'color' => '#FA7343'],
            ['nombre' => 'Kotlin', 'categoria' => 'Mobile', 'icono' => 'kotlin', 'color' => '#7F52FF'],
            
            // Design
            ['nombre' => 'UI/UX Design', 'categoria' => 'Design', 'icono' => 'palette', 'color' => '#FF6B6B'],
            ['nombre' => 'Figma', 'categoria' => 'Design', 'icono' => 'figma', 'color' => '#F24E1E'],
            ['nombre' => 'Adobe XD', 'categoria' => 'Design', 'icono' => 'adobe', 'color' => '#FF61F6'],
            ['nombre' => 'Photoshop', 'categoria' => 'Design', 'icono' => 'photoshop', 'color' => '#31A8FF'],
            
            // Data Science
            ['nombre' => 'Machine Learning', 'categoria' => 'Data Science', 'icono' => 'brain', 'color' => '#FF6F00'],
            ['nombre' => 'TensorFlow', 'categoria' => 'Data Science', 'icono' => 'tensorflow', 'color' => '#FF6F00'],
            ['nombre' => 'PyTorch', 'categoria' => 'Data Science', 'icono' => 'pytorch', 'color' => '#EE4C2C'],
            ['nombre' => 'Data Analysis', 'categoria' => 'Data Science', 'icono' => 'chart', 'color' => '#4BC0C0'],
            ['nombre' => 'SQL', 'categoria' => 'Data Science', 'icono' => 'database', 'color' => '#00758F'],
            
            // DevOps
            ['nombre' => 'Git', 'categoria' => 'DevOps', 'icono' => 'git', 'color' => '#F05032'],
            ['nombre' => 'Docker', 'categoria' => 'DevOps', 'icono' => 'docker', 'color' => '#2496ED'],
            ['nombre' => 'AWS', 'categoria' => 'DevOps', 'icono' => 'aws', 'color' => '#FF9900'],
            ['nombre' => 'CI/CD', 'categoria' => 'DevOps', 'icono' => 'cycle', 'color' => '#2088FF'],
            
            // Other
            ['nombre' => 'Scrum/Agile', 'categoria' => 'Other', 'icono' => 'users', 'color' => '#009FDA'],
            ['nombre' => 'Testing', 'categoria' => 'Other', 'icono' => 'check-circle', 'color' => '#10B981'],
            ['nombre' => 'API REST', 'categoria' => 'Other', 'icono' => 'api', 'color' => '#0EA5E9'],
        ];

        foreach ($habilidades as $habilidad) {
            DB::table('cat_habilidades')->insert($habilidad);
        }
    }
}
