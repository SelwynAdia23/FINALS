<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Broken Facilities', 'department' => 'Maintenance', 'description' => 'Report broken chairs, desks, doors, windows, and other facility issues'],
            ['name' => 'Comfort Room Issues', 'department' => 'Maintenance', 'description' => 'Plumbing, water supply, or cleanliness issues in restrooms'],
            ['name' => 'Electrical Problems', 'department' => 'Maintenance', 'description' => 'Lighting, outlets, fans, and electrical system issues'],
            ['name' => 'Water Supply', 'department' => 'Maintenance', 'description' => 'Water leaks, no water supply, or water quality issues'],
            ['name' => 'Building Repairs', 'department' => 'Maintenance', 'description' => 'Structural repairs, painting, flooring, and roofing issues'],
            ['name' => 'Enrollment Concerns', 'department' => 'Registrar', 'description' => 'Issues related to enrollment, class registration, and schedules'],
            ['name' => 'Document Requests', 'department' => 'Registrar', 'description' => 'Requests for transcripts, diplomas, certificates, and other documents'],
            ['name' => 'Grade Issues', 'department' => 'Registrar', 'description' => 'Grade corrections, missing grades, or grade disputes'],
            ['name' => 'Academic Advising', 'department' => 'Academic Affairs', 'description' => 'Course planning, academic guidance, and career counseling'],
            ['name' => 'Counseling Services', 'department' => 'Guidance', 'description' => 'Personal counseling, mental health support, and student welfare'],
            ['name' => 'Student Affairs', 'department' => 'Student Affairs', 'description' => 'Student organizations, events, and extracurricular activities'],
            ['name' => 'Scholarship Concerns', 'department' => 'Student Affairs', 'description' => 'Scholarship applications, renewals, and related issues'],
            ['name' => 'IT Support', 'department' => 'IT Department', 'description' => 'Computer lab issues, WiFi problems, and software requests'],
            ['name' => 'Library Services', 'department' => 'Library', 'description' => 'Book requests, library facilities, and research assistance'],
            ['name' => 'Financial Concerns', 'department' => 'Accounting', 'description' => 'Tuition payments, refunds, and financial aid inquiries'],
            ['name' => 'Security Issues', 'department' => 'Security', 'description' => 'Campus safety, lost items, and security incidents'],
            ['name' => 'Cleanliness', 'department' => 'Maintenance', 'description' => 'Garbage collection, cleaning services, and pest control'],
            ['name' => 'Other', 'department' => 'Admin', 'description' => 'Other concerns not covered by the categories above'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
