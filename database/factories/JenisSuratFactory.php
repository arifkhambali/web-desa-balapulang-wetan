<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JenisSuratFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama_surat' => $this->faker->words(2, true),
            'kode' => strtoupper($this->faker->lexify('SK??')),
            'icon' => 'fa-file',
            'color' => 'blue',
            'deskripsi' => $this->faker->sentence(),
            'persyaratan' => $this->faker->sentence(),
            'aktif' => true,
            'form_schema' => [],
        ];
    }
}
