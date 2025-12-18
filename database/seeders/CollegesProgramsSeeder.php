<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\College;
use App\Models\Program;

class CollegesProgramsSeeder extends Seeder
{
    public function run(): void
    {
        // USeP Colleges and Programs
        $colleges = [
            [
                'name' => 'College of Education',
                'code' => 'CoE',
                'programs' => [
                    ['name' => 'Bachelor of Secondary Education', 'code' => 'BSEd'],
                    ['name' => 'Bachelor of Elementary Education', 'code' => 'BEEd'],
                    ['name' => 'Bachelor of Early Childhood Education', 'code' => 'BECEd'],
                    ['name' => 'Bachelor of Special Needs Education', 'code' => 'BSNEd'],
                    ['name' => 'Bachelor of Physical Education', 'code' => 'BPEd'],
                    ['name' => 'Bachelor of Technology and Livelihood Education major in Home Economics', 'code' => 'BTLEd-HE'],
                    ['name' => 'Bachelor of Technical-Vocational Teacher Education', 'code' => 'BTVTEd'],
                ]
            ],
            [
                'name' => 'College of Arts and Sciences',
                'code' => 'CAS',
                'programs' => [
                    ['name' => 'Bachelor of Arts in Literature and Cultural Studies', 'code' => 'AB-LCS'],
                    ['name' => 'Bachelor of Arts in English Language major in Applied Linguistics', 'code' => 'AB-EL-AL'],
                    ['name' => 'Bachelor of Science in Biology', 'code' => 'BS-Bio'],
                    ['name' => 'Bachelor of Science in Mathematics', 'code' => 'BS-Math'],
                    ['name' => 'Bachelor of Science in Statistics', 'code' => 'BS-Stat'],
                ]
            ],
            [
                'name' => 'College of Business Administration',
                'code' => 'CBA',
                'programs' => [
                    ['name' => 'Bachelor of Science in Business Administration Major in Financial Management', 'code' => 'BSBA-FM'],
                    ['name' => 'Bachelor of Science in Hospitality Management', 'code' => 'BSHM'],
                    ['name' => 'Bachelor of Science in Entrepreneurship', 'code' => 'BS-Entrep'],
                    ['name' => 'Bachelor of Science in Accountancy', 'code' => 'BSA'],
                ]
            ],
            [
                'name' => 'College of Engineering',
                'code' => 'CoEng',
                'programs' => [
                    ['name' => 'Bachelor of Science in Civil Engineering', 'code' => 'BSCE'],
                    ['name' => 'Bachelor of Science in Electrical Engineering', 'code' => 'BSEE'],
                    ['name' => 'Bachelor of Science in Electronics Engineering', 'code' => 'BSEcE'],
                    ['name' => 'Bachelor of Science in Geodetic Engineering', 'code' => 'BSGE'],
                    ['name' => 'Bachelor of Science in Geology', 'code' => 'BS-Geo'],
                    ['name' => 'Bachelor of Science in Mechanical Engineering', 'code' => 'BSME'],
                    ['name' => 'Bachelor of Science in Mining Engineering', 'code' => 'BSMinE'],
                    ['name' => 'Bachelor of Science in Sanitary Engineering', 'code' => 'BSSE'],
                ]
            ],
            [
                'name' => 'College of Technology',
                'code' => 'CT',
                'programs' => [
                    ['name' => 'Bachelor of Science in Industrial Technology', 'code' => 'BSIT'],
                ]
            ],
            [
                'name' => 'College of Information and Computing',
                'code' => 'CIC',
                'programs' => [
                    ['name' => 'Bachelor of Science in Information Technology', 'code' => 'BSIT'],
                    ['name' => 'Bachelor of Science in Computer Science', 'code' => 'BSCS'],
                    ['name' => 'Bachelor of Library and Information Science', 'code' => 'BLIS'],
                ]
            ],
            [
                'name' => 'College of Applied Economics',
                'code' => 'CAEC',
                'programs' => [
                    ['name' => 'Bachelor of Science in Economics', 'code' => 'BS-Econ'],
                ]
            ],
        ];

        foreach ($colleges as $collegeData) {
            $college = College::create([
                'name' => $collegeData['name'],
                'code' => $collegeData['code'],
                'is_active' => true,
            ]);

            foreach ($collegeData['programs'] as $programData) {
                Program::create([
                    'college_id' => $college->id,
                    'name' => $programData['name'],
                    'code' => $programData['code'],
                    'is_active' => true,
                ]);
            }
        }
    }
}
