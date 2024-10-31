<?php

namespace Database\Seeders;

use App\Models\Comuni;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComuniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csv = storage_path('app/csv_db/comuni.csv');
        $file = fopen($csv, 'r');

        while(($data = fgetcsv($file,200,',')) != false){
            Comuni::create(
                [
                    "idComune"=>$data[0],
                    "nome"=>$data[1],
                    "regione"=>$data[2],
                    "metropolitana"=>$data[3],
                    "provincia"=>$data[4],
                    "siglaAuto"=>$data[5],
                    "codCat"=>$data[6],
                    "capoluogo"=>$data[7],
                    "multicap"=>$data[8],
                    "cap"=>$data[9],
                    "capFine"=>$data[10],
                    "capInizio"=>$data[11]
                ]
                );
        }
    }
}
