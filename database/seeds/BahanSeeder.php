<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bahan = ['Amplas(RY)', 'BigDot(MC)', 'C30(MC)', 'C38(MC)', 'Carbon', 'Grafitti', 'K-Jeruk', 'L-Hole', 'Navaro(MC)', 'U-Tangan(MC)', 'Vario(M)', 'Vario(MC)'];
        $kombinasi = ['Kombinasi Sayap Warna Motif A + LG + jht Univ'];
        $standar = ["RXK'95 Jet Darat"];
        $busastang = ["Busastang"];

        for ($i = 0; $i < count($bahan); $i++) {
            DB::table('bahans')->insert([
                'nama' => $bahan[$i],
            ]);
        }
    }
}
