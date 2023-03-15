<?php

namespace App\Http\Controllers;

use App\city;
use App\province;

ini_set('max_execution_time', 180); //3 minutes
class TestController extends Controller
{

    public function testerfunction()
    {

        echo '<pre>';
        $provinces = [];
        $provinces[] = [
            'name' => 'Metro Manila',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Caloocan',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                ['name' => 'Las Piñas',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                ['name' => 'Makati',
                    'is_enabled' => 1,
                    'province' => 1],
                ['name' => 'Malabon',
                    'is_enabled' => 1,
                    'province' => 1],
                ['name' => 'Mandaluyong',
                    'is_enabled' => 1,
                    'province' => 1],
                ['name' => 'Manila',
                    'is_enabled' => 1,
                    'province' => 1],
                ['name' => 'Marikina',
                    'is_enabled' => 1,
                    'province' => 1],
                ['name' => 'Muntinlupa',
                    'is_enabled' => 1,
                    'province' => 1],
                ['name' => 'Navotas',
                    'is_enabled' => 1,
                    'province' => 1],
                ['name' => 'Parañaque',
                    'is_enabled' => 1,
                    'province' => 1],
                ['name' => 'Pasay',
                    'is_enabled' => 1,
                    'province' => 1],
                ['name' => 'Pasig',
                    'is_enabled' => 1,
                    'province' => 1],
                ['name' => 'Pateros',
                    'is_enabled' => 1,
                    'province' => 1],
                ['name' => 'Quezon City',
                    'is_enabled' => 1,
                    'province' => 1],
                ['name' => 'San Juan',
                    'is_enabled' => 1,
                    'province' => 1],
                ['name' => 'Taguig',
                    'is_enabled' => 1,
                    'province' => 1],
                ['name' => 'Valenzuela',
                    'is_enabled' => 1,
                    'province' => 1],
            ],
        ];

        $provinces[] = [
            'name' => 'Abra',
            'is_enabled' => 1,
            'cities' => [

                [
                    'name' => 'Bangued',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'Boliney',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'Bucay',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'Bucloc',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'Daguioman',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'Danglas',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'Dolores',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'La Paz',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'Lacub',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'Lagangilang',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'Lagayan',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'Langiden',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'Licuan-Baay',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'Luba',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'Malibcong',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'Manabo',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'Peñarrubia',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'Pidigan',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'Pilar',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'Sallapadan',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'San Isidro',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'San Juan',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'San Quintin',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'Tayum',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'Tineg',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'Tubo',
                    'is_enabled' => 1,
                    'province' => 1,
                ],
                [
                    'name' => 'Villaviciosa',
                    'is_enabled' => 1,
                    'province' => 1,
                ],

            ],
        ];

        $provinces[] = [
            'name' => 'Agusan del Norte',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Buenavista',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Butuan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cabadbaran',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Carmen',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Jabonga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kitcharao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Las Nieves',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Magallanes',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Nasipit',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Remedios T. Romualdez',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santiago',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tubay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Agusan del Sur',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Bayugan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bunawan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Esperanza',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'La Paz',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Loreto',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Prosperidad',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Rosario',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Francisco',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Luis',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Josefa',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sibagat',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Talacogon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Trento',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Veruela',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Aklan',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Altavas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Balete',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Banga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Batan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Buruanga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ibajay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kalibo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lezo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Libacao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Madalag',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Makato',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Malay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Malinao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Nabas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'New Washington',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Numancia',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tangalan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Albay',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Bacacay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Camalig',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Daraga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Guinobatan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Jovellar',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Legazpi',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Libon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ligao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Malilipot',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Malinao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Manito',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Oas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pio Duran',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Polangui',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Rapu-Rapu',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santo Domingo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tabaco',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tiwi',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Antique',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Anini-y',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Barbaza',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Belison',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bugasong',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Caluya',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Culasi',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Hamtic',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Laua-an',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Libertad',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pandan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Patnongon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Jose de Buenavista',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Remigio',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sebaste',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sibalom',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tibiao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tobias Fornier',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Valderrama',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Apayao',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Calanasan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Conner',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Flora',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kabugao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Luna',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pudtol',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Marcela',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Aurora',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Baler',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Casiguran',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dilasag',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dinalungan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dingalan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dipaculao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Maria Aurora',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Luis',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Basilan',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Akbar',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Al-Barka',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Hadji Mohammad Ajul',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Hadji Muhtamad',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Isabela',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lamitan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lantawan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Maluso',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sumisip',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tabuan-Lasa',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tipo-Tipo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tuburan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ungkaya Pukan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Bataan',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Abucay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bagac',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Balanga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dinalupihan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Hermosa',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Limay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mariveles',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Morong',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Orani',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Orion',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pilar',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Samal',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Batanes',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Basco',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Itbayat',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ivana',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mahatao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sabtang',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Uyugan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Batangas',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Agoncillo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Alitagtag',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Balayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Balete',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Batangas City',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bauan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Calaca',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Calatagan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cuenca',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ibaan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Laurel',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lemery',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lian',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lipa',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lobo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mabini',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Malvar',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mataasnakahoy',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Nasugbu',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Padre Garcia',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Rosario',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Jose',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Juan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Luis',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Nicolas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Pascual',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Teresita',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santo Tomas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Taal',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Talisay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tanauan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Taysan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tingloy',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tuy',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Benguet',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Atok',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Baguio',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bakun',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bokod',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Buguias',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Itogon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kabayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kapangan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kibungan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'La Trinidad',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mankayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sablan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tuba',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tublay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Biliran',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Almeria',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Biliran',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cabucgayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Caibiran',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Culaba',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kawayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Maripipi',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Naval',
                    'is_enabled' => 1,
                    'province' => 3,
                ],

            ],
        ];

        $provinces[] = [
            'name' => 'Bohol',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Alburquerque',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Alicia',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Anda',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Antequera',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Baclayon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Balilihan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Batuan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bien Unido',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bilar',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Buenavista',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Calape',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Candijay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Carmen',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Catigbian',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Clarin',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Corella',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cortes',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dagohoy',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Danao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dauis',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dimiao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Duero',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Garcia Hernandez',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Getafe',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Guindulman',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Inabanga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Jagna',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lila',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Loay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Loboc',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Loon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mabini',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Maribojoc',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Panglao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pilar',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'President Carlos P. Garcia',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sagbayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Isidro',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Miguel',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sevilla',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sierra Bullones',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sikatuna',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tagbilaran',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Talibon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Trinidad',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tubigon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ubay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Valencia',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Bukidnon',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Baungon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cabanglasan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Damulog',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dangcagan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Don Carlos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Impasugong',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kadingilan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kalilangan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kibawe',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kitaotao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lantapan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Libona',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Malaybalay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Malitbog',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Manolo Fortich',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Maramag',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pangantucan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Quezon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Fernando',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sumilao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Talakag',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Valencia',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Bulacan',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Angat',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Balagtas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Baliuag',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bocaue',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bulakan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bustos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Calumpit',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Doña Remedios Trinidad',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Guiguinto',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Hagonoy',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Malolos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Marilao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Meycauayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Norzagaray',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Obando',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pandi',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Paombong',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Plaridel',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pulilan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Ildefonso',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Jose del Monte',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Miguel',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Rafael',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Maria',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Cagayan',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Abulug',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Alcala',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Allacapan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Amulung',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Aparri',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Baggao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ballesteros',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Buguey',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Calayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Camalaniugan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Claveria',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Enrile',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Gattaran',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Gonzaga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Iguig',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lal-lo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lasam',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pamplona',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Peñablanca',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Piat',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Rizal',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sanchez-Mira',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Ana',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Praxedes',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Teresita',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santo Niño',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Solana',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tuao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tuguegarao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Camarines Norte',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Basud',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Capalonga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Daet',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Jose Panganiban',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Labo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mercedes',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Paracale',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Lorenzo Ruiz',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Vicente',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Elena',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Talisay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Vinzons',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Camarines Sur',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Baao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Balatan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bato',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bombon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Buhi',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bula',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cabusao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Calabanga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Camaligan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Canaman',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Caramoan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Del Gallego',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Gainza',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Garchitorena',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Goa',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Iriga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lagonoy',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Libmanan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lupi',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Magarao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Milaor',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Minalabac',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Nabua',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Naga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ocampo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pamplona',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pasacao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pili',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Presentacion',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ragay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sagñay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Fernando',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Jose',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sipocot',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Siruma',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tigaon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tinambac',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Camiguin',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Catarman',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Guinsiliban',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mahinog',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mambajao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sagay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Capiz',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Cuartero',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dumalag',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dumarao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ivisan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Jamindan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ma-ayon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mambusao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Panay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Panitan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pilar',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pontevedra',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'President Roxas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Roxas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sapian',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sigma',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tapaz',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Catanduanes',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Bagamanoc',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Baras',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bato',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Caramoran',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Gigmoto',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pandan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Panganiban',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Andres',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Miguel',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Viga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Virac',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Cavite',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Alfonso',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Amadeo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bacoor',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Carmona',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cavite City',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dasmariñas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'General Emilio Aguinaldo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'General Mariano Alvarez',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'General Trias',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Imus',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Indang',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kawit',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Magallanes',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Maragondon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mendez',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Naic',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Noveleta',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Rosario',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Silang',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tagaytay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tanza',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ternate',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Trece Martires',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Cebu',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Alcantara',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Alcoy',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Alegria',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Aloguinsan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Argao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Asturias',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Badian',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Balamban',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bantayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Barili',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bogo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Boljoon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Borbon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Carcar',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Carmen',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Catmon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cebu City',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Compostela',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Consolacion',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cordova',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Daanbantayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dalaguete',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Danao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dumanjug',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ginatilan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lapu-Lapu',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Liloan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Madridejos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Malabuyoc',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mandaue',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Medellin',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Minglanilla',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Moalboal',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Naga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Oslob',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pilar',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pinamungajan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Poro',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ronda',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Samboan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Fernando',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Francisco',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Remigio',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Fe',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santander',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sibonga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sogod',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tabogon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tabuelan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Talisay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Toledo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tuburan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tudela',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Cotabato',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Alamada',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Aleosan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Antipas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Arakan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Banisilan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Carmen',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kabacan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kidapawan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Libungan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => "M'lang",
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Magpet',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Makilala',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Matalam',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Midsayap',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pigcawayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pikit',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'President Roxas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tulunan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],

            ],
        ];

        $provinces[] = [
            'name' => 'Davao de Oro',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Compostela',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Laak',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mabini',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Maco',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Maragusan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mawab',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Monkayo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Montevista',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Nabunturan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'New Bataan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pantukan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Davao del Norte',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Asuncion',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Braulio E. Dujali',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Carmen',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kapalong',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'New Corella',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Panabo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Samal',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Isidro',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santo Tomas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tagum',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Talaingod',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Davao del Sur',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Bansalan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Davao City',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Digos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Hagonoy',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kiblawan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Magsaysay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Malalag',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Matanao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Padada',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Cruz',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sulop',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Davao Occidental',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Don Marcelino',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Jose Abad Santos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Malita',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Maria',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sarangani',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Davao Oriental',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Baganga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Banaybanay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Boston',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Caraga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cateel',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Governor Generoso',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lupon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Manay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mati',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Isidro',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tarragona',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Dinagat Islands',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Basilisa',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cagdianao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dinagat',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Libjo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Loreto',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Jose',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tubajon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Eastern Samar',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Arteche',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Balangiga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Balangkayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Borongan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Can-avid',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dolores',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'General MacArthur',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Giporlos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Guiuan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Hernani',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Jipapad',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lawaan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Llorente',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Maslog',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Maydolong',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mercedes',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Oras',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Quinapondan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Salcedo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Julian',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Policarpo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sulat',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Taft',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Guimaras',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Buenavista',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Jordan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Nueva Valencia',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Lorenzo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sibunag',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Ifugao',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Aguinaldo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Alfonso Lista',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Asipulo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Banaue',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Hingyon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Hungduan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kiangan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lagawe',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lamut',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mayoyao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tinoc',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Ilocos Norte',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Adams',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bacarra',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Badoc',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bangui',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Banna',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Batac',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Burgos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Carasi',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Currimao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dingras',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dumalneg',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Laoag',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Marcos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Nueva Era',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pagudpud',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Paoay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pasuquin',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Piddig',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pinili',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Nicolas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sarrat',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Solsona',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Vintar',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Ilocos Sur',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Alilem',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Banayoyo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bantay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Burgos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cabugao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Candon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Caoayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cervantes',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Galimuyod',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Gregorio del Pilar',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lidlidda',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Magsingal',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Nagbukel',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Narvacan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Quirino',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Salcedo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Emilio',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Esteban',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Ildefonso',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Juan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Vicente',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Catalina',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Cruz',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Lucia',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Maria',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santiago',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santo Domingo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sigay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sinait',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sugpon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Suyo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tagudin',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Vigan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],

            ],
        ];

        $provinces[] = [
            'name' => 'Iloilo',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Ajuy',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Alimodian',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Anilao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Badiangan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Balasan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Banate',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Barotac Nuevo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Barotac Viejo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Batad',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bingawan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cabatuan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Calinog',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Carles',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Concepcion',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dingle',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dueñas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dumangas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Estancia',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Guimbal',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Igbaras',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Iloilo City',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Janiuay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lambunao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Leganes',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lemery',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Leon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Maasin',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Miagao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mina',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'New Lucena',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Oton',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Passi',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pavia',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pototan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Dionisio',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Enrique',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Joaquin',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Miguel',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Rafael',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Barbara',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sara',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tigbauan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tubungan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Zarraga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],

            ],
        ];

        $provinces[] = [
            'name' => 'Isabela',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Alicia',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Angadanan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Aurora',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Benito Soliven',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Burgos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cabagan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cabatuan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cauayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cordon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Delfin Albano',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dinapigue',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Divilacan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Echague',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Gamu',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ilagan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Jones',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Luna',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Maconacon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mallig',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Naguilian',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Palanan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Quezon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Quirino',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ramon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Reina Mercedes',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Roxas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Agustin',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Guillermo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Isidro',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Manuel',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Mariano',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Mateo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Pablo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Maria',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santiago',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santo Tomas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tumauini',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Kalinga',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Balbalan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lubuagan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pasil',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pinukpuk',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Rizal',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tabuk',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tanudan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tinglayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'La Union',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Agoo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Aringay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bacnotan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bagulin',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Balaoan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bangar',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bauang',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Burgos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Caba',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Luna',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Naguilian',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pugo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Rosario',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Fernando',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Gabriel',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Juan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santo Tomas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santol',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sudipen',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tubao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Laguna',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Alaminos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Biñan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cabuyao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Calamba',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Calauan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cavinti',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Famy',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kalayaan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Liliw',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Los Baños',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Luisiana',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lumban',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mabitac',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Magdalena',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Majayjay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Nagcarlan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Paete',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pagsanjan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pakil',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pangil',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pila',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Rizal',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Pablo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Pedro',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Cruz',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Maria',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Rosa',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Siniloan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Victoria',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Lanao del Norte',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Bacolod',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Balo-i',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Baroy',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Iligan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kapatagan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kauswagan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kolambugan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lala',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Linamon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Magsaysay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Maigo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Matungao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Munai',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Nunungan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pantao Ragat',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pantar',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Poona Piagapo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Salvador',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sapad',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sultan Naga Dimaporo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tagoloan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tangcal',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tubod',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Lanao del Sur',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Amai Manabilang',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bacolod-Kalawi',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Balabagan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Balindong',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bayang',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Binidayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Buadiposo-Buntong',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bubong',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Butig',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Calanogas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ditsaan-Ramain',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ganassi',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kapai',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kapatagan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lumba-Bayabao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lumbaca-Unayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lumbatan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lumbayanague',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Madalum',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Madamba',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Maguing',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Malabang',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Marantao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Marawi',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Marogong',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Masiu',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mulondo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pagayawan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Piagapo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Picong',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Poona Bayabao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pualas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Saguiaran',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sultan Dumalondong',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tagoloan II',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tamparan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Taraka',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tubaran',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tugaya',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Wao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Leyte',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Abuyog',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Alangalang',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Albuera',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Babatngon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Barugo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bato',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Baybay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Burauen',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Calubian',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Capoocan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Carigara',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dagami',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dulag',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Hilongos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Hindang',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Inopacan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Isabel',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Jaro',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Javier',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Julita',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kananga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'La Paz',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Leyte',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'MacArthur',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mahaplag',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Matag-ob',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Matalom',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mayorga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Merida',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ormoc',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Palo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Palompon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pastrana',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Isidro',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Miguel',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Fe',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tabango',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tabontabon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tacloban',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tanauan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tolosa',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tunga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Villaba',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Maguindanao',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Ampatuan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Barira',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Buldon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Buluan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cotabato City',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Datu Abdullah Sangki',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Datu Anggal Midtimbang',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Datu Blah T. Sinsuat',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Datu Hoffer Ampatuan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Datu Montawal',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Datu Odin Sinsuat',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Datu Paglas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Datu Piang',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Datu Salibo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Datu Saudi-Ampatuan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Datu Unsay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'General Salipada K. Pendatun',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Guindulungan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kabuntalan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mamasapano',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mangudadatu',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Matanog',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Northern Kabuntalan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pagalungan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Paglat',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pandag',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Parang',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Rajah Buayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Shariff Aguak',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Shariff  Saydona Mustapha',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'South Upi',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sultan Kudarat',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sultan Mastura',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sultan Sumagka',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sultan sa Barongis',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Talayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Upi',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Marinduque',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Boac',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Buenavista',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Gasan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mogpog',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Cruz',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Torrijos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Masbate',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Aroroy',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Baleno',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Balud',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Batuan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cataingan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cawayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Claveria',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dimasalang',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Esperanza',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mandaon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Masbate City',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Milagros',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mobo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Monreal',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Palanas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pio V. Corpuz',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Placer',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Fernando',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Jacinto',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Pascual',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Uson',
                    'is_enabled' => 1,
                    'province' => 3,
                ],

            ],
        ];
        $provinces[] = [
            'name' => 'Misamis Occidental',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Aloran',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Baliangao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bonifacio',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Calamba',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Clarin',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Concepcion',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Don Victoriano Chiongbian',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Jimenez',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lopez Jaena',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Oroquieta',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ozamiz',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Panaon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Plaridel',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sapang Dalaga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sinacaban',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tangub',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tudela',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Misamis Oriental',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Alubijid',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Balingasag',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Balingoan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Binuangan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cagayan de Oro',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Claveria',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'El Salvador',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Gingoog',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Gitagum',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Initao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Jasaan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kinoguitan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lagonglong',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Laguindingan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Libertad',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lugait',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Magsaysay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Manticao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Medina',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Naawan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Opol',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Salay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sugbongcogon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tagoloan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Talisayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Villanueva',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Mountain Province',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Barlig',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bauko',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Besao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bontoc',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Natonin',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Paracelis',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sabangan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sadanga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sagada',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tadian',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Negros Occidental',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Bacolod',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bago',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Binalbagan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cadiz',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Calatrava',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Candoni',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cauayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Enrique B. Magalona',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Escalante',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Himamaylan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Hinigaran',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Hinoba-an',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ilog',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Isabela',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kabankalan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'La Carlota',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'La Castellana',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Manapla',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Moises Padilla',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Murcia',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pontevedra',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pulupandan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sagay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Salvador Benedicto',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Carlos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Enrique',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Silay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sipalay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Talisay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Toboso',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Valladolid',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Victorias',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Negros Oriental',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Amlan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ayungon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bacong',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bais',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Basay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bayawan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bindoy',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Canlaon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dauin',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dumaguete',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Guihulngan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Jimalalud',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'La Libertad',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mabinay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Manjuyod',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pamplona',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Jose',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Catalina',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Siaton',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sibulan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tanjay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tayasan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Valencia',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Vallehermoso',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Zamboanguita',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Northern Samar',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Allen',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Biri',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bobon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Capul',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Catarman',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Catubig',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Gamay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Laoang',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lapinig',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Las Navas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lavezares',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lope de Vega',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mapanas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mondragon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Palapag',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pambujan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Rosario',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Antonio',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Isidro',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Jose',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Roque',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Vicente',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Silvino Lobos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Victoria',
                    'is_enabled' => 1,
                    'province' => 3,
                ],

            ],
        ];

        $provinces[] = [
            'name' => 'Nueva Ecija',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Aliaga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bongabon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cabanatuan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cabiao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Carranglan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cuyapo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Gabaldon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Gapan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'General Mamerto Natividad',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'General Tinio',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Guimba',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Jaen',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Laur',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Licab',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Llanera',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lupao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Muñoz',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Nampicuan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Palayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pantabangan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Peñaranda',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Quezon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Rizal',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Antonio',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Isidro',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Jose',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Leonardo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Rosa',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santo Domingo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Talavera',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Talugtug',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Zaragoza',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Nueva Vizcaya',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Alfonso Castañeda',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ambaguio',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Aritao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bagabag',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bambang',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bayombong',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Diadi',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dupax del Norte',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dupax del Sur',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kasibu',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kayapa',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Quezon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Fe',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Solano',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Villaverde',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Occidental Mindoro',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Abra de Ilog',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Calintaan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Looc',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lubang',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Magsaysay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mamburao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Paluan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Rizal',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sablayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Jose',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Cruz',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Oriental Mindoro',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Baco',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bansud',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bongabong',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bulalacao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Calapan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Gloria',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mansalay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Naujan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pinamalayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pola',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Puerto Galera',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Roxas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Teodoro',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Socorro',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Victoria',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Palawan',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Aborlan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Agutaya',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Araceli',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Balabac',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bataraza',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => "Brooke's Point",
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Busuanga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cagayancillo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Coron',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Culion',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cuyo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dumaran',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'El Nido',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kalayaan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Linapacan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Magsaysay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Narra',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Puerto Princesa',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Quezon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Rizal',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Roxas Palawan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Vicente',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sofronio Española',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Taytay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Pampanga',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Angeles',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Apalit',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Arayat',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bacolor',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Candaba',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Floridablanca',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Guagua',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lubao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mabalacat',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Macabebe',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Magalang',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Masantol',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mexico',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Minalin',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Porac',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Fernando',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Luis',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Simon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Ana',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Rita',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santo Tomas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sasmuan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Pangasinan',
            'is_enabled' => 1,
            'cities' => [

                [
                    'name' => 'Aguilar',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Alaminos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Alcala',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Anda',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Asingan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Balungao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bani',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Basista',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bautista',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bayambang',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Binalonan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Binmaley',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bolinao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bugallon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Burgos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Calasiao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dagupan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dasol',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Infanta',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Labrador',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Laoac',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lingayen',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mabini',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Malasiqui',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Manaoag',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mangaldan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mangatarem',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mapandan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Natividad',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pozorrubio',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Rosales',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Carlos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Fabian',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Jacinto',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Manuel',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Nicolas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Quintin',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Barbara',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Maria',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santo Tomas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sison',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sual',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tayug',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Umingan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Urbiztondo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Urdaneta',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Villasis',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Quezon',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Agdangan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Alabat',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Atimonan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Buenavista',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Burdeos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Calauag',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Candelaria',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Catanauan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dolores',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'General Luna',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'General Nakar',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Guinayangan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Gumaca',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Infanta',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Jomalig',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lopez',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lucban',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lucena',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Macalelon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mauban',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mulanay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Padre Burgos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pagbilao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Panukulan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Patnanungan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Perez',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pitogo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Plaridel',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Polillo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Quezon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Real',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sampaloc',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Andres',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Antonio',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Francisco',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Narciso',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sariaya',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tagkawayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tayabas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tiaong',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Unisan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Quirino',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Aglipay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cabarroguis',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Diffun',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Maddela',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Nagtipunan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Saguday',
                    'is_enabled' => 1,
                    'province' => 3,
                ],

            ],
        ];

        $provinces[] = [
            'name' => 'Rizal',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Angono',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Antipolo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Baras',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Binangonan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cainta',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cardona',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Jalajala',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Morong',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pililla',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Rodriguez',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Mateo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tanay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Taytay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Teresa',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Romblon',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Alcantara',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Banton',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cajidiocan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Calatrava',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Concepcion',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Corcuera',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ferrol',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Looc',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Magdiwang',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Odiongan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Romblon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Agustin',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Andres',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Fernando',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Jose',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Fe',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Maria',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Samar',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Almagro',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Basey',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Calbayog',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Calbiga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Catbalogan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Daram',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Gandara',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Hinabangan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Jiabong',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Marabut',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Matuguinao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Motiong',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pagsanghan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Paranas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pinabacdao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Jorge',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Jose de Buan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Sebastian',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Margarita',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Rita',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santo Niño',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tagapul-an',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Talalora',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tarangnan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Villareal',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Zumarraga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Sarangani',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Alabel',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Glan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kiamba',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Maasim',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Maitum',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Malapatan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Malungon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],

            ],
        ];

        $provinces[] = [
            'name' => 'Siquijor',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Enrique Villanueva',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Larena',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lazi',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Maria',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Juan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Siquijor',
                    'is_enabled' => 1,
                    'province' => 3,
                ],

            ],
        ];

        $provinces[] = [
            'name' => 'Sorsogon',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Barcelona',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bulan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bulusan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Casiguran',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Castilla',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Donsol',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Gubat',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Irosin',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Juban',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Magallanes',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Matnog',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pilar',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Prieto Diaz',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Magdalena',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sorsogon City',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'South Cotabato',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Banga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'General Santos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Koronadal',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lake Sebu',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Norala',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Polomolok',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santo Niño',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Surallah',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => "T'Boli",
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tampakan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tantangan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tupi',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Southern Leyte',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Anahawan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bontoc',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Hinunangan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Hinundayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Libagon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Liloan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Limasawa',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Maasin',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Macrohon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Malitbog',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Padre Burgos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pintuyan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Saint Bernard',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Francisco',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Juan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Ricardo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Silago',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sogod',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tomas Oppus',
                    'is_enabled' => 1,
                    'province' => 3,
                ],

            ],
        ];

        $provinces[] = [
            'name' => 'Sultan Kudarat',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Bagumbayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Columbio',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Esperanza',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Isulan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kalamansig',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lambayong',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lebak',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lutayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Palimbang',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'President Quirino',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Senator Ninoy Aquino',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tacurong',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Sulu',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Banguingui',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Hadji Panglima Tahil',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Indanan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Jolo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kalingalan Caluang',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lugus',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Luuk',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Maimbung',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Omar',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Panamao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pandami',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Panglima Estino',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pangutaran',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Parang',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pata',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Patikul',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Siasi',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Talipao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tapul',
                    'is_enabled' => 1,
                    'province' => 3,
                ],

            ],

        ];

        $provinces[] = [
            'name' => 'Surigao del Norte',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Bacuag',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Burgos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Claver',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dapa',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Del Carmen',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'General Luna',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Gigaquit',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mainit',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Malimono',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pilar',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Placer',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Benito',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Francisco',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Isidro',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Monica',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sison',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Socorro',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Surigao City',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tagana-an',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tubod',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Surigao del Sur',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Barobo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bayabas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bislig',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cagwait',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cantilan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Carmen',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Carrascal',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cortes',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Hinatuan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lanuza',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lianga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lingig',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Madrid',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Marihatag',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Agustin',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Miguel',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tagbina',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tago',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tandag',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Tarlac',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Anao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bamban',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Camiling',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Capas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Concepcion',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Gerona',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'La Paz',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mayantoc',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Moncada',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Paniqui',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pura',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ramos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Clemente',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Jose',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Manuel',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Ignacia',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tarlac City',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Victoria',
                    'is_enabled' => 1,
                    'province' => 3,
                ],

            ],
        ];

        $provinces[] = [
            'name' => 'Tawi-Tawi',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Bongao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Languyan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mapun',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Panglima Sugala',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sapa-Sapa',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sibutu',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Simunul',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sitangkai',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'South Ubian',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tandubas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Turtle Islands',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Zambales',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Botolan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Cabangan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Candelaria',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Castillejos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Iba',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Masinloc',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Olongapo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Palauig',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Antonio',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Felipe',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Marcelino',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Narciso',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Santa Cruz',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Subic',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Zamboanga del Norte',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Baliguian',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dapitan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dipolog',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Godod',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Gutalac',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Jose Dalman',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kalawit',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Katipunan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'La Libertad',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Labason',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Leon B. Postigo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Liloy',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Manukan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mutia',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Piñan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Polanco',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Rizal',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Roxas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Salug',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sergio Osmeña',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Siayan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sibuco',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sibutad',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sindangan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Siocon',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sirawai',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tampilisan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        $provinces[] = [
            'name' => 'Zamboanga del Sur',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Aurora',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Bayog',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dimataling',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dinas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dumalinao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Dumingag',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Guipos',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Josefina',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kumalarang',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Labangan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lakewood',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Lapuyan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mahayag',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Margosatubig',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Midsalip',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Molave',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pagadian',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Pitogo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ramon Magsaysay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Miguel',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'San Pablo',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Sominot',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tabina',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tambulig',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tigbao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tukuran',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Vincenzo A. Sagun',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Zamboanga City',
                    'is_enabled' => 1,
                    'province' => 3,
                ],

            ],

        ];

        $provinces[] = [
            'name' => 'Zamboanga Sibugay',
            'is_enabled' => 1,
            'cities' => [
                [
                    'name' => 'Alicia',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Buug',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Diplahan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Imelda',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Ipil',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Kabasalan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Mabuhay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Malangas',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Naga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Olutanga',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Payao',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Roseller Lim',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Siay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Talusan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Titay',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
                [
                    'name' => 'Tungawan',
                    'is_enabled' => 1,
                    'province' => 3,
                ],
            ],
        ];

        // alphabetically sort province
        usort($provinces, function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        foreach ($provinces as $kprovince => $vprovince) {
            $provinceCreate = province::create($vprovince);

            $cities = $vprovince['cities'];
            // alphabetically sort cities
            usort($cities, function ($a, $b) {
                return strcmp($a['name'], $b['name']);
            });

            $province_id = $provinceCreate->id;
            foreach ($cities as $kcity => $vcity) {
                $vcity['province'] = $province_id;
                $cityCreate = City::create($vcity);
            }
        }

    }
}
