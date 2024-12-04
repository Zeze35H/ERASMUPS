let displayedImage = document.querySelector("main#edit_profile form div.container div.card-body img")
let resetButton = document.querySelector("main#edit_profile form div.container div.card-body div.media-body button")
let uploadInput = document.querySelector("main#edit_profile form div.container div.card-body div.media-body input.account-settings-fileinput")
let cancelButtons = document.querySelectorAll("main#edit_profile div.text-right.mt-3 button.btn.btn-default.button_small")

//console.log(displayedImage)
//console.log(resetButton)
//console.log(uploadInput)

resetButton.addEventListener('click', reset)

for(let cancelButton of cancelButtons) cancelButton.addEventListener('click', cancel)


function cancel(event){
    window.location.href = window.location.href;
}

function reset(event) {
    event.preventDefault()
    let id = event.target.getAttribute('data-id')
    sendAjaxRequest('post', '/user/'+id+'/reset_picture', {}, resetHandler);
}

function resetHandler() {
    let response = JSON.parse(this.responseText)

    let messages = document.querySelector("main#edit_profile div.messages")
    let div = document.createElement("div")

    if(response.sucess)
    {
        displayedImage.setAttribute("src", "/images/user.png")
        div.setAttribute("class", "offset-md-2 col-md-8 success")
    }
    else
    {
        div.setAttribute("class", "offset-md-2 col-md-8 failure")
    }

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

}

function selectImage(event) {
    
    var reader = new FileReader()   ;
    reader.onload = function()
    {
        //console.log(reader.result)
        displayedImage.setAttribute("src", reader.result)
    }
    reader.readAsDataURL(event.target.files[0]);
    
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

function close_message(event) {
    event.target.parentNode.parentNode.remove()
}