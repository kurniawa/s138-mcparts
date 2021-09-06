@extends('layouts/main_layout')
{{-- // SELECT list dari nama pelanggan terlebih dahulu, untuk fitur live search
$sql = "SELECT pelanggan.id, pelanggan.nama, pelanggan.daerah, pelanggan_reseller.id_reseller
FROM pelanggan LEFT JOIN pelanggan_reseller ON pelanggan.id=pelanggan_reseller.id_pelanggan ORDER BY pelanggan.nama ASC";

$dPelanggan = mysqliQuery("SELECT", $sql);

// dd($dPelanggan);

$i = 0;
$dLabelValPelanggan = array();
foreach ($dPelanggan as $pelanggan) {
    if ($pelanggan["id_reseller"] !== null) {
        $sql = "SELECT pelanggan.nama FROM pelanggan WHERE id=" . $pelanggan["id_reseller"];

        $nama_reseller = mysqliQuery("SELECT", $sql);

        $dPelanggan[$i]["nama_reseller"] = $nama_reseller[0]["nama"];
        // dd($dPelanggan[$i]);
    }
    array_push($dLabelValPelanggan, array("label" => $pelanggan["nama"], "value" => $pelanggan["nama"], "id" => $pelanggan["id"], "daerah" => $pelanggan["daerah"]));

    $i++;
}

// dd($dPelanggan); --}}

@section('content')
    
<header class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="img/icons/back-button-white.svg" alt="" onclick="goBack();">
    <div class="justify-self-right pr-0_5em">
        <!-- <a href="06-02-produk-baru.php" id="btnNewProduct" class="btn-atas-kanan2">
            + Tambah Produk Baru
        </a> -->
    </div>
</header>
<form action="03-03-01-begin-inserting-products.php" method="GET" id="SPKBaru">

    <div class="mt-1em ml-1em grid-2-10_auto">
        <div class="">
            <img class="w-2em" src="img/icons/pencil.svg" alt="">
        </div>
        <div class="font-weight-bold">
            Untuk siapa SPK ini?
        </div>
    </div>

    <div class="ml-0_5em mr-0_5em mt-2em">

        <div class="grid-2-auto grid-column-gap-1em mt-1em">
            <input id="SPKNo" class="input-1 pb-1em" type="text" placeholder="No." disabled>
            <input type="date" class="input-select-option-1 pb-1em" name="tanggal" id="date" value="<?php echo date('Y-m-d'); ?>">
        </div>

        <div id="divInputCustomerName" class="containerInputEkspedisi mt-1em mb-1em">
            <div class="bb-1px-solid-grey">
                <input id="inputCustomerName" class="input-1 pb-1em bb-none" name="nama_pelanggan" type="text" placeholder="Pelanggan">
                <div id="searchResults" class="d-none b-1px-solid-grey bb-none"></div>
                <input id="daerahCust" type="hidden" name="daerah">
                <input id="inputIDCust" type="hidden" name="id_pelanggan">
            </div>
        </div>

        <input name="ket_judul" id="titleDesc" class="input-1 mt-1em pb-1em" type="text" placeholder="Keterangan Judul (opsional)">


    </div>


    <br><br>

    <div id="warning" class="d-none"></div>

    <div class="m-1em">
        <!-- <button type="submit" class="w-100 h-4em bg-color-orange-2 grid-1-auto" onclick="beginInsertingProducts();"> -->
        <button type="submit" class="w-100 h-4em bg-color-orange-2 grid-1-auto">
            <span class="justify-self-center font-weight-bold">Input Item SPK >></span>
        </button>
    </div>

    <div id="closingAreaPertanyaan" class="d-none position-absolute z-index-2 w-100vw h-100vh bg-color-grey top-0 opacity-0_5">
    </div>

</form>


<script>
    const dPelanggan = {!! json_encode($dPelanggan) !!};
    // console.log("dPelanggan");
    // console.log(dPelanggan);
    const dLabelValPelanggan = {!! json_encode($dLabelValPelanggan) !!};
    console.log("dLabelValPelanggan");
    console.log(dLabelValPelanggan);

    $("#inputCustomerName").autocomplete({
        source: dLabelValPelanggan,
        select: function(event, ui) {
            console.log(ui);
            $("#inputIDCust").val(ui.item.id);
            $("#daerahCust").val(ui.item.daerah);
            // console.log(event);
            // alert(ui.item.name);
        }
    });

    
</script>

<style>

</style>
@endsection