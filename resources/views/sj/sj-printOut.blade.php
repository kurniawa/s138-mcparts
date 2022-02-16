@extends('layouts.main_layout')

@section('content')
<header class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="/img/icons/back-button-white.svg" alt="" onclick="goBack();">
</header>

{{-- <div class="threeDotMenu">
    <div class="threeDot">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
    <div class="divThreeDotMenuContent">
        <a href="08-03-editsj.php?idsj={{ $sj['id'] }}" class="threeDotMenuItem">
            <img src="/img/icons/edit.svg" alt=""><span>Edit Surat Jalan</span>
        </a>
        <div id="" class="threeDotMenuItem" onclick="showLightBox();">
            <img src="/img/icons/trash-can.svg" alt=""><span>Hapus Surat Jalan</span>
        </div>
        
    </div>
</div> --}}

<div id="containerDetailsj">
    <div class="grid-3-25_25_50">
        <img width="200em" src="/img/images/logo-mc.jpg" alt="">
        <div><span class="font-weight-bold">CV. MC-Parts</span><br>Jl. Raya Karanggan No. 96<br>Kec. Gn. Putri/Kab. Bogor<br>0812 9335 218<br>0812 8655 6500</div>

        <div class="grid-1-auto justify-items-center font-weight-bold font-size-2em">
            <span>SURAT JALAN -</span><span>TANDA TERIMA BARANG</span>
        </div>
    </div>

    <br>

    <hr style="height: 2px; background-color: black; margin-bottom: 0.2em; margin-top: 0;">
    <br>
    <div class="grid-2-65_35 grid-column-gap-1em">
        <table style="width: 100%;">
            <tr>
                <td class="font-weight-bold" style="width: 35%;">Untuk:</td>
                <td class="font-weight-bold">Alamat:</td>
            </tr>
            <tr>
                <td style="height: 1.5em;"></td>
            </tr>
            <tr>
                <td id="custName" style="vertical-align: top;" class="font-weight-bold font-size-1_5em">{{ $pelanggan['nama'] }}</td>
                <td id="alamatCust" class="font-size-1_5em"></td>
            </tr>
        </table>
        <!-- <div class="grid-1-auto2">
            <span class="font-weight-bold">Untuk:</span>
            <div></div>
            <span id='custName' class="font-weight-bold font-size-1_5em"></span>
        </div>

        <div class="grid-1-auto2">
            <span class="font-weight-bold">Alamat:</span>
            <div></div>
            <span id="alamatCust" class=" font-size-1_5em"></span>
        </div> -->

        <div class="grid-3-35_5_60 grid-row-gap-0_5em">
            <div>No.</div>
            <div>:</div>
            <div id="no_sj">{{ $sj['no_sj'] }}</div>
            <div>Tanggal</div>
            <div>:</div>
            <div id="tglsj">{{ date("Y-m-d", strtotime($sj['created_at'])) }}</div>
            <div>Ekspedisi</div>
            <div>:</div>
            <div id="ekspedisi"></div>
        </div>
    </div>
    <br>
    <table id="tableItemsj">
        <tr>
            <th class="thTableItemsj" style="width: 50%;">Nama / Jenis Barang</th>
            <th class="thTableItemsj">Jumlah</th>
        </tr>
        <tr>
            <td class="tdTableItemsj font-size-2em font-weight-bold">Sarung Jok Motor</td>
            <td class="tdTableItemsj font-weight-bold" style="font-size: xx-large;">
                <div class="grid-2-auto grid-column-gap-0_5em">
                    <div id="divJmlKoli" class="justify-self-right">
                        <span id="jmlKoli">{{ $sj['colly_T'] }}</span>
                    </div>
                    <img style="width: 2em;" class="d-inline-block" src="/img/icons/koli.svg" alt="">
                </div>
            </td>
        </tr>
    </table>
    <span style="font-style: italic;">*Barang sudah diterima dengan baik dan sesuai, oleh:</span>

    <br><br><br>

    <div class="grid-2-auto">
        <div class="grid-1-auto justify-items-center">
            <div class="">Penerima,</div>
            <br><br><br><br>
            <div>(....................)</div>
        </div>
        <div class="grid-1-auto justify-items-center">
            <div class="">Hormat Kami,</div>
            <br><br><br><br>
            <div>(....................)</div>
        </div>
    </div>
</div>

<style>
    #closingArea {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 1;
    }

    #inputEditKoli {
        width: 2em;
        font-size: xx-large;
        position: relative;
        z-index: 3;
    }

    #containerDetailsj {
        font-family: 'Roboto';
        font-weight: normal;
        font-style: normal;
    }

    #tableItemsj {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid black;
    }

    .thTableItemsj,
    .tdTableItemsj {
        border-left: 1px solid black;
        border-right: 1px solid black;
        border-bottom: 1px solid black;
    }

    .thTableItemsj {
        height: 3em;
    }

    .tdTableItemsj {
        height: 8em;
        text-align: center;
    }

    @media print {
        .bg-color-orange-1 {
            background-color: #FFED50;
            -webkit-print-color-adjust: exact;
        }
    }
</style>

<script>
    const show_console = true;

    const sj = {!! json_encode($sj, JSON_HEX_TAG) !!};
    const pelanggan = {!! json_encode($pelanggan, JSON_HEX_TAG) !!};
    const ekspedisi = {!! json_encode($ekspedisi, JSON_HEX_TAG) !!};
    
    if (show_console === true) {
        console.log("sj");
        console.log(sj);
        console.log("pelanggan");
        console.log(pelanggan);
        console.log("ekspedisi");
        console.log(ekspedisi);
    }

    document.getElementById('alamatCust').innerHTML = formatNewLine(pelanggan.alamat);

    var htmlEkspedisi = "";
    if (ekspedisi !== "") {
        htmlEkspedisi +=
            `
            ${ekspedisi.nama}<br>
            ${formatNewLine(ekspedisi.alamat)}<br>
            ${ekspedisi.no_kontak}
            `;
    } else {
        htmlEkspedisi += `Belum ditentukan`;
    }

    document.getElementById('ekspedisi').innerHTML = htmlEkspedisi;

</script>

@endsection
