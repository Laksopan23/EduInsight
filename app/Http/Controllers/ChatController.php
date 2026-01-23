<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use OpenAI\Client;
use OpenAI;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    private $openai;
    private $predefinedResponses = [
        // General Greetings
        'hello' => 'Hello! I\'m your EduInsight assistant. How can I help you today?',
        'hi' => 'Hi there! I\'m here to help you with any questions about our educational platform.',
        'help' => 'I can help you with:\n1. Sri Lankan Education System\n2. Grade 6-11 Subjects\n3. O/L and A/L Information\n4. Course information\n5. Student records\n6. Teacher information\n7. Exam schedules\n8. Fee payments\nWhat would you like to know?',

        // Sri Lankan Education System
        'education system' => 'The Sri Lankan education system includes:\n1. Primary Education (Grades 1-5)\n2. Junior Secondary (Grades 6-9)\n3. Senior Secondary (Grades 10-11)\n4. Advanced Level (Grades 12-13)\n5. University Education\nWould you like more details about any specific level?',
        
        'ol exam' => 'O/L (Ordinary Level) Exam Information:\n- Taken at the end of Grade 11\n- Core subjects: Sinhala/Tamil, English, Mathematics, Science\n- Optional subjects: History, Geography, ICT, etc.\n- Grading: A (Distinction) to S (Below 35%)\n- Required for A/L studies\nWould you like specific subject information?',
        
        'al exam' => 'A/L (Advanced Level) Exam Information:\n- Taken after O/L\n- Three main streams:\n  1. Science\n  2. Commerce\n  3. Arts\n- Required for university admission\n- Grading: A to S\nNeed details about specific streams?',

        // Grade 6-11 Subjects
        'grade 6 subjects' => 'Grade 6 Core Subjects:\n1. First Language (Sinhala/Tamil)\n2. English\n3. Mathematics\n4. Science\n5. History\n6. Geography\n7. Health & Physical Education\n8. Aesthetic Subjects (Art, Music, Dancing)\n9. Practical & Technical Skills\n10. Religion\nWould you like details about any specific subject?',
        
        'grade 7 subjects' => 'Grade 7 Core Subjects:\n1. First Language (Sinhala/Tamil)\n2. English\n3. Mathematics\n4. Science\n5. History\n6. Geography\n7. Health & Physical Education\n8. Aesthetic Subjects\n9. Practical & Technical Skills\n10. Religion\nNeed information about any subject?',
        
        'grade 8 subjects' => 'Grade 8 Core Subjects:\n1. First Language (Sinhala/Tamil)\n2. English\n3. Mathematics\n4. Science\n5. History\n6. Geography\n7. Health & Physical Education\n8. Aesthetic Subjects\n9. Practical & Technical Skills\n10. Religion\nWould you like specific subject details?',
        
        'grade 9 subjects' => 'Grade 9 Core Subjects:\n1. First Language (Sinhala/Tamil)\n2. English\n3. Mathematics\n4. Science\n5. History\n6. Geography\n7. Health & Physical Education\n8. Aesthetic Subjects\n9. Practical & Technical Skills\n10. Religion\nNeed help with any subject?',
        
        'grade 10 subjects' => 'Grade 10 Core Subjects:\n1. First Language (Sinhala/Tamil)\n2. English\n3. Mathematics\n4. Science\n5. History\n6. Geography\n7. Health & Physical Education\n8. Aesthetic Subjects\n9. Practical & Technical Skills\n10. Religion\nWould you like subject-specific information?',
        
        'grade 11 subjects' => 'Grade 11 Core Subjects:\n1. First Language (Sinhala/Tamil)\n2. English\n3. Mathematics\n4. Science\n5. History\n6. Geography\n7. Health & Physical Education\n8. Aesthetic Subjects\n9. Practical & Technical Skills\n10. Religion\nNeed details about any subject?',

        // Subject Details
        'mathematics' => 'Mathematics Curriculum (Grades 6-11):\n- Number Systems\n- Algebra\n- Geometry\n- Trigonometry\n- Statistics\n- Probability\n- Calculus (Grade 11)\nWould you like specific topic information?',
        
        'science' => 'Science Curriculum (Grades 6-11):\n- Physics\n- Chemistry\n- Biology\n- Environmental Science\n- Scientific Method\n- Laboratory Work\nNeed details about any specific area?',
        
        'english' => 'English Curriculum (Grades 6-11):\n- Reading Comprehension\n- Grammar\n- Literature\n- Writing Skills\n- Speaking & Listening\n- Vocabulary\nWould you like specific skill information?',

        // Exam Information
        'exam schedule' => 'Exam Schedule Information:\n1. Term Tests (3 per year)\n2. First Term Exam\n3. Second Term Exam\n4. Final Term Exam\n5. O/L Exam (Grade 11)\nWould you like specific exam dates?',
        
        'exam preparation' => 'Exam Preparation Tips:\n1. Create a study schedule\n2. Review past papers\n3. Practice time management\n4. Take regular breaks\n5. Stay healthy\n6. Get enough sleep\nNeed specific subject preparation tips?',

        // General Education Topics
        'study tips' => 'Effective Study Tips:\n1. Create a quiet study space\n2. Use active learning techniques\n3. Take regular breaks\n4. Stay organized\n5. Review regularly\n6. Get enough sleep\n7. Stay hydrated\n8. Exercise regularly\nWould you like specific subject study tips?',
        
        'time management' => 'Time Management Tips:\n1. Create a daily schedule\n2. Prioritize tasks\n3. Use a planner\n4. Set realistic goals\n5. Take regular breaks\n6. Avoid procrastination\n7. Review and adjust\nNeed help creating a study schedule?',
        
        'stress management' => 'Stress Management Tips:\n1. Regular exercise\n2. Healthy diet\n3. Adequate sleep\n4. Meditation/breathing exercises\n5. Time management\n6. Social support\n7. Hobbies and relaxation\nWould you like specific stress relief techniques?',

        // Platform Features
        'courses' => 'We offer various courses including:\n- Mathematics\n- Science\n- English\n- History\n- Computer Science\nWould you like more details about any specific course?',
        
        'fees' => 'Our fee structure includes:\n- Tuition fees\n- Examination fees\n- Library fees\n- Laboratory fees\nWould you like to know the specific amounts?',
        
        'contact' => 'You can contact us through:\n- Email: support@eduinsight.com\n- Phone: +1234567890\n- Office Hours: 9 AM - 5 PM\nHow else can I help you?',
        
        'login' => 'To login:\n1. Go to the login page\n2. Enter your username/email\n3. Enter your password\n4. Click "Login"\nAre you having trouble with any of these steps?',
        
        'password' => 'To reset your password:\n1. Click "Forgot Password" on the login page\n2. Enter your email\n3. Check your email for reset instructions\n4. Follow the link to set a new password\nNeed help with any of these steps?'
    ];

    public function __construct()
    {
        $this->middleware('auth');
        $this->openai = OpenAI::client(env('OPENAI_API_KEY'));
    }

    public function chat(Request $request)
    {
        // Check if user is authenticated and is a student
        if (!Auth::check() || Auth::user()->role !== 'student') {
            return response()->json([
                'error' => 'Access denied. Only students can use the AI chatbox.'
            ], 403);
        }

        $request->validate([
            'message' => 'required|string'
        ]);

        try {
            $response = $this->getAIResponse($request->message);
            return response()->json([
                'response' => $response
            ]);
        } catch (\Exception $e) {
            Log::error('Chat API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Sorry, there was an error processing your request.'
            ], 500);
        }
    }

    private function getAIResponse($message)
    {
        // Convert message to lowercase for case-insensitive matching
        $message = strtolower(trim($message));

        // Check for predefined responses
        foreach ($this->predefinedResponses as $keyword => $response) {
            if (strpos($message, $keyword) !== false) {
                return $response;
            }
        }

        try {
            $result = $this->openai->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a helpful AI assistant for an educational platform called EduInsight, focusing on the Sri Lankan education system. Provide clear, concise, and accurate responses about education, particularly for grades 6-11, O/L and A/L exams, and general study tips. Always maintain a supportive and encouraging tone.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $message
                    ]
                ],
                'temperature' => 0.7,
                'max_tokens' => 500
            ]);

            return $result->choices[0]->message->content;
        } catch (\Exception $e) {
            Log::error('OpenAI API Error: ' . $e->getMessage());
            return "I'm sorry, I couldn't find a specific answer to your question. Please try asking about:\n- Sri Lankan Education System\n- Grade 6-11 Subjects\n- O/L and A/L Exams\n- Study Tips\n- Time Management\n- Stress Management\n- Course Information\n- Platform Features";
        }
    }
} 