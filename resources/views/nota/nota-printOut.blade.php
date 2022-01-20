@extends('layouts.main_layout')

@section('content')

<header class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="/img/icons/back-button-white.svg" alt="" onclick="goBack();">
</header>

<div id="containerDetailNota">
    <div class="grid-3-25_25_50">
        <div><img width="200em" src="/img/images/logo-mc.jpg" alt=""></div>
        <div><span class="font-weight-bold font-size-1_5em" style="font-family: Georgia, 'Times New Roman', Times, serif; color:darkblue;">NOTA</span><br>CV. MC-Parts<br>Jl. Raya Kranggan No. 96<br>Kec. Gn. Putri/Kab. Bogor<br>0812 9335 218<br>0812 8655 6500</div>
        <div class='grid-3-30_5_65'>
            <div>No. Nota</div>
            <div>:</div>
            <div id="noNota">{{ $nota['no_nota'] }}</div>
            <div>Tanggal</div>
            <div>:</div>
            <div id="tglNota">{{ date('d-m-Y', strtotime($nota['created_at'])) }}</div>
            <div>Nama</div>
            <div>:</div>
            <div id="custName">{{ $pelanggan['nama'] }}</div>
            <div>Alamat</div>
            <div>:</div>
            <div id="alamatCust">{{ $pelanggan['daerah'] }}</div>
        </div>
    </div>

    <br>

    <hr style="height: 2px; background-color: black; margin-bottom: 0.2em; margin-top: 0;">
    <table id="tableItemNota" style="width: 100%;">
        <tr class="tr-border-bottom tr-border-left-right">
            <th>Jumlah</th>
            <th>Nama Barang</th>
            <th>Hrg./pcs</th>
            <th>Harga</th>
        </tr>
    </table>

    <br>
    <div class="grid-1-auto justify-items-right">
        <div class="grid-1-auto justify-items-center">
            <div class="">Hormat Kami,</div>
            <br><br><br>
            <div>(....................)</div>
        </div>
    </div>
</div>

<div id="closingGreyArea" class="closingGreyArea" style="display: none;"></div>
<form action="07-04-hapusNota.php" method="POST" class="lightBox" style="display:none;">
    <div class="grid-2-10_auto">
        <div><img src="/img/icons/speech-bubble.svg" alt="" style="width: 2em;"></div>
        <div class="font-weight-bold">Yakin ingin menghapus nota?</div>
    </div>
    <br><br>
    <input type="hidden" name="idNota" value=" $idNota">
    <div class="text-center">
        <div class="btn-tipis bg-color-orange-1 d-inline-block" onclick="closingLightBox();">Tidak</div>
        <button type="submit" id="btnSPKSelesai" class="btn-tipis bg-color-soft-red d-inline-block">Ya</button>
    </div>
</form>

<style>
    #containerDetailNota {
        font-family: 'Roboto';
        font-weight: normal;
        font-style: normal;
        /* font-size: 0.8em; */
    }

    #tableItemNota {
        border-collapse: collapse;
        border-top: 1px solid black;
    }

    .tr-border-bottom th {
        border-bottom: 1px solid black;
        padding-top: 1em;
        padding-bottom: 1em;
    }

    .tr-border-bottom td {
        border-bottom: 1px solid black;
    }

    .tr-border-left-right th,
    .tr-border-left-right td {
        border-left: 1px solid black;
        border-right: 1px solid black;
    }

    .height-1_5em td {
        height: 1.5em;
    }

    .blrb-total {
        border-left: 1px solid black;
        border-right: 1px solid black;
        border-bottom: 3px solid black;
        padding-top: 1em;
        padding-bottom: 1em;
    }

    @media print {
        .bg-color-orange-1 {
            background-color: #FFED50;
            -webkit-print-color-adjust: exact;
        }
    }
</style>

<script>

    var tglNota = ' $tglNota';
    var namaPelanggan = ' $namaPelanggan';
    var daerahPelanggan = ' $daerahPelanggan';
    var alamatPelanggan = ` $alamatPelanggan`;

    var totalHarga = 0;

    // OVERWRITE BEBERAPA VARIABLE DIATAS DENGAN VERSI BARU
    var nota = {!! json_encode($nota, JSON_HEX_TAG) !!};
    console.log("nota");
    console.log(nota);

    const d_nota_item = JSON.parse(nota['data_nota_item']);
    console.log("d_nota_item");
    console.log(d_nota_item);

    for (var i = 0; i < d_nota_item.length; i++) {
        var htmlItem =
            `
        <tr class='tr-border-left-right height-1_5em'><td>${formatHarga(d_nota_item[i].jml_item.toString())}</td><td>${d_nota_item[i].nama_nota}</td><td>${formatHarga(d_nota_item[i].hrg_per_item.toString())}</td><td>${formatHarga(d_nota_item[i].hrg_total_item.toString())}</td></tr>
        `;
        $('#tableItemNota').append(htmlItem);
    }

    var restRow = 16 - d_nota_item.length;
    console.log("restRow");
    console.log(restRow);

    for (var i = 0; i < restRow; i++) {
        var htmlRestRow =
            `
        <tr class='tr-border-left-right height-1_5em'><td></td><td></td><td></td><td></td></tr>
        `;
        $('#tableItemNota').append(htmlRestRow);
    }

    var htmlLastRow =
        `
    <tr class='tr-border-left-right tr-border-bottom'><td></td><td></td><td></td><td></td></tr>
    `;

    $('#tableItemNota').append(htmlLastRow);

    var htmlTotalHarga =
        `
        <tr><td></td><td></td>
        <th class='blrb-total'>Total Harga</th>
        <td class='blrb-total'>${formatHarga(nota.harga_total.toString())}</td>
        </tr>
        `;

    $('#tableItemNota').append(htmlTotalHarga);

    document.querySelector('.closingGreyArea').addEventListener('click', (event) => {
        $('.closingGreyArea').hide();
        $('.lightBox').hide();
    });

    function showLightBox() {
        $('.lightBox').show();
        $('#closingGreyArea').show();
        $('.divThreeDotMenuContent').hide();
    }

    function closingLightBox() {
        $('.closingGreyArea').hide();
        $('.lightBox').hide();
    }

    // document.getElementById("konfirmasiHapusNota").addEventListener("click", function() {
    //     var deleteProperies = [{
    //         title: "Yakin ingin menghapus Nota ini?",
    //         yes: "Ya",
    //         no: "Batal",
    //         table: "nota",
    //         column: "id",
    //         columnValue: idNota,
    //         goBackNumber: -2,
    //         goBackStatement: "Daftar Nota"
    //     }];

    //     var deletePropertiesStringified = JSON.stringify(deleteProperies);
    //     showLightBoxGlobal(deletePropertiesStringified);
    // });;
</script>

<style>
    .closingGreyArea {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: black;
        opacity: 0.2;
    }

    .lightBox {
        position: absolute;
        top: 25vh;
        left: 0.5em;
        right: 0.5em;
        height: 13em;
        background-color: white;
        padding: 1em;
    }
</style>

@endsection
