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

{{-- {{ dd($d_nama_pelanggan) }} --}}

{{-- const dPelanggan = {!! json_encode($dPelanggan) !!};
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

const d_nama_pelanggan_2 = {!! json_encode($d_nama_pelanggan_2, JSON_HEX_TAG) !!}
    console.log("d_nama_pelanggan_2");
    console.log(d_nama_pelanggan_2);

    {{ date_default_timezone_set("Asia/Jakarta") }}
--}}

@section('content')

<header class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="/img/icons/back-button-white.svg" alt="" onclick="goBack();">
    <div class="justify-self-right pr-0_5em">
        <!-- <a href="06-02-produk-baru.php" id="btnNewProduct" class="btn-atas-kanan2">
            + Tambah Produk Baru
        </a> -->
    </div>
</header>
<form action="/spk/inserting_spk_item" method="GET" id="SPKBaru">
    {{-- diputuskan untuk memakai get, supaya tidak pusing ketika berpindah-pindah halaman --}}
    @csrf

    <div class="mt-1em ml-1em grid-2-10_auto">
        <div class="">
            <img class="w-2em" src="/img/icons/pencil.svg" alt="">
        </div>
        <div class="font-weight-bold">
            Untuk siapa SPK ini?
        </div>
    </div>

    <div class="ml-0_5em mr-0_5em mt-2em">

        <div class="grid-2-auto grid-column-gap-1em mt-1em">
            <input id="SPKNo" class="input-1 pb-1em" type="text" placeholder="No." disabled>
            <input type="datetime-local" class="input-select-option-1 pb-1em" name="tanggal" id="date" value="{{ date('Y-m-d\TH:i:s') }}">
        </div>

        <div id="divInputCustomerName" class="containerInputEkspedisi mt-1em mb-1em">
            <div class="bb-1px-solid-grey">
                <input id="inputCustomerName" class="input-1 pb-1em bb-none" name="nama_pelanggan" type="text" placeholder="Pelanggan">
                <div id="searchResults" class="d-none b-1px-solid-grey bb-none"></div>
                <input id="daerahCust" type="hidden" name="daerah">
                <input id="inputIDCust" type="hidden" name="pelanggan_id">
                <input id="reseller_id" type="hidden" name="reseller_id">
            </div>
        </div>

        <input name="judul" id="titleDesc" class="input-1 mt-1em pb-1em" type="text" placeholder="Keterangan (opsional)">


    </div>


    <br><br>

    <div id="warning" class="d-none"></div>

    <div class="m-1em">
        <button type="submit" class="btn btn-warning w-100 pb-4 pt-4">
            Input Item SPK >>
        </button>
    </div>

    <div id="closingAreaPertanyaan" class="d-none position-absolute z-index-2 w-100vw h-100vh bg-color-grey top-0 opacity-0_5">
    </div>

</form>


<script>
    const d_label_pelanggan = {!! json_encode($d_label_pelanggan, JSON_HEX_TAG) !!}
    console.log("d_label_pelanggan");
    console.log(d_label_pelanggan);

    $("#inputCustomerName").autocomplete({
    source: d_label_pelanggan,
    select: function(event, ui) {
        console.log(ui);
        $("#inputIDCust").val(ui.item.id);
        $("#reseller_id").val(ui.item.reseller_id);
        $("#daerahCust").val(ui.item.daerah);
        // console.log(event);
        // alert(ui.item.name);
    }
});
   
</script>

<style>

</style>
@endsection