@extends('layouts/main_layout')

@section('content')
    
<header class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="/img/icons/back-button-white.svg" alt="" onclick="goBack();">
    <div class="justify-self-right pr-0_5em">
        <a href="pelanggan/pelanggan-baru" class="btn-atas-kanan">
            + Pelanggan Baru
        </a>
    </div>
</header>

<div class="grid-2-auto mt-1em ml-1em mr-1em pb-1em div-cari-filter">
    <div class="justify-self-left grid-2-auto b-1px-solid-grey b-radius-50px mr-1em pl-1em pr-0_4em w-11em">
        <input class="input-2 mt-0_4em mb-0_4em" type="text" placeholder="Cari...">
        <div class="justify-self-right grid-1-auto justify-items-center circle-small bg-color-orange-1">
            <img class="w-0_8em" src="/img/icons/loupe.svg" alt="">
        </div>
    </div>
    <div class="div-filter-icon">

        <div class="icon-small-circle bg-color-orange-1">
            <img class="icon-img w-1em" src="/img/icons/sort-by-attributes.svg" alt="sort-icon">
        </div>
    </div>
</div>

<div id="list_pelanggan">
</div>

<script>
    const show_console = true;
 
    const pelanggans = {!! json_encode($pelanggans, JSON_HEX_TAG) !!};
    const resellers = {!! json_encode($resellers, JSON_HEX_TAG) !!};

    if (show_console === true) {
        console.log('pelanggans');
        console.log(pelanggans);
        console.log('resellers');
        console.log(resellers);
    }

    if (pelanggans == undefined || pelanggans.length == 0) {
        console.log("Tidak ada list pelanggan di database!");
    } else {
        $arrayBgColors = ["#FFB08E", "#DEDEDE", "#D1FFCA", "#FFB800"];
        var i_pelanggan = 0;
        for (const pelanggan of pelanggans) {
            $randomIndex = Math.floor(Math.random() * 4);
            console.log("$randomIndex: " + $randomIndex);
            var initial = "";
            if (pelanggan.initial === null || typeof pelanggan.initial === 'undefined') {
                
            } else {
                initial = pelanggan.initial;
            }

            const arr_alamat = pelanggan.alamat.split('[br]');
            var html_alamat = '';
            for (let i_arrAlamat = 0; i_arrAlamat < arr_alamat.length; i_arrAlamat++) {
                html_alamat += `${arr_alamat[i_arrAlamat]}<br>`;
            }

            var nama_x_reseller = pelanggan.nama;
            if (pelanggan.reseller_id !== null) {
                nama_x_reseller = `${resellers[i_pelanggan].nama}: ${pelanggan.nama}`;
            }

            $htmlPelanggan = "<div class='ml-1em mr-1em pb-1em bb-1px-solid-grey pt-1em font-size-0_9em'>" +
                "<div class='grid-3-10_80_10'>" +
                "<div class='initial circle-medium grid-1-auto justify-items-center font-weight-bold' style='background-color: " + $arrayBgColors[$randomIndex] + "'>" + initial + "</div>" +
                "<div class='justify-self-left font-weight-bold'>" + nama_x_reseller + " - " + pelanggan.daerah + "</div>" +
                "<div id='divDropdown-" + pelanggan.id + "' class='justify-self-right' onclick='showDropDown(" + pelanggan.id + ");'><img class='w-0_7em' src='img/icons/dropdown.svg'></div>" +
                "</div>" +

                // DROPDOWN
                "<div id='divDetailDropDown-" + pelanggan.id + "' class='b-1px-solid-grey p-0_5em mt-1em' style='display:none'>" +

                "<div class='grid-2-10_auto'>" +

                "<div><img class='w-2em' src='/img/icons/address.svg'></div>" +
                "<div>" + html_alamat + "</div>" +
                "<div><img class='w-2em' src='/img/icons/call.svg'></div>" +
                "<div>" + pelanggan.no_kontak + "</div>" +

                "</div>" +

                "<div class='grid-1-auto justify-items-right mt-1em'>" +
                "<a href='pelanggan/pelanggan-detail?cust_id=" + pelanggan.id + "' class='bg-color-orange-1 b-radius-50px pl-1em pr-1em'>Lebih Detail >></a>" +
                "</div>" +
                "</div>" +
                // END OF DROPDOWN

                "</div>";
            $("#list_pelanggan").append($htmlPelanggan);

            i_pelanggan++;
        }
    }

</script>

<style>
    .input-cari {
        border: none;
        width: 10em;
        border-radius: 25px;
        padding: 0.5em 1em 0.5em 1em;
        box-shadow: 0 0 2px gray;
    }

    .input-cari:focus {
        box-shadow: 0 0 6px #23FFAD;
    }

    .field {
        margin: 1em;
    }

    .div-filter-icon {
        justify-self: end;
    }

    .icon-small-circle {
        border-radius: 100%;
        width: 2.5em;
        height: 2.5em;
        position: relative;
    }

    .icon-img {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    /* .hr {
        box-shadow: none;
    } */
    .div-cari-filter {
        border-bottom: 0.5px solid #E4E4E4;
    }
</style>

@endsection