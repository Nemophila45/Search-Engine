<?php

namespace Database\Seeders;

use App\Models\MedicalRecord;
use App\Models\Patient;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;

class PatientMedicalRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = FakerFactory::create('id_ID');

        $patients = Patient::factory()
            ->count(100)
            ->create();

        $patients->each(function (Patient $patient) use ($faker): void {
            $recordCount = $faker->numberBetween(1, 4);

            $records = MedicalRecord::factory()
                ->count($recordCount)
                ->make([
                    'patient_id' => $patient->id,
                ]);

            $patient->medicalRecords()->saveMany($records);
        });
    }
}
