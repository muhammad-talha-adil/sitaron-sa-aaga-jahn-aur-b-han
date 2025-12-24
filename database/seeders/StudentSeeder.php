<?php

namespace Database\Seeders;

use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create students for each grade: 8/9/10 (only males)
        $grades = [8, 9, 10];

        foreach ($grades as $grade) {
            for ($i = 1; $i <= 25; $i++) { // Create 25 students per grade
                $firstName = $this->getRandomName('male');
                $fatherName = $this->getRandomFatherName();
                $dob = $this->getRandomDOB($grade);
                $age = $this->calculateAge($dob);
                $participationId = $this->generateParticipationId();
                $schoolName = $this->getRandomSchoolName(); // Always have school name
                $contact = $this->getRandomContact(); // Always have contact

                Student::create([
                    'school_name' => $schoolName,
                    'name' => $firstName,
                    'father' => $fatherName,
                    'dob' => $dob,
                    'age' => $age,
                    'grade' => (string) $grade,
                    'gender' => 'male',
                    'contact' => $contact,
                    'participation_id' => $participationId,
                    'payment_receipt' => null, // No receipt in seeder
                    'student_image' => null, // No image in seeder
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function getRandomName($gender)
    {
        $maleNames = ['Ahmed', 'Ali', 'Hassan', 'Hussain', 'Muhammad', 'Omar', 'Usman', 'Bilal', 'Saad', 'Fahad', 'Hamza', 'Ibrahim', 'Yusuf', 'Zain', 'Rayyan'];

        return $maleNames[array_rand($maleNames)];
    }

    private function getRandomFatherName()
    {
        $fatherNames = ['Muhammad Khan', 'Ahmed Ali', 'Hassan Butt', 'Ibrahim Malik', 'Yusuf Ahmed', 'Ali Khan', 'Omar Sheikh', 'Usman Raja', 'Bilal Mughal', 'Fahad Javed', 'Hamza Qureshi', 'Saad Bhatti', 'Zain Dar', 'Rayyan Gill', 'Asif Iqbal'];

        return $fatherNames[array_rand($fatherNames)];
    }

    private function getRandomDOB($grade)
    {
        // Generate DOB for ages 11-16
        $currentYear = now()->year;
        $age = rand(11, 16);
        $year = $currentYear - $age;
        $month = rand(1, 12);
        $day = rand(1, 28); // Safe day to avoid invalid dates

        return Carbon::create($year, $month, $day);
    }

    private function calculateAge($dob)
    {
        return Carbon::now()->diffInYears($dob);
    }

    private function generateParticipationId()
    {
        $maxId = Student::max('participation_id') ?? 10000;
        return $maxId + 1;
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
        $prefixes = [
            '0300',
            '0301',
            '0302',
            '0303',
            '0304',
            '0305',
            '0306',
            '0307',
            '0308',
            '0309',
            '0310',
            '0311',
            '0312',
            '0313',
            '0314',
            '0315',
            '0316',
            '0317',
            '0318',
            '0319',
            '0320',
            '0321',
            '0322',
            '0323',
            '0324',
            '0325',
            '0326',
            '0327',
            '0328',
            '0329'
        ];

        $prefix = $prefixes[array_rand($prefixes)];
        $number = str_pad(rand(1000000, 9999999), 7, '0', STR_PAD_LEFT);

        return $prefix . $number;
    }
}