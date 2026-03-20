<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        User::factory()->create([
            'name' => 'Sponsor User',
            'email' => 'sponsor@example.com',
            'password' => bcrypt('password'),
            'role' => 'sponsor'
        ]);

        $student = User::factory()->create([
            'name' => 'Student User',
            'email' => 'student@example.com',
            'password' => bcrypt('password'),
            'role' => 'student'
        ]);

        \App\Models\StudentProfile::create([
            'user_id' => $student->id,
            'surname' => 'Doe',
            'age' => 18,
            'class' => 'University Year 1',
        ]);

        $sponsor = User::where('email', 'sponsor@example.com')->first();
        
        \App\Models\SponsorStudentAssignment::create([
            'sponsor_id' => $sponsor->id,
            'student_id' => $student->id,
        ]);

        \App\Models\SponsorToken::create([
            'sponsor_id' => $sponsor->id,
            'token' => 'abc123xyz',
            'expires_at' => null,
        ]);
    }
}
