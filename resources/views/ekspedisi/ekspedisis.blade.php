@extends('layouts/main_layout')

@section('content')
    
<header class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="/img/icons/back-button-white.svg" alt="" onclick="goBack();">
    <div class="justify-self-right pr-0_5em">
        <a href="ekspedisi/ekspedisi-baru" class="btn-atas-kanan">
            + Ekspedisi Baru
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

<table id="list_ekspedisi" style="width:100%">
</table>

<script>     
    const ekspedisis = {!! json_encode($ekspedisis, JSON_HEX_TAG) !!};

    if (show_console === true) {
        console.log('ekspedisis');
        console.log(ekspedisis);
    }
    
    for (const ekspedisi of ekspedisis) {
        const arr_alamat_eks = ekspedisi.alamat.split('[br]');
        var html_alamat_eks = '';
        arr_alamat_eks.forEach(alamat_eks => {
            html_alamat_eks += alamat_eks + '<br>';
        });

            // "<div class='grid-4-8-auto-auto-5'>" +
        $htmlEkspedisi = 
            "<tr>" +
                "<td class='font-weight-bold'>" + ekspedisi.nama + "</td>" +
                "<td class='font-weight-bold color-blue-purple'>" + ekspedisi.no_kontak + "</td>" +
                "<td id='divDropdown-" + ekspedisi.id + "' onclick='showDropDown(" + ekspedisi.id + ");'><img src='/img/icons/dropdown.svg' style='width:0.7em'></td>" +
            "</tr>" +
            "<tr id='divDetailDropDown-" + ekspedisi.id + "' class='b-1px-solid-grey p-0_5em mt-1em' style='display:none'>" +
            `<td colspan=3 style="padding:1rem;">
                <table style="width:100%">
                    <tr>
                        <td style="width:50%;">
                            <div><img class='w-2em' src='/img/icons/address.svg'></div>
                            <br>
                            <div>${html_alamat_eks}</div>
                        </td>
                        <td valign="bottom" align="right">
                            <form action='ekspedisi/detail' method='GET'>
                                <input type="hidden" name="ekspedisi_id" value="${ekspedisi.id}">
                                <button class="btn btn-warning">Lebih Detail</button>
                            </form>
                        </td>
                    </tr>
                </table>
            </td>

            </tr>
            <tr class='alamat text-right' style='display:none'>${html_alamat_eks}</tr>
            `;



        $("#list_ekspedisi").append($htmlEkspedisi);
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