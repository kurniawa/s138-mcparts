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
        $variasi = ['Polos','LG.Bayang','LG.Bludru', 'LG.Sablon', 'T.Bayang', 'T.Polimas', 'T.Sablon', 'T.Trisula'];
        $jahit = ['Univ', 'JB', 'ABS-RV'];
        $ukuran = [['nama'=>'JB 93x53','nama_nota'=>'JB'], ['nama'=>'S-JB 97x53', 'nama_nota'=>'S-JB'], ['nama'=>'Aerox', 'nama_nota'=>'Aerox']];
        $kombinasi = ['Kombinasi Sayap Warna Motif A + LG + jht Univ'];
        $standar = ["RXK'95 Jet Darat"];
        DB::table('bahans')->insert([
            'nama' => 'Akong',
        ], []);
    }
}
