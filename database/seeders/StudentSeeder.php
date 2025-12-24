<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schools = School::all();

        foreach ($schools as $school) {
            // Create 5 students for each combination: grade 5/8 × male/female
            $combinations = [
                ['grade' => 5, 'gender' => 'male'],
                ['grade' => 5, 'gender' => 'female'],
                ['grade' => 8, 'gender' => 'male'],
                ['grade' => 8, 'gender' => 'female'],
            ];

            foreach ($combinations as $combo) {
                for ($i = 1; $i <= 5; $i++) {
                    $firstName = $this->getRandomName($combo['gender']);
                    $fatherName = $this->getRandomFatherName();
                    $dob = $this->getRandomDOB($combo['grade']);
                    $rollNumber = $this->generateRollNumber($combo['grade'], $combo['gender']);

                    Student::create([
                        'school_id' => $school->id,
                        'name' => $firstName,
                        'father' => $fatherName,
                        'dob' => $dob,
                        'grade' => (string) $combo['grade'], // Convert to string for ENUM
                        'gender' => $combo['gender'],
                        'participate_with' => 'school',
                        'roll_number' => $rollNumber,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        // Create some individual students
        $individualCombinations = [
            ['grade' => 5, 'gender' => 'male'],
            ['grade' => 5, 'gender' => 'female'],
            ['grade' => 8, 'gender' => 'male'],
            ['grade' => 8, 'gender' => 'female'],
        ];

        foreach ($individualCombinations as $combo) {
            for ($i = 1; $i <= 2; $i++) { // Create 2 individual students per combination
                $firstName = $this->getRandomName($combo['gender']);
                $fatherName = $this->getRandomFatherName();
                $dob = $this->getRandomDOB($combo['grade']);
                $rollNumber = $this->generateRollNumber($combo['grade'], $combo['gender']);
                $schoolName = $this->getRandomSchoolName();
                $contact = $this->getRandomContact();

                Student::create([
                    'school_name' => $schoolName,
                    'name' => $firstName,
                    'father' => $fatherName,
                    'dob' => $dob,
                    'grade' => (string) $combo['grade'], // Convert to string for ENUM
                    'gender' => $combo['gender'],
                    'participate_with' => 'individual',
                    'contact' => $contact,
                    'roll_number' => $rollNumber,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function getRandomName($gender)
    {
        $maleNames = ['Ahmed', 'Ali', 'Hassan', 'Hussain', 'Muhammad', 'Omar', 'Usman', 'Bilal', 'Saad', 'Fahad', 'Hamza', 'Ibrahim', 'Yusuf', 'Zain', 'Rayyan'];
        $femaleNames = ['Ayesha', 'Fatima', 'Maryam', 'Zainab', 'Hafsa', 'Khadija', 'Amina', 'Sana', 'Sara', 'Hira', 'Noor', 'Aisha', 'Mehreen', 'Sadia', 'Nazia'];

        return $gender === 'male' ? $maleNames[array_rand($maleNames)] : $femaleNames[array_rand($femaleNames)];
    }

    private function getRandomFatherName()
    {
        $fatherNames = ['Muhammad Khan', 'Ahmed Ali', 'Hassan Butt', 'Ibrahim Malik', 'Yusuf Ahmed', 'Ali Khan', 'Omar Sheikh', 'Usman Raja', 'Bilal Mughal', 'Fahad Javed', 'Hamza Qureshi', 'Saad Bhatti', 'Zain Dar', 'Rayyan Gill', 'Asif Iqbal'];

        return $fatherNames[array_rand($fatherNames)];
    }

    private function getRandomDOB($grade)
    {
        // For grade 5: ages 10-12 (born 2012-2014)
        // For grade 8: ages 13-15 (born 2009-2011)
        $year = $grade === 5 ? rand(2012, 2014) : rand(2009, 2011);
        $month = rand(1, 12);
        $day = rand(1, 28); // Safe day to avoid invalid dates

        return Carbon::create($year, $month, $day);
    }

    private function generateRollNumber($grade, $gender)
    {
        $baseNumbers = [
            '5_male' => 11201,
            '5_female' => 12201,
            '8_male' => 13201,
            '8_female' => 14201,
        ];

        $key = $grade . '_' . $gender;
        $base = $baseNumbers[$key];

        // Find the next available roll number
        $existing = Student::where('roll_number', 'like', substr($base, 0, 3) . '%')
            ->orderBy('roll_number', 'desc')
            ->first();

        if ($existing) {
            $lastNumber = (int) substr($existing->roll_number, 3);
            return substr($base, 0, 3) . str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);
        }

        return $base;
    }

    private function getRandomSchoolName()
    {
        $schoolNames = [
            'City Public School',
            'Green Valley Academy',
            'Sunrise International School',
            'Bright Future High School',
            'Knowledge Hub School',
            'Star Academy',
            'Modern Education Center',
            'Elite Learning Institute',
            'Progressive School System',
            'Academic Excellence School'
        ];

        return $schoolNames[array_rand($schoolNames)];
    }

    private function getRandomContact()
    {
        // Generate random Pakistani phone numbers
        $prefixes = ['0300', '0301', '0302', '0303', '0304', '0305', '0306', '0307', '0308', '0309',
                     '0310', '0311', '0312', '0313', '0314', '0315', '0316', '0317', '0318', '0319',
                     '0320', '0321', '0322', '0323', '0324', '0325', '0326', '0327', '0328', '0329'];

        $prefix = $prefixes[array_rand($prefixes)];
        $number = str_pad(rand(1000000, 9999999), 7, '0', STR_PAD_LEFT);

        return $prefix . $number;
    }
}