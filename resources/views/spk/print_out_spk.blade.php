@extends('layouts.main_layout')

@section('content')
    
{{-- <div id="containerPrintOutSPK" class="p-0_5em"> --}}

<div id="divTableToPrint" class="grid-2-auto grid-column-gap-0_5em"></div>

<br><br>


<div class="text-center" class="no_print">
    <button type="submit" id='goToMainMenu' class="btn-1 d-inline-block bg-color-orange-1" onclick="windowHistoryGo({{ $go_back_number }});">Kembali ke SPK</button>
</div>



{{-- </div> --}}

<script>
    
    const spk = {!! json_encode($spk, JSON_HEX_TAG) !!};
    const pelanggan = {!! json_encode($pelanggan, JSON_HEX_TAG) !!};
    const data_spk_item = {!! json_encode($data_spk_item, JSON_HEX_TAG) !!};
    const tgl_pembuatan = {!! json_encode($tgl_pembuatan, JSON_HEX_TAG) !!};

    console.log("spk:");
    console.log(spk);

    console.log("pelanggan:");
    console.log(pelanggan);

    console.log("data_spk_item:");
    console.log(data_spk_item);

    console.log('tgl_pembuatan');
    console.log(tgl_pembuatan);

    var htmlTable =
        `
    <table style="width: 100%;">
    <tr>
        <td colspan="3" style="text-align: center;"><span style="font-weight: bold;">SURAT PERINTAH KERJA<br>PENGAMBILAN STOK</span></td>
    </tr>
    <tr>
        <td>NO.</td>
        <td>: ${spk.id}</td>
        <td style='text-align: center;'><span class="spanAsli" style="font-weight:bold;">ASLI</span></td>
    </tr>
    <tr>
        <td>TGL.</td>
        <td>: ${tgl_pembuatan}</td>
        <td></td>
    </tr>
    <tr>
        <td>UTK.</td>
        <td>: ${pelanggan.nama}-${pelanggan.daerah}</td>
        <td></td>
    </tr>
    <tr>
        <th colspan='2'>ITEM PRODUKSI</th>
        <th>JUMLAH</th>
    </tr>

    `;

    // var jumlahTotalItem = 0;

    for (var i = 0; i < 15; i++) {
        if (i < data_spk_item.length) {
            console.log(data_spk_item[i]);
            if (data_spk_item[i].ktrg !== '' && data_spk_item[i].ktrg !== null) {
                htmlTable = htmlTable +
                    `
                <tr>
                    <td colspan='2'>${data_spk_item[i].nama} :</td>
                    <td>${data_spk_item[i].jumlah}</td>
                </tr>
                <tr>
                    <td colspan='2' style='font-style: italic;'>${data_spk_item[i].ktrg.replace(new RegExp('\r?\n', 'g'), '<br />')}</td>
                    <td></td>
                </tr>
                `;
            } else {
                htmlTable = htmlTable +
                    `
                <tr>
                    <td colspan='2'>${data_spk_item[i].nama}</td>
                    <td>${data_spk_item[i].jumlah}</td>
                </tr>
                `;
            }

            // jumlahTotalItem = jumlahTotalItem + parseFloat(data_spk_item[i].jumlah);
        } else {
            htmlTable += `
            <tr style="height: 1.5em;">
                <td colspan='2'></td>
                <td></td>
            </tr>
            `;
        }

    }

    // for (const spkItem of data_spk_item) {
    //     if (spkItem.desc !== '') {
    //         htmlTable = htmlTable +
    //             `
    //         <tr>
    //             <td colspan='2'>${spkItem.nama} :</td>
    //             <td>${spkItem.jumlah}</td>
    //         </tr>
    //         <tr>
    //             <td colspan='2' style='font-style: italic;'>${spkItem.ktrg.replace(new RegExp('\r?\n', 'g'), '<br />')}</td>
    //             <td></td>
    //         </tr>
    //         `;
    //     } else {
    //         htmlTable = htmlTable +
    //             `
    //         <tr>
    //             <td colspan='2'>${spkItem.nama}</td>
    //             <td>${spkItem.jumlah}</td>
    //         </tr>
    //         `;
    //     }

    //     jumlahTotalItem = jumlahTotalItem + parseFloat(spkItem.jumlah);
    // }

    htmlTable = htmlTable +
        `
        <tr>
            <td colspan='2' style='font-weight: bold; text-align: right;'>
                Total
                <div style='display: inline-block;width: 0.5em;'></div>
            </td>
            <td style='font-weight: bold;'>${spk['jumlah_total']}</td>
        </tr>
        </table>
        `;


    $('#divTableToPrint').html(htmlTable);
    $('#divTableToPrint').append(htmlTable);

    var spanAsli = document.querySelectorAll('.spanAsli');
    spanAsli[1].innerHTML = 'COPY';
</script>

<style>
    table {
        border-collapse: collapse;
        border: 1px solid black;
    }

    table td {
        border: 1px solid black;
    }

    @media print {
        .no_print {
            display: none;
        }

        .divLogError {
            display: none;
        }

        .divLogWarning {
            display: none;
        }

        .divLogOK {
            display: none;
        }

        #goToMainMenu {
            display: none;
        }

        @page {
            size: A4;
            /* DIN A4 standard, Europe */
            margin: 0 5mm 0 5mm;
            padding-top: 0;
        }

        html,
        body {
            width: 210mm;
            /* height: 297mm; */
            height: 282mm;
            /* font-size: 11px; */
            background: #FFF;
            overflow: visible;
        }

        body {
            padding-top: 0mm;
        }
    }
</style>

@endsection

