{{-- 
include_once "01-header.php";
include_once "01-config.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $status = "OK";
} else {
    $status = "ERROR";
    die;
}
$tipe = $_GET["tipe"];
// dd($tipe);

// GET ARRAY BAHAN, VARIASI, UKURAN, JAHIT BESERTA HARGA NYA MASING2
include_once "01-getProduk2.php"; 

<-?= $input_container; ?>
<-?= $available_options; ?>

// MULAI MENCARI APA TIPE NYA DAN BAGAIMANA BEHAVIOR INTERAKSI DENGAN INPUT NYA
const tipe = '<-?= $tipe; ?>';
console.log("tipe: " + tipe);
--}}
@extends('layouts/main_layout')

@section('content')
    
<form action="03-03-02-inserting_item_spk_db.php" method="POST" id="form_properti_item_spk" class="m-1em">

    <div>
        <h2>Tipe: SJ Variasi</h2>
    </div>

    <div id="container_properti_item_spk">
        <div id='div_pilih_bahan'></div>
        <div id='div_pilih_variasi' class='mt-1em'></div>
        <div style='display:none;' class='mt-1em' id='div_select_ukuran'></div>
        <div style='display:none;' class='mt-1em' id='div_select_jht'></div>
        <div style='display:none;' class='mt-1em' id='div_ta_ktrg'></div>
        <div style='display:none;' class='mt-1em' id='div_input_jml'></div>
    </div>

    <br><br>


    <div id="divAvailableOptions" class="position-absolute bottom-5em w-calc-100-1em">
        Available options:
        <div id="container_options">
            <div style="display:inline-block" id="div_option_jml"></div>
            <div style="display:inline-block" id="div_option_ktrg"></div>
            <div style='display:inline-block' id='div_option_ukuran'></div>
            <div style='display:inline-block' id='div_option_jht'></div>
        </div>

    </div>
    <div class="position-absolute bottom-0_5em w-calc-100-1em">
        <button type="submit" id="bottomDiv" class="w-100 h-4em bg-color-orange-2 grid-1-auto">

            <span class="justify-self-center font-weight-bold">TAMBAH ITEM KE SPK</span>

        </button>
    </div>
    <input id="tipe" type="hidden" name="tipe">
</form>

