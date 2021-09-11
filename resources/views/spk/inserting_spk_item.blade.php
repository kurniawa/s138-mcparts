
{{-- 
include_once "01-header.php";
include_once "01-config.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // KENAPA DISINI PAKE GET: Karena nanti supaya ga hilang parameter2 yang dibutuhkan, ketika harus bolak balik pindah halaman.
    $status = "OK";
} else {
    $status = "ERROR";
    die;
}

$pelanggan_id = $_GET["pelanggan_id"];
$tanggal = $_GET["tanggal"];
$ket_judul = $_GET["ket_judul"];
$nama_pelanggan = $_GET["nama_pelanggan"];
$daerah = $_GET["daerah"];

// CEK APAKAH ADA ITEM YANG SUDAH SEMPAT DIINPUT
$spk_item;
if ($status == "OK") {
    $table = "spk_item";
    $spk_item = dbGet($table);
    // var_dump($spk_item);
}

$htmlLogError = $htmlLogError . "</div>";
$htmlLogOK = $htmlLogOK . "</div>";
$htmlLogWarning = $htmlLogWarning . "</div>"; 

 var spk_item = <-?= json_encode($spk_item); ?>;
    console.log("spk_item:");
    console.log(spk_item);

    var status = '<-?= $status; ?>';

--}}

{{-- {{ dd($post) }} --}}

@extends('layouts/main_layout')

@section('content')
    
<header class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="/img/icons/back-button-white.svg" alt="" onclick="goBack();">
    <div class="justify-self-right pr-0_5em">
        <!-- <a href="06-02-produk-baru.php" id="btnNewProduct" class="btn-atas-kanan2">
            + Tambah Produk Baru
        </a> -->
    </div>
</header>

<form action="03-03-01-proceed-spk.php" method="POST" id="containerBeginSPK" class="m-0_5em">

    <div class="b-1px-solid-grey">
        <div class="text-center">
            <h2>Surat Perintah Kerja</h2>
        </div>
        <div class="grid-3-25_10_auto m-0_5em grid-row-gap-1em">
            <div>No.</div>
            <div>:</div>
            <div class="divSPKNumber font-weight-bold">(Auto Generated)</div>
            <div>Tanggal</div>
            <div>:</div>
            <div class="divSPKDate font-weight-bold">{{ $spks['tanggal'] }}</div>
            <div>Untuk</div>
            <div>:</div>
            <div class="divSPKCustomer font-weight-bold">{{ $spks['nama_pelanggan'] }} - {{ $spks['daerah'] }}</div>
            <input id="inputIDCustomer" type="hidden" name="pelanggan_id" value="">
        </div>
        <div class="grid-1-auto justify-items-right m-0_5em">
            <div>
                <img class="w-1em" src="/img/icons/edit-grey.svg" alt="">
            </div>
        </div>
        <input type="hidden" name="tgl_pembuatan" value="">
    </div>

    <div class="divTitleDesc grid-1-auto justify-items-center mt-0_5em"></div>
    <input type="hidden" name="ket_judul">

    <div id="divItemList" class="bt-1px-solid-grey font-weight-bold"></div>
    <input id="inputHargaTotalSPK" type="hidden" name="total_harga">

    <div id="divJmlTotal" class="text-right">
        <div id="divJmlTotal2" class="font-weight-bold font-size-2em color-green"></div>
        <div class="font-weight-bold color-red font-size-1_5em">Total</div>
    </div>

    <div id="divAddItems" class="h-9em position-relative mt-1em">
        <a href="/spk/inserting_varia" class="productType position-absolute top-0 left-50 transform-translate--50_0 circle-L bg-color-orange-1 grid-1-auto justify-items-center">
            <span class="font-size-0_8em text-center font-weight-bold">SJ<br>Varia</span>
        </a>
        <a href="03-03-02-inserting_spk_item.php?tipe=kombi" class="productType position-absolute top-1em left-35 transform-translate--50_0 circle-L bg-color-orange-1 grid-1-auto justify-items-center">
            <span class="font-size-0_8em text-center font-weight-bold">SJ<br>Kombi</span>
        </a>
        <a href="03-03-02-inserting_spk_item.php?tipe=std" class="productType position-absolute top-1em left-65 transform-translate--50_0 circle-L bg-color-orange-1 grid-1-auto justify-items-center">
            <span class="font-size-0_8em text-center font-weight-bold">SJ<br>Std</span>
        </a>
        <a href="03-03-02-inserting_spk_item.php?tipe=tankpad" class="productType position-absolute top-5em left-30 transform-translate--50_0 circle-L bg-color-soft-red grid-1-auto justify-items-center">
            <span class="font-size-0_8em text-center font-weight-bold">Tank<br>Pad</span>
        </a>
        <a href="03-03-02-inserting_spk_item.php?tipe=busastang" class="productType position-absolute top-5em left-70 transform-translate--50_0 circle-L bg-color-grey grid-1-auto justify-items-center">
            <span class="font-size-0_8em text-center font-weight-bold">Busa<br>Stang</span>
        </a>
        <div class="position-absolute top-5em left-50 transform-translate--50_0 grid-1-auto justify-items-center" onclick="toggleProductType();">
            <div class="circle-medium bg-color-orange-2 grid-1-auto justify-items-center">
                <span class="color-white font-weight-bold font-size-1_5em">+</span>
            </div>
        </div>

    </div>

    <!-- EDIT ITEM SPK -->
    <div id="divBtnShowEditOptItemSPK" class="text-center">
        <div class="d-inline-block btn-1 bg-color-purple-blue font-weight-bold color-white" onclick="showEditOptItemSPK();">Edit Item</div>
    </div>
    <div id="divBtnHideEditOptItemSPK" class="text-center">
        <div class="d-inline-block btn-1 font-weight-bold color-white" style="background-color: gray;" onclick="hideEditOptItemSPK();">Finish Editing</div>
    </div>
    <!-- END - EDIT ITEM SPK -->
    <div class="position-absolute bottom-0_5em w-calc-100-1em">
        <button type="submit" id="btnProsesSPK" class="w-100 h-4em bg-color-orange-2 grid-1-auto">
            <span class="justify-self-center font-weight-900">PROSES SPK</span>
        </button>
    </div>

