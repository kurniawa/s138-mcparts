@extends('layouts.main_layout')

@section('content')
    
<div class="header grid-1-auto">
    <img class="w-0_8em ml-1_5em" src="/img/icons/back-button-white.svg" alt="" onclick="goBack();">
</div>

<div class="grid-2-10_auto mt-1em ml-1em">
    <div>
        <img class="w-2em" src="/img/icons/pencil.svg" alt="Data Pelanggan Baru">
    </div>
    <h1>Edit Data Ekspedisi</h1>
</div>

<form action="/ekspedisi/edit-db" method="POST" class="ml-1em mr-1em mt-2em">
    @csrf
    <input type="hidden" name="ekspedisi_id" value="{{ $ekspedisi['id'] }}">
    <div class="grid-2-auto grid-column-gap-1em">
        <div class="bb-0_5px-grey pb-1em">
            <label for="selectBentukPerusahaan">Bentuk:</label><br>
            <select class="b-none" name="bentuk_perusahaan" id="selectBentukPerusahaan">
                <option value="" disabled>Bentuk</option>
                <option value="" @if ($ekspedisi['bentuk'] === '')
                    selected
                @endif >-</option>
                <option value="PT" @if ($ekspedisi['bentuk'] === 'PT')
                    selected
                @endif >PT</option>
                <option value="CV" @if ($ekspedisi['bentuk'] === 'CV')
                    selected
                @endif >CV</option>
            </select>
        </div>
        <div>
            <label for="namaEdited">Nama Ekspedisi:</label>
            <input id="namaEdited" class="input-1 pb-1em" name="nama_ekspedisi" type="text" placeholder="Nama Ekspedisi" value="{{ $ekspedisi['nama'] }}">
        </div>
    </div>

    <br>
    <label style="font-weight:bold">Alamat:</label>
    <div id="div_alamat_eks"></div>
    <div id="btn_tbh_baris" class="btn btn-secondary">+ Tambah Baris</div>

    {{-- <textarea id="alamatEdited" class="text-area-mode-1 mt-1em pt-1em pl-1em" name="alamat_ekspedisi" placeholder="Alamat">{{ $ekspedisi['alamat'] }}</textarea> --}}

    <div class="mt-1em">
        <label for="kontakEdited">Kontak:</label>
        <input id="kontakEdited" name="kontak_ekspedisi" class="input-1 pb-1em" type="text" placeholder="No. Kontak" value="{{ $ekspedisi['no_kontak'] }}">
    </div>

    <br>
    <label for="divTujuanEkspedisi">Tujuan Ekspedisi:</label>
    <div id="divTujuanEkspedisi" class="mt-1em grid-2-auto grid-column-gap-1em">
        <input id="pulauTujuan" class="input-1 pb-1em" type="text" placeholder="Pulau Tujuan Ekspedisi" name="pulau_tujuan">
        <input id="daerahTujuan" class="input-1 pb-1em" type="text" placeholder="Daerah Tujuan Ekspedisi" name="daerah_tujuan">
    </div>

    <br>
    <label for="keteranganEdited">Keterangan:</label>
    <textarea id="keteranganEdited" class="text-area-mode-1 mt-1em pt-1em pl-1em" name="keterangan" placeholder="Keterangan lain (opsional)" value="{{ $ekspedisi['keterangan'] }}"></textarea>

    <div id="peringatan" class="d-none color-red p-1em">

    </div>

    <div class="m-1em">
        <button type="submit" class="h-4em bg-color-orange-2 grid-1-auto w-100">
            <span class="justify-self-center font-weight-bold">Simpan Perubahan</span>
        </button>
    </div>
</form>


<script>
    const ekspedisi = {!! json_encode($ekspedisi, JSON_HEX_TAG) !!};

    const arr_alamat_eks = ekspedisi.alamat.split('[br]');

    if (show_console === true) {
        console.log("ekspedisi");
        console.log(ekspedisi);
        console.log('arr_alamat_eks');
        console.log(arr_alamat_eks);
    }

    var htmlAlamatEks = '';
    var i_arrAlamatEks = 1;
    arr_alamat_eks.forEach(alamat_eks => {
        htmlAlamatEks += `<label>Baris ${i_arrAlamatEks}:<br></label><input class="form-control" type="text" name='alamat_ekspedisi[]' value="${alamat_eks}">`;
        i_arrAlamatEks++;
    });

    document.getElementById('div_alamat_eks').innerHTML = htmlAlamatEks;

    document.getElementById('btn_tbh_baris').addEventListener('click', function () {
        var label_tbh_baris = document.createElement('label');
        label_tbh_baris.textContent = `Baris ${i_arrAlamatEks}:`;
        var ipt_tbh_baris = document.createElement('input');
        ipt_tbh_baris.name = "alamat_ekspedisi[]";
        ipt_tbh_baris.className = "form-control";
        ipt_tbh_baris.type = "text";
        document.getElementById('div_alamat_eks').appendChild(label_tbh_baris);
        document.getElementById('div_alamat_eks').appendChild(ipt_tbh_baris);
        i_arrAlamatEks++;
        // https://stackoverflow.com/questions/195951/how-can-i-change-an-elements-class-with-javascript
    });
    
</script>

@endsection


