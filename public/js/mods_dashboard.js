'use strict'

let ban_mod_buttons = document.querySelectorAll("main#mods_dashboard table.table tbody tr.mods button.ban i")
let demote_buttons = document.querySelectorAll("main#mods_dashboard table.table tbody tr.mods button.demote i")

console.log(ban_mod_buttons)
console.log(demote_buttons)

for(let ban__mod_button of ban_mod_buttons) ban__mod_button.addEventListener('click', ban_mod)
for(let demote_button of demote_buttons) demote_button.addEventListener('click', demote_mod)

function ban_mod(event) {
    event.preventDefault();

    let mod_id = event.target.parentNode.parentNode.parentNode.getAttribute('data-id')

    console.log(mod_id)

    sendAjaxRequest('post', '/modsdashboard/treat_mod/' + mod_id, {action : 'Banned.'}, modHandler);

}

function demote_mod(event) {
    event.preventDefault();

    let mod_id = event.target.parentNode.parentNode.parentNode.getAttribute('data-id')

    console.log(mod_id)

    sendAjaxRequest('post', '/modsdashboard/treat_mod/' + mod_id, {action : 'Demoted.'}, modHandler);

}

function promote_mod(event) {
    event.preventDefault();

    let user_id = event.target.parentNode.parentNode.parentNode.getAttribute('data-id')

    console.log(user_id)

    sendAjaxRequest('post', '/modsdashboard/treat_mod/' + user_id, {action : 'Promoted.'}, modHandler);

}


function modHandler() {
    let response = JSON.parse(this.responseText)
    console.log(response)

    let empty = false

    if (response.success) //deleted content
    {
        console.log("Success ")
        let mods = document.querySelectorAll("main#mods_dashboard table.table tbody tr.mods")
        for(let mod of mods)
        {
            if(mod.getAttribute('data-id') == response.id)
            {
                mod.remove()

            }
        }
        console.log("Lenght: " + mods.length)
        if (mods.length === 1)
            empty = true
        
    }

    
    let messages = document.querySelector("main#mods_dashboard > div.messages")
    let div = document.createElement("div")
    if(response.success)
        div.setAttribute("class", "offset-md-2 col-md-8 success")
    else
        div.setAttribute("class", "offset-md-2 col-md-8 failure")
        
    let cross = document.createElement("div")
    cross.setAttribute("class", "close_button")
    let crossElem = document.createElement("i")
    crossElem.setAttribute("class", "fas fa-times")
    cross.appendChild(crossElem)
    div.appendChild(cross)

    crossElem.addEventListener('click', close_message)

    let message = document.createElement("p")
    message.setAttribute("class", "text_message")
    message.innerHTML = response.message
    div.appendChild(message)

    messages.appendChild(div)

    if(empty)
    {
        // let empty_div_existant = document.querySelector('main#mods_dashboard div.offset-md-2.col-md-8.empty_message')
        // if(empty_div_existant == null){
        //     let empty_div = document.createElement("div")
        //     empty_div.setAttribute("class", "offset-md-2 col-md-8 empty_message")
        //     empty_div.innerHTML = "Users/Mods list is empty."
        //     document.querySelector("main#mods_dashboard").appendChild(empty_div)
        // }
        sendAjaxRequest('post', '/modsdashboard/search', {input: ""}, searchModsHandler)
    }
    
}

function close_message(event) {
    event.target.parentNode.parentNode.remove()
}

function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function(k){
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}

function sendAjaxRequest(method, url, data, handler) {
    let request = new XMLHttpRequest();

    request.open(method, url, true);
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.addEventListener('load', handler);
    request.send(encodeForAjax(data));
}

//  SEARCH by Username

let search_form_dashboard = document.querySelector("main#mods_dashboard form#search")
search_form_dashboard.addEventListener('submit',searchMod)

function searchMod(event){
    event.preventDefault();
    let input = event.target.children[0].children[0].value
    console.log('Searching: ' + input)

    sendAjaxRequest('post', '/modsdashboard/search', {input: input}, searchModsHandler)

}

