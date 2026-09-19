<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Profession;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $professions = [
            'مهندس مدني',
            'فني ألواح شمسية',
            'سمكري',
            'كهربائي سيارات',
            'ميكانيكي سيارات',
            'عامل تحميل وتنزيل',
            'سائق نقل ثقيل'
        ];

        foreach ($professions as $profession) {
            Profession::firstOrCreate(['name' => $profession]);
        }
    }
}
