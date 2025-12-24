<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schoolNames = [
            'Baxter Sheppard School', 'Green Valley Academy', 'Sunrise Public School', 'Bright Future Institute', 'Knowledge Hub School',
            'City Public School', 'Star Academy', 'Modern Education Center', 'Elite Learning Institute', 'Progressive School System',
            'Academic Excellence School', 'Global Education Academy', 'Future Leaders School', 'Innovative Learning Center', 'Prime Education Institute',
            'Excellence Academy', 'Smart Kids School', 'Brilliant Minds Institute', 'Success Path Academy', 'Visionary Education Center',
            'Pioneer School System', 'Advance Learning Academy', 'Superior Education Institute', 'Top Rank School', 'Leading Edge Academy',
            'Premier Education Center', 'Ultimate Learning Institute', 'Champion School', 'Victory Academy', 'Triumph Education Center'
        ];

        $streets = ['Main Street', 'Oak Avenue', 'Pine Road', 'Elm Street', 'Maple Drive', 'Cedar Lane', 'Birch Boulevard', 'Willow Way', 'Ash Alley', 'Spruce Street',
                    'Fir Road', 'Poplar Path', 'Beech Boulevard', 'Hazel Highway', 'Sycamore Street', 'Chestnut Circle', 'Walnut Walk', 'Alder Avenue',
                    'Linden Lane', 'Juniper Junction', 'Magnolia Meadow', 'Cypress Court', 'Redwood Road', 'Sequoia Street', 'Palm Parkway',
                    'Bamboo Boulevard', 'Eucalyptus Avenue', 'Acacia Alley', 'Dogwood Drive', 'Holly Hill'];

        $ownerNames = ['John Smith', 'Sarah Johnson', 'Michael Brown', 'Emily Davis', 'David Wilson', 'Ahmed Khan', 'Fatima Ali', 'Hassan Malik',
                       'Ayesha Butt', 'Muhammad Sheikh', 'Zainab Raja', 'Ali Mughal', 'Maryam Javed', 'Usman Bhatti', 'Hafsa Dar',
                       'Bilal Gill', 'Sana Iqbal', 'Omar Qureshi', 'Khadija Khan', 'Saad Ahmed', 'Amina Malik', 'Fahad Butt', 'Noor Sheikh',
                       'Hamza Raja', 'Sara Mughal', 'Ibrahim Javed', 'Hira Bhatti', 'Yusuf Dar', 'Mehreen Gill', 'Zain Iqbal'];

        $phones = [];
        for ($i = 0; $i < 30; $i++) {
            $prefix = '03' . rand(00, 29);
            $number = str_pad(rand(1000000, 9999999), 7, '0', STR_PAD_LEFT);
            $phones[] = $prefix . $number;
        }

        $schools = [];
        for ($i = 0; $i < 30; $i++) {
            $schools[] = [
                'school_name' => $schoolNames[$i],
                'address' => ($i + 1) * 10 . ' ' . $streets[$i % count($streets)] . ', Faisalabad',
                'owner_name' => $ownerNames[$i % count($ownerNames)],
                'phone' => $phones[$i],
                'payment_receipt' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach ($schools as $school) {
            School::create($school);
        }
    }
}