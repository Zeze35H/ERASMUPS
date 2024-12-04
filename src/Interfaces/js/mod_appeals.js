'use strict'

let sort_buttons = document.querySelectorAll("#mod_appeals .sort .sort_buttons p")

sort_buttons.forEach(button => {
    button.addEventListener("click", function(e) {
        sort_buttons.forEach(aux => {aux.style.borderBottom = "none"})
        button.style.borderBottom = "4px solid rgb(0, 91, 196)"
    })
});