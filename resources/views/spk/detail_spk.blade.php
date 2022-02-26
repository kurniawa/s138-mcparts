@extends('layouts.main_layout')
@section('content')
    
<div class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="/img/icons/back-button-white.svg" alt="" onclick="goBack();">

</div>

<div class="threeDotMenu">
    <div class="threeDot">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
    <div class="divThreeDotMenuContent">
        <div id="editKopSPK" class="threeDotMenuItem">
            <img src="/img/icons/edit.svg" alt=""><span>Edit Kop SPK</span>
        </div>
        <form action="/spk/print_out_spk" method='GET'>
            <button id="downloadExcel" type="submit" class="threeDotMenuItem">
                <img src="/img/icons/download.svg" alt=""><span>Download Excel</span>
            </button>
            <input type="hidden" name="spk_id" value={{ $spk['id'] }}>
        </form>
        <!-- <a href="03-03-01-pembuatanNota.php?id_spk=<a?= $id_spk" id="" class="threeDotMenuItem">
            <img src="/img/icons/pencil.svg" alt=""><span>Buat Nota</span>
        </a> -->
        <div id="konfirmasiHapusSPK" class="threeDotMenuItem">
            <img src="/img/icons/trash-can.svg" alt=""><span>Cancel/Hapus SPK</span>
        </div>
        <a href="/spk/penetapan_item_selesai?spk_id={{ $spk['id'] }}" id="SPKSelesai" class="threeDotMenuItem">
            <img src="/img/icons/edit.svg" alt=""><span>Tetapkan Item Selesai</span>
        </a>
    </div>
</div>

<form action="03-03-01-spk-selesai.php" method="POST" id="containerBeginSPK" class="m-0_5em">

    <div class="b-1px-solid-grey">
        <div class="text-center">
            <h2>Surat Perintah Kerja</h2>
        </div>
        <div class="grid-3-25_10_auto m-0_5em grid-row-gap-1em">
            <div>No.</div>
            <div>:</div>
            <div id="divSPKNumber" style="font-weight: bold;">{{ $spk['no_spk'] }}</div>
            <div>Tanggal</div>
            <div>:</div>
            <div id="divTglPembuatan" style="font-weight: bold;">{{ date('d-m-Y', strtotime($spk['created_at'])) }}</div>
            <div>Untuk</div>
            <div>:</div>
            <div id="divSPKCustomer" style="font-weight: bold;"></div>
            <input id="inputIDCustomer" type="hidden" name="inputIDCustomer">
        </div>
        <div class="grid-1-auto justify-items-right m-0_5em">
            <div>
                <img class="w-1em" src="/img/icons/edit-grey.svg" alt="">
            </div>
        </div>
    </div>

    <div id="divTitleDesc" class="grid-1-auto justify-items-center mt-0_5em"></div>

    <div id="btnProsesSPK" class="position-fixed bottom-0_5em w-calc-100-1em h-4em bg-color-orange-2 grid-1-auto" onclick="proceedSPK();">
        <span class="justify-self-center font-weight-900">PROSES SPK</span>
    </div>

    <div id="btnEditSPKItem" class="position-fixed bottom-0_5em w-calc-100-1em h-4em bg-color-orange-1 grid-1-auto" onclick="updateSPK();">
        <span class="justify-self-center font-weight-900">Konfirmasi Perubahan</span>
    </div>

    <!-- <div id="divBtnSPKSelesai" class="position-fixed bottom-0_5em w-calc-100-1em">
        <div class="h-4em bg-color-orange-2 grid-1-auto" onclick="finishSPK();">
            <span class="justify-self-center font-weight-900">SPK SELESAI</span>
        </div>
    </div> -->

    <!-- <div id="closingGreyArea" class="closingGreyArea" style="display: none;"></div>
    <div class="lightBox" style="display:none;">
        <div class="grid-2-10_auto">
            <div><img src="/img/icons/speech-bubble.svg" alt="" style="width: 2em;"></div>
            <div class="font-weight-bold">Tanggal Selesai / Pengiriman</div>
        </div>
        <br><br>
        <div class="text-center">
            <input id="inputTglSelesaiSPK" type="date" class="input-select-option-1 w-12em" name="tgl_selesai" value="<-?php echo date('Y-m-d')">
        </div>
        <br><br>
        <input type="hidden" name="id_spk" value=<-?= $id_spk>
        <div class="text-center">
            <button type="submit" id="btnSPKSelesai" class="btn-tipis bg-color-orange-1 d-inline-block">Lanjutkan >></button>
        </div>
    </div> -->

