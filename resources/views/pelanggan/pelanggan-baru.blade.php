@extends('layouts/main_layout')

@section('content')
    
<header class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="/img/icons/back-button-white.svg" alt="" onclick="goBack();">
    <div>
        <h2 style="color: white">Pelanggan: Input Pelanggan Baru</h2>
    </div>
</header>

<form action="04-03-pelanggan-baru-2.php" method="POST">
    <div class="ml-1em mr-1em mt-2em">
        <input name="nama_pelanggan" id="nama" class="input-1 pb-1em" type="text" placeholder="Nama/Perusahaan/Pabrik">
        <textarea class="mt-1em pt-1em pl-1em text-area-mode-1" name="alamat_pelanggan" id="alamat" placeholder="Alamat"></textarea>
        <div class="grid-2-auto grid-column-gap-1em mt-1em">
            <input name="pulau" id="pulau" class="input-1 pb-1em" type="text" placeholder="Pulau">
            <input name="daerah" id="daerah" class="input-1 pb-1em" type="text" placeholder="Daerah">
        </div>
        <div class="grid-2-auto grid-column-gap-1em mt-1em">
            <input name="kontak_pelanggan" id="kontak" class="input-1 pb-1em" type="text" placeholder="No. Kontak">
            <input name="singkatan_pelanggan" id="singkatan" class="input-1 pb-1em" type="text" placeholder="Singkatan (opsional)">
        </div>

        <!-- <div id="divInputEkspedisi" class="mt-1em">
        </div> -->

        <!-- DROPDOWN MENU -->

        <!-- <div class="grid-1-auto justify-items-center">
            <div class="bg-color-orange-1 pl-1em pr-1em pt-0_5em pb-0_5em b-radius-50px" onclick="showPertanyaanEkspedisiTransit();">+ Tambah Ekspedisi</div>
        </div> -->
        <textarea id="keterangan" class="mt-1em pt-1em pl-1em text-area-mode-1" name="keterangan" placeholder="Keterangan lain (opsional)"></textarea>
    </div>

    <!-- <div class="grid-2-10_auto_auto mt-1em ml-1em mr-1em">
        <div class="">
            <img class="w-2em" src="img/icons/speech-bubble.svg" alt="Reseller?">
        </div>
        <div class="font-weight-bold">
            Apakah Pelanggan ini memiliki Reseller?
        </div>
        <div>
            <div id="divToggleReseller" class="position-relative b-radius-50px b-1px-solid-grey bg-color-grey w-4_5em" onclick="showInputReseller();">
                <div id="toggleReseller" class="position-absolute w-3em text-center b-radius-50px b-1px-solid-grey color-grey bg-color-white">tidak</div>
            </div>
        </div>
    </div> -->

    <!-- <div id="divInputNamaReseller" class="d-none ml-2em mr-2em mt-1em b-1px-solid-grey p-1em">
        <input id="inputReseller" name="nama_reseller" class="input-1 pb-1em" type="text" placeholder="Nama Reseller">

    </div> -->

    <br><br>

    <!-- Warning apabila ada yang kurang -->

    <div id="warning" class="d-none"></div>

    <div class="m-1em">
        <button type="submit" class="h-4em bg-color-orange-2 w-100 grid-1-auto">
            <span class="justify-self-center font-weight-bold">Input Pelanggan Baru</span>
        </button>
    </div>
</form>

<style>
    #divToggleReseller {
        height: 1.5em;
    }

    .btn-atas-kanan {
        display: inline;
        border-radius: 25px;
        background-color: #FFED50;
        padding: 0.5em 1em 0.5em 1em;
        position: absolute;
        top: 1em;
        right: 0.5em;
    }

    .div-filter-icon {
        justify-self: end;
    }

    .icon-small-circle {
        border-radius: 100%;
        width: 2.5em;
        height: 2.5em;
        position: relative;
    }

    .circle-medium {
        border-radius: 100%;
        width: 2.5em;
        height: 2.5em;
    }

    .icon-img {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .div-cari-filter {
        border-bottom: 0.5px solid #E4E4E4;
    }

</style>
@endsection