@extends('layouts.main_layout')
@section('content')
    
<header class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="/img/icons/back-button-white.svg" alt="" onclick="goBack();">
    {{-- <div class="justify-self-right pr-0_5em">
        <a href="ekspedisi/ekspedisi-baru" class="btn-atas-kanan">
            + Ekspedisi Baru
        </a>
    </div> --}}
</header>

<div class="mt-1em ml-1em">
    <div class="d-inline">
        <img class="w-2em" src="img/icons/pencil.svg" alt="Data Pelanggan Baru">
    </div>
    {{-- <div class="d-inline font-weight-bold">
        Tambah Ekspedisi untuk Pelanggan:
        <br>
        <div class="text-center">
            <span style="font-size: large;"><-?= $pelanggan["nama"]; ?></span>
        </div>
        <br>
    </div> --}}
</div>
<form id="formTambahEkspedisi" action="04-07-tambah-ekspedisi-db.php" method="POST" class="ml-1em mr-1em">

    <br>
    <h3>Nama Ekspedisi:</h3>

    <input type="text" name="nama_ekspedisi" id="nama_ekspedisi" class="input">
    <input type="hidden" name="id_ekspedisi" id="id_ekspedisi">

    <br>
    <h3>Tipe Ekspedisi:</h3>
    <select name="tipe_ekspedisi" id="tipe_ekspedisi" class="p-0_5em">
        <option value="UTAMA">UTAMA</option>
        <option value="BIASA">BIASA</option>
        <option value="TRANSIT">TRANSIT</option>
    </select>

    <br><br>
    <button type="submit" class="btn-warning-full">
        Tambah Ekspedisi
    </button>
</form>

<script>

    // const id_pelanggan = {-!! json_encode($id_pelanggan, JSON_HEX_TAG) !!};
    var all_ekspedisi = {!! json_encode($all_ekspedisi, JSON_HEX_TAG) !!};
    console.log(all_ekspedisi);

    var list_id_nama_ekspedisi = new Array();

    for (const ekspedisi of all_ekspedisi) {
        var strToPush = `${ekspedisi.id}---${ekspedisi.nama}`;
        list_id_nama_ekspedisi.push(strToPush);
    }
    console.log("list_id_nama_ekspedisi:");
    console.log(list_id_nama_ekspedisi);

    setAutoComplete();

    function setAutoComplete() {
        console.log("Running setAutoComplete...");
        $(`#nama_ekspedisi`).autocomplete({
            source: list_id_nama_ekspedisi,
            select: function(event, ui) {
                console.log(ui);
                console.log(ui.item.value);
                $value = ui.item.value.split('---');
                console.log($value);
                $id = $value[0];
                console.log('chosen ID: ' + $id);
                $(`#id_ekspedisi`).val($id);
            }
        });
    }
</script>
@endsection

