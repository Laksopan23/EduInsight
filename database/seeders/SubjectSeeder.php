<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run()
    {
        $coreSubjects = [
            'Sinhala',
            'Tamil',
            'English',
            'Mathematics',
            'Science',
            'Buddhism',
            'Christianity',
            'Hinduism',
            'Islam',
            'History',
            'Geography',
            'Civic Education',
            'Health & Physical Education'
        ];
        $optionalSubjects = [
            'Art',
            'Music (Western)',
            'Music (Oriental)',
            'Dancing (Traditional)',
            'Dancing (Modern)',
            'Drama & Theatre',
            'Sinhala Literature',
            'Tamil Literature',
            'English Literature',
            'ICT',
            'Agriculture & Food Technology',
            'Home Economics'
        ];
        $grades69 = ['Grade 6', 'Grade 7', 'Grade 8', 'Grade 9'];

        // Grades 6-9 Core and Optional
        foreach ($grades69 as $grade) {
            foreach ($coreSubjects as $subject) {
                Subject::create([
                    'name' => $subject,
                    'grade' => $grade,
                    'category' => 'Core',
                    'is_mandatory' => true,
                ]);
            }
            foreach ($optionalSubjects as $subject) {
                Subject::create([
                    'name' => $subject,
                    'grade' => $grade,
                    'category' => in_array($subject, ['ICT', 'Agriculture & Food Technology', 'Home Economics']) ? 'Basket 3' : 'Basket 2',
                    'is_mandatory' => false,
                ]);
            }
        }

        // Grades 10-11 Core and Basket Subjects
        $coreSubjects1011 = [
            'Sinhala',
            'Tamil',
            'English',
            'Mathematics',
            'Science',
            'Buddhism',
            'Christianity',
            'Hinduism',
            'Islam',
            'History'
        ];
        $basket1 = ['Geography', 'Civic Education', 'Business & Accounting Studies'];
        $basket2 = [
            'Music (Western)',
            'Music (Oriental)',
            'Art',
            'Drama & Theatre',
            'Dancing (Traditional)',
            'Dancing (Modern)',
            'Sinhala Literature',
            'Tamil Literature',
            'English Literature'
        ];
        $basket3 = [
            'ICT',
            'Agriculture & Food Technology',
            'Home Economics',
            'Health & Physical Education',
            'Communication & Media Studies'
        ];
        $grades1011 = ['Grade 10', 'Grade 11'];

        foreach ($grades1011 as $grade) {
            foreach ($coreSubjects1011 as $subject) {
                Subject::create([
                    'name' => $subject,
                    'grade' => $grade,
                    'category' => 'Core',
                    'is_mandatory' => true,
                ]);
            }
            foreach ($basket1 as $subject) {
                Subject::create([
                    'name' => $subject,
                    'grade' => $grade,
                    'category' => 'Basket 1',
                    'is_mandatory' => false,
                ]);
            }
            foreach ($basket2 as $subject) {
                Subject::create([
                    'name' => $subject,
                    'grade' => $grade,
                    'category' => 'Basket 2',
                    'is_mandatory' => false,
                ]);
            }
            foreach ($basket3 as $subject) {
                Subject::create([
                    'name' => $subject,
                    'grade' => $grade,
                    'category' => 'Basket 3',
                    'is_mandatory' => false,
                ]);
            }
        }
    }
}
