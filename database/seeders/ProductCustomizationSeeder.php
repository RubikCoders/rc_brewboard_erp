<?php

namespace Database\Seeders;

use App\Models\ProductCustomization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCustomizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //region Bebidas calientes
        ProductCustomization::create([
            'id' => 1001,
            'product_id' => 1001,
            'name' => 'Tamaño',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1002,
            'product_id' => 1001,
            'name' => 'Tipo de leche',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1003,
            'product_id' => 1001,
            'name' => 'Jarabes',
            'required' => false,
        ]);

        ProductCustomization::create([
            'id' => 1004,
            'product_id' => 1001,
            'name' => 'Extras',
            'required' => false,
        ]);

        ProductCustomization::create([
            'id' => 1005,
            'product_id' => 1002,
            'name' => 'Tamaño',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1006,
            'product_id' => 1002,
            'name' => 'Tipo de leche',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1007,
            'product_id' => 1002,
            'name' => 'Jarabes',
            'required' => false,
        ]);

        ProductCustomization::create([
            'id' => 1008,
            'product_id' => 1002,
            'name' => 'Extras',
            'required' => false,
        ]);

        ProductCustomization::create([
            'id' => 1009,
            'product_id' => 1003,
            'name' => 'Tamaño',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1010,
            'product_id' => 1003,
            'name' => 'Tipo de leche',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1011,
            'product_id' => 1003,
            'name' => 'Jarabes',
            'required' => false,
        ]);

        ProductCustomization::create([
            'id' => 1012,
            'product_id' => 1003,
            'name' => 'Extras',
            'required' => false,
        ]);

        ProductCustomization::create([
            'id' => 1013,
            'product_id' => 1004,
            'name' => 'Sabor',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1014,
            'product_id' => 1004,
            'name' => 'Tamaño',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1015,
            'product_id' => 1004,
            'name' => 'Tipo de leche',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1016,
            'product_id' => 1004,
            'name' => 'Jarabes',
            'required' => false,
        ]);

        ProductCustomization::create([
            'id' => 1017,
            'product_id' => 1004,
            'name' => 'Extras',
            'required' => false,
        ]);

        ProductCustomization::create([
            'id' => 1018,
            'product_id' => 1005,
            'name' => 'Tamaño',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1019,
            'product_id' => 1005,
            'name' => 'Jarabes',
            'required' => false,
        ]);

        ProductCustomization::create([
            'id' => 1020,
            'product_id' => 1005,
            'name' => 'Extras',
            'required' => false,
        ]);

        ProductCustomization::create([
            'id' => 1021,
            'product_id' => 1006,
            'name' => 'Tamaño',
            'required' => true,
        ]);

        // Chocolate
        ProductCustomization::create([
            'id' => 1022,
            'product_id' => 1007,
            'name' => 'Tamaño',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1023,
            'product_id' => 1007,
            'name' => 'Tipo de leche',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1024,
            'product_id' => 1007,
            'name' => 'Jarabes',
            'required' => false,
        ]);

        ProductCustomization::create([
            'id' => 1025,
            'product_id' => 1007,
            'name' => 'Extras',
            'required' => false,
        ]);

        // Matcha
        ProductCustomization::create([
            'id' => 1026,
            'product_id' => 1008,
            'name' => 'Tamaño',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1027,
            'product_id' => 1008,
            'name' => 'Tipo de leche',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1028,
            'product_id' => 1008,
            'name' => 'Jarabes',
            'required' => false,
        ]);

        ProductCustomization::create([
            'id' => 1029,
            'product_id' => 1008,
            'name' => 'Extras',
            'required' => false,
        ]);

        // Chai
        ProductCustomization::create([
            'id' => 1030,
            'product_id' => 1009,
            'name' => 'Sabor',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1031,
            'product_id' => 1009,
            'name' => 'Tamaño',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1032,
            'product_id' => 1009,
            'name' => 'Tipo de leche',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1033,
            'product_id' => 1009,
            'name' => 'Jarabes',
            'required' => false,
        ]);

        ProductCustomization::create([
            'id' => 1034,
            'product_id' => 1009,
            'name' => 'Extras',
            'required' => false,
        ]);

        // Te
        ProductCustomization::create([
            'id' => 1035,
            'product_id' => 1010,
            'name' => 'Tipo',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1036,
            'product_id' => 1010,
            'name' => 'Tamaño',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1037,
            'product_id' => 1010,
            'name' => 'Extras',
            'required' => false,
        ]);

        // Tisanas
        ProductCustomization::create([
            'id' => 1038,
            'product_id' => 1011,
            'name' => 'Sabor',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1039,
            'product_id' => 1011,
            'name' => 'Tamaño',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1040,
            'product_id' => 1011,
            'name' => 'Jarabes',
            'required' => false,
        ]);

        ProductCustomization::create([
            'id' => 1041,
            'product_id' => 1011,
            'name' => 'Extras',
            'required' => false,
        ]);

        //endregion

        //region Bebidas frias
        // Latte frío (1012)
        ProductCustomization::create([
            'id' => 1042,
            'product_id' => 1012,
            'name' => 'Tamaño',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1043,
            'product_id' => 1012,
            'name' => 'Tipo de leche',
            'required' => true,
        ]);

        // Capuccino frío (1013)
        ProductCustomization::create([
            'id' => 1044,
            'product_id' => 1013,
            'name' => 'Tamaño',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1045,
            'product_id' => 1013,
            'name' => 'Tipo de leche',
            'required' => true,
        ]);

        // Cold Brew (1014)
        ProductCustomization::create([
            'id' => 1046,
            'product_id' => 1014,
            'name' => 'Tamaño',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1047,
            'product_id' => 1014,
            'name' => 'Extras',
            'required' => false,
        ]);

        // Americano frío (1015)
        ProductCustomization::create([
            'id' => 1048,
            'product_id' => 1015,
            'name' => 'Tamaño',
            'required' => true,
        ]);

        // Frappe Café (1011)
        ProductCustomization::create([
            'id' => 1049,
            'product_id' => 1016,
            'name' => 'Sabor',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1050,
            'product_id' => 1016,
            'name' => 'Tipo de leche',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1051,
            'product_id' => 1016,
            'name' => 'Extras',
            'required' => false,
        ]);

        // Chocolate frío (1017)
        ProductCustomization::create([
            'id' => 1052,
            'product_id' => 1017,
            'name' => 'Presentación',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1053,
            'product_id' => 1017,
            'name' => 'Tamaño',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1054,
            'product_id' => 1017,
            'name' => 'Tipo de leche',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1055,
            'product_id' => 1017,
            'name' => 'Extras',
            'required' => false,
        ]);

        // Matcha frío (1018)
        ProductCustomization::create([
            'id' => 1056,
            'product_id' => 1018,
            'name' => 'Presentación',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1057,
            'product_id' => 1018,
            'name' => 'Tamaño',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1058,
            'product_id' => 1018,
            'name' => 'Tipo de leche',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1059,
            'product_id' => 1018,
            'name' => 'Extras',
            'required' => false,
        ]);

        // Chai frío (1014)
        ProductCustomization::create([
            'id' => 1060,
            'product_id' => 1019,
            'name' => 'Sabor',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1061,
            'product_id' => 1019,
            'name' => 'Presentación',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1062,
            'product_id' => 1019,
            'name' => 'Tamaño',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1063,
            'product_id' => 1019,
            'name' => 'Tipo de leche',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1064,
            'product_id' => 1019,
            'name' => 'Extras',
            'required' => false,
        ]);

        // Tisanas frías (1020)
        ProductCustomization::create([
            'id' => 1065,
            'product_id' => 1020,
            'name' => 'Sabor',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1066,
            'product_id' => 1020,
            'name' => 'Presentación',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1067,
            'product_id' => 1020,
            'name' => 'Tamaño',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1068,
            'product_id' => 1020,
            'name' => 'Extras',
            'required' => false,
        ]);
        //endregion

        //region Alimentos
        // Paninis (1021)
        ProductCustomization::create([
            'id' => 1069,
            'product_id' => 1021,
            'name' => 'Tipo',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1070,
            'product_id' => 1021,
            'name' => 'Pan',
            'required' => true,
        ]);

        ProductCustomization::create([
            'id' => 1071,
            'product_id' => 1021,
            'name' => 'Extras',
            'required' => false,
        ]);

        // Rebanada de pastel (1022)
        ProductCustomization::create([
            'id' => 1072,
            'product_id' => 1022,
            'name' => 'Sabor',
            'required' => true,
        ]);

        // Galletas artesanales (1023)
        ProductCustomization::create([
            'id' => 1073,
            'product_id' => 1023,
            'name' => 'Cantidad',
            'required' => true,
        ]);

        //  Brownie (1024)
        ProductCustomization::create([
            'id' => 1074,
            'product_id' => 1024,
            'name' => 'Extras',
            'required' => false,
        ]);
        //endregion
    }
}
