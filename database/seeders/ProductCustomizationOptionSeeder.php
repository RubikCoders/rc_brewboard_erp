<?php

namespace Database\Seeders;

use App\Models\ProductCustomizationOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCustomizationOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //region Caliente
        // Con kfeee

        //region Latte
        // Tamanio
        ProductCustomizationOption::create([
            'customization_id' => 1001,
            'name' => 'Grande',
            'extra_price' => 15
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1001,
            'name' => 'Mediano',
            'extra_price' => 10
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1001,
            'name' => 'Pequeño',
            'extra_price' => 5
        ]);

        // Tipo de leche
        ProductCustomizationOption::create([
            'customization_id' => 1002,
            'name' => 'Entera',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1002,
            'name' => 'Deslactosada',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1002,
            'name' => 'Soya',
            'extra_price' => 10
        ]);

        // Jarabes
        ProductCustomizationOption::create([
            'customization_id' => 1003,
            'name' => 'Vainilla',
            'extra_price' => 5
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1003,
            'name' => 'Almendra',
            'extra_price' => 5
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1003,
            'name' => 'Crema Irlandesa',
            'extra_price' => 5
        ]);

        // extra_prices
        ProductCustomizationOption::create([
            'customization_id' => 1004,
            'name' => 'Shot Espresso',
            'extra_price' => 10
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1004,
            'name' => 'Chocolate',
            'extra_price' => 7
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1004,
            'name' => 'Crema Batida',
            'extra_price' => 8
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1004,
            'name' => 'Canela Espolvoreada',
            'extra_price' => 8
        ]);
        //endregion

        //region Latte Caramelo
        // Tamanio
        ProductCustomizationOption::create([
            'customization_id' => 1005,
            'name' => 'Grande',
            'extra_price' => 15
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1005,
            'name' => 'Mediano',
            'extra_price' => 10
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1005,
            'name' => 'Pequeño',
            'extra_price' => 5
        ]);

        // Tipo de leche
        ProductCustomizationOption::create([
            'customization_id' => 1006,
            'name' => 'Entera',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1006,
            'name' => 'Deslactosada',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1006,
            'name' => 'Soya',
            'extra_price' => 10
        ]);

        // Jarabes
        ProductCustomizationOption::create([
            'customization_id' => 1007,
            'name' => 'Vainilla',
            'extra_price' => 5
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1007,
            'name' => 'Almendra',
            'extra_price' => 5
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1007,
            'name' => 'Crema Irlandesa',
            'extra_price' => 5
        ]);

        // extra_prices
        ProductCustomizationOption::create([
            'customization_id' => 1008,
            'name' => 'Shot Espresso',
            'extra_price' => 10
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1008,
            'name' => 'Chocolate',
            'extra_price' => 7
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1008,
            'name' => 'Crema Batida',
            'extra_price' => 8
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1008,
            'name' => 'Canela Espolvoreada',
            'extra_price' => 8
        ]);
        //endregion

        //region Capuccino
        // Tamanio
        ProductCustomizationOption::create([
            'customization_id' => 1009,
            'name' => 'Grande',
            'extra_price' => 15
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1009,
            'name' => 'Mediano',
            'extra_price' => 10
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1009,
            'name' => 'Pequeño',
            'extra_price' => 5
        ]);

        // Tipo de leche
        ProductCustomizationOption::create([
            'customization_id' => 1010,
            'name' => 'Entera',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1010,
            'name' => 'Deslactosada',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1010,
            'name' => 'Soya',
            'extra_price' => 10
        ]);

        // Jarabes
        ProductCustomizationOption::create([
            'customization_id' => 1011,
            'name' => 'Vainilla',
            'extra_price' => 5
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1011,
            'name' => 'Almendra',
            'extra_price' => 5
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1011,
            'name' => 'Crema Irlandesa',
            'extra_price' => 5
        ]);

        // extra_prices
        ProductCustomizationOption::create([
            'customization_id' => 1012,
            'name' => 'Shot Espresso',
            'extra_price' => 10
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1012,
            'name' => 'Chocolate',
            'extra_price' => 7
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1012,
            'name' => 'Crema Batida',
            'extra_price' => 8
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1012,
            'name' => 'Canela Espolvoreada',
            'extra_price' => 8
        ]);
        //endregion

        //region Mocha / Mocha Blanco

        // Sabor
        ProductCustomizationOption::create([
            'customization_id' => 1013,
            'name' => 'Clásico Chocolate',
            'extra_price' => 0
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1013,
            'name' => 'Chocolate Blanco',
            'extra_price' => 0
        ]);

        // Sabor
        ProductCustomizationOption::create([
            'customization_id' => 1014,
            'name' => 'Grande',
            'extra_price' => 15
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1014,
            'name' => 'Mediano',
            'extra_price' => 10
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1014,
            'name' => 'Pequeño',
            'extra_price' => 5
        ]);

        // Tipo de leche
        ProductCustomizationOption::create([
            'customization_id' => 1015,
            'name' => 'Entera',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1015,
            'name' => 'Deslactosada',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1015,
            'name' => 'Soya',
            'extra_price' => 10
        ]);

        // Jarabes
        ProductCustomizationOption::create([
            'customization_id' => 1016,
            'name' => 'Vainilla',
            'extra_price' => 5
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1016,
            'name' => 'Almendra',
            'extra_price' => 5
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1016,
            'name' => 'Crema Irlandesa',
            'extra_price' => 5
        ]);

        // extra_prices
        ProductCustomizationOption::create([
            'customization_id' => 1017,
            'name' => 'Shot Espresso',
            'extra_price' => 10
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1017,
            'name' => 'Chocolate',
            'extra_price' => 7
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1017,
            'name' => 'Crema Batida',
            'extra_price' => 8
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1017,
            'name' => 'Canela Espolvoreada',
            'extra_price' => 8
        ]);

        //endregion

        //region Americano

        // Tamanio
        ProductCustomizationOption::create([
            'customization_id' => 1018,
            'name' => 'Grande',
            'extra_price' => 15
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1018,
            'name' => 'Mediano',
            'extra_price' => 10
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1018,
            'name' => 'Pequeño',
            'extra_price' => 5
        ]);


        // Jarabes
        ProductCustomizationOption::create([
            'customization_id' => 1019,
            'name' => 'Vainilla',
            'extra_price' => 5
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1019,
            'name' => 'Almendra',
            'extra_price' => 5
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1019,
            'name' => 'Crema Irlandesa',
            'extra_price' => 5
        ]);

        // extra_prices
        ProductCustomizationOption::create([
            'customization_id' => 1020,
            'name' => 'Shot Espresso',
            'extra_price' => 10
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1020,
            'name' => 'Chocolate',
            'extra_price' => 7
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1020,
            'name' => 'Crema Batida',
            'extra_price' => 8
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1020,
            'name' => 'Canela Espolvoreada',
            'extra_price' => 8
        ]);
        //endregion

        //region Espresso

        // Tamanio
        ProductCustomizationOption::create([
            'customization_id' => 1021,
            'name' => 'Sencillo',
            'extra_price' => 0
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1021,
            'name' => 'Doble',
            'extra_price' => 10
        ]);
        //endregion

        // Sin kfeee

        //region Chocolate

        // Tamanio
        ProductCustomizationOption::create([
            'customization_id' => 1022,
            'name' => 'Grande',
            'extra_price' => 15
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1022,
            'name' => 'Mediano',
            'extra_price' => 10
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1022,
            'name' => 'Pequeño',
            'extra_price' => 5
        ]);

        // Tipo de leche
        ProductCustomizationOption::create([
            'customization_id' => 1023,
            'name' => 'Entera',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1023,
            'name' => 'Deslactosada',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1023,
            'name' => 'Soya',
            'extra_price' => 10
        ]);

        // Jarabes
        ProductCustomizationOption::create([
            'customization_id' => 1024,
            'name' => 'Vainilla',
            'extra_price' => 5
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1024,
            'name' => 'Almendra',
            'extra_price' => 5
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1024,
            'name' => 'Crema Irlandesa',
            'extra_price' => 5
        ]);

        // extra_prices
        ProductCustomizationOption::create([
            'customization_id' => 1025,
            'name' => 'Shot Espresso',
            'extra_price' => 10
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1025,
            'name' => 'Crema Batida',
            'extra_price' => 7
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1025,
            'name' => 'Malvaviscos',
            'extra_price' => 8
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1025,
            'name' => 'Chocolate',
            'extra_price' => 8
        ]);

        //endregion

        //region Matcha
        // Tamanio
        ProductCustomizationOption::create([
            'customization_id' => 1026,
            'name' => 'Grande',
            'extra_price' => 15
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1026,
            'name' => 'Mediano',
            'extra_price' => 10
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1026,
            'name' => 'Pequeño',
            'extra_price' => 5
        ]);

        // Tipo de leche
        ProductCustomizationOption::create([
            'customization_id' => 1027,
            'name' => 'Entera',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1027,
            'name' => 'Deslactosada',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1027,
            'name' => 'Soya',
            'extra_price' => 10
        ]);

        // Jarabes
        ProductCustomizationOption::create([
            'customization_id' => 1028,
            'name' => 'Vainilla',
            'extra_price' => 5
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1028,
            'name' => 'Almendra',
            'extra_price' => 5
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1028,
            'name' => 'Crema Irlandesa',
            'extra_price' => 5
        ]);

        // extra_prices
        ProductCustomizationOption::create([
            'customization_id' => 1029,
            'name' => 'Shot Espresso',
            'extra_price' => 10
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1029,
            'name' => 'Chocolate',
            'extra_price' => 7
        ]);

        //endregion

        //region Chai
        // Sabor
        ProductCustomizationOption::create([
            'customization_id' => 1030,
            'name' => 'Vainilla',
            'extra_price' => 5
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1030,
            'name' => 'Manzana',
            'extra_price' => 8
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1030,
            'name' => 'Verde',
            'extra_price' => 5
        ]);

        // Tamanio
        ProductCustomizationOption::create([
            'customization_id' => 1031,
            'name' => 'Grande',
            'extra_price' => 15
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1031,
            'name' => 'Mediano',
            'extra_price' => 10
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1031,
            'name' => 'Pequeño',
            'extra_price' => 5
        ]);

        // Tipo de leche
        ProductCustomizationOption::create([
            'customization_id' => 1032,
            'name' => 'Entera',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1032,
            'name' => 'Deslactosada',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1032,
            'name' => 'Soya',
            'extra_price' => 10
        ]);

        // Jarabes
        ProductCustomizationOption::create([
            'customization_id' => 1033,
            'name' => 'Vainilla',
            'extra_price' => 5
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1033,
            'name' => 'Almendra',
            'extra_price' => 5
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1033,
            'name' => 'Crema Irlandesa',
            'extra_price' => 5
        ]);

        // extra_prices
        ProductCustomizationOption::create([
            'customization_id' => 1034,
            'name' => 'Shot Espresso',
            'extra_price' => 10
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1034,
            'name' => 'Chocolate',
            'extra_price' => 7
        ]);
        //endregion

        //region Te
        // Tipo
        ProductCustomizationOption::create([
            'customization_id' => 1035,
            'name' => 'Negro',
            'extra_price' => 0
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1035,
            'name' => 'Rojo',
            'extra_price' => 0
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1035,
            'name' => 'Verde',
            'extra_price' => 0
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1035,
            'name' => 'Manzanilla',
            'extra_price' => 0
        ]);

        // Tamanio
        ProductCustomizationOption::create([
            'customization_id' => 1036,
            'name' => 'Grande',
            'extra_price' => 15
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1036,
            'name' => 'Mediano',
            'extra_price' => 10
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1036,
            'name' => 'Pequeño',
            'extra_price' => 5
        ]);

        // extra_prices
        ProductCustomizationOption::create([
            'customization_id' => 1037,
            'name' => 'Shot Espresso',
            'extra_price' => 10
        ]);

        //endregion

        //region Tisanas

        // Sabor
        ProductCustomizationOption::create([
            'customization_id' => 1038,
            'name' => 'Frutos Rojos',
            'extra_price' => 0
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1038,
            'name' => 'Piña Mango',
            'extra_price' => 0
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1038,
            'name' => 'Chabacano',
            'extra_price' => 0
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1038,
            'name' => 'Fresa Kiwi',
            'extra_price' => 0
        ]);

        // Tamanio
        ProductCustomizationOption::create([
            'customization_id' => 1039,
            'name' => 'Grande',
            'extra_price' => 15
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1039,
            'name' => 'Mediano',
            'extra_price' => 10
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1039,
            'name' => 'Pequeño',
            'extra_price' => 5
        ]);

        // Jarabes
        ProductCustomizationOption::create([
            'customization_id' => 1040,
            'name' => 'Vainilla',
            'extra_price' => 5
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1040,
            'name' => 'Almendra',
            'extra_price' => 5
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1040,
            'name' => 'Crema Irlandesa',
            'extra_price' => 5
        ]);

        // extra_prices
        ProductCustomizationOption::create([
            'customization_id' => 1041,
            'name' => 'Shot Espresso',
            'extra_price' => 10
        ]);

        //endregion

        //endregion

        //region Frias

        // con kfee
        //region Latte frio
        // Tamanio
        ProductCustomizationOption::create([
            'customization_id' => 1042,
            'name' => 'Grande',
            'extra_price' => 15
        ]);

        // tipo de leche
        ProductCustomizationOption::create([
            'customization_id' => 1043,
            'name' => 'Entera',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1043,
            'name' => 'Deslactosada',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1043,
            'name' => 'Soya',
            'extra_price' => 10
        ]);
        //endregion

        //region Capuccino frio
        // Tamanio
        ProductCustomizationOption::create([
            'customization_id' => 1044,
            'name' => 'Grande',
            'extra_price' => 15
        ]);

        // tipo de leche
        ProductCustomizationOption::create([
            'customization_id' => 1045,
            'name' => 'Entera',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1045,
            'name' => 'Deslactosada',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1045,
            'name' => 'Soya',
            'extra_price' => 10
        ]);
        //endregion

        //region Cold Brew
        // Tamanio
        ProductCustomizationOption::create([
            'customization_id' => 1046,
            'name' => 'Grande',
            'extra_price' => 15
        ]);

        // extra_prices
        ProductCustomizationOption::create([
            'customization_id' => 1047,
            'name' => 'Entera',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1047,
            'name' => 'Deslactosada',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1047,
            'name' => 'Soya',
            'extra_price' => 10
        ]);
        //endregion

        //region Americano Frio
        // Tamanio
        ProductCustomizationOption::create([
            'customization_id' => 1048,
            'name' => 'Grande',
            'extra_price' => 15
        ]);
        //endregion

        //region Frappe Cafe
        // Sabor
        ProductCustomizationOption::create([
            'customization_id' => 1049,
            'name' => 'Natural',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1049,
            'name' => 'Mocha Chocolate',
            'extra_price' => 10
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1049,
            'name' => 'Mocha Blanco',
            'extra_price' => 10
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1049,
            'name' => 'Vainilla',
            'extra_price' => 3
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1049,
            'name' => 'Caramelo',
            'extra_price' => 10
        ]);

        // Tipo de leche
        ProductCustomizationOption::create([
            'customization_id' => 1050,
            'name' => 'Entera',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1050,
            'name' => 'Deslactosada',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1050,
            'name' => 'Soya',
            'extra_price' => 10
        ]);

        // extra_prices
        ProductCustomizationOption::create([
            'customization_id' => 1051,
            'name' => 'Shot Espresso',
            'extra_price' => 10
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1051,
            'name' => 'Chocolate',
            'extra_price' => 7
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1051,
            'name' => 'Crema Batida',
            'extra_price' => 8
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1051,
            'name' => 'Chispas de chocolate',
            'extra_price' => 8
        ]);
        //endregion

        // sin kfeee

        //region Chocolate Frio
        // Presentacion
        ProductCustomizationOption::create([
            'customization_id' => 1052,
            'name' => 'Clásico',
            'extra_price' => 15
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1052,
            'name' => 'Frappe',
            'extra_price' => 10
        ]);
        // tamaño
        ProductCustomizationOption::create([
            'customization_id' => 1053,
            'name' => 'Grande',
            'extra_price' => 15
        ]);
        // Tipo de leche
        ProductCustomizationOption::create([
            'customization_id' => 1054,
            'name' => 'Entera',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1054,
            'name' => 'Deslactosada',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1054,
            'name' => 'Soya',
            'extra_price' => 10
        ]);
        // extra_prices
        ProductCustomizationOption::create([
            'customization_id' => 1055,
            'name' => 'Shot Espresso',
            'extra_price' => 10
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1055,
            'name' => 'Chocolate',
            'extra_price' => 7
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1055,
            'name' => 'Crema Batida',
            'extra_price' => 8
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1055,
            'name' => 'Chispas de chocolate',
            'extra_price' => 8
        ]);
        //endregion

        //region Matcha Frio
        // Presentacion
        ProductCustomizationOption::create([
            'customization_id' => 1056,
            'name' => 'Clásico',
            'extra_price' => 15
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1056,
            'name' => 'Frappe',
            'extra_price' => 10
        ]);
        // tamaño
        ProductCustomizationOption::create([
            'customization_id' => 1057,
            'name' => 'Grande',
            'extra_price' => 15
        ]);
        // Tipo de leche
        ProductCustomizationOption::create([
            'customization_id' => 1058,
            'name' => 'Entera',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1058,
            'name' => 'Deslactosada',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1058,
            'name' => 'Soya',
            'extra_price' => 10
        ]);
        // extra_prices
        ProductCustomizationOption::create([
            'customization_id' => 1059,
            'name' => 'Chocolate',
            'extra_price' => 7
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1059,
            'name' => 'Chispas de chocolate',
            'extra_price' => 8
        ]);
        //endregion

        //region Chai frio
        // Sabor
        ProductCustomizationOption::create([
            'customization_id' => 1060,
            'name' => 'Vainilla',
            'extra_price' => 15
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1060,
            'name' => 'Manzana',
            'extra_price' => 10
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1060,
            'name' => 'Verde',
            'extra_price' => 10
        ]);
        // Presentacion
        ProductCustomizationOption::create([
            'customization_id' => 1061,
            'name' => 'Clásico',
            'extra_price' => 15
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1061,
            'name' => 'Frappe',
            'extra_price' => 15
        ]);
        // Tamanio
        ProductCustomizationOption::create([
            'customization_id' => 1062,
            'name' => 'Frappe',
            'extra_price' => 15
        ]);
        // Tipo de leche
        ProductCustomizationOption::create([
            'customization_id' => 1063,
            'name' => 'Entera',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1063,
            'name' => 'Deslactosada',
            'extra_price' => 0
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1063,
            'name' => 'Soya',
            'extra_price' => 10
        ]);
        // extra_prices
        ProductCustomizationOption::create([
            'customization_id' => 1064,
            'name' => 'Chocolate',
            'extra_price' => 7
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1064,
            'name' => 'Chispas de chocolate',
            'extra_price' => 8
        ]);
        //endregion

        //region Tisanas Frisa
        // Sabor
        ProductCustomizationOption::create([
            'customization_id' => 1065,
            'name' => 'Frutos Rojos',
            'extra_price' => 15
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1065,
            'name' => 'Piña Mango',
            'extra_price' => 10
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1065,
            'name' => 'Chabacano',
            'extra_price' => 10
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1065,
            'name' => 'Fresa Kiwi',
            'extra_price' => 10
        ]);
        // Presentacion
        ProductCustomizationOption::create([
            'customization_id' => 1066,
            'name' => 'Clásico',
            'extra_price' => 15
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1066,
            'name' => 'Frappe',
            'extra_price' => 15
        ]);
        // Tamanio
        ProductCustomizationOption::create([
            'customization_id' => 1067,
            'name' => 'Frappe',
            'extra_price' => 15
        ]);
        // extra_prices
        ProductCustomizationOption::create([
            'customization_id' => 1068,
            'name' => 'Hielo extra_price',
            'extra_price' => 2
        ]);
        //endregion
        //endregion

        //region Alimentos

        //region Paninis
        // tipo
        ProductCustomizationOption::create([
            'customization_id' => 1069,
            'name' => 'Clasico (Jamón, queso, jitomate)',
            'extra_price' => 30
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1069,
            'name' => 'Caprese (jitomate, albahaca, mozzarella)',
            'extra_price' => 30
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1069,
            'name' => 'Pollo Pesto (pollo, queso, pesto)',
            'extra_price' => 40
        ]);
        // pan
        ProductCustomizationOption::create([
            'customization_id' => 1070,
            'name' => 'Blanco',
            'extra_price' => 4
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1070,
            'name' => 'Integral',
            'extra_price' => 8
        ]);
        // extra_prices
        ProductCustomizationOption::create([
            'customization_id' => 1071,
            'name' => 'Queso extra_price',
            'extra_price' => 4
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1071,
            'name' => 'Guacamole',
            'extra_price' => 8
        ]);
        //endregion

        //region Rebanada de pastel
        // Sabor
        ProductCustomizationOption::create([
            'customization_id' => 1072,
            'name' => 'Chocolate',
            'extra_price' => 7
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1072,
            'name' => 'Zanahoria',
            'extra_price' => 8
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1072,
            'name' => 'Tres leches',
            'extra_price' => 8
        ]);
        //endregion

        //region Galletas
        // Sabor
        ProductCustomizationOption::create([
            'customization_id' => 1073,
            'name' => '1 pieza',
            'extra_price' => 10
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1073,
            'name' => '3 pieza',
            'extra_price' => 18
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1073,
            'name' => '6 piezas',
            'extra_price' => 24
        ]);
        //endregion

        //region Brownie
        // Sabor
        ProductCustomizationOption::create([
            'customization_id' => 1074,
            'name' => 'Nuez',
            'extra_price' => 10
        ]);
        ProductCustomizationOption::create([
            'customization_id' => 1074,
            'name' => 'Crema Batida',
            'extra_price' => 7
        ]);

        ProductCustomizationOption::create([
            'customization_id' => 1074,
            'name' => 'Helado',
            'extra_price' => 15
        ]);
        //endregion

        //endregion
    }
}
