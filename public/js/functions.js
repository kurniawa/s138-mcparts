// Jangan lupa pakai JSON stringify dan tanda petik satu
// elements merupakan array dalam array dengan key ID dan time
function elementToToggle(elements) {
    console.log(elements);
    for (const element of elements) {
        if ($(element.id).css("display") == "none") {
            $(element.id).show(element.time);
        } else {
            $(element.id).toggle(element.time);
        }
    }
}

function getLastID(table) {
    var results;
    $.ajax({
        type: "POST",
        url: "01-crud.php",
        cache: false,
        async: false,
        data: {
            table: table,
            type: "last",
        },
        success: function (responseText) {
            console.log(responseText);
            results = responseText;
        },
    });
    return results;
}

function liveSearch(key, table, column) {
    let results;
    $.ajax({
        type: "POST",
        url: "01-crud.php",
        cache: false,
        async: false,
        data: {
            key: key,
            table: table,
            column: column,
            type: "live-search",
        },
        success: function (responseText) {
            console.log(responseText);
            results = responseText;
        },
    });
    return results;
}

function formatDate(date) {
    var d = new Date(date),
        month = "" + (d.getMonth() + 1),
        day = "" + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = "0" + month;
    if (day.length < 2) day = "0" + day;

    return [day, month, year].join("-");
}

function formatHarga(harga) {
    // console.log(harga);
    let hargaRP = "";
    let akhir = harga.length;
    let posisi = akhir - 3;
    let jmlTitik = Math.ceil(harga.length / 3 - 1);
    // console.log(jmlTitik);
    for (let i = 0; i < jmlTitik; i++) {
        hargaRP = "." + harga.slice(posisi, akhir) + hargaRP;
        // console.log(hargaRP);
        akhir = posisi;
        posisi = akhir - 3;
    }
    hargaRP = harga.slice(0, akhir) + hargaRP;
    return hargaRP;
}

function formatNewLine(line) {
    arr_line = line.split("[br]");
    var string_formated = "";
    arr_line.forEach((new_line) => {
        string_formated += new_line + "<br>";
    });
    return string_formated;
}

function onCheckToggle(elements) {
    // console.log(elements);
    for (const element of elements) {
        console.log("(element.idCheckbox).is(':checked')");
        console.log($(element.idCheckbox).is(":checked"));
        if ($(element.idCheckbox).is(":checked") == true) {
            $(element.elementToToggle).show(element.time);
        } else {
            $(element.elementToToggle).hide(element.time);
        }
    }
}

function onMultipleCheckToggleWithORLogic(elements) {
    // console.log(elements);
    for (const element of elements) {
        // console.log("(element.idCheckbox).is(':checked')");
        // console.log($(element.idCheckbox).is(':checked'));
        var sumCheckboxIsChecked = 0;
        var lengthIdCheckbox = element.idCheckboxORLogic.length;
        for (let i = 0; i < lengthIdCheckbox; i++) {
            if (i == 0) {
                if ($(element.idCheckboxORLogic[0]).is(":checked") == true) {
                    $(element.elementToToggle).show(element.time);
                } else {
                    $(element.elementToToggle).toggle(element.time);
                }
            }
            if ($(element.idCheckboxORLogic[i]).is(":checked") == true) {
                sumCheckboxIsChecked++;
            }
        }

        // console.log("sumCheckboxIsChecked");
        // console.log(sumCheckboxIsChecked);
        if (sumCheckboxIsChecked > 0) {
            // console.log("running toggle elementORLogic");
            // console.log(element);
            $(element.elementORLogicToToggle).show(element.time);
        } else {
            $(element.elementORLogicToToggle).hide(element.time);
        }
    }
}
// function insertToDB (table, column, value, data_length) {
//     let sqlPart1 = "INSERT INTO $table(";
//     let sqlPart2 = " VALUE(";

//     for (let i = 0; i < $data_length; i++) {
//         if (i === ($data_length - 1)) {
//             sqlPart1 = `${sqlPart1}${column[i]})`;
//             sqlPart2 = `${sqlPart2}'${value[i]}')`;
//         } else {
//             sqlPart1 = `${sqlPart1}${column[i]}, `;
//             sqlPart2 = `${sqlPart2}'${value[$i]}', `;
//         }
//     }
//     let sql = sqlPart1 + sqlPart2;
//     console.log(sql)

