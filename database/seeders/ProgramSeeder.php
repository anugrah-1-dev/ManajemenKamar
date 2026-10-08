<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(ProgramSeeder::class);
        Program::create([
            'tab_title' => 'Speaking & Confidence',
            'tab_icon' => 'fas fa-comments',
            'tab_identifier' => 'speaking',
            'content_heading' => 'Program Speaking & Confidence',
            'description' => 'Dirancang khusus untuk Anda yang ingin lancar berbicara dalam situasi sehari-hari. Lupakan gugup dan teori rumit, di sini Anda akan langsung praktik!',
            'benefits' => "Kelas praktik speaking setiap hari\nMateri percakapan yang relevan\nLingkungan belajar yang suportif",
            'image' => 'speaking.jpg',
            'is_default_active' => true,
        ]);

        Program::create([
            'tab_title' => 'TOEFL / IELTS Prep',
            'tab_icon' => 'fas fa-graduation-cap',
            'tab_identifier' => 'toefl',
            'content_heading' => 'Persiapan TOEFL / IELTS',
            'description' => 'Raih skor impian Anda dengan program persiapan tes yang terstruktur. Pelajari strategi jitu, latihan soal intensif, dan dapatkan feedback dari ahlinya.',
            'benefits' => "Strategi jitu untuk setiap seksi tes\nSimulasi tes berkala\nFeedback dari tutor ahli",
            'image' => 'toefl.jpg',
            'is_default_active' => false,
        ]);
    }
}