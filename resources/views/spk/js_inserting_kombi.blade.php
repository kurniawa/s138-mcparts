<script>
    const kombis = {!! json_encode($kombis, JSON_HEX_TAG) !!};
    console.log(kombis);

    const pilih_kombis = `
        <div>Pilih Kombinasi:</div>
        <input type="text" id="kombi" name="kombi" class="input-normal" style="border-radius:5px;">
        <input type="hidden" id="kombi_id" name="kombi_id">
        <input type="hidden" id="kombi_harga" name="kombi_harga">
    `;

    document.getElementById("tipe").value = "kombinasi";
    document.getElementById("div_pilih_kombi").innerHTML = pilih_kombis;
    document.getElementById("div_option_jml").innerHTML = box_jml;
    document.getElementById("div_input_jml").innerHTML = input_jml;
    document.getElementById("div_option_ktrg").innerHTML = box_ktrg;
    document.getElementById("div_ta_ktrg").innerHTML = ta_ktrg;

    const available_options = ["box_jml", "box_ktrg"];

    $("#kombi").autocomplete({
        source: kombis,
        select: function(event, ui) {
            // console.log(ui.item);
            $("#kombi_id").val(ui.item.id);
            $("#kombi_harga").val(ui.item.harga);
            // show_select_variasi();
            show_options(available_options);
        }
    });


</script>