</form>

<div id="divItemList" class="bt-1px-solid-grey font-weight-bold"></div>
<input id="inputHargaTotalSPK" type="hidden">

<div id="divKeteranganTambahan" class="mt-1em">
    <div class='text-right'><span class='ui-icon ui-icon-closethick' onclick='removeKeteranganTambahan();'></span></div>
    <textarea class="pt-1em pl-1em text-area-mode-1" name="taDesc" id="taKeteranganTambahan" placeholder="Keterangan"></textarea>
</div>

<div id="divJmlTotal" class="text-right p-1em">
    <div id="divJmlTotal2" style="font-weight:bold;color:green;font-size:2em;">{{ $spk['jumlah_total'] }}</div>
    <div class="font-weight-bold color-red font-size-1_5em">Total</div>
</div>

<div id="divAddItems" class="h-9em position-relative mt-1em">
    <a href="/spk/inserting_varia" class="productType position-absolute top-0 left-50 transform-translate--50_0 circle-L bg-color-orange-1 grid-1-auto justify-items-center">
        <span class="font-size-0_8em text-center">SJ<br>Varia</span>
    </a>
    <a href="/spk/inserting_kombi" class="productType position-absolute top-1em left-35 transform-translate--50_0 circle-L bg-color-orange-1 grid-1-auto justify-items-center">
        <span class="font-size-0_8em text-center">SJ<br>Kombi</span>
    </a>
    <a href="/spk/inserting_std" class="productType position-absolute top-1em left-65 transform-translate--50_0 circle-L bg-color-orange-1 grid-1-auto justify-items-center">
        <span class="font-size-0_8em text-center">SJ<br>Std</span>
    </a>
    <a href="/spk/inserting_tankpad" class="productType position-absolute top-5em left-30 transform-translate--50_0 circle-L bg-color-soft-red grid-1-auto justify-items-center">
        <span class="font-size-0_8em text-center">Tank<br>Pad</span>
    </a>
    <a href="/spk/inserting_busastang" class="productType position-absolute top-5em left-70 transform-translate--50_0 circle-L bg-color-grey grid-1-auto justify-items-center">
        <span class="font-size-0_8em text-center">Busa<br>Stang</span>
    </a>
    <a href="/spk/inserting_spjap" class="productType position-absolute transform-translate--50_0 circle-L bg-color-grey grid-1-auto justify-items-center" style="top:10em;left:30%">
        <span class="font-size-0_8em text-center">T.SP<br>Jap</span>
    </a>
    <a href="/spk/inserting_stiker" class="productType position-absolute transform-translate--50_0 circle-L bg-color-grey grid-1-auto justify-items-center" style="top:10em;left:70%">
        <span class="font-size-0_8em text-center">Stiker</span>
    </a>
    <div class="position-absolute top-5em left-50 transform-translate--50_0 grid-1-auto justify-items-center" onclick="toggleProductType();">
        <div class="circle-medium bg-color-orange-2 grid-1-auto justify-items-center">
            <span class="color-white font-weight-bold font-size-1_5em">+</span>
        </div>
    </div>

</div>

{{-- <div id="boxKeteranganTambahan" class="position-fixed bottom-5em d-inline-block mr-0_5em pt-0_5em pb-0_5em pl-1em pr-1em b-radius-5px bg-color-soft-red" onclick='showKeteranganTambahan();'>
    + Ktrgn Tambahan
</div> --}}

