<?php

namespace Database\Seeders;

use App\Models\Printer;
use Illuminate\Database\Seeder;

class PrintersSeeder extends Seeder
{
    public function run(): void
    {
        $printers = [
            ['name' => 'Impresora Principal', 'ip' => '192.168.1.100', 'model' => 'EPSON L325', 'status' => 'online', 'is_available' => true, 'priority' => 1],
            ['name' => 'Impresora Secundaria', 'ip' => '192.168.1.101', 'model' => 'EPSON L355', 'status' => 'online', 'is_available' => true, 'priority' => 2],
            ['name' => 'Impresora Express', 'ip' => '192.168.1.102', 'model' => 'EPSON L375', 'status' => 'online', 'is_available' => true, 'priority' => 3],
            ['name' => 'Impresora Mantenimiento', 'ip' => '192.168.1.103', 'model' => 'EPSON L365', 'status' => 'maintenance', 'is_available' => false, 'priority' => 10],
        ];

        foreach ($printers as $data) {
            Printer::updateOrCreate(['ip' => $data['ip']], $data);
        }
    }
}

