<?php

namespace Database\Factories;

use App\Models\Layanan; // Import model Layanan
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Layanan>
 */
class LayananFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Layanan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       return [
            'nama_layanan' => $this->faker->sentence(4), // contoh: "Surat Keterangan Domisili Usaha"
            'deskripsi' => $this->faker->paragraph(2),
            'estimasi_proses' => $this->faker->randomElement(['1-2 Hari Kerja', '3-5 Hari Kerja', '1 Hari Kerja']),
            'biaya' => $this->faker->randomElement(['Rp 0,- (Gratis)', 'Rp 50.000,-']),
            'dasar_hukum' => $this->faker->randomElement(['PP No. 24 Tahun 1997', 'UU No. 5 Tahun 1960', 'Perda DKI Jakarta']),
            'status' => 'aktif', // default 'aktif' agar bisa langsung dipakai
        ];
    }
}