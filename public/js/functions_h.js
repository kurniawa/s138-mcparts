function randomColor () {
    let arrayColor = ["#FFB08E", "#DEDEDE", "#D1FFCA", "#FFB800", '#706DFF'];
    let randomIndex = Math.floor(Math.random() * arrayColor.length);
    return arrayColor[randomIndex];
}

function reloadPage (reload_page) {
    // RELOAD PAGE
    /**
     * Seletah reload pertama, maka controller yang berkaitan akan di panggil kembali, dimana
     * session reload page nya sudah di set false sebelumnya, sehingga tidak terjadi reload
     * berulang kali.
     */
    console.log('reload_page: ' + reload_page);
    if (reload_page === true) {
        window.location.reload();
    } else {
        console.log('tidak reload!');
    }

    return false;
}