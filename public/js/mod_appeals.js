'use strict'

let accept_buttons = document.querySelectorAll("main#mod_appeals table.table tbody tr.appeals button.accept i")
let refuse_buttons = document.querySelectorAll("main#mod_appeals table.table tbody tr.appeals button.refuse i")

console.log(accept_buttons)
console.log(refuse_buttons)

for (let accept_button of accept_buttons) accept_button.addEventListener("click", accept)
for (let refuse_button of refuse_buttons) refuse_button.addEventListener("click", refuse)

function accept(event) {
    event.preventDefault();

    let appeal_id = event.target.parentNode.parentNode.parentNode.getAttribute('data-id')

    console.log(appeal_id)

    sendAjaxRequest('post', '/modappeals/treat_appeal/' + appeal_id, {action : 'accepted'}, appealHandler);

}

function refuse(event) {
    event.preventDefault();

    let appeal_id = event.target.parentNode.parentNode.parentNode.getAttribute('data-id')

    console.log(appeal_id)

    sendAjaxRequest('post', '/modappeals/treat_appeal/' + appeal_id, {action : 'rejected'}, appealHandler);

}


function appealHandler() {
    let response = JSON.parse(this.responseText)
    console.log(response)

    let empty = false

    if (response.success) //deleted content
    {
        let appeals = document.querySelectorAll("main#mod_appeals table.table tbody tr.appeals")
        for(let appeal of appeals)
        {
            if(appeal.getAttribute('data-id') == response.id)
            {
                appeal.remove()
                if (appeals.length === 1)
                    empty = true
            }
        }
        
    }

    
    let messages = document.querySelector("main#mod_appeals > div.messages")
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
        //<div class="offset-md-2 col-md-8 empty_message">Reports list is empty.</div>
        let empty_div = document.createElement("div")
        empty_div.setAttribute("class", "offset-md-2 col-md-8 empty_message")
        empty_div.innerHTML = "Mod appeals list is empty."
        document.querySelector("main#mod_appeals").appendChild(empty_div)
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

let search_form_username = document.querySelector("main#mod_appeals form#search")
search_form_username.addEventListener('submit',searchAppeal)

function searchAppeal(event){
    event.preventDefault();
    let input = event.target.children[0].children[0].value
    console.log('Searching: ' + input)

    sendAjaxRequest('post', '/modappeals/search', {input: input}, searchModAppeals)

}

function searchModAppeals(){
    let mods = JSON.parse(this.responseText)
    console.log("Mods: " + mods)
    let tableBody = document.querySelector("main#mod_appeals .table > tbody:nth-child(2)")
    tableBody.innerHTML = ""

    for (var i = 0; i < mods.length; i++) {
        let mod = mods[i]

        let appealsRow = document.createElement('tr')
        appealsRow.setAttribute('class', 'appeals')
        appealsRow.setAttribute('data-id', mod.idMod)
        tableBody.appendChild(appealsRow)

        let avatarData = document.createElement('td')
        avatarData.setAttribute('class', 'user_avatar')
        appealsRow.appendChild(avatarData)

        let img = document.createElement('img')
        img.setAttribute('src', mod.user_path)
        img.setAttribute('alt', "user profile picture")
        img.setAttribute('width', '40')
        img.setAttribute('height', '40')
        avatarData.appendChild(img)

        let userLink = window.location.href.split("modappeals")[0] + "user/" + mod.id
        let userAnchor = document.createElement('a')
        userAnchor.setAttribute('href', userLink)
        userAnchor.setAttribute('class', 'user-link')
        userAnchor.innerHTML = mod.username
        avatarData.appendChild(userAnchor)

        let trustData = document.createElement('td')
        trustData.setAttribute('class', 'text-center trust_level')
        trustData.innerHTML = mod.trust_level
        appealsRow.appendChild(trustData)

        let countryData = document.createElement('td')
        countryData.setAttribute('class', 'text-center country')
        countryData.innerHTML = mod.country
        appealsRow.appendChild(countryData)

        let actionData = document.createElement('td')
        actionData.setAttribute('class', 'text-center action')
        appealsRow.appendChild(actionData)

        let acceptButton = document.createElement('button')
        acceptButton.setAttribute('class', 'btn sucess accept')
        acceptButton.setAttribute('data-bs-toggle', 'tooltip')
        acceptButton.setAttribute('data-bs-placement', 'top')
        acceptButton.setAttribute('title', 'Accept')
        actionData.appendChild(acceptButton)

        let acceptIcon = document.createElement('i')
        acceptIcon.setAttribute('class', 'fas fa-check-circle')
        acceptButton.appendChild(acceptIcon)

        let refuseButton = document.createElement('button')
        refuseButton.setAttribute('class', 'btn sucess refuse')
        refuseButton.setAttribute('data-bs-toggle', 'tooltip')
        refuseButton.setAttribute('data-bs-placement', 'top')
        refuseButton.setAttribute('title', 'Reject')
        actionData.appendChild(refuseButton)

        let rejectIcon = document.createElement('i')
        rejectIcon.setAttribute('class', 'fas fa-times-circle')
        refuseButton.appendChild(rejectIcon)


    }

    if(mods == ""){
        let empty_div_existant = document.querySelector('main#mod_appeals div.offset-md-2.col-md-8.empty_message')
        if(empty_div_existant == null){
            let empty_div = document.createElement("div")
            empty_div.setAttribute("class", "offset-md-2 col-md-8 empty_message")
            empty_div.innerHTML = "Mod appeals list is empty."
            document.querySelector("main#mod_appeals").appendChild(empty_div)
        }
    } else {
        let empty_div = document.querySelector('main#mod_appeals div.offset-md-2.col-md-8.empty_message')
        if(empty_div != null)
            empty_div.outerHTML = ""
        
        let accept_buttons = document.querySelectorAll("main#mod_appeals table.table tbody tr.appeals button.accept i")
        let refuse_buttons = document.querySelectorAll("main#mod_appeals table.table tbody tr.appeals button.refuse i")

        for (let accept_button of accept_buttons) accept_button.addEventListener("click", accept)
        for (let refuse_button of refuse_buttons) refuse_button.addEventListener("click", refuse)

    }
}

