@extends('layouts.main_layout')
@section('content')
    
<header class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="/img/icons/back-button-white.svg" alt="" onclick="goBack();">
</header>

<div class="grid-2-10-auto mt-1em ml-1em">
    <div>
        <img class="w-2em" src="/img/icons/pencil.svg" alt="">
    </div>
    <div class="font-weight-bold">
        Input Data Ekspedisi Baru
    </div>
</div>

<form action="/ekspedisi/ekspedisi-baru-db" method="POST">
    @csrf
    <div class="ml-1em mr-1em mt-2em">
        <div class="grid-2-auto grid-column-gap-1em">
            <div class="bb-0_5px-grey pb-1em">
                <select class="b-none" name="bentuk_perusahaan" id="bentukPerusahaan">
                    <option value="" selected disabled>Bentuk</option>
                    <option value="">-</option>
                    <option value="PT">PT</option>
                    <option value="CV">CV</option>
                </select>
            </div>
            <input id="nama-ekspedisi" name="nama_ekspedisi" class="input-1 pb-1em" type="text" placeholder="Nama Ekspedisi" required>
        </div>

        {{-- <textarea id="alamat" class="mt-1em pt-1em pl-1em" name="alamat_ekspedisi" placeholder="Alamat" required></textarea> --}}
        <label for="">Alamat:</label>
        <input type="text" class="form-control" name="alamat_ekspedisi[]" placeholder="Baris 1">
        <input type="text" class="form-control" name="alamat_ekspedisi[]" placeholder="Baris 2">
        <input type="text" class="form-control" name="alamat_ekspedisi[]" placeholder="Baris 3">
        <input type="text" class="form-control" name="alamat_ekspedisi[]" placeholder="Baris 4">
        <input type="text" class="form-control" name="alamat_ekspedisi[]" placeholder="Baris 5"><br>
        <div class="mt-1em">
            <input id="kontak" class="input-1 pb-1em" type="text" placeholder="No. Kontak" name="kontak_ekspedisi">
        </div>
        <br>
        <label for="divTujuanEkspedisi">Tujuan Ekspedisi:</label>
        <div id="divTujuanEkspedisi" class="mt-1em grid-2-auto grid-column-gap-1em">
            <input id="pulauTujuan" class="input-1 pb-1em" type="text" placeholder="Pulau Tujuan Ekspedisi" name="pulau_tujuan">
            <input id="daerahTujuan" class="input-1 pb-1em" type="text" placeholder="Daerah Tujuan Ekspedisi" name="daerah_tujuan">
        </div>
        <textarea id="keterangan" class="mt-1em pt-1em pl-1em" name="keterangan" placeholder="Keterangan lain (opsional)"></textarea>
    </div>
    <div id="peringatan" class="d-none color-red p-1em">

    </div>
    <div class="m-1em">
        <button type="submit" class="h-4em bg-color-orange-2 grid-1-auto w-100">
            <span class="justify-self-center font-weight-bold">Input Ekspedisi Baru</span>
        </button>
    </div>

</form>

<!-- <div id="closingArea" class="closingArea" style="display: none;"></div>
<div class="lightBox" style="display:none;">
    <br><br>
    <div class="text-center">
        Input Ekspedisi Baru berhasil!
    </div>
    <br><br>
</div> -->

<style>
    .closingArea {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: white;
    }

    .lightBox {
        position: absolute;
        top: 25vh;
        left: 0.5em;
        right: 0.5em;
        height: 13em;
        background-color: white;
        padding: 1em;
        border: 1px solid grey;
    }
</style>

<script>
    // Just use a simple button instead of a submit button. And call a JavaScript function to handle form submit:

    // <input type="button" name="submit" value="submit" onclick="submit_form();"/>
    // Function within a script tag:

    // function submit_form() {
    //     if (conditions) {
    //         document.forms['myform'].submit();
    //     }
    //     else {
    //         returnToPreviousPage();
    //     }
    // }

    function formValidation() {
        $nama = $("#nama").val();
        $alamat = $("#alamat").val();
        $peringatan = $("#peringatan");

        if ($nama === "") {
            $peringatan.html("Nama Ekspedisi harus diisi!");
            if ($peringatan.css("display") == "none") {
                $peringatan.show();
            }
            alert("Nama Ekspedisi harus diisi!");
            history.back();
            return false;
        }

        if ($alamat === '') {
            $peringatan.html("Alamat Ekspedisi harus diisi!");
            if ($peringatan.css("display") == "none") {
                $peringatan.show();
            }
            history.back();
            return false;
        }

        return true;
    }

    function inputEkspedisiBaru() {
        $bentuk = $("#bentukPerusahaan").val();
        $nama = $("#nama").val();
        $alamat = $("#alamat").val();
        $kontak = $("#kontak").val();
        $keterangan = $("#keterangan").val();
        $peringatan = $("#peringatan");
        var lastIdEkspedisi = getLastID('ekspedisi');
        lastIdEkspedisi = JSON.parse(lastIdEkspedisi);

        console.log($alamat);
        if ($nama == "") {
            $peringatan.html("Nama Ekspedisi harus diisi!");
            if ($peringatan.css("display") == "none") {
                $peringatan.toggle(100);
            }
        } else if ($nama != "" && $peringatan.css("display") != "none") {
            $peringatan.toggle(100);
        }

        if ($bentuk === '' || $bentuk === null) {
            console.log('Bentuk Perusahaan tidak diisi!');
        } else {
            $bentuk = $bentuk.trim();
        }

        $.ajax({
            url: "05-04-insert-edit-ekspedisi.php",
            type: "POST",
            async: false,
            data: {
                id: lastIdEkspedisi[1],
                nama: $nama.trim(),
                bentuk: $bentuk,
                alamat: $alamat.trim(),
                kontak: $kontak.trim(),
                keterangan: $keterangan.trim(),
                type: 'new_ekspedisi'
            },
            success: function(responseText) {
                console.log(responseText);
                responseText = JSON.parse(responseText);
                if (responseText[0] === 'New record created successfully.') {
                    alert('Ekspedisi baru berhasil diinput!');
                    setTimeout(() => {
                        window.history.back();
                    }, 500);
                }
            }
        });
    }
</script>

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


    #alamat,
    #keterangan {
        box-sizing: border-box;
        width: 100%;
        height: 8em;
        border: 1px solid #E4E4E4;
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
        width: 3em;
        height: 3em;
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