// $msg = "Query: ".$sql. " SUCCESSFULLY EXECUTED.";
// $res = mysqli_query($con, $sql);

// if (!$res) {
//     echo json_encode(array("error", "Error: ".$sql. "<br>".mysqli_error($con)));
//     die;
// } else {
//     echo json_encode(array("insert", $msg));
// }
// }

function goBack() {
    window.history.back();
}

function windowHistoryGo(params) {
    window.history.go(parseInt(params));
}

function goTo(link) {
    window.location.href = `${link}`;
}

// FUNCTION CREATE LIST

function createList(params) {
    var grid_num = params.keys.length + 1;
    // var list_html = `
    //     <div class='grid-${grid_num}-auto'>
    // `;
    var list_html = `
        <div class='bb-1px-solid-grey'>
    `;

    console.log(params.keys);

    var k = 0; // INDEX LIST atau obj nya
    params.json_obj.forEach((obj) => {
        list_html += `
            <div>
            <table style='width:100%'><tr>
        `;

        var i = 0;
        // Menentukan banyaknya kolom atau td dalam satu row
        params.keys.forEach((key) => {
            list_html += `
                <td>${obj[key]}</td>
            `;

            if (i == params.keys.length - 1) {
                list_html += `
                    <td onclick="showDD('#dd-${k}','#dd_icon-${k}');" id="dd_icon-${k}"><img src='/img/icons/dropdown.svg' style="width:0.7em"></td>
                    </tr></table>
                `;
            }
            i++;
        });

        // DROPDOWN
        var dd_html = `<div id="dd-${k}" class="b-1px-solid-grey p-1em" style="display:none">`;
        if (typeof params.dd_keys !== "undefined") {
            params.dd_keys.forEach((dd_key) => {
                var icon = "";
                if (dd_key == "alamat") {
                    icon += `
                        <div style="display:inline-block"><img src='/img/icons/address.svg' style="width:2em"></div>
                    `;
                } else if (dd_key == "kontak") {
                    icon += `
                        <div style="display:inline-block"><img src='/img/icons/phonebook.svg' style="width:2em"></div>
                    `;
                }
                dd_html += `
                    <div>${icon}<div style="display:inline-block">${obj[dd_key]}</div></div>
                `;
            });
        }

        // DROPDOWN -> BUTTON HAPUS DAN DETAIL
        var btn = '<div class="text-right">';
        if (params.detail !== "" && typeof params.detail !== "undefined") {
            btn += `
                <a href='${params.detail.link}${
                obj[params.detail.key]
            }' class='btn-warning' style="display:inline-block">Detail</a>
            `;
        }

        if (params.delete !== "" && typeof params.delete !== "undefined") {
            console.log(params.delete);
            var col = new Array();
            var colVal = new Array();

            params.delete.input.forEach((inp) => {
                console.log("inp");
                console.log(inp);
                col.push(inp.name);

                if (typeof inp.key !== "undefined") {
                    colVal.push(obj[inp.key]);
                } else {
                    colVal.push(inp.value);
                }
            });

            var delProps = {
                table: params.delete.table,
                goBackNum: params.delete.goBackNum,
                col: col,
                colVal: colVal,
            };

            delProps = JSON.stringify(delProps);

            // btn += `<form action="${params.delete.action}" method="post" style="display:inline-block">`;
            // params.delete.input.forEach(inp => {
            //     if (typeof inp.key !== "undefined") {
            //         btn += `
            //         <input type="hidden" name="${inp.name}" value="${obj[inp.key]}">
            //         `;
            //     } else {
            //         btn += `
            //             <input type="hidden" name="${inp.name}" value="${inp.value}">
            //         `;
            //     }
            // });
            btn += `
                <button class='btn-danger' onclick='showDelConfirm(${delProps});'>Hapus</button>
                `;
            // </form>
        }
        btn += `</div>`;

        dd_html += `${btn}</div>`;
        // END OF DROPDOWN

        list_html += `
            ${dd_html}</div>
        `;

        k++;
    });

    list_html += `</div>`;

    return list_html;
}

