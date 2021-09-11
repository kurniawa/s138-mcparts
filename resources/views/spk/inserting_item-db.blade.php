{{-- 
include_once "01-header.php";
include_once "01-config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $status = "OK";
} else {
    $status = "ERROR";
    die;
}

dd($_POST);

 --}}

 <header class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="/img/icons/back-button-white.svg" alt="" onclick="goBack();">
    <div class="justify-self-right pr-0_5em">
        
    </div>
</header>



<script>
    const tipe_sj = '<?= $tipe_sj; ?>';
    console.log("tipe_sj: " + tipe_sj);

    const pilih_bahan = `
        <div>Pilih Bahan:</div>
        <input type="text" id="bahan" name="bahan" class="input-normal">
        <input type="hidden" id="id_bahan" name="id_bahan">
    `;

    var pilih_variasi = `
        <div class="mt-1em">Pilih Variasi:</div>
        <select id="id_variasi" name="id_variasi" class="p-0_5em">
        `;
    variasi.forEach(varia => {
        pilih_variasi += `
                <option value="${varia.id}">${varia.nama}</option>
            `;
    });
    pilih_variasi += `
        </select>
    `;

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

    // ELEMENT TO ALTERNATE SHOW
    const input_jml =
        `<div id="input_jml">
            <h4>Jumlah:</h4>
            <input type="number" name="jumlah" min="0" step="1" placeholder="Jumlah" class="p-0_5em" style="border-radius:5px;">
        </div>`;

    const select_ukuran =
        `<div id="select_ukuran">
            <h4>Pilih Ukuran:</h4>
            <div class="grid-2-auto_10">
                <select name="ukuran" onchange='namaDanHargaUkuran(this.value)' style="border-radius:5px;padding:0.5em;">
                    <option value="" disabled selected>Pilih Jenis Ukuran</option>
                </select>
                <span id="close_ukuran" class="ui-icon ui-icon-closethick justify-self-center" onclick='alternate_show(this.id, ${props_alternate_ukuran});'></span>
            </div>
        </div>`;

    const select_jht =
        `<div id="select_jht">
            <h4>Tambah Jahit Kepala:</h4>
            <div class="grid-2-auto_10">
                <select name="jahit" style="border-radius:5px;padding:0.5em;">
                    <option value="" disabled selected>Pilih Jenis Jahit</option>
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

    document.getElementById("div_option_jml").innerHTML = box_jml;
    document.getElementById("div_input_jml").innerHTML = input_jml;
    document.getElementById("div_option_ukuran").innerHTML = box_ukuran;
    document.getElementById("div_select_ukuran").innerHTML = select_ukuran;
    document.getElementById("div_option_jht").innerHTML = box_jht;
    document.getElementById("div_select_jht").innerHTML = select_jht;
    document.getElementById("div_option_ktrg").innerHTML = box_ktrg;
    document.getElementById("div_ta_ktrg").innerHTML = ta_ktrg;

    if (tipe_sj === "varia") {
        document.getElementById("div_pilih_bahan").innerHTML = pilih_bahan;

        const available_options = ["box_jml", "box_jht", "box_ukuran", "box_ktrg"];

        $("#bahan").autocomplete({
            source: bahan,
            select: function(event, ui) {
                // console.log(ui.item);
                $("#id_bahan").val(ui.item.id);
                show_select_variasi();
                show_options(available_options);
            }
        });
    }

    function show_select_variasi() {
        // console.log("run innerHTML pilih_variasi");
        // console.log(pilih_variasi);
        document.getElementById("div_pilih_variasi").innerHTML = pilih_variasi;
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

<?php
include_once "01-footer.php";
?>