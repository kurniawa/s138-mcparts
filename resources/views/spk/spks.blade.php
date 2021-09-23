@extends('layouts/main_layout')

{{-- var pelanggan = {!! json_encode($pelanggan, JSON_HEX_TAG) !!};
console.log("pelanggan:")
console.log(pelanggan);

var spk_item = {!! json_encode($spk_item, JSON_HEX_TAG) !!};
console.log("spk_item:");
console.log(spk_item);

var spk_contains_item = {!! json_encode($spk_contains_item, JSON_HEX_TAG) !!};
console.log("spk_contains_item:");
console.log(spk_contains_item); --}}

{{-- {{ dd($spks) }} --}}
@section('content')
    
<header class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="img/icons/back-button-white.svg" alt="" onclick="goBack();">
    <div class="justify-self-right pr-0_5em">
        <a href="/spk/spk_baru" id="btn-spk-baru" class="btn-atas-kanan2">
            + Buat SPK Baru
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

const spks = {!! json_encode($spks, JSON_HEX_TAG) !!};
console.log("spks:");
console.log(spks);

if (spks == undefined || spks.length == 0) {
    console.log('Belum ada daftar SPK');
} else {
    for (var i = 0; i < spks.length; i++) {
        // console.log(spks[i].created_at);
        const SPKDate = spks[i].created_at.split('T')[0];
        // console.log(SPKDate);
        var arrayDate = SPKDate.split('-');
        var getYear = arrayDate[0];
        var getMonth = arrayDate[1];
        var getDay = arrayDate[2];
        console.log('getYear: ' + getYear);
        console.log('getMonth: ' + getMonth);
        console.log('getDay: ' + getDay);
        var subGetYear = getYear.substr(2);
        console.log('subGetYear: ' + subGetYear);
        var warnaTglPembuatan = 'bg-color-soft-red';

        // apabila tanggal selesai telah ada
        var html_tgl_sls = "";

        if (spks[i].finished_at !== '' && spks[i].finished_at !== null) {
            const arrayDateSls = spks[i].finished_at.split('-');
            const getYearSls = arrayDateSls[0];
            const getMonthSls = arrayDateSls[1];
            const getDaySls = arrayDateSls[2];

            console.log('getYearSls: ' + getYearSls);
            console.log('getMonthSls: ' + getMonthSls);
            console.log('getDaySls: ' + getDaySls);
            subGetYearSls = getYearSls.substr(2);
            console.log('subGetYearSls: ' + subGetYearSls);
            warnaTglSls = 'bg-color-purple-blue';
            warnaTglPembuatan = 'bg-color-orange-2';

            html_tgl_sls = `
                <div class='grid-1-auto justify-items-center ${warnaTglSls} color-white b-radius-5px w-3_5em'>
                <div class='font-size-2_5em'>${getDaySls}</div><div>${getMonthSls}-${subGetYearSls}</div></div>
            `;
        } else {
            var statusColor = "";
            if (spks[i].status == "PROSES") {
                statusColor = "tomato";
            } else {
                statusColor = "slateblue";
            }
            html_tgl_sls = `
                <div style="font-weight:bold;color:${statusColor}">${spks[i].status}</div>
            `;
        }

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
        console.log('element_to_toggle:');
        console.log(element_to_toggle);
        element_to_toggle = JSON.stringify(element_to_toggle);
        console.log(element_to_toggle);

        // HTML Item each SPK
        var htmlItemsEachSPK = '';

        const spk_item = JSON.parse(spks[i].data_spk_item);
        console.log(spk_item);

        for (var k = 0; k < spk_item[i].length; k++) {
            htmlItemsEachSPK = htmlItemsEachSPK +
                `<div>${spk_item[i][k].nama_lengkap}</div><div>${spk_contains_item[i][k].jumlah}</div>`;
        }


        var htmlDaftarSPK =
            `<form method='GET' action='03-03-01-detail-spk.php' class='pb-0_5em pt-0_5em bb-1px-solid-grey'>
                <div class='grid-5-9_45_25_18_5'>
                <div class='circle-medium grid-1-auto justify-items-center font-weight-bold' style='background-color: ${randomColor()}'>${pelanggan[i].singkatan}</div>
                <div>${pelanggan[i].nama} - ${pelanggan[i].daerah}</div>
                <div class='grid-3-auto'>
                <div class='grid-1-auto justify-items-center ${warnaTglPembuatan} color-white b-radius-5px w-3_5em'>
                <div class='font-size-2_5em'>${getDay}</div><div>${getMonth}-${subGetYear}</div>
                </div>
                -
                ${html_tgl_sls}
                </div>
                <div class='grid-1-auto'>
                <div class='color-green justify-self-right font-size-1_2em font-weight-bold'>${spks[i].jumlah_total}</div>
                <div class='color-grey justify-self-right'>Jumlah</div>
                </div>
                <div class='justify-self-center'><img class='w-0_7em' src='img/icons/dropdown.svg' onclick='elementToToggle(${element_to_toggle});'></div>
                </div>` +
            // DROPDOWN
            `<div id='divSPKItems-${i}' class='p-0_5em b-1px-solid-grey' style='display: none'>
            <div class='font-weight-bold color-grey'>No. ${spk[i].id}</div>
            <input type='hidden' name='id_spk' value=${spk[i].id}>
            <div class='grid-2-auto'>${htmlItemsEachSPK}</div>
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

function daftarSPK() {
    let i = 0;
    console.log('function dafarSPK dijalankan.');
    console.log('daftarIDSPK: ' + daftarIDSPK);
    daftarIDSPK.forEach(idSPK => {
        let arrayDate = daftarTglPembuatan[i].split('-');
        let getYear = arrayDate[0];
        let getMonth = arrayDate[1];
        let getDay = arrayDate[2];
        console.log('getYear: ' + getYear);
        console.log('getMonth: ' + getMonth);
        console.log('getDay: ' + getDay);
        let subGetYear = getYear.substr(2);
        console.log('subGetYear: ' + subGetYear);
        let warnaTglPembuatan = 'bg-color-soft-red';

        // apabila tanggal selesai telah ada
        let arrayDateSls = '';
        let getYearSls = '';
        let getMonthSls = '';
        let getDaySls = '';
        let warnaTglSls = '';
        let subGetYearSls = '';

        if (daftarTglSelesai[i] != '') {
            arrayDateSls = daftarTglSelesai[i].split('-');
            getYearSls = arrayDateSls[0];
            getMonthSls = arrayDateSls[1];
            getDaySls = arrayDateSls[2];

            console.log('getYearSls: ' + getYearSls);
            console.log('getMonthSls: ' + getMonthSls);
            console.log('getDaySls: ' + getDaySls);
            subGetYearSls = getYearSls.substr(2);
            console.log('subGetYearSls: ' + subGetYearSls);
            warnaTglSls = 'bg-color-orange-2';
            warnaTglPembuatan = 'bg-color-purple-blue';
        }

        console.log(`daftarNamaPelangganSPK[${i}]: ${daftarNamaPelangganSPK[i]}`);
        console.log(`daftarJumlahTotalSPK[${i}]: ${daftarJumlahTotalSPK[i]}`);
        console.log(`daftarNamaProdukEachSPK[${i}]: ${JSON.stringify(daftarNamaProdukEachSPK[i])}`);
        let elementToToggle = [{
            id: `#divSPKItems-${i}`,
            time: 300
        }];
        console.log('elementToToggle:');
        console.log(elementToToggle);
        elementToToggle = JSON.stringify(elementToToggle);
        console.log(elementToToggle);
        let htmlItemsEachSPK = '';
        let htmlHiddenInput =
            `
            <input type='hidden' name='SPKID' value='${daftarIDSPK[i]}'>
            <input type='hidden' name='custID' value='${daftarIDPelangganSPK[i]}'>
            <input type='hidden' name='custName' value='${daftarNamaPelangganSPK[i]}'>
            <input type='hidden' name='daerah' value='${daftarDaerahPelangganSPK[i]}'>
            <input type='hidden' name='tglPembuatan' value='${daftarTglPembuatan[i]}'>
            <input type='hidden' name='tglSelesai' value='${daftarTglSelesai[i]}'>
            <input type='hidden' name='ketSPK' value='${daftarKetSPK[i]}'>
            <input type='hidden' name='jmlTotal' value='${daftarJumlahTotalSPK[i]}'>
            <input type='hidden' name='keteranganTambahan' value='${daftarKeteranganTambahanSPK[i]}'>
        `;
        for (let j = 0; j < daftarNamaProdukEachSPK[i].length; j++) {
            htmlItemsEachSPK = htmlItemsEachSPK +
                `<div>${daftarNamaProdukEachSPK[i][j]}</div><div>${daftarJumlahItemSPK[i][j]}</div>`;
            htmlHiddenInput = htmlHiddenInput +
                `
                <input type='hidden' name='SPKItem[]' value='${daftarNamaProdukEachSPK[i][j]}'>
                <input type='hidden' name='jmlItem[]' value='${daftarJumlahItemSPK[i][j]}'>
                <input type='hidden' name='descEachItem[]' value='${daftarDescEachItem[i][j]}'>
                <input type='hidden' name='hargaPcs[]' value='${daftarHargaPerPcs[i][j]}'>
                <input type='hidden' name='hargaItem[]' value='${daftarHargaItemSPK[i][j]}'>
                <input type='hidden' name='bahan[]' value='${daftarBahan[i][j]}'>
                <input type='hidden' name='varia[]' value='${daftarVaria[i][j]}'>
                <input type='hidden' name='ukuran[]' value='${daftarUkuran[i][j]}'>
                <input type='hidden' name='logo[]' value='${daftarLogo[i][j]}'>
                <input type='hidden' name='tato[]' value='${daftarTato[i][j]}'>
                <input type='hidden' name='jahit[]' value='${daftarJahit[i][j]}'>
                <input type='hidden' name='japstyle[]' value='${daftarJapstyle[i][j]}'>
                <input type='hidden' name='tipe[]' value='${daftarTipeProduk[i][j]}'>
                `;
        }
        let htmlDaftarSPK =
            `<form method='POST' action='03-03-01-inserting-items.php' class='pb-0_5em pt-0_5em bb-1px-solid-grey'>
                <div class='grid-5-9_45_25_18_5'>
                <div class='circle-medium grid-1-auto justify-items-center font-weight-bold' style='background-color: ${randomColor()}'>${daftarSingkatanPelangganSPK[i]}</div>
                <div>${daftarNamaPelangganSPK[i]} - ${daftarDaerahPelangganSPK[i]}</div>
                <div class='grid-3-auto'>
                <div class='grid-1-auto justify-items-center ${warnaTglPembuatan} color-white b-radius-5px w-3_5em'>
                <div class='font-size-2_5em'>${getDay}</div><div>${getMonth}-${subGetYear}</div>
                </div>
                -
                <div class='grid-1-auto justify-items-center ${warnaTglSls} color-white b-radius-5px w-3_5em'>
                <div class='font-size-2_5em'>${getDaySls}</div><div>${getMonthSls}-${subGetYearSls}</div>
                </div>
                </div>
                <div class='grid-1-auto'>
                <div class='color-green justify-self-right font-size-1_2em font-weight-bold'>${daftarJumlahTotalSPK[i]}</div>
                <div class='color-grey justify-self-right'>Jumlah</div>
                </div>
                <div class='justify-self-center'><img class='w-0_7em' src='img/icons/dropdown.svg' onclick='elementToToggle(${elementToToggle});'></div>
                </div>` + htmlHiddenInput +
            // DROPDOWN
            `<div id='divSPKItems-${i}' class='p-0_5em b-1px-solid-grey' style='display: none'>
            <div class='font-weight-bold color-grey'>No. ${daftarIDSPK[i]}</div>
            <div class='grid-2-auto'>` + htmlItemsEachSPK + `</div>
            <div class='text-right'>
            <button type='submit' class="d-inline-block bg-color-orange-1 pl-1em pr-1em b-radius-50px" style='border: none'>
            Lebih Detail >>
            </button>
            </div>
            </div>
            </form>`;

        $('#div-daftar-spk').append(htmlDaftarSPK);
        i++;
        console.log('i: ' + i);
    });
}

// function addNewSPK() {
//     localStorage.setItem('SPKItems', '');
//     window.location.href = '03-03-spk-baru.php';
// }

// set keadaan awal dimana JSON SPKToEdit dihilangkan
if (localStorage.getItem('dataSPKToEdit') !== null || localStorage.getItem('dataSPKBefore') !== null) {
    localStorage.removeItem('dataSPKToEdit');
    localStorage.removeItem('dataSPKBefore');
}

// RELOAD PAGE
const reload_page =  {!! json_encode($reload_page, JSON_HEX_TAG) !!};
console.log('reload_page: ' + reload_page);
if (reload_page === true) {
    window.location.reload();
}
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