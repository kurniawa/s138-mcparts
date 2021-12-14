@extends('layouts/main_layout')

{{ 

$sql = "SELECT id, no_spk, id_pelanggan FROM spk WHERE status='SELESAI' OR status='SEBAGIAN'";
$dPilihanSPK = mysqliQuery("SELECT", $sql);

// dd($dPilihanSPK);

// while ($row = $res->fetch_assoc()) {
//     array_push($dPilihanSPK, $row);
// }
// dd($dPilihanSPK);

}}

@section('content')

<header class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="img/icons/back-button-white.svg" alt="" onclick="goBack();">
</header>

<div class="container m-1em">
    <form action="07-01-01-pembuatanNota.php" method="get">
        <span style="font-weight:bold">Pilihan SPK yang Sebagian atau Seluruhnya SELESAI:</span><br>
        <select name="idSPK" id="selectIDSPK" class="p-1em">
            <?php
            for ($i = 0; $i < count($dPilihanSPK); $i++) {
                echo "<option value='" . $dPilihanSPK[$i]["id"] . "'>" . $dPilihanSPK[$i]["no_spk"] . "</option>";
            }
            ?>
        </select>
        <br><br>
        <button type="submit" class="btn-warning">Lanjut Ke Pembuatan Nota</button>
    </form>
</div>

<script>
    const dPilihanSPK = <?= json_encode($dPilihanSPK); ?>;
    console.log("dPilihanSPK");
    console.log(dPilihanSPK);
</script>

@endsection
