<script>
    const busastangs = {!! json_encode($busastangs, JSON_HEX_TAG) !!};
    console.log(busastangs);

    document.getElementById("tipe").value = "busastang";
    document.getElementById("div_option_jml").innerHTML = box_jml;
    document.getElementById("div_input_jml").innerHTML = input_jml;
    document.getElementById("div_option_ktrg").innerHTML = box_ktrg;
    document.getElementById("div_ta_ktrg").innerHTML = ta_ktrg;

    const available_options = ["box_jml", "box_ktrg"];

    if (busastangs.length === 1) {
        document.getElementById('busastang').value = busastangs[0].value;
        document.getElementById('busastang').readOnly = true;
        document.getElementById('busastang_id').value = busastangs[0].id;
        document.getElementById('busastang_harga').value = busastangs[0].harga;
    }

</script>
