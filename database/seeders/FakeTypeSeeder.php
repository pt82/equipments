<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FakeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['title' => 'TP-Link TL-WR74', 'mask' => 'XXAAAAAXAA'],
            ['title' => 'D-Link DIR-300', 'mask' => 'NXXAAXZXaa'],
            ['title' => 'D-Link DIR-300 E', 'mask' => 'NNAAAAAXAA'],
            ['title' => 'TP-Link TL-TN740', 'mask' => 'NXAAAAAXaA'],
        ];

        foreach ($data as $key => $value) {
            Type::create($value);
        }
    }
}