<div id="divMarginBottom" style="height: 20vh;"></div>


<style>
    /* .closingGreyArea {
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
    } */
</style>

<script>
    const show_console = true;
    const spk = {!! json_encode($spk, JSON_HEX_TAG) !!};
    const pelanggan = {!! json_encode($pelanggan, JSON_HEX_TAG) !!};
    const reseller = {!! json_encode($reseller, JSON_HEX_TAG) !!};
    const produks = {!! json_encode($produks, JSON_HEX_TAG) !!};
    const spk_item = {!! json_encode($spk_item, JSON_HEX_TAG) !!};
    const my_csrf = {!! json_encode($my_csrf, JSON_HEX_TAG) !!};
    
    if (show_console === true) {
        console.log(spk);
        console.log(pelanggan);
        console.log("produks:");
        console.log(produks);
        console.log("spk_item:");
        console.log(spk_item);
    }

    // var produk = json_encode($array_produk)
    // console.log(produk);

    // var daftarSPKCPNota = json_encode($daftarSPKCPNota)
    // console.log("daftarSPKCPNota:");
    // console.log(daftarSPKCPNota);
    var statusNota = "";
    var jumlahSisa = 0;
    // var daftarNota = json_encode($daftarNota)
    // console.log("daftarNota");
    // console.log(daftarNota);

    $jmlTotalSPK = 0;
    var htmlSPKItem = '';
    var element_to_toggle = "";

    for (var i = 0; i < spk_item.length; i++) {
        var action = "";
        element_to_toggle = [{
            id: `#divOpsiSPKItem-${i}`,
            time: 300
        }];

        element_to_toggle = JSON.stringify(element_to_toggle);

        // menentukan background color untuk membedakan mana yang udah dibuat nota dan mana yang belum
        var bgColor = "";
        var jumlahSudahInputKeNota = 0;
        // if (daftarSPKCPNota.length <= 0) {
        //     statusNota = "EMPTY";
        // }
        console.log("statusNota:");
        console.log(statusNota);

        // if (statusNota != "EMPTY") {
        //     for (var j = 0; j < daftarSPKCPNota[i].length; j++) {
        //         jumlahSudahInputKeNota += parseInt(daftarSPKCPNota[i][j].jumlah);
        //     }
        //     jumlahSisa = parseInt(produks[i].jumlah) - jumlahSudahInputKeNota
        // }


        console.log("jumlahSisa:")
        console.log(jumlahSisa);
        if (jumlahSisa == 0) {
            fColor = "color-red";
        } else if (jumlahSisa >= 0 && jumlahSisa < spk_item[i].jumlah) {
            fColor = "color-blue-purple";
        }

        // UNTUK PENENTUAN WARNA, METODE diatas kita timpa dengan metode berikut:

        if (spk_item[i].status === 'SELESAI') {
            fColor = "color-blue-purple";
        } else if(spk_item[i].status === 'SEBAGIAN') {
            fColor = 'color-indigo';
        } else {
            fColor = "color-red";
        }

        // END MENENTUKAN warna nama item

        // MENAMPILKAN DEVIASI JUMLAH
        var textContent_deviasi_jml = `${spk_item[i].jumlah} <span style='color:salmon'>`;
        var textContent_jumlah = ``;
        if (typeof spk_item[i].deviasi_jml !== 'undefined' && spk_item[i].deviasi_jml !== null) {
            const deviasi_jml = spk_item[i].deviasi_jml;
            if (deviasi_jml > 0) {
                textContent_deviasi_jml += ` +${deviasi_jml}`;
            } else if (deviasi_jml < 0) {
                textContent_deviasi_jml += ` ${deviasi_jml}`;
            }
        }
        textContent_deviasi_jml += '</span>';
        
        textContent_jumlah += `
            <div style:"color:black;text-align:right;font-weight:normal">${textContent_deviasi_jml}</div>
        `;
        
        var ktrg = spk_item[i].ktrg;
        if (ktrg == null) {
            ktrg = "";
        } else {
            ktrg = ktrg.replace(new RegExp('\n?\r', 'g'), '<br />');
        }


/*
Untuk Metode Edit, dia akan pindah ke link lain dengan parameter yang di pass melalui URL.
Untuk Metode Hapus, sebaiknya tetap menggunakan form dengan method POST.
*/

        htmlSPKItem = htmlSPKItem +
            `<div>
            <div class='divItem p-0_5em grid-3-75_15_10 pt-0_5em pb-0_5em bb-1px-solid-grey'>
                <div class='divItemName ${fColor}'>
                    <span style="">${produks[i].nama}</span>
                </div>
                <div class='grid-1-auto'>
                    <div class='justify-self-right' style='color:green;font-size:1.2em'>
                        ${textContent_jumlah}
                    </div>
                    <div class='justify-self-right' style='color:grey'>Jumlah</div>
                </div>
                <div class='justify-self-center' onclick='elementToToggle(${element_to_toggle});'><img class='w-0_7em' src='/img/icons/dropdown.svg'></div>
            </div>

            <!-- DROPDOWN -->
            <div id='divOpsiSPKItem-${i}' class='p-0_5em b-1px-solid-grey text-center' style='display: none'>
                <button id='editSPKItem-${i}' class="d-inline-block bg-color-purple-blue pl-1em pr-1em b-radius-50px" style='border: none;'>
                    <a href='/spk/edit_spk_item?spk_id=${spk.id}&spk_item_id=${spk_item[i].id}&produk_id=${produks[i].id}'>Edit</a>
                </button>
                <form action='/spk/delete_spk_item' method='POST' class='d-inline-block'>
                @csrf
                <button id='hapusSPKItem-${i}' class="bg-color-grey pl-1em pr-1em b-radius-50px" style='border: none;'>
                    Hapus
                </button>
                <input type="hidden" name="spk_item_id" value="${spk_item[i].id}">
                </form>
                <!--
                <button id='notaSPKItem-${i}' class="d-inline-block bg-color-orange-1 pl-1em pr-1em b-radius-50px" style='border: none;' onclick='goToNotaSPKItem("${i}")'>
                    Buat Nota
                </button>
                -->
            </div>
            <div class='pl-0_5em color-blue-purple'>${ktrg}</div>
            <input type="hidden" name="spk_id" value="${spk.id}">
            <input type="hidden" name="produk_id" value="${produks[i].id}">
            </div>
            `;

        $jmlTotalSPK += parseFloat(spk_item[i].jumlah) + parseFloat(spk_item[i].deviasi_jml);
        console.log(spk_item[i].jumlah, spk_item[i].deviasi_jml, $jmlTotalSPK);
    }

    $('#divTitleDesc').html(spk.ktrg);
    $('#divItemList').html(htmlSPKItem);
    console.log($jmlTotalSPK);

    $('#divTglPembuatan').html(spk.tgl_pembuatan);
    if (reseller !== null) {
        $('#divSPKCustomer').html(`${reseller.nama}: ${pelanggan.nama} - ${pelanggan.daerah}`);
    } else {
        $('#divSPKCustomer').html(`${pelanggan.nama} - ${pelanggan.daerah}`);
    }
    $('#divTitleDesc').html(spk.ket_judul);
    $('#taKeteranganTambahan').html(spk.ktrg);

    // keadaan awal apa aja yang di hide
    $('.divThreeDotMenuContent').hide();
    // $('.threeDotMenu').css('display', 'none'); // -> untuk new SPK
    $('.productType').hide();
    $('#boxKeteranganTambahan').hide();
    $('#divKeteranganTambahan').hide();
    $('#btnProsesSPK').hide();
    // $('#divBtnSPKSelesai').hide();
    $('#btnEditSPKItem').hide();

    function goToPrintOutSPK() {
        location.href = `03-06-print-out-spk.php?id_spk=${spk.id}`;
    }

    function goToDeleteSPK() {
        location.href = `03-03-01-deleteSPK.php?id_spk=${spk.id}`;
    }

    function goToEditSPKItem(index) {
        if (produk[index].tipe == "sj-varia") {
            location.href = `03-03-02-editVariaFDetailSPK.php?id_spk=${spk.id}&id_produks=${produks[index].id}&id_produk=${produk[index].id}`;
        } else if (produk[index].tipe == "sj-kombi") {
            location.href = `03-03-03-editKombiFDetailSPK.php?id_spk=${spk.id}&id_produks=${produks[index].id}&id_produk=${produk[index].id}`;
        } else if (produk[index].tipe == "sj-std") {
            location.href = `03-03-04-editStdFDetailSPK.php?id_spk=${spk.id}&id_produks=${produks[index].id}&id_produk=${produk[index].id}`;
        } else if (produk[index].tipe == "tankpad") {
            location.href = `03-03-05-editTPFDetailSPK.php?id_spk=${spk.id}&id_produks=${produks[index].id}&id_produk=${produk[index].id}`;
        } else if (produk[index].tipe == "busa-stang") {
            location.href = `03-03-06-editBusaStangFDetailSPK.php?id_spk=${spk.id}&id_produks=${produks[index].id}&id_produk=${produk[index].id}`;
        }
    }

    function goToNotaSPKItem(index) {
        window.location.href = `03-03-01-pembuatanNota.php?idSPKCP=${produks[index].id}`;
    }

    document.getElementById('editKopSPK').addEventListener('click', function() {
        console.log('clicked');
        window.location.href = `03-05-edit-kop-spk.php?id_spk=${spk.id}`;
    });

    // function finishSPK() {
    //     $('.closingGreyArea').show();
    //     $('.lightBox').show();
    // }

    // document.querySelector('.closingGreyArea').addEventListener('click', (event) => {
    //     $('.closingGreyArea').hide();
    //     $('.lightBox').hide();
    // });


    function toggleProductType() {
        $(".productType").toggle(500);
    }



    function showEditOptItemSPK() {
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

    // hideEditOptItemSPK();

    function removeSPKItem(id_produks) {
        window.location.href = `03-03-01-removeItemFromDetailSPK.php?id_produks=${id_produks}`;
    }

    function showKeteranganTambahan() {
        $('#boxKeteranganTambahan').hide();
        $('#divKeteranganTambahan').show();
    }

    function removeKeteranganTambahan() {
        $('#boxKeteranganTambahan').show();
        $('#divKeteranganTambahan').hide();
    }

    // Bubble Warning
    // var deleteProperties = [{
    //     title: "Yakin ingin menghapus SPK ini?",
    //     yes: "Ya",
    //     no: "Batal",
    //     table: "spk",
    //     column: "id",
    //     columnValue: spk.id,
    //     goBackNumber: -2,
    //     goBackStatement: "Daftar SPK"
    // }];
    
    // document.getElementById('deleteSPK').addEventListener('click', function () {
    //     bubbleWarning(deleteProperties);
    // });

    document.getElementById("konfirmasiHapusSPK").addEventListener("click", function() {
        var deleteProperties = {
            title: "Yakin ingin menghapus SPK ini?",
            yes: "Ya",
            no: "Batal",
            table: "spks",
            column: "id",
            columnValue: spk.id,
            action: "/spk/hapus-SPK",
            csrf: my_csrf,
            goBackNumber: -2,
            goBackStatement: "Daftar SPK"
        };

        var deletePropertiesStringified = JSON.stringify(deleteProperties);
        showLightBoxGlobal(deletePropertiesStringified);
    });

    /*
    Reload Page di lakukan dengan 2 tahap untuk jaga2 apabila tidak ter reload
    */
    // Reload Page Berdasarkan session
    // const reload_page2 = {-!! json_encode($reload_page, JSON_HEX_TAG) !!};
    // console.log('reload_page2');
    // console.log(reload_page2);
    
    // reloadPage(reload_page);
    
    
</script>

<style>
    #downloadExcel{
        /* display: block; */
    }
</style>
@endsection