<script>
    const bahans = {!! json_encode($bahans, JSON_HEX_TAG) !!};
    const varias = {!! json_encode($varias, JSON_HEX_TAG) !!};
    const ukurans = {!! json_encode($ukurans, JSON_HEX_TAG) !!};
    const jahits = {!! json_encode($jahits, JSON_HEX_TAG) !!};

    console.log(bahans);
    console.log(varias);
    console.log(ukurans);
    console.log(jahits);

    var props_alternate_jml = {
        btn_hide: "close_jml",
        btn_show: "box_jml",
        id: "div_input_jml",
    };
    props_alternate_jml = JSON.stringify(props_alternate_jml);

    var props_alternate_ukuran = {
        btn_hide: "close_ukuran",
        btn_show: "box_ukuran",
        id: "div_select_ukuran",
    };
    props_alternate_ukuran = JSON.stringify(props_alternate_ukuran);

    var props_alternate_jht = {
        btn_hide: "close_jht",
        btn_show: "box_jht",
        id: "div_select_jht",
    };
    props_alternate_jht = JSON.stringify(props_alternate_jht);

    var props_alternate_ktrg = {
        btn_hide: "close_ktrg",
        btn_show: "box_ktrg",
        id: "div_ta_ktrg",
    };
    props_alternate_ktrg = JSON.stringify(props_alternate_ktrg);

    // BUTTON OPTIONS
    const box_jml = `<div id="box_jml" class="box" onclick='alternate_show(this.id, ${props_alternate_jml});'>Jumlah</div>`;
    const box_ukuran = `<div id="box_ukuran" class="box" onclick='alternate_show(this.id, ${props_alternate_ukuran});'>+ Ukuran</div>`;
    const box_jht = `<div id="box_jht" class="box" onclick='alternate_show(this.id, ${props_alternate_jht});'>+ Jahit</div>`;
    const box_ktrg = `<div id="box_ktrg" class="box" onclick='alternate_show(this.id, ${props_alternate_ktrg});'>+ Ktrgn</div>`;
    // END BUTTON OPTIONS

    // ELEMENT AWAL YAND DIMUNCULKAN
    const pilih_bahan = `
        <div>Pilih Bahan:</div>
        <input type="text" id="bahan" name="bahan" class="input-normal" style="border-radius:5px;">
        <input type="hidden" id="id_bahan" name="id_bahan">
    `;

    var pilih_variasi = `
        <div class="mt-1em">Pilih Variasi:</div>
        <select id="id_variasi" name="id_variasi" class="p-0_5em" style="border-radius:5px;">
        `;

    if (typeof varias !== "undefined") {
        varias.forEach(varia => {
            pilih_variasi += `
                <option value="${varia.id}">${varia.nama}</option>
            `;
        });
    }

    pilih_variasi += `
        </select>
    `;
    // END OF ELEMENT AWAL

    // ELEMENT TO ALTERNATE SHOW
    const input_jml =
        `<div id="input_jml">
            <h4>Jumlah:</h4>
            <input type="number" name="jumlah" min="0" step="1" placeholder="Jumlah" class="p-0_5em" style="border-radius:5px;">
        </div>`;

    var select_ukuran =
        `<div id="select_ukuran">
            <h4>Pilih Ukuran:</h4>
            <div class="grid-2-auto_10">
                <select name="ukuran" onchange='namaDanHargaUkuran(this.value)' style="border-radius:5px;padding:0.5em;">
                    <option value="" disabled selected>Pilih Jenis Ukuran</option>`;

    if (typeof ukurans !== "undefined") {
        ukurans.forEach(uk => {
            select_ukuran += `
                <option value="${uk.id}">${uk.nama}</option>
            `;
        });
    }

    select_ukuran += `
                </select>
                <span id="close_ukuran" class="ui-icon ui-icon-closethick justify-self-center" onclick='alternate_show(this.id, ${props_alternate_ukuran});'></span>
            </div>
        </div>`;

    var select_jht =
        `<div id="select_jht">
            <h4>Tambah Jahit Kepala:</h4>
            <div class="grid-2-auto_10">
                <select name="jahit" style="border-radius:5px;padding:0.5em;">
                    <option value="" disabled selected>Pilih Jenis Jahit</option>`;

    if (typeof jahits !== "undefined") {
        jahits.forEach(jht => {
            select_jht += `
                <option value="${jht.id}">${jht.nama}</option>
            `;
        });
    }
    select_jht += `
                </select>
                <span id="close_jht" class="ui-icon ui-icon-closethick justify-self-center" onclick='alternate_show(this.id, ${props_alternate_jht});'></span>        
            </div>
        </div>`;

    const ta_ktrg =
        `<div id="ta_ktrg">
            <div>Keterangan <span style="color:grey">(opsional)</span>:</div>
            <div class='text-right'><span id="close_ktrg" class='ui-icon ui-icon-closethick' onclick='alternate_show(this.id, ${props_alternate_ktrg});'></span></div>
            <textarea class="pt-1em pl-1em text-area-mode-1" name="ktrg" id="taDesc" placeholder="Keterangan"></textarea>
        </div>`;
    // END ELEMENT TO ALTERNATE SHOW

    // ELEMEN KHUSUS KOMBINASI
    const pilih_kombinasi = `
        <div>Nama Kombinasi:</div>
        <input type="text" id="kombinasi" name="kombinasi" class="input-normal" style="border-radius:5px;">
        <input type="hidden" id="id_kombinasi" name="id_kombinasi">
    `;
    // END: ELEMEN KHUSUS KOMBINASI

    // ELEMEN KHUSUS Standar
    const pilih_std = `
        <div>Nama Standar:</div>
        <input type="text" id="std" name="std" class="input-normal" style="border-radius:5px;">
        <input type="hidden" id="id_std" name="id_std">
    `;
    // END: ELEMEN KHUSUS Standar

    // ELEMEN KHUSUS Tankpad
    const pilih_tankpad = `
        <div>Nama Tankpad:</div>
        <input type="text" id="tankpad" name="tankpad" class="input-normal" style="border-radius:5px;">
        <input type="hidden" id="id_tankpad" name="id_tankpad">
    `;
    // END: ELEMEN KHUSUS Tankpad

    // ELEMEN KHUSUS Busastang
    const pilih_busastang = `
        <div>Nama Busastang:</div>
        <input type="text" id="busastang" name="busastang" class="input-normal" style="border-radius:5px;">
        <input type="hidden" id="id_busastang" name="id_busastang">
    `;
    // END: ELEMEN KHUSUS Busastang

    const tipe = 'varia';

    if (tipe === "varia") {
        document.getElementById("tipe").value = "varia";
        document.getElementById("div_pilih_bahan").innerHTML = pilih_bahan;
        document.getElementById("div_option_jml").innerHTML = box_jml;
        document.getElementById("div_input_jml").innerHTML = input_jml;
        document.getElementById("div_option_ukuran").innerHTML = box_ukuran;
        document.getElementById("div_select_ukuran").innerHTML = select_ukuran;
        document.getElementById("div_option_jht").innerHTML = box_jht;
        document.getElementById("div_select_jht").innerHTML = select_jht;
        document.getElementById("div_option_ktrg").innerHTML = box_ktrg;
        document.getElementById("div_ta_ktrg").innerHTML = ta_ktrg;

        const available_options = ["box_jml", "box_jht", "box_ukuran", "box_ktrg"];

        $("#bahan").autocomplete({
            source: bahans,
            select: function(event, ui) {
                // console.log(ui.item);
                $("#id_bahan").val(ui.item.id);
                // show_select_variasi();
                show_options(available_options);
                document.getElementById("div_pilih_variasi").innerHTML = pilih_variasi;
            }
        });
    } else if (tipe === "kombi") {
        document.getElementById("tipe").value = "kombinasi";
        document.getElementById("div_kombinasi").innerHTML = pilih_kombinasi;
        document.getElementById("div_option_jml").innerHTML = box_jml;
        document.getElementById("div_input_jml").innerHTML = input_jml;
        document.getElementById("div_option_ukuran").innerHTML = box_ukuran;
        document.getElementById("div_select_ukuran").innerHTML = select_ukuran;
        document.getElementById("div_option_jht").innerHTML = box_jht;
        document.getElementById("div_select_jht").innerHTML = select_jht;
        document.getElementById("div_option_ktrg").innerHTML = box_ktrg;
        document.getElementById("div_ta_ktrg").innerHTML = ta_ktrg;

        const available_options = ["box_jml", "box_jht", "box_ukuran", "box_ktrg"];

        $("#kombinasi").autocomplete({
            source: ivar.kombinasi,
            select: function(event, ui) {
                // console.log(ui.item);
                $("#id_kombinasi").val(ui.item.id);
                // show_select_variasi();
                show_options(available_options);
            }
        });
    } else if (tipe === "std") {
        document.getElementById("tipe").value = "std";
        document.getElementById("div_pilih_std").innerHTML = pilih_std;
        document.getElementById("div_option_jml").innerHTML = box_jml;
        document.getElementById("div_input_jml").innerHTML = input_jml;
        document.getElementById("div_option_ukuran").innerHTML = box_ukuran;
        document.getElementById("div_select_ukuran").innerHTML = select_ukuran;
        document.getElementById("div_option_jht").innerHTML = box_jht;
        document.getElementById("div_select_jht").innerHTML = select_jht;
        document.getElementById("div_option_ktrg").innerHTML = box_ktrg;
        document.getElementById("div_ta_ktrg").innerHTML = ta_ktrg;

        const available_options = ["box_jml", "box_jht", "box_ukuran", "box_ktrg"];

        $("#std").autocomplete({
            source: ivar.std,
            select: function(event, ui) {
                // console.log(ui.item);
                $("#id_std").val(ui.item.id);
                // show_select_variasi();
                show_options(available_options);
            }
        });
    } else if (tipe === "tankpad") {
        document.getElementById("tipe").value = "tankpad";
        document.getElementById("div_pilih_tankpad").innerHTML = pilih_tankpad;
        document.getElementById("div_option_jml").innerHTML = box_jml;
        document.getElementById("div_input_jml").innerHTML = input_jml;
        document.getElementById("div_option_ktrg").innerHTML = box_ktrg;
        document.getElementById("div_ta_ktrg").innerHTML = ta_ktrg;

        const available_options = ["box_jml", "box_ktrg"];

        $("#tankpad").autocomplete({
            source: ivar.tankpad,
            select: function(event, ui) {
                // console.log(ui.item);
                $("#id_tankpad").val(ui.item.id);
                // show_select_variasi();
                show_options(available_options);
            }
        });
    } else if (tipe === "busastang") {
        document.getElementById("tipe").value = "busastang";
        document.getElementById("div_pilih_busastang").innerHTML = pilih_busastang;
        document.getElementById("div_option_jml").innerHTML = box_jml;
        document.getElementById("div_input_jml").innerHTML = input_jml;
        document.getElementById("div_option_ktrg").innerHTML = box_ktrg;
        document.getElementById("div_ta_ktrg").innerHTML = ta_ktrg;

        const available_options = ["box_jml", "box_ktrg"];

        $("#busastang").autocomplete({
            source: ivar.busastang,
            select: function(event, ui) {
                // console.log(ui.item);
                $("#id_busastang").val(ui.item.id);
                // show_select_variasi();
                show_options(available_options);
            }
        });
    }

    function show_options(available_options) {
        // console.log(available_options);

        available_options.forEach(option => {
            document.getElementById(option).style.display = "block";
        });
    }

    function alternate_show(clicked, props) {
        // console.log(props);
        if (clicked === props.btn_show) {
            // console.log("show");
            // console.log(props.id);
            document.getElementById(props.id).style.display = "block";
            document.getElementById(props.btn_show).style.display = "none";
        } else if (clicked === props.btn_hide) {
            // console.log('hide');
            document.getElementById(props.id).style.display = "none";
            document.getElementById(props.btn_show).style.display = "block";
        }
    }
</script>


@endsection


