<?php

namespace Database\Seeders;

use App\Models\CompanySetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySettingSeeder extends Seeder
{
    public function run()
    {
        CompanySetting::create([
            'business_hours' => ([
                ["day" => "monday", "open" => "08:00", "close" => "12:00", "open_afternoon" => "16:00", "close_afternoon" => "20:00"],
                ["day" => "tuesday", "open" => "08:00", "close" => "12:00", "open_afternoon" => "16:00", "close_afternoon" => "20:00"],
                ["day" => "wednesday", "open" => "08:00", "close" => "12:00", "open_afternoon" => "16:00", "close_afternoon" => "20:00"],
                ["day" => "thursday", "open" => "08:00", "close" => "12:00", "open_afternoon" => "16:00", "close_afternoon" => "20:00"],
                ["day" => "friday", "open" => "08:00", "close" => "12:00", "open_afternoon" => "16:00", "close_afternoon" => "20:00"],
                ["day" => "saturday", "open" => "09:00", "close" => "13:00", "open_afternoon" => "17:00", "close_afternoon" => "21:00"],
                ["day" => "sunday", "open" => null, "close" => null, "open_afternoon" => null, "close_afternoon" => null], // Cerrado
            ]),
            'payment_methods' => ([
                ["method" => "Efectivo"],
                ["method" => "Tarjeta de débito"],
                ["method" => "MercadoPago"],
            ]),
            'delivery_methods' => ([
                ["method" => "Delivery"]
            ]),
            'address' => ([
                ["address" => "RUTA 27 KM 80.3/80.4, X6271 Del Campillo, Córdoba", "gps" => "151515151, 151515151"],
            ]),
            'phone' => ([
                ["number" => "12345678"],
            ]),

        ]);
    }
}

// [{"0": "Efectivo", "method": "transfereci"}, {"method": "efectivo"}]