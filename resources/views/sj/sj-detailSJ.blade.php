@extends('layouts.main_layout')

@section('content')

<header class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="/img/icons/back-button-white.svg" alt="" onclick="goBack();">
</header>

<div class="threeDotMenu">
    <div class="threeDot">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
    <div class="divThreeDotMenuContent">
        {{-- <form method='post' action="sj/sj-editsj" id="" class="threeDotMenuItem">
            <img src="/img/icons/edit.svg" alt=""><span>Edit sj</span>
        </form> --}}
        <!-- <div id="downloadExcel" class="threeDotMenuItem" onclick="goToPrintOutSPK();">
            <img src="img/icons/download.svg" alt=""><span>Download Excel</span>
        </div> -->
        <form action="/sj/sj-printOut" method='POST'>
            <button id="downloadExcel" type="submit" class="threeDotMenuItem">
                <img src="/img/icons/download.svg" alt=""><span>Print Out Surat Jalan</span>
            </button>
            <input type="hidden" name="sj" value='{{ $sj }}'>
            <input type="hidden" name="pelanggan" value='{{ $pelanggan }}'>
            <input type="hidden" name="reseller" value='{{ $reseller }}'>
            <input type="hidden" name="ekspedisi" value='{{ $ekspedisi }}'>
            @csrf
        </form>
        {{-- <form action="/sj/sj-hapus" method='POST'>
            @csrf
            <button id="hapussj" type="submit" class="threeDotMenuItem" id="konfirmasiHapussj" style="width: 100%">
                <img src="/img/icons/trash-can.svg" alt=""><span>Hapus sj</span>
            </button>
            <input type="hidden" name="sj_id" value={{ $sj['id'] }}>
        </form> --}}
        <div id="konfirmasiHapussj" class="threeDotMenuItem">
            <img src="/img/icons/trash-can.svg" alt=""><span>Hapus Surat Jalan</span>
        </div>
        <!-- <div id="deleteSPK" class="threeDotMenuItem" onclick="goToDeleteSPK();">
            <img src="img/icons/trash-can.svg" alt=""><span>Cancel/Hapus SPK</span>
        </div> -->
    </div>
</div>

<div class="grid-2-10_auto p-0_5em">
    <img class="w-2em" src="/img/icons/pencil.svg" alt="">
    <h2 class="">Detail Surat Jalan: {{ $sj['no_sj'] }} </h2>
</div>

<div class="table">
    <div>
        <div class="b-1px-solid-grey" style="width: 50%">
    
            <div>
                <div class="grid-1-auto justify-items-center">
                    <img class="w-2_5em" src="/img/icons/boy.svg" alt="">
                </div>
                <div id="customerInfo" class="mt-0_5em font-size-0_9em" style="font-weight: bold">Info Customer</div>
                <div id="info_cust"></div>
            </div>
    
        </div>
    
        <div class='b-1px-solid-grey' style="width: 50%">
    
            <div>
                <div class='grid-1-auto justify-items-center'>
                    <img class='w-2_5em' src='/img/icons/truck_2.svg' alt=''>
                </div>
                <div id='customerExpedition-$index' class='mt-0_5em font-size-0_9em' style="font-weight: bold">Info Ekspedisi</div>
                <div id="info_ekspedisi"></div>
            </div>
    
        </div>
    </div>
</div>

<div id="divDaftarItemsj" class="p-0_5em"></div>

