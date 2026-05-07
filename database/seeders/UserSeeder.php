<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@isufst.edu.ph',
            'password' => Hash::make('password'),
            'student_id' => 'ADMIN-001',
            'department' => 'Administration',
            'phone' => '09123456789',
        ]);
        $admin->assignRole('admin');

        $student = User::create([
            'name' => 'Juan Dela Cruz',
            'email' => 'student@isufst.edu.ph',
            'password' => Hash::make('password'),
            'student_id' => '2024-0001',
            'course' => 'BS Information Technology',
            'year_level' => '3rd Year',
            'department' => 'IT Department',
            'phone' => '09187654321',
        ]);
        $student->assignRole('student');

        $faculty = User::create([
            'name' => 'Maria Santos',
            'email' => 'faculty@isufst.edu.ph',
            'password' => Hash::make('password'),
            'student_id' => 'FAC-001',
            'course' => null,
            'year_level' => null,
            'department' => 'IT Department',
            'phone' => '09176543210',
        ]);
        $faculty->assignRole('faculty');

        $staff = User::create([
            'name' => 'Jose Reyes',
            'email' => 'registrar@isufst.edu.ph',
            'password' => Hash::make('password'),
            'student_id' => 'STAFF-001',
            'course' => null,
            'year_level' => null,
            'department' => 'Registrar',
            'phone' => '09165432109',
        ]);
        $staff->assignRole('staff');

        $maintenance = User::create([
            'name' => 'Pedro Garcia',
            'email' => 'maintenance@isufst.edu.ph',
            'password' => Hash::make('password'),
            'student_id' => 'MNT-001',
            'course' => null,
            'year_level' => null,
            'department' => 'Maintenance',
            'phone' => '09154321098',
        ]);
        $maintenance->assignRole('maintenance');

        $guidance = User::create([
            'name' => 'Ana Lopez',
            'email' => 'guidance@isufst.edu.ph',
            'password' => Hash::make('password'),
            'student_id' => 'STAFF-002',
            'course' => null,
            'year_level' => null,
            'department' => 'Guidance',
            'phone' => '09143210987',
        ]);
        $guidance->assignRole('staff');

        for ($i = 1; $i <= 10; $i++) {
            $s = User::create([
                'name' => 'Student ' . $i,
                'email' => 'student' . $i . '@isufst.edu.ph',
                'password' => Hash::make('password'),
                'student_id' => '2024-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'course' => ['BSIT', 'BSCS', 'BSBA', 'BSEd', 'BSA'][array_rand(['BSIT', 'BSCS', 'BSBA', 'BSEd', 'BSA'])],
                'year_level' => ['1st Year', '2nd Year', '3rd Year', '4th Year'][array_rand(['1st Year', '2nd Year', '3rd Year', '4th Year'])],
                'department' => 'IT Department',
                'phone' => '09' . rand(10, 99) . rand(1000000, 9999999),
            ]);
            $s->assignRole('student');
        }
    }
}
