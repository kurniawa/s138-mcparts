@extends('layouts/main_layout')

@section('content')
    
<header class="header grid-3-auto">
    <img class="w-0_8em ml-1_5em" src="img/icons/back-button-white.svg" alt="" onclick="goBack();">
    <div>
        <h2 style="color: white">SJ</h2>
    </div>
    <div class="justify-self-right pr-0_5em">
        <a href="/sj/sjBaru-pCust" id="btn-spk-baru" class="btn-atas-kanan2">
            + Buat Surat Jalan Baru
        </a>
    </div>
</header>

<div class="grid-2-auto mt-1em ml-1em mr-1em pb-1em bb-0_5px-solid-grey">
    <div class="justify-self-left grid-2-auto b-1px-solid-grey b-radius-50px mr-1em pl-1em pr-0_4em w-11em">
        <input class="input-2 mt-0_4em mb-0_4em" type="text" placeholder="Cari...">
        <div class="justify-self-right grid-1-auto justify-items-center circle-small bg-color-orange-1">
            <img class="w-0_8em" src="img/icons/loupe.svg" alt="">
        </div>
    </div>
    <div class="div-filter-icon">

        <div class="icon-small-circle grid-1-auto justify-items-center bg-color-orange-1">
            <img class="w-0_9em" src="img/icons/sort-by-attributes.svg" alt="sort-icon">
        </div>
    </div>
</div>

<div id="div-daftar-spk" class='ml-0_5em mr-0_5em'>
</div>

<script>

const sjs = {!! json_encode($sjs, JSON_HEX_TAG) !!};
console.log("sjs:");
console.log(sjs);

const pelanggans = {!! json_encode($pelanggans, JSON_HEX_TAG) !!};
console.log(pelanggans);