<style>
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
    const d_sj_item = JSON.parse(sj['json_sj_item']);
    const pelanggan = {!! json_encode($pelanggan, JSON_HEX_TAG) !!};
    const reseller = {!! json_encode($reseller, JSON_HEX_TAG) !!};
    const ekspedisi = {!! json_encode($ekspedisi, JSON_HEX_TAG) !!};
    const my_csrf = {!! json_encode($csrf, JSON_HEX_TAG) !!};

    if (show_console === true) {
        console.log("sj");
        console.log(sj);
        console.log("d_sj_item");
        console.log(d_sj_item);
        console.log("pelanggan");
        console.log(pelanggan);
        console.log("reseller");
        console.log(reseller);
        console.log("ekspedisi");
        console.log(ekspedisi);
    }

    var htmlInfoCust = '';

    if (reseller !== null) {
        htmlInfoCust += `
            Reseller: ${reseller.nama} =><br>akan dicantumkan sebagai Pengirim.<br>Barang akan dikirimkan ke:
            <br>
            <br>
        `;
    }

    htmlInfoCust += `
    <div>${pelanggan.nama}</div>
    <div>${formatNewLine(pelanggan.alamat)}</div>
    <div>${pelanggan.no_kontak}</div>
    `;

    document.getElementById("info_cust").innerHTML = htmlInfoCust;

    var htmlInfoEkspedisi = `
        <div>${ekspedisi.nama}</div>
        <div>${formatNewLine(ekspedisi.alamat)}</div>
        <div>${ekspedisi.no_kontak}</div>
    `;

    document.getElementById("info_ekspedisi").innerHTML = htmlInfoEkspedisi;

    // var htmlItem = `
    //     <table>
    //         <tr><th>Jml.</th><th>Nama Barang</th><th>Koli</th></tr>
    // `;

    var htmlItem = `
        <div class='table'>
            <div style='font-weight:bold'><div>Jml.</div><div>Nama Barang</div><div>Koli</div></div>
    
    `;
    for (var i = 0; i < d_sj_item.length; i++) {
        var nomorUrutItem = i + 1;

        var opsiEditToToggle = [{
            idCheckbox: `#checkboxShowOpsiEdit-${i}`,
            elementToToggle: `#divOpsiEdit-${i}`,
            time: 300
        }];

        opsiEditToToggle = JSON.stringify(opsiEditToToggle);

        var inputJumlahToToggle = [{
            idCheckboxORLogic: [`#checkboxShowInputJumlah-${i}`, `#checkboxShowInputNamaHrg-${i}`],
            elementToToggle: `#divInputJumlah-${i}`,
            elementORLogicToToggle: `#btnEdit-${i}`,
            time: 300
        }];

        inputJumlahToToggle = JSON.stringify(inputJumlahToToggle);

        var inputNamaHrgToToggle = [{
            idCheckboxORLogic: [`#checkboxShowInputNamaHrg-${i}`, `#checkboxShowInputJumlah-${i}`],
            elementToToggle: `#divInputNamaHrg-${i}`,
            elementORLogicToToggle: `#btnEdit-${i}`,
            time: 300
        }];

        inputNamaHrgToToggle = JSON.stringify(inputNamaHrgToToggle);

        var htmlElementDropdown = `
        <div id="divOpsiEdit-${i}" style="display:none">
            <div><input id="checkboxShowInputJumlah-${i}" type="checkbox" onclick='onMultipleCheckToggleWithORLogic(${inputJumlahToToggle});'>Edit Jumlah</div>
            <div id="divInputJumlah-${i}" class="mt-0_5em" style="display:none">
                Jumlah tersedia:
                Jumlah Tambahan yang Ingin diinput: <input class="p-0_5em" type="number" value="${d_sj_item[i].jml_item}">
            </div>
            <div class="mt-0_5em"><input id="checkboxShowInputNamaHrg-${i}" type="checkbox" onclick='onMultipleCheckToggleWithORLogic(${inputNamaHrgToToggle});'>Edit Nama sj & Hrg/pcs</div>
            <div id="divInputNamaHrg-${i}" style="display:none">
                <div class="mt-0_5em">Nama sj: <input class="p-0_5em w-70" type="text" value="${d_sj_item[i].nama_sj}"></div>
                <div class="mt-0_5em">Hrg/pcs: <input class="p-0_5em" type="number" value="${d_sj_item[i].hrg_item}"></div>
            </div>
            <br>
            <div id="divBtnHapusEdit-${i}" class="text-center">
                <input type="hidden" name="sj_id" value="${sj.id}">
                <button class="btn-1 bg-color-soft-red" type="submit" name="hapus">Hapus</button>
                <button id="btnEdit-${i}" class="btn-1 bg-color-orange-1" type="submit" name="edit" style="display:none">Konfirmasi Edit</button>
            </div>
        </div>
        `;

        // console.log(`nomorUrutItem: ${nomorUrutItem}`);
        // console.log(`d_sj_item[${i}].jml_item: ${d_sj_item[i].jml_item}`);
        // console.log(`d_sj_item[${i}].nama_sj: ${d_sj_item[i].nama_sj}`);
        // console.log(`d_sj_item[${i}].hrg_item: ${d_sj_item[i].hrg_item}`);
        // console.log(`d_sj_item[${i}].hrg_t: ${d_sj_item[i].hrg_t}`);
        // <div class="mt-0_5em text-right">Tampilkan Opsi Edit <input id="checkboxShowOpsiEdit-${i}" type="checkbox" onclick='onCheckToggle(${opsiEditToToggle});'></div>

        // ${htmlElementDropdown}
        
        htmlItem += `
            <div class="bb-1px-solid-grey pb-0_5em pt-0_5em">
                <div>${d_sj_item[i].jml_item}</div>
                <div>${d_sj_item[i].nama_nota}</div>
                <div>${d_sj_item[i].colly}</div>
            </div>
        `;
        // console.log(htmlItem);
        // totalHarga += parseInt(d_sj_item[i].hrg_t);
    }
    htmlItem += '</div>';
    
    $('#divDaftarItemsj').append(htmlItem);
   

    var htmlTotalHarga =
        `
        <div class="text-right p-1em">
            <div class="font-weight-bold font-size-2em color-green">${sj.colly_T}</div>
            <div class="font-weight-bold color-red font-size-1_5em">Total</div>
        </div>
        `;

    $('#divDaftarItemsj').append(htmlTotalHarga);

    document.getElementById("konfirmasiHapussj").addEventListener("click", function() {
        var deleteProperties = {
            title: "Yakin ingin menghapus sj ini?",
            yes: "Ya",
            no: "Batal",
            table: "sjs",
            column: "sj_id",
            columnValue: sj.id,
            action: "/sj/sj-hapus",
            csrf: my_csrf,
            goBackNumber: -2,
            goBackStatement: "Daftar sj"
        };

        var deletePropertiesStringified = JSON.stringify(deleteProperties);
        showLightBoxGlobal(deletePropertiesStringified);
    });
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
