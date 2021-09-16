<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StandarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $standar = [[
            'nama' => 'Absolute Revo',
            'id' => 1,
            'harga' => 12500
        ], [
            'nama' => 'Astrea 800',
            'id' => 2,
            'harga' => 12500
        ], [
            'nama' => 'Beat',
            'id' => 3,
            'harga' => 12500
        ], [
            'nama' => 'C70 Tanpa Alas',
            'id' => 4,
            'harga' => 12500
        ], [
            'nama' => 'CB Tanpa Alas',
            'id' => 5,
            'harga' => 12500
        ], [
            'nama' => 'F1ZR',
            'id' => 6,
            'harga' => 12500
        ], [
            'nama' => 'GL PRO',
            'id' => 7,
            'harga' => 12500
        ], [
            'nama' => 'Grand 97',
            'id' => 8,
            'harga' => 12500
        ], [
            'nama' => 'Jupiter MX',
            'id' => 9,
            'harga' => 12500
        ], [
            'nama' => 'Jupiter Z',
            'id' => 10,
            'harga' => 12500
        ], [
            'nama' => 'Karisma',
            'id' => 11,
            'harga' => 12500
        ], [
            'nama' => 'Mio',
            'id' => 12,
            'harga' => 12500
        ], [
            'nama' => 'Prima',
            'id' => 13,
            'harga' => 12500
        ], [
            'nama' => 'RX King 02',
            'id' => 14,
            'harga' => 12500
        ], [
            'nama' => 'RX-S',
            'id' => 15,
            'harga' => 12500
        ], [
            'nama' => 'RX Spesial',
            'id' => 16,
            'harga' => 12500
        ], [
            'nama' => 'Shogun',
            'id' => 17,
            'harga' => 12500
        ], [
            'nama' => 'Shogun 110',
            'id' => 18,
            'harga' => 12500
        ], [
            'nama' => 'Supra 125',
            'id' => 19,
            'harga' => 12500
        ], [
            'nama' => 'Supra Fit',
            'id' => 20,
            'harga' => 12500
        ], [
            'nama' => 'Supra Fit New',
            'id' => 21,
            'harga' => 12500
        ], [
            'nama' => 'Supra X',
            'id' => 22,
            'harga' => 12500
        ], [
            'nama' => 'Tiger',
            'id' => 23,
            'harga' => 12500
        ], [
            'nama' => 'Vario',
            'id' => 24,
            'harga' => 12500
        ]];

        $standar_variasi = [[
            'standar_id' => 1,
            'jahit_kepala' => 1,
            'jahit_samping' => 1,
            'press' => 0,
            'alas' => 0,
        ], [
            'standar_id' => 2,
            'jahit_kepala' => 1,
            'jahit_samping' => 1,
            'press' => 1,
            'alas' => 0,
        ], [
            'standar_id' => 3,
            'jahit_kepala' => 1,
            'jahit_samping' => 0,
            'press' => 0,
            'alas' => 0,
        ], [
            'standar_id' => 4,
            'jahit_kepala' => 1,
            'jahit_samping' => 1,
            'press' => 1,
            'alas' => 0,
        ], [
            'standar_id' => 5,
            'jahit_kepala' => 1,
            'jahit_samping' => 1,
            'press' => 1,
            'alas' => 0,
        ], [
            'standar_id' => 6,
            'jahit_kepala' => 1,
            'jahit_samping' => 1,
            'press' => 0,
            'alas' => 0,
        ], [
            'standar_id' => 7,
            'jahit_kepala' => 1,
            'jahit_samping' => 0,
            'press' => 0,
            'alas' => 0,
        ], [
            'standar_id' => 8,
            'jahit_kepala' => 1,
            'jahit_samping' => 1,
            'press' => 0,
            'alas' => 0,
        ], [
            'standar_id' => 9,
            'jahit_kepala' => 1,
            'jahit_samping' => 0,
            'press' => 0,
            'alas' => 0,
        ], [
            'standar_id' => 10,
            'jahit_kepala' => 1,
            'jahit_samping' => 1,
            'press' => 0,
            'alas' => 0,
        ], [
            'standar_id' => 11,
            'jahit_kepala' => 1,
            'jahit_samping' => 0,
            'press' => 0,
            'alas' => 0,
        ], [
            'standar_id' => 12,
            'jahit_kepala' => 1,
            'jahit_samping' => 0,
            'press' => 0,
            'alas' => 0,
        ], [
            'standar_id' => 13,
            'jahit_kepala' => 1,
            'jahit_samping' => 1,
            'press' => 1,
            'alas' => 0,
        ], [
            'standar_id' => 14,
            'jahit_kepala' => 1,
            'jahit_samping' => 0,
            'press' => 0,
            'alas' => 0,
        ], [
            'standar_id' => 15,
            'jahit_kepala' => 1,
            'jahit_samping' => 1,
            'press' => 0,
            'alas' => 0,
        ], [
            'standar_id' => 16,
            'jahit_kepala' => 1,
            'jahit_samping' => 1,
            'press' => 1,
            'alas' => 0,
        ], [
            'standar_id' => 17,
            'jahit_kepala' => 1,
            'jahit_samping' => 0,
            'press' => 0,
            'alas' => 0,
        ], [
            'standar_id' => 18,
            'jahit_kepala' => 1,
            'jahit_samping' => 0,
            'press' => 0,
            'alas' => 0,
        ], [
            'standar_id' => 19,
            'jahit_kepala' => 1,
            'jahit_samping' => 1,
            'press' => 0,
            'alas' => 0,
        ], [
            'standar_id' => 20,
            'jahit_kepala' => 1,
            'jahit_samping' => 0,
            'press' => 0,
            'alas' => 0,
        ], [
            'standar_id' => 21,
            'jahit_kepala' => 1,
            'jahit_samping' => 1,
            'press' => 0,
            'alas' => 0,
        ], [
            'standar_id' => 22,
            'jahit_kepala' => 1,
            'jahit_samping' => 1,
            'press' => 0,
            'alas' => 0,
        ], [
            'standar_id' => 23,
            'jahit_kepala' => 1,
            'jahit_samping' => 0,
            'press' => 0,
            'alas' => 0,
        ], [
            'standar_id' => 24,
            'jahit_kepala' => 1,
            'jahit_samping' => 1,
            'press' => 0,
            'alas' => 0,
        ]];

        $variasi_std_harga = [[
            'variasi_standar' => 'jahit_kepala',
            'harga' => 1500
        ], [
            'variasi_standar' => 'jahit_samping',
            'harga' => 1500
        ], [
            'variasi_standar' => 'press',
            'harga' => 1500
        ], [
            'variasi_standar' => 'alas',
            'harga' => 1500
        ]];

        for ($i = 0; $i < count($standar); $i++) {
            DB::table('standars')->insert([
                'nama' => $standar[$i]['nama'],
                'harga_dasar' => $standar[$i]['harga_dasar']
            ]);
            DB::table('standar_harga_dasar')->insert([
                'standar_id' => $standar_variasi[$i]['standar_id'],
                'jahit_kepala' => $standar_variasi[$i]['jahit_kepala'],
                'jahit_samping' => $standar_variasi[$i]['jahit_samping'],
                'press' => $standar_variasi[$i]['press'],
                'alas' => $standar_variasi[$i]['alas'],
            ]);
        }
    }
}