function showDelConfirm(delProps) {
    // delProps = JSON.parse(delProps);
    console.log("running showDelConfirm");
    var divConfirmBox = document.createElement("div");
    divConfirmBox.id = "divConfirmBox";
    var htmlConfirmBox = `
            <div class="grid-2-10_auto">
                <div><img src="/img/icons/speech-bubble.svg" alt="" style="width: 2em;"></div>
                <div class="font-weight-bold">Yakin ingin menghapus?</div>
            </div>
            <br><br>
            <div>
            <form action="DELETE-OneItem.php" method="post" class="grid-2-auto">
            `;
    for (let i = 0; i < delProps.col.length; i++) {
        htmlConfirmBox += `
        <input type="hidden" name="column[]" value="${delProps.col[i]}">
        <input type="hidden" name="columnValue[]" value="${delProps.colVal[i]}">
        `;
    }
    htmlConfirmBox += `
            <input type="hidden" name="goBackNum" value="${delProps.goBackNum}">
            <input type="hidden" name="table" value="${delProps.table}">
            <button type="submit" class="btn-danger">Ya</button>
            <div class="btn-secondary" onclick='removeElem(["divConfirmBox", "closingArea"]);'>
                <span>Batal</span>
            </div>
            </form>
        </div>
        `;
    divConfirmBox.innerHTML = htmlConfirmBox;

    var closingArea = document.createElement("div");
    closingArea.id = "closingArea";

    document.body.appendChild(closingArea);
    document.body.appendChild(divConfirmBox);
}

function removeElem(elements) {
    for (let i = 0; i < elements.length; i++) {
        document.querySelector(`#${elements[i]}`).remove();
    }
}

// #################################

function showDD(divID, iconID) {
    console.log(iconID);
    $(divID).toggle(400);

    setTimeout(() => {
        if ($(divID).css("display") === "block") {
            $(iconID + " img").attr("src", "/img/icons/dropup.svg");
        } else {
            $(iconID + " img").attr("src", "/img/icons/dropdown.svg");
        }
    }, 450);
}

// FUNCTION CHECKBOX CONFIRM LIST

