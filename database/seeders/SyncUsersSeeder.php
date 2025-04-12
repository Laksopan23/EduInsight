<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SyncUsersSeeder extends Seeder
{
    public function run()
    {
        foreach (Teacher::all() as $teacher) {
            if (!$teacher->user_id_fk) {
                $user = User::create([
                    'user_id' => $teacher->user_id ?? 'USR' . Str::random(8),
                    'name' => $teacher->full_name,
                    'email' => $teacher->email ?? 'teacher' . $teacher->id . '@school.com',
                    'phone_number' => $teacher->phone_number,
                    'date_of_birth' => $teacher->date_of_birth,
                    'role_name' => 'Teachers',
                    'status' => 'Active',
                    'password' => Hash::make('default123'),
                    'avatar' => 'photo_defaults.jpg',
                ]);
                $teacher->update(['user_id_fk' => $user->id]);
            }
        }

        foreach (Student::all() as $student) {
            if (!$student->user_id_fk) {
                $user = User::create([
                    'user_id' => $student->user_id ?? 'USR' . Str::random(8),
                    'name' => $student->first_name . ' ' . $student->last_name,
                    'email' => $student->email ?? 'student' . $student->id . '@school.com',
                    'phone_number' => $student->phone_number,
                    'date_of_birth' => $student->date_of_birth,
                    'role_name' => 'Student',
                    'status' => 'Active',
                    'password' => Hash::make('default123'),
                    'avatar' => 'photo_defaults.jpg',
                ]);
                $student->update(['user_id_fk' => $user->id]);
            }
        }
    }
}