function searchModsHandler(){
    let response = JSON.parse(this.responseText)
    let result = response.select
    let mods = response.mods

    console.log("Result")
    console.log("isMods: " + mods)
    let tableBody = document.querySelector("main#mods_dashboard .table > tbody:nth-child(2)")
    tableBody.innerHTML = ""

    for (var i = 0; i < result.length; i++) {
        let mod = result[i]

        let row = document.createElement('tr')
        row.setAttribute('class', 'mods')
        row.setAttribute('data-id', mod.id)
        tableBody.appendChild(row)

        let avatarData = document.createElement('td')
        avatarData.setAttribute('class', 'user_avatar')
        row.appendChild(avatarData)

        let img = document.createElement('img')
        img.setAttribute('src', mod.user_path)
        img.setAttribute('alt', "user profile picture")
        img.setAttribute('width', '40')
        img.setAttribute('height', '40')
        avatarData.appendChild(img)

        let userLink = window.location.href.split("modsdashboard")[0] + "user/" + mod.id
        let userAnchor = document.createElement('a')
        userAnchor.setAttribute('href', userLink)
        userAnchor.setAttribute('class', 'user-link')
        userAnchor.innerHTML = mod.username
        avatarData.appendChild(userAnchor)

        let trustData = document.createElement('td')
        trustData.setAttribute('class', 'text-center trust_level')
        trustData.innerHTML = mod.trust_level
        row.appendChild(trustData)

        let num_interactionsData = document.createElement('td')
        num_interactionsData.setAttribute('class', 'text-center')
        let num_interactions = document.createElement('span')
        num_interactions.setAttribute('class', 'label label-default')
        num_interactions.innerHTML = mod.num_interactions
        num_interactionsData.appendChild(num_interactions)
        row.appendChild(num_interactionsData)

        let actionData = document.createElement('td')
        actionData.setAttribute('class', 'text-center action')
        row.appendChild(actionData)

        let banButton = document.createElement('button')
        banButton.setAttribute('class', 'btn danger ban')
        banButton.setAttribute('data-bs-toggle', 'tooltip')
        banButton.setAttribute('data-bs-placement', 'top')
        banButton.setAttribute('title', 'Ban Mod')
        actionData.appendChild(banButton)

        let banIcon = document.createElement('i')
        banIcon.setAttribute('class', 'fas fa-user-times')
        banButton.appendChild(banIcon)

        if(mods)
        {
            let demoteButton = document.createElement('button')
            demoteButton.setAttribute('class', 'btn danger demote')
            demoteButton.setAttribute('data-bs-toggle', 'tooltip')
            demoteButton.setAttribute('data-bs-placement', 'top')
            demoteButton.setAttribute('title', 'Demote Mod')
            actionData.appendChild(demoteButton)
    
            let rejectIcon = document.createElement('i')
            rejectIcon.setAttribute('class', 'fas fa-times-circle')
            demoteButton.appendChild(rejectIcon)
        }
        else
        {
            let promoteButton = document.createElement('button')
            promoteButton.setAttribute('class', 'btn sucess accept')
            promoteButton.setAttribute('data-bs-toggle', 'tooltip')
            promoteButton.setAttribute('data-bs-placement', 'top')
            promoteButton.setAttribute('title', 'Promote Mod')
            actionData.appendChild(promoteButton)
    
            let acceptIcon = document.createElement('i')
            acceptIcon.setAttribute('class', 'fas fa-check-circle')
            promoteButton.appendChild(acceptIcon)
        }

        
    }
    

    if(result == ""){
        let empty_div_existant = document.querySelector('main#mods_dashboard div.offset-md-2.col-md-8.empty_message')
        if(empty_div_existant == null){
            let empty_div = document.createElement("div")
            empty_div.setAttribute("class", "offset-md-2 col-md-8 empty_message")
            empty_div.innerHTML = "Users/Mods list is empty."
            document.querySelector("main#mods_dashboard").appendChild(empty_div)
        }
    } else {
        let empty_div = document.querySelector('main#mods_dashboard div.offset-md-2.col-md-8.empty_message')

        if(empty_div != null)
            empty_div.outerHTML = ""
        
        let ban_mod_buttons = document.querySelectorAll("main#mods_dashboard table.table tbody tr.mods button.ban i")
        console.log(ban_mod_buttons)
        for(let ban__mod_button of ban_mod_buttons) ban__mod_button.addEventListener('click', ban_mod)

        if(mods) {
            let demote_buttons = document.querySelectorAll("main#mods_dashboard table.table tbody tr.mods button.demote i")
            console.log(demote_buttons)
            for(let demote_button of demote_buttons) demote_button.addEventListener('click', demote_mod)
        } else {
            let promote_buttons = document.querySelectorAll("main#mods_dashboard table.table tbody tr.mods button.accept i")
            console.log(promote_buttons)
            for(let promote_button of promote_buttons) promote_button.addEventListener('click', promote_mod)
        }
    }
}
