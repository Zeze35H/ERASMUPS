'use strict'

let page = document.querySelector("body main").getAttribute("id")
selectButtonNav()

function selectButtonNav() {
    if(page === "sign_in") document.querySelector("body header nav #navbarSupportedContent a#log_in_button").style.color = "#2286DB"
    else if(page === "sign_up") document.querySelector("body header nav #navbarSupportedContent a#sign_up_button").style.color = "#2286DB"
    else if(page === "about_us") document.querySelector("body header nav #navbarSupportedContent a#about_us_button").style.color = "#2286DB"
    else if(page === "edit_profile"){
        document.querySelector("body header nav #navbarSupportedContent a#edit_profile_button").style.color = "#2286DB"
        document.querySelector("body header nav #navbarSupportedContent a#navbarDropdown").style.color = "#2286DB"
    }
    else if(page == "user_profile") {
        document.querySelector("body header nav #navbarSupportedContent #profile_button").style.color = "#2286DB"
        document.querySelector("body header nav #navbarSupportedContent a#navbarDropdown").style.color = "#2286DB"
    } 
    else if(page === "q_a") document.querySelector("body header nav #navbarSupportedContent a#q_a_button").style.color = "#2286DB"
    else if(page === "reports") document.querySelector("body header nav #navbarSupportedContent a#reports_button").style.color = "#2286DB"
    else if(page === "mod_appeals") document.querySelector("body header nav #navbarSupportedContent a#mod_appeals_button").style.color = "#2286DB"
    else if(page === "mods_dashboard") document.querySelector("body header nav #navbarSupportedContent a#mods_dashboard_button").style.color = "#2286DB"
}