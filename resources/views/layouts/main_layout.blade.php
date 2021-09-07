<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="fonts/Nunito-Fontface/stylesheet.css"> --}}
    {{-- <link rel="stylesheet" href="fonts/Roboto-Fontface/stylesheet.css"> --}}
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/grid.css">
    {{-- <link rel="stylesheet" href="css/fonts.css"> --}}
    <link rel="stylesheet" href="/css/border.css">
    <link rel="stylesheet" href="/js/jquery-ui-1.12.1/jquery-ui.css">
    <script src="/js/jquery-3.5.1.js"></script>
    <script src="/js/jquery-ui-1.12.1/jquery-ui.js"></script>
    <script src="/js/functions.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>MC-Parts Smart System</title>
</head>

<body>
    @yield('content')
</body>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script>
    function showDropDown(id) {
        // console.log("run dropdown!");
        $selectedDiv = $("#divDetailDropDown-" + id);
        $selectedDiv.toggle(400);

        setTimeout(() => {
            if ($selectedDiv.css("display") === "block") {
                $("#divDropdown-" + id + " img").attr("src", "img/icons/dropup.svg");
            } else {
                $("#divDropdown-" + id + " img").attr("src", "img/icons/dropdown.svg");
            }
        }, 450);
    }

    function finishSPK() {
        $('.closingGreyArea').show();
        $('.lightBox').show();
    }

    function showLightBox() {
        $('.closingGreyArea').show();
        $('.lightBox').show();
    }
    var closingGreyArea = document.querySelector(".closingGreyArea");
    if (closingGreyArea !== null) {

        closingGreyArea.addEventListener('click', (event) => {
            $('.closingGreyArea').hide();
            $('.lightBox').hide();
        });
    }

    var cancelDelete = document.getElementById("cancelDelete");
    if (cancelDelete !== null) {
        cancelDelete.setAttribute("onclick", "funcCancelDelete()");
    }

    function funcCancelDelete() {
        $('.closingGreyArea').hide();
        $('.lightBox').hide();
    }

    function showLightBoxGlobal(deletePropertiesStrigified) {
        $('.divThreeDotMenuContent').hide();

        var deleteProperties = JSON.parse(deletePropertiesStrigified);
        var divLightBoxGlobal = document.createElement("div");
        divLightBoxGlobal.id = "divLightBoxGlobal";
        var htmlDivLightBoxGlobal = `
            <div class="grid-2-10_auto">
                <div><img src="img/icons/speech-bubble.svg" alt="" style="width: 2em;"></div>
                <div class="font-weight-bold">${deleteProperties[0].title}</div>
            </div>
            <br><br>
            <div class="grid-2-auto">
                <a href="DELETE-OneItemGlobalFromTable.php?table=${deleteProperties[0].table}&column=${deleteProperties[0].column}&columnValue=${deleteProperties[0].columnValue}&goBackNumber=${deleteProperties[0].goBackNumber}&goBackStatement=${deleteProperties[0].goBackStatement}" class="text-center btn-1 bg-color-soft-red">
                    <span>${deleteProperties[0].yes}</span>
                </a>
                <button class="text-center btn-1 bg-color-orange-1" onclick='lightBoxGlobalNo();'>
                    <span>${deleteProperties[0].no}</span>
                </button>
            </div>
        `;
        divLightBoxGlobal.innerHTML = htmlDivLightBoxGlobal;

        var divClosingGreyAreaGlobal = document.createElement("div");
        divClosingGreyAreaGlobal.id = "divClosingGreyAreaGlobal";
        // var htmlDivClosingGreyAreaGlobal = `
        // <div id="divClosingGreyAreaGlobal"></div>
        // `;
        // divClosingGreyAreaGlobal.innerHTML(htmlDivClosingGreyAreaGlobal);

        document.body.appendChild(divClosingGreyAreaGlobal);
        document.body.appendChild(divLightBoxGlobal);

    }

    function lightBoxGlobalNo() {
        $("#divLightBoxGlobal").remove();
        $("#divClosingGreyAreaGlobal").remove();
    }

    function confirmBox(params) {
        $('.divThreeDotMenuContent').hide();

        var delProps = JSON.parse(params);
        var divConfirmBox = document.createElement("div");
        divConfirmBox.id = "divConfirmBox";
        var htmlConfirmBox = `
            <div class="grid-2-10_auto">
                <div><img src="img/icons/speech-bubble.svg" alt="" style="width: 2em;"></div>
                <div class="font-weight-bold">${delProps[0].title}</div>
            </div>
            <br><br>
            <form action="DEL_FPost.php" method="POST" class="grid-2-auto">
                <input type="hidden" name="table" value="${delProps[0].table}">
                <input type="hidden" name="column" value="${delProps[0].column}">
                <input type="hidden" name="columnValue" value="${delProps[0].columnValue}">
                <input type="hidden" name="goBackNumber" value="${delProps[0].goBackNumber}">
                <input type="hidden" name="goBackStatement" value="${delProps[0].goBackStatement}">
                <button type="submit" class="btn-danger">
                    <span>${delProps[0].yes}</span>
                </button>
                <div class="btn-warning" onclick='confirmCancel();'>
                    <span>${delProps[0].no}</span>
                </div>
            </form>
        `;
        divConfirmBox.innerHTML = htmlConfirmBox;

        var closingArea = document.createElement("div");
        closingArea.id = "closingArea";
        // var htmlDivClosingGreyAreaGlobal = `
        // <div id="divClosingGreyAreaGlobal"></div>
        // `;
        // divClosingGreyAreaGlobal.innerHTML(htmlDivClosingGreyAreaGlobal);

        document.body.appendChild(closingArea);
        document.body.appendChild(divConfirmBox);

    }

    function confirmCancel() {
        $("#divConfirmBox").remove();
        $("#closingArea").remove();
    }

    function dbDelete(table_name, column_name, column_value) {
        var deleteProperties = [{
            title: "Anda yakin ingin menghapus?",
            yes: "Ya",
            no: "Batal",
            table: table_name,
            column: column_name,
            columnValue: column_value,
            goBackNumber: -2,
            goBackStatement: ""
        }];

        var deletePropertiesStringified = JSON.stringify(deleteProperties);
        showLightBoxGlobal(deletePropertiesStringified);
    }
</script>
<style>
    a {
        text-decoration: none;
    }
</style>
</html>