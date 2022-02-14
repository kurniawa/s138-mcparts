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
        <form action="/sj/sj-printOut" method='GET'>
            <button id="downloadExcel" type="submit" class="threeDotMenuItem">
                <img src="/img/icons/download.svg" alt=""><span>Print Out Surat Jalan</span>
            </button>
            <input type="hidden" name="sj_id" value={{ $sj['id'] }}>
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

<div class="grid-2-50_50 grid-row-gap-0_5em grid-column-gap-0_5em ml-0_5em mr-0_5em">
    <div class="b-1px-solid-grey">

        <div class="h-10em">
            <div class="grid-1-auto justify-items-center">
                <img class="w-2_5em" src="/img/icons/address.svg" alt="">
            </div>
            <div id="customerInfo" class="mt-0_5em font-size-0_9em font-weight-bold">Alamat Customer</div>
        </div>

    </div>

    <div class='b-1px-solid-grey'>

        <div class='h-10em'>
            <div class='grid-1-auto justify-items-center'>
                <img class='w-2_5em' src='/img/icons/truck_2.svg' alt=''>
            </div>
            <div id='customerExpedition-$index' class='mt-0_5em font-size-0_9em font-weight-bold'>Info Ekspedisi</div>
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
    const my_csrf = {!! json_encode($csrf, JSON_HEX_TAG) !!};
    const pelanggan = {!! json_encode($pelanggan, JSON_HEX_TAG) !!};
    const reseller = {!! json_encode($reseller, JSON_HEX_TAG) !!};

    if (show_console === true) {
        console.log("sj");
        console.log(sj);
        console.log("d_sj_item");
        console.log(d_sj_item);
        console.log("pelanggan");
        console.log(pelanggan);
        console.log("reseller");
        console.log(reseller);
    }


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
        
        var htmlItem =
            `
            <form action="07-02-editDetailsj.php" method="POST" class="bb-1px-solid-grey pb-0_5em pt-0_5em">

            <div>${nomorUrutItem}.</div>
            <div class="grid-4-10_52_18_20">
                <div>${d_sj_item[i].jml_item}</div>
                <div>${d_sj_item[i].nama_nota}</div>
                <div>${formatHarga(d_sj_item[i].hrg_item.toString())}</div>
                <div>${formatHarga(d_sj_item[i].hrg_t.toString())}</div>

                <div>Jml.</div>
                <div>Nama Item Pada sj</div>
                <div>Hrg/Pcs</div>
                <div>Harga</div>
            </div>
            <div class="mt-0_5em text-right">Tampilkan Opsi Edit <input id="checkboxShowOpsiEdit-${i}" type="checkbox" onclick='onCheckToggle(${opsiEditToToggle});'></div>

            ${htmlElementDropdown}
           
            </form>
        `;
        // console.log(htmlItem);
        $('#divDaftarItemsj').append(htmlItem);
        // totalHarga += parseInt(d_sj_item[i].hrg_t);
    }

   

    var htmlTotalHarga =
        `
        <div class="text-right p-1em">
            <div class="font-weight-bold font-size-2em color-green">${sj.colly_T}</div>
            <div class="font-weight-bold color-red font-size-1_5em">Total</div>
        </div>
        `;

    $('#divDaftarItemsj').append(htmlTotalHarga);

    $('.divThreeDotMenuContent').hide();
    
    function showLightBox() {
        $('.lightBox').show();
        $('#closingGreyArea').show();
        $('.divThreeDotMenuContent').hide();
    }

    document.querySelector('.threeDot').addEventListener('click', function () {
    let element = [{
        id: '.divThreeDotMenuContent',
        time: 300
    }];
    elementToToggle(element);
    });

    function closingLightBox() {
        $('.closingGreyArea').hide();
        $('.lightBox').hide();
    }

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

    function showLightBoxGlobal(deletePropertiesStrigified) {
        $('.divThreeDotMenuContent').hide();

        var deleteProperties = JSON.parse(deletePropertiesStrigified);
        var divLightBoxGlobal = document.createElement("div");
        divLightBoxGlobal.id = "divLightBoxGlobal";
        var htmlDivLightBoxGlobal = `
            <div class="grid-2-10_auto">
                <div><img src="/img/icons/speech-bubble.svg" alt="" style="width: 2em;"></div>
                <div class="font-weight-bold">${deleteProperties.title}</div>
            </div>
            <br><br>
            <div class="grid-2-auto">
                <form action="${deleteProperties.action}" method='POST'>
                    <input type="hidden" name="_token" value="${deleteProperties.csrf}">
                    <button type="submit" class="btn-1 bg-color-soft-red" style="width:100%">
                        <img src="/img/icons/trash-can.svg" style="width:1em" alt=""><span>${deleteProperties.yes}</span>
                    </button>
                    <input type="hidden" name="${deleteProperties.column}" value=${deleteProperties.columnValue}>
                </form>
                
                <button class="text-center btn-1 bg-color-orange-1" onclick='lightBoxGlobalNo();'>
                    <span>${deleteProperties.no}</span>
                </button>
            </div>
        `;
        divLightBoxGlobal.innerHTML = htmlDivLightBoxGlobal;

        var divClosingGreyAreaGlobal = document.createElement("div");
        divClosingGreyAreaGlobal.id = "divClosingGreyAreaGlobal";
        // var htmlDivClosingGreyAreaGlobal = `
        // <div id="divClosingGreyAreaGlobal"></div>
        // `;
        // divClosingGreyAreaGlobal.innerHTML(htmlDivClosingGreyAreaGlobal);

        // <a href="DELETE-OneItemGlobalFromTable.php?table=${deleteProperties.table}&column=${deleteProperties.column}&columnValue=${deleteProperties.columnValue}&goBackNumber=${deleteProperties.goBackNumber}&goBackStatement=${deleteProperties.goBackStatement}" class="text-center btn-1 bg-color-soft-red">
        //     <span>${deleteProperties.yes}</span>
        // </a>

        document.body.appendChild(divClosingGreyAreaGlobal);
        document.body.appendChild(divLightBoxGlobal);

    }
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
