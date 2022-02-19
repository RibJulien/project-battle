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