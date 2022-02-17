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
        {{-- <form method='post' action="nota/nota-editNota" id="" class="threeDotMenuItem">
            <img src="/img/icons/edit.svg" alt=""><span>Edit Nota</span>
        </form> --}}
        <!-- <div id="downloadExcel" class="threeDotMenuItem" onclick="goToPrintOutSPK();">
            <img src="img/icons/download.svg" alt=""><span>Download Excel</span>
        </div> -->
        <form action="/nota/nota-printOut" method='GET'>
            <button id="downloadExcel" type="submit" class="threeDotMenuItem">
                <img src="/img/icons/download.svg" alt=""><span>Print Out Nota</span>
            </button>
            <input type="hidden" name="nota_id" value={{ $nota['id'] }}>
        </form>
        {{-- <form action="/nota/nota-hapus" method='POST'>
            @csrf
            <button id="hapusNota" type="submit" class="threeDotMenuItem" id="konfirmasiHapusNota" style="width: 100%">
                <img src="/img/icons/trash-can.svg" alt=""><span>Hapus Nota</span>
            </button>
            <input type="hidden" name="nota_id" value={{ $nota['id'] }}>
        </form> --}}
        <div id="konfirmasiHapusNota" class="threeDotMenuItem">
            <img src="/img/icons/trash-can.svg" alt=""><span>Hapus Nota</span>
        </div>
        <!-- <div id="deleteSPK" class="threeDotMenuItem" onclick="goToDeleteSPK();">
            <img src="img/icons/trash-can.svg" alt=""><span>Cancel/Hapus SPK</span>
        </div> -->
    </div>
</div>

<div class="grid-2-10_auto p-0_5em">
    <img class="w-2em" src="/img/icons/pencil.svg" alt="">
    <h2 class="">Detail Nota: {{ $nota['no_nota'] }} </h2>
</div>
<div id="divDaftarItemNota" class="p-0_5em"></div>

<style>
    @media print {
        .bg-color-orange-1 {
            background-color: #FFED50;
            -webkit-print-color-adjust: exact;
        }
    }
</style>

<script>
    const nota = {!! json_encode($nota, JSON_HEX_TAG) !!};
    console.log("nota");
    console.log(nota);

    const d_nota_item = JSON.parse(nota['data_nota_item']);
    console.log("d_nota_item");
    console.log(d_nota_item);

    const my_csrf = {!! json_encode($csrf, JSON_HEX_TAG) !!};


    for (var i = 0; i < d_nota_item.length; i++) {
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
                Jumlah Tambahan yang Ingin diinput: <input class="p-0_5em" type="number" value="${d_nota_item[i].jml_item}">
            </div>
            <div class="mt-0_5em"><input id="checkboxShowInputNamaHrg-${i}" type="checkbox" onclick='onMultipleCheckToggleWithORLogic(${inputNamaHrgToToggle});'>Edit Nama Nota & Hrg/pcs</div>
            <div id="divInputNamaHrg-${i}" style="display:none">
                <div class="mt-0_5em">Nama Nota: <input class="p-0_5em w-70" type="text" value="${d_nota_item[i].nama_nota}"></div>
                <div class="mt-0_5em">Hrg/pcs: <input class="p-0_5em" type="number" value="${d_nota_item[i].hrg_per_item}"></div>
            </div>
            <br>
            <div id="divBtnHapusEdit-${i}" class="text-center">
                <input type="hidden" name="nota_id" value="${nota.id}">
                <button class="btn-1 bg-color-soft-red" type="submit" name="hapus">Hapus</button>
                <button id="btnEdit-${i}" class="btn-1 bg-color-orange-1" type="submit" name="edit" style="display:none">Konfirmasi Edit</button>
            </div>
        </div>
        `;

        // console.log(`nomorUrutItem: ${nomorUrutItem}`);
        // console.log(`d_nota_item[${i}].jml_item: ${d_nota_item[i].jml_item}`);
        // console.log(`d_nota_item[${i}].nama_nota: ${d_nota_item[i].nama_nota}`);
        // console.log(`d_nota_item[${i}].hrg_per_item: ${d_nota_item[i].hrg_per_item}`);
        // console.log(`d_nota_item[${i}].hrg_total_item: ${d_nota_item[i].hrg_total_item}`);
        
        var htmlItem =
            `
            <form action="07-02-editDetailNota.php" method="POST" class="bb-1px-solid-grey pb-0_5em pt-0_5em">

            <div>${nomorUrutItem}.</div>
            <div class="grid-4-10_52_18_20">
                <div>${d_nota_item[i].jml_item}</div>
                <div>${d_nota_item[i].nama_nota}</div>
                <div>${formatHarga(d_nota_item[i].hrg_per_item.toString())}</div>
                <div>${formatHarga(d_nota_item[i].hrg_total_item.toString())}</div>

                <div>Jml.</div>
                <div>Nama Item Pada Nota</div>
                <div>Hrg/Pcs</div>
                <div>Harga</div>
            </div>
            <div class="mt-0_5em text-right">Tampilkan Opsi Edit <input id="checkboxShowOpsiEdit-${i}" type="checkbox" onclick='onCheckToggle(${opsiEditToToggle});'></div>

            ${htmlElementDropdown}
           
            </form>
        `;
        // console.log(htmlItem);
        $('#divDaftarItemNota').append(htmlItem);
        // totalHarga += parseInt(d_nota_item[i].hrg_total_item);
    }

   

    var htmlTotalHarga =
        `
        <div class="text-right p-1em">
            <div class="font-weight-bold font-size-2em color-green">${formatHarga(nota.harga_total.toString())}</div>
            <div class="font-weight-bold color-red font-size-1_5em">Total</div>
        </div>
        `;

    $('#divDaftarItemNota').append(htmlTotalHarga);

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

    document.getElementById("konfirmasiHapusNota").addEventListener("click", function() {
        var deleteProperties = {
            title: "Yakin ingin menghapus Nota ini?",
            yes: "Ya",
            no: "Batal",
            table: "notas",
            column: "nota_id",
            columnValue: nota.id,
            action: "/nota/nota-hapus",
            csrf: my_csrf,
            goBackNumber: -2,
            goBackStatement: "Daftar Nota"
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