if (sjs == undefined || sjs.length == 0) {
    console.log('Belum ada daftar Surat Jalan');
} else {
    for (var i = 0; i < sjs.length; i++) {
        // console.log(sjs[i].created_at);
        // const SJDate = sjs[i].created_at.split('T')[0];
        const SJDate = sjs[i].created_at.split(' ')[0];
        console.log(SJDate);
        var arrayDate = SJDate.split('-');
        var getYear = arrayDate[0];
        var getMonth = arrayDate[1];
        var getDay = arrayDate[2];
        // console.log('getYear: ' + getYear);
        // console.log('getMonth: ' + getMonth);
        // console.log('getDay: ' + getDay);
        var subGetYear = getYear.substr(2);
        // console.log('subGetYear: ' + subGetYear);
        var warnaTglPembuatan = 'bg-color-soft-red';

        // apabila tanggal selesai telah ada
        var html_tgl_sls = "";

        if (sjs[i].finished_at !== '' && sjs[i].finished_at !== null) {
            const arrayDateSls = sjs[i].finished_at.split('-');
            const getYearSls = arrayDateSls[0];
            const getMonthSls = arrayDateSls[1];
            const getDaySls = arrayDateSls[2];

            // console.log('getYearSls: ' + getYearSls);
            // console.log('getMonthSls: ' + getMonthSls);
            // console.log('getDaySls: ' + getDaySls);
            subGetYearSls = getYearSls.substr(2);
            // console.log('subGetYearSls: ' + subGetYearSls);
            warnaTglSls = 'bg-color-purple-blue';
            warnaTglPembuatan = 'bg-color-orange-2';

            html_tgl_sls = `
                <div class='grid-1-auto justify-items-center ${warnaTglSls} color-white b-radius-5px w-3_5em'>
                <div class='font-size-2_5em'>${getDaySls}</div><div>${getMonthSls}-${subGetYearSls}</div></div>
            `;
        }
        
        // else {
        //     var statusColor = "";
        //     if (sjs[i].status == "PROSES") {
        //         statusColor = "tomato";
        //     } else {
        //         statusColor = "slateblue";
        //     }
        //     html_tgl_sls = `
        //         <div style="font-weight:bold;color:${statusColor}">${sjs[i].status}</div>
        //     `;
        // }

        // // MENGHITUNG Jumlah total
        // var jumlah_total_item_spk = 0;
        // for (let j = 0; j < spk_contains_item[i].length; j++) {
        //     jumlah_total_item_spk = jumlah_total_item_spk + parseFloat(spk_contains_item[i][j].jumlah);
        // }
        // console.log("jumlah total item spk:");
        // console.log(jumlah_total_item_spk);

        // ELEMENT to toggle
        var element_to_toggle = [{
            id: `#divSPKItems-${i}`,
            time: 300
        }];
        // console.log('element_to_toggle:');
        // console.log(element_to_toggle);
        element_to_toggle = JSON.stringify(element_to_toggle);
        // console.log(element_to_toggle);

        // HTML Item each SPK
        var htmlItemsEachSPK = '<tr><th>Nama Nota</th><th>Jml.</th><th>Hrg./pcs</th><th>Hrg.T</th></tr>';

        const nota_item = JSON.parse(sjs[i].data_nota_item);
        console.log('nota_item');
        console.log(nota_item);

        for (var k = 0; k < nota_item.length; k++) {
            var textContent_jumlah = `${nota_item[k].jumlah}`;
            console.log('define textContent_jumlah');
            if (typeof nota_item[k].deviasi_jml !== 'undefined') {
                console.log('deviasi_jml is defined!');
                const deviasi_jml = nota_item[k].deviasi_jml;
                if (deviasi_jml < 0) {
                    textContent_jumlah += ` ${deviasi_jml}`;
                } else {
                    textContent_jumlah += ` +${deviasi_jml}`;
                }
            }
            htmlItemsEachSPK = htmlItemsEachSPK +
                `<tr>
                    <td>${nota_item[k].nama_nota}</td>
                    <td>${nota_item[k].jml_item}</td>
                    <td>${formatHarga(nota_item[k].hrg_per_item.toString())}</td>
                    <td>${formatHarga(nota_item[k].hrg_total_item.toString())}</td>
                </tr>`;
        }


        var htmlDaftarSPK =
            `<form method='GET' action='/nota/nota-detailNota' class='pb-0_5em pt-0_5em bb-1px-solid-grey'>
                <div class='grid-5-9_45_25_18_5'>
                    <div class='circle-medium grid-1-auto justify-items-center font-weight-bold' style='background-color: ${randomColor()}'>${pelanggans[i].singkatan}</div>
                    <div>${pelanggans[i].nama} - ${pelanggans[i].daerah}</div>
                    <div class='grid-3-auto'>
                        <div class='grid-1-auto justify-items-center ${warnaTglPembuatan} b-radius-5px w-3_5em' style="color:white;">
                            <div style="font-size:2.5em">${getDay}</div><div>${getMonth}-${subGetYear}</div>
                        </div>
                        -
                        ${html_tgl_sls}
                    </div>
                    <div class='grid-1-auto'>
                        <div class='justify-self-right font-size-1_2em' style="color:green;font-weight:bold;">${formatHarga(sjs[i].harga_total.toString())}</div>
                        <div class='justify-self-right' style='color:grey'>Rp.</div>
                    </div>
                    <div class='justify-self-center'><img class='w-0_7em' src='img/icons/dropdown.svg' onclick='elementToToggle(${element_to_toggle});'></div>
                </div>` +
            // DROPDOWN
            `<div id='divSPKItems-${i}' class='p-0_5em b-1px-solid-grey' style='display: none'>
            <div class='font-weight-bold color-grey'>No. ${sjs[i].no_nota}</div>
            <input type='hidden' name='nota_id' value=${sjs[i].id}>
            <table style='width:100%'>${htmlItemsEachSPK}</table>
            <div class='text-right'>
            <button type='submit' class="d-inline-block bg-color-orange-1 pl-1em pr-1em b-radius-50px" style='border: none'>
            Lebih Detail >>
            </button>
            </div>
            </div>
            </form>`;

        $('#div-daftar-spk').append(htmlDaftarSPK);
    }
}



// set keadaan awal dimana JSON SPKToEdit dihilangkan
if (localStorage.getItem('dataSPKToEdit') !== null || localStorage.getItem('dataSPKBefore') !== null) {
    localStorage.removeItem('dataSPKToEdit');
    localStorage.removeItem('dataSPKBefore');
}

// Reload Page
const reload_page = {!! json_encode($reload_page, JSON_HEX_TAG) !!};
reloadPage(reload_page);

</script>

<style>
    .input-cari {
        border: none;
        width: 10em;
        border-radius: 25px;
        padding: 0.5em 1em 0.5em 1em;
        box-shadow: 0 0 2px gray;
    }

    .input-cari:focus {
        box-shadow: 0 0 6px #23FFAD;
    }

    .field {
        margin: 1em;
    }

    .div-filter-icon {
        justify-self: end;
    }

    .icon-small-circle {
        border-radius: 100%;
        width: 2em;
        height: 2em;
    }

    .icon-img {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>
@endsection