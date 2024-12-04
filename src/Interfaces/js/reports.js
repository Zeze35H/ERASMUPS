'use strict'

let type_buttons = document.querySelectorAll("main#reports div#side_nav #types p")
let vertical_line = document.querySelector("main#reports div#side_nav img#vertical_line")

type_buttons.forEach(button => {
    button.addEventListener("click", changeButton)
});

function changeButton(){

    type_buttons.forEach(button => {
        button.style.fontWeight = "normal"
        button.style.color = "rgb(170, 170, 170)"
    })

    this.style.fontWeight = "bold"
    this.style.color = "rgb(130, 130, 130)"
    vertical_line.style.gridRowStart = this.id

}