<script>
    const spjaps = {!! json_encode($spjaps, JSON_HEX_TAG) !!};
    console.log(spjaps);

    const pilih_spjaps = `
        <div>Pilih Sixpack/Japstyle:</div>
        <input type="text" id="spjap" name="spjap" class="input-normal" style="border-radius:5px;">
        <input type="hidden" id="spjap_id" name="spjap_id">
        <input type="hidden" id="spjap_harga" name="spjap_harga">
    `;

    document.getElementById("tipe").value = "spjap";
    document.getElementById("div_pilih_spjap").innerHTML = pilih_spjaps;
    document.getElementById("div_option_jml").innerHTML = box_jml;
    document.getElementById("div_input_jml").innerHTML = input_jml;
    document.getElementById("div_option_ktrg").innerHTML = box_ktrg;
    document.getElementById("div_ta_ktrg").innerHTML = ta_ktrg;

    const available_options = ["box_jml", "box_ktrg"];

    $("#spjap").autocomplete({
        source: spjaps,
        select: function(event, ui) {
            // console.log(ui.item);
            $("#spjap_id").val(ui.item.id);
            $("#spjap_harga").val(ui.item.harga);
            // show_select_variasi();
            show_options(available_options);
        }
    });


</script>
