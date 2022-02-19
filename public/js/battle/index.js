document.querySelector("#form_life").addEventListener("click", function() {
    document.getElementById("range-life-value").innerHTML = this.value;
})

document.querySelector("#form_damage").addEventListener("click", function() {
    document.getElementById("range-damage-value").innerHTML = this.value;
})

document.querySelector("#form_initiative").addEventListener("click", function() {
    document.getElementById("range-initiative-value").innerHTML = this.value;
})

document.querySelector("#form_agility").addEventListener("click", function() {
    document.getElementById("range-agility-value").innerHTML = this.value;
})

document.querySelector("#form_threat").addEventListener("click", function() {
    document.getElementById("range-threat-value").innerHTML = this.value;
})

// Select Player Image
document.querySelector("#img-choice1").addEventListener("click", function() {
    document.getElementById('form_img_0').checked = true;
    deleteSelectedImg();
    this.classList.add("choice-player-selected");
})

document.querySelector("#img-choice2").addEventListener("click", function() {
    document.getElementById('form_img_1').checked = true;
    deleteSelectedImg();
    this.classList.add("choice-player-selected");
})

document.querySelector("#img-choice3").addEventListener("click", function() {
    document.getElementById('form_img_2').checked = true;
    deleteSelectedImg();
    this.classList.add("choice-player-selected");
})

document.querySelector("#img-choice4").addEventListener("click", function() {
    document.getElementById('form_img_3').checked = true;
    deleteSelectedImg();
    this.classList.add("choice-player-selected");
})

document.querySelector("#img-choice5").addEventListener("click", function() {
    document.getElementById('form_img_4').checked = true;
    deleteSelectedImg();
    this.classList.add("choice-player-selected");
})

document.querySelector("#img-choice6").addEventListener("click", function() {
    document.getElementById('form_img_5').checked = true;
    deleteSelectedImg();
    this.classList.add("choice-player-selected");
})


function deleteSelectedImg() {
    var element = document.querySelector('.choice-player-selected');
    if (element) {
        element.classList.remove("choice-player-selected");
    }
}