function createCheckboxConfirmList(params, my_csrf) {
    console.log("params");
    console.log(params);

    var list_html = `
        <form action="${params.form.action}" method="${params.form.method}" class="m-1em">
        <input type="hidden" name="_token" value="${my_csrf}">
        <table style='width:100%'>
    `;

    if (typeof params.form.input !== "undefined") {
        console.log("run: if typeof params.form.input");

        var html_form_input = "";
        params.form.input.forEach((inp) => {
            var inpClass = "";
            if (typeof inp.class !== "undefined") {
                console.log("run: if typeof inp.class !== undefined");
                inpClass = inp.class;
            }
            html_form_input += `<input type="${inp.type}" name="${inp.name}" value="${inp.value}" class="${inpClass}">`;
        });
        list_html += html_form_input;
    }

    var k = 0; // INDEX LIST atau obj nya
    // console.log('list_html');
    // console.log(list_html);

    var isCheckedParamsAll = new Array();
    params.object.forEach((obj) => {
        list_html += `
            <tr class='bb-1px-solid-grey'>
        `;

        var i = 0;
        // Menentukan banyaknya kolom atau td dalam satu row
        params.first_line_keys.forEach((key) => {
            // MENENTUKAN WARNA TULISAN
            var color = "";

            if (typeof key.color !== "undefined") {
                if (typeof key.color.requirement !== "undefined") {
                    var j = 0;
                    key.color.requirement.value.forEach((val) => {
                        // console.log("run foreach requirement value");
                        // console.log(obj[key.color.requirement.key], val);
                        // console.log(key.color.requirement.key);
                        // console.log(obj['status']);
                        if (obj[key.color.requirement.key] === val) {
                            color = key.color.requirement.color[j];
                        }
                        j++;
                    });
                } else {
                    color = key.color;
                }
            }

            // MENAMBAHKAN CLASS
            var attClass = "";
            if (typeof key.class !== "undefined") {
                attClass = key.class;
            }

            list_html += `
                <td style="color:${color};font-weight:bold;font-size:1em;padding-bottom:1em;padding-top:1em;" class="${attClass}">${
                obj[key.name]
            }</td>
            `;

            var isCheckedParams = {
                id_dd: `#dd_checkbox_show-${k}`,
                class_checkbox: ".dd_checkbox",
                id_checkbox: `#dd_checkbox-${k}`,
                id_button: `#${params.button.id}`,
            };

            isCheckedParamsAll.push(isCheckedParams);

            isCheckedParams = JSON.stringify(isCheckedParams);

            if (i == params.first_line_keys.length - 1) {
                list_html += `
                    <td><input id="dd_checkbox-${k}" class="dd_checkbox" type="checkbox" name="${
                    params.checkbox.name
                }[]" value="${
                    obj[params.checkbox.value]
                }" onclick='isChecked(${isCheckedParams});'></td>
                    </tr>
                `;
            }
            i++;
        });

        /**CHECKPOINT list_html */
        // console.log('list_html');
        // console.log(list_html);

        // DROPDOWN
        var html_dd_title = "";
        if (typeof params.dd_input_title !== "undefined") {
            html_dd_title += `<td colspan='3'><div>${params.dd_input_title.title}`;
            if (typeof obj[params.dd_input_title.key] !== "undefined") {
                html_dd_title += `${obj[params.dd_input_title.key]}</div>`;
            } else {
                html_dd_title += `0</div>`;
            }
        }
        var dd_html = `<tr id="dd_checkbox_show-${k}" style="display:none">
        ${html_dd_title}
        <table class="b-1px-solid-grey">`;
        if (typeof params.dd_input !== "undefined") {
            params.dd_input.forEach((input) => {
                // MENENTUKAN VALUE DARI INPUT
                // console.log('input');
                // console.log(input);
                var value = "";
                if (typeof input.value.key !== "undefined") {
                    // if (input.type === 'number') {
                    // console.log('untuk deviasi dan jml_selesai');
                    // console.log(obj[input.value.key]);
                    if (typeof obj[input.value.key] !== "undefined") {
                        value = obj[input.value.key];
                    } else {
                        value = 0;
                    }
                    // }
                } else {
                    value = input.value;
                    // console.log("obj.jumlah");
                    // console.log(obj.jumlah);
                }
                // MENENTUKAN INPUT HIDDEN
                if (input.type == "hidden") {
                    dd_html += `<tr><td></td>`;
                } else {
                    dd_html += `<tr><td>${input.label}:</td>`;
                }

                var inpClass = "";
                if (typeof input.class !== "undefined") {
                    inpClass = input.class;
                }

                dd_html += `
                    <td><input type="${input.type}" name="${input.name}[]" value="${value}" class="${inpClass}"></td></tr>
                `;
            });
        }

        dd_html += `</table></td></tr>`;
        // END OF DROPDOWN

        list_html += `
            ${dd_html}
        `;

        k++;
    });

    list_html += `</table>`;
    // HTML BUTTON
    html_button = `<button id="${params.button.id}" type="submit" class="btn-warning-full" style="display:none">${params.button.label}</button>`;

    // END HTML
    list_html += `${html_button}`;

    list_html += `</form>`;

    if (typeof params.container !== "undefined") {
        // console.log("run embed innerHTML");
        // console.log(list_html);
        document.getElementById(`${params.container.id}`).innerHTML = list_html;
        isCheckedParamsAll.forEach((isCheckedParams) => {
            isChecked(isCheckedParams);
        });
    } else {
        return list_html;
    }
}

// Kalau checkbox nya di check maka akan muncul tombol selesai
/**
 * Nanti input2 yang di hide juga otomatis di disable jadi ga kebaca pada saat di post
 * input nya nanti dalam bentuk array misal name="deviasi_jml[]".
 * Nanti kalo ke disable otomatis array length nya jg mengikuti jadi berkurang.
 * Nanti di file db nya tinggal diproses secara loop
 * 
 * var isCheckedParams = {
        id_dd: `#dd_checkbox_show-${k}`,
        class_checkbox: ".dd_checkbox",
        id_checkbox: `#dd_checkbox-${k}`,
        id_button: `#${params.button.id}`
    };

    isCheckedParamsAll.push(isCheckedParams);

    isCheckedParams = JSON.stringify(isCheckedParams);
 * 
 */

