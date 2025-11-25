<?php

namespace Database\Factories;

use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\MedicalRecord>
 */
class MedicalRecordFactory extends Factory
{
    protected $model = MedicalRecord::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'patient_id' => Patient::factory(),
            'tanggal_kunjungan' => $this->faker
                ->dateTimeBetween('-18 months', 'now')
                ->format('Y-m-d'),
            'diagnosa' => $this->faker->randomElement([
                'Hipertensi',
                'Diabetes Mellitus',
                'Infeksi Saluran Pernapasan Akut',
                'Gastritis',
                'Demam Berdarah',
                'Anemia',
            ]),
            'dokter' => 'dr. ' . $this->faker->lastName(),
            'catatan' => $this->faker->sentence(),
        ];
    }
}