</form>

{{-- <div class="divLogError"></div>
<div class="divLogWarning"></div>
<div class="divLogOK"></div>
<div class="h-4em"></div> --}}

<script>

    // $("#containerBeginSPK").css("display", "none");
    $('#btnProsesSPK').hide();
    $('#divJmlTotal').hide();
    // getSPKItems();

    var spks = {!! json_encode($spks, JSON_HEX_TAG) !!};
    var spk_item = {!! json_encode($spk_item, JSON_HEX_TAG) !!};

    console.log(spks);
    // console.log(spks.daerah);
    console.log(spk_item);

    var htmlItemList = '';
    var totalHarga = 0;
    var jumlahTotalItem = 0;
    var keterangan = "";
    for (var i = 0; i < spk_item.length; i++) {
        if (spk_item[i].ktrg == null) {

        } else {
            keterangan = spk_item[i].ktrg.replace(new RegExp('\r?\n', 'g'), '<br />');
        }
        htmlItemList = htmlItemList +
            `<div class='divItem grid-3-auto_auto_10 pt-0_5em pb-0_5em bb-1px-solid-grey'>
            <div class='divItemName grid-2-15_auto'>
                <div id='btnRemoveItem-${i}' class='btnRemoveItem grid-1-auto justify-items-center circle-medium bg-color-soft-red' onclick='removeSPKItem("${spk_item[i].id}");'><img style='width: 1.3em;' src='img/icons/minus-white.svg'></div>
                    ${spk_item[i].nama_lengkap}
                </div>
            <div class='grid-1-auto'>
            <div class='color-green justify-self-right font-size-1_2em'>
                ${spk_item[i].jumlah}
            </div>
                <div class='color-grey justify-self-right'>Jumlah</div>
            </div>
            <div id='btnEditItem-${i}' class='btnEditItem grid-1-auto justify-items-center circle-medium bg-color-purple-blue' onclick='editSPKItem("${spk_item[i].id}", "${spk_item[i].tipe}");'><img style='width: 1.3em;' src='img/icons/pencil2-white.svg'></div>
            <div class='pl-0_5em color-blue-purple'>${keterangan}</div>
            </div>`;

        // kita jumlah harga semua item untuk satu SPK
        totalHarga = totalHarga + parseFloat(spk_item[i].harga_item);
        jumlahTotalItem = jumlahTotalItem + parseFloat(spk_item[i].jumlah);
    }
    $('#inputHargaTotalSPK').val(totalHarga);
    if (jumlahTotalItem !== 0) {
        $('#divJmlTotal2').html(jumlahTotalItem);
        $('#divJmlTotal').show();
    }
    $('#divItemList').html(htmlItemList);
    $('#btnProsesSPK').show();

    function showEditOptItemSPK(params) {
        $('.divItem').removeClass('grid-2-auto').addClass('grid-3-auto_auto_10');
        $('.divItemName').addClass('grid-2-15_auto');
        $('.btnRemoveItem').show();
        $('.btnEditItem').show();
        $('#divBtnShowEditOptItemSPK').hide();
        $('#divBtnHideEditOptItemSPK').show();
    }

    function hideEditOptItemSPK() {
        $('.divItem').removeClass('grid-3-auto_auto_10').addClass('grid-2-auto');
        $('.divItemName').removeClass('grid-2-15_auto');
        $('.btnRemoveItem').hide();
        $('.btnEditItem').hide();
        $('#divBtnShowEditOptItemSPK').show();
        $('#divBtnHideEditOptItemSPK').hide();
    }

    hideEditOptItemSPK();

    function editSPKItem(id, tipe) {
        console.log(id);
        console.log(tipe);

        if (tipe === 'sj-varia') {
            console.log(tipe);
            location.href = '03-03-02-editVariaFNewSPK.php?id=' + id + '&table=' + 'spk_item';
        } else if (tipe === 'sj-kombi') {
            console.log(tipe);
            location.href = '03-03-03-editKombiFNewSPK.php?id=' + id + '&table=' + 'spk_item';
        } else if (tipe === 'sj-std') {
            console.log(tipe);
            location.href = '03-03-04-editStdFNewSPK.php?id=' + id + '&table=' + 'spk_item';
        } else if (tipe === "tankpad") {
            console.log(tipe);
            location.href = '03-03-05-editTPFNewSPK.php?id=' + id + '&table=' + 'spk_item';
        } else {
            console.log(tipe);
            location.href = '03-03-06-editBusaStangFNewSPK.php?id=' + id + '&table=' + 'spk_item';
        }
    }

    function removeSPKItem(id) {
        location.href = `03-03-07-remove-item-spk.php?id=${id}`;
    }

    $(document).ready(function() {
        $(".productType").css("display", "none");
        $("#containerSJVaria").css("display", "none");
    });

    function toggleProductType() {
        $(".productType").toggle(500);
    }

    function toggleSJVaria() {
        history.pushState({
            page: 'SJVaria'
        }, 'test title');
        $(".productType").hide();
        $("#containerSJVaria").toggle();
        $("#containerBeginSPK").toggle();
    }

    
</script>
@endsection