function isChecked(params) {
    // console.log(params);
    const checkbox_all = document.querySelectorAll(
        `${params.class_checkbox}:checked`
    );
    const btnToShow = document.querySelector(params.id_button);
    const checkbox = document.querySelector(params.id_checkbox);
    // const dd = document.querySelector(params.id_dd);

    // SHOW DD
    // console.log(checkbox.checked);
    if (checkbox.checked == true) {
        $(params.id_dd).show(300);
        // document.querySelector(params.id_dd).getElementsByTagName('input').disabled = false;
        $(`${params.id_dd} :input`).prop("disabled", false);
        // console.log($(`${params.id_dd} :input`).prop("disabled"));
        // dd.style.display = "block";
    } else {
        $(params.id_dd).hide(300);
        $(`${params.id_dd} :input`).prop("disabled", true);
        // console.log($(`${params.id_dd} :input`).prop("disabled"));

        // document.querySelector(params.id_dd).getElementsByTagName('input').disabled = true;
        // setTimeout(() => {
        // dd.style.display = "none";
        // }, 300);
    }

    // SHOW BUTTON
    // console.log('btnToShow');
    // console.log(btnToShow);
    if (btnToShow !== null) {
        if (checkbox_all.length !== 0) {
            // console.log("checked");
            btnToShow.style.display = "block";
        } else {
            btnToShow.style.display = "none";
        }
    }

    if (typeof params.to_uncheck !== "undefined") {
        console.log("run uncheck!");

        var to_uncheck = JSON.parse(params.to_uncheck);

        console.log(to_uncheck);
        document.querySelector(to_uncheck.id_checkbox).checked = false;
        isChecked(to_uncheck);
    }
}
// END: Memunculkan tombol selesai

/**DATE TODAY */

function getDateToday() {
    var now = new Date();
    var month = now.getMonth() + 1;
    var day = now.getDate();
    if (month < 10) month = "0" + month;
    if (day < 10) day = "0" + day;
    var today = now.getFullYear() + "-" + month + "-" + day;

    return today;
}

function showLightBoxGlobal(deletePropertiesStrigified) {
    $(".divThreeDotMenuContent").hide();

    var deleteProperties = JSON.parse(deletePropertiesStrigified);
    var divLightBoxGlobal = document.createElement("div");
    divLightBoxGlobal.id = "divLightBoxGlobal";
    var htmlDivLightBoxGlobal = `
        <div class="grid-2-10_auto">
            <div><img src="/img/icons/speech-bubble.svg" alt="" style="width: 2em;"></div>
            <div class="font-weight-bold">${deleteProperties.title}</div>
        </div>
        <br><br>
        <div class="grid-2-auto">
            <form action="${deleteProperties.action}" method='POST'>
                <input type="hidden" name="_token" value="${deleteProperties.csrf}">
                <button type="submit" class="btn-1 bg-color-soft-red" style="width:100%">
                    <img src="/img/icons/trash-can.svg" style="width:1em" alt=""><span>${deleteProperties.yes}</span>
                </button>
                <input type="hidden" name="${deleteProperties.column}" value=${deleteProperties.columnValue}>
            </form>
            
            <button class="text-center btn-1 bg-color-orange-1" onclick='lightBoxGlobalNo();'>
                <span>${deleteProperties.no}</span>
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

    // <a href="DELETE-OneItemGlobalFromTable.php?table=${deleteProperties.table}&column=${deleteProperties.column}&columnValue=${deleteProperties.columnValue}&goBackNumber=${deleteProperties.goBackNumber}&goBackStatement=${deleteProperties.goBackStatement}" class="text-center btn-1 bg-color-soft-red">
    //     <span>${deleteProperties.yes}</span>
    // </a>

    document.body.appendChild(divClosingGreyAreaGlobal);
    document.body.appendChild(divLightBoxGlobal);
}
