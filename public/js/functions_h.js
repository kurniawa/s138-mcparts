function randomColor () {
    let arrayColor = ["#FFB08E", "#DEDEDE", "#D1FFCA", "#FFB800", '#706DFF'];
    let randomIndex = Math.floor(Math.random() * arrayColor.length);
    return arrayColor[randomIndex];
}