<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Campus;
use App\Models\Category;
use App\Models\TicketHistory;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $students = User::role('student')->get();
        $staff = User::role('staff')->get();
        $maintenance = User::role('maintenance')->first();
        $campuses = Campus::all();
        $categories = Category::all();

        $ticketData = [
            ['subject' => 'Broken chair in Room 201', 'description' => 'There are 3 broken chairs in Room 201. Students are unable to sit properly during lectures. This has been an issue for over 2 weeks now.', 'priority' => 'medium', 'status' => 'pending', 'category' => 'Broken Facilities'],
            ['subject' => 'No water in CR Building A', 'description' => 'The comfort room in Building A 2nd floor has no water supply for the past 3 days. Students are forced to use other buildings.', 'priority' => 'high', 'status' => 'in_progress', 'category' => 'Water Supply'],
            ['subject' => 'Flickering lights in Computer Lab', 'description' => 'The fluorescent lights in Computer Lab 3 are flickering intermittently. This is causing eye strain and making it difficult to work on computers.', 'priority' => 'medium', 'status' => 'pending', 'category' => 'Electrical Problems'],
            ['subject' => 'Request for Transcript of Records', 'description' => 'I need my official transcript of records for my scholarship application. I have completed all requirements and fees.', 'priority' => 'medium', 'status' => 'pending', 'category' => 'Document Requests'],
            ['subject' => 'Enrollment system error', 'description' => 'When I try to enroll in IT 301, the system shows an error message saying "Prerequisite not met" even though I have already passed IT 201.', 'priority' => 'high', 'status' => 'in_progress', 'category' => 'Enrollment Concerns'],
            ['subject' => 'Missing grade in IT 302', 'description' => 'My grade for IT 302 (Object-Oriented Programming) last semester is still showing as "Incomplete" in the system. I have already completed all requirements.', 'priority' => 'high', 'status' => 'pending', 'category' => 'Grade Issues'],
            ['subject' => 'Leaking ceiling in Library', 'description' => 'There is a leaking ceiling near the reference section of the library. Water is dripping onto books and creating a safety hazard.', 'priority' => 'urgent', 'status' => 'in_progress', 'category' => 'Building Repairs'],
            ['subject' => 'WiFi not working in Building C', 'description' => 'The campus WiFi is completely unavailable in Building C for the past week. This is affecting online classes and research activities.', 'priority' => 'high', 'status' => 'resolved', 'category' => 'IT Support'],
            ['subject' => 'Counseling appointment request', 'description' => 'I would like to schedule a counseling appointment. I have been experiencing anxiety related to my academic workload.', 'priority' => 'high', 'status' => 'pending', 'category' => 'Counseling Services'],
            ['subject' => 'Garbage not collected', 'description' => 'The garbage bins near the canteen have not been collected for 3 days. The area is becoming unsanitary and attracting pests.', 'priority' => 'high', 'status' => 'resolved', 'category' => 'Cleanliness'],
            ['subject' => 'Scholarship renewal inquiry', "description" => "I would like to inquire about the requirements and deadline for my CHED scholarship renewal for next semester.", 'priority' => 'low', 'status' => 'resolved', 'category' => 'Scholarship Concerns'],
            ['subject' => 'Damaged door in Room 105', 'description' => 'The door of Room 105 cannot close properly. The lock mechanism is broken and the door keeps swinging open.', 'priority' => 'medium', 'status' => 'pending', 'category' => 'Broken Facilities'],
            ['subject' => 'Aircon not working in Faculty Room', 'description' => 'The air conditioning unit in the faculty room has not been working for a week. The room becomes extremely hot in the afternoon.', 'priority' => 'medium', 'status' => 'in_progress', 'category' => 'Electrical Problems'],
            ['subject' => 'Lost student ID', 'description' => 'I lost my student ID somewhere near the gymnasium. I need a replacement for my upcoming exams.', 'priority' => 'low', 'status' => 'pending', 'category' => 'Security Issues'],
            ['subject' => 'Book request for thesis research', 'description' => "I need the following books for my thesis research: 'Data Structures and Algorithms' by Goodrich and 'Database Systems' by Date. They are not available in the library.", 'priority' => 'low', 'status' => 'in_progress', 'category' => 'Library Services'],
        ];

        foreach ($ticketData as $index => $data) {
            $student = $students->random();
            $category = Category::where('name', $data['category'])->first();
            $campus = $campuses->random();

            if (!$category) {
                continue;
            }

            $assignedTo = null;
            if ($category->department === 'Maintenance' && $maintenance) {
                $assignedTo = $maintenance->id;
            } elseif ($data['status'] === 'in_progress') {
                $assignedTo = $staff->random()->id;
            }

            $ticket = Ticket::create([
                'ticket_number' => 'CC-202604' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'user_id' => $student->id,
                'campus_id' => $campus->id,
                'category_id' => $category->id,
                'subject' => $data['subject'],
                'description' => $data['description'],
                'priority' => $data['priority'],
                'status' => $data['status'],
                'assigned_to' => $assignedTo,
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(0, 5)),
            ]);

            if ($data['status'] === 'resolved') {
                $ticket->update([
                    'resolved_at' => now()->subDays(rand(1, 10)),
                    'resolution' => 'This issue has been addressed and resolved. Please submit a new ticket if the problem persists.',
                ]);
            }

            TicketHistory::create([
                'ticket_id' => $ticket->id,
                'user_id' => $student->id,
                'action' => 'created',
                'comment' => 'Ticket submitted',
                'created_at' => $ticket->created_at,
            ]);

            if ($data['status'] !== 'pending') {
                $action = $data['status'] === 'in_progress' ? 'started_progress' : 'resolved';
                $comment = $data['status'] === 'in_progress' ? 'Ticket is being processed' : 'Issue has been resolved';
                TicketHistory::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $assignedTo ?? $staff->random()->id,
                    'action' => $action,
                    'comment' => $comment,
                    'created_at' => $data['status'] === 'resolved' ? $ticket->resolved_at : now()->subDays(rand(1, 10)),
                ]);
            }
        }
    }
}
