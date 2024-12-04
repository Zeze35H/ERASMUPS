 'use strict'


 let cross = document.getElementById('close')
 cross.addEventListener('click', closeAlert)

 function closeAlert(event){
    alert = event.target.parentNode.parentNode.remove()
}



/*
let recoverButton = document.querySelector("main#recovery .sendEmail button#submit")
recoverButton.addEventListener('click', recoverPassword)

function recoverPassword(event){
    let emailElem = document.querySelector("main#recovery .sendEmail input#inputEmail4")

    if(emailElem.value !== "" && event.target.innerHTML !== 'Resend Email'){ //TODO Check if valid
        event.target.innerHTML = 'Resend Email'
        let resendText = document.createElement('p')
        resendText.className = 'resendText'
        resendText.innerHTML = "Remember to check the spam folder on your email. If you didn't get any email resend it using the button above. "
        event.target.parentNode.appendChild(resendText)


        sendAjaxRequest('put', '/login/reset', {email: emailElem.value} ,function(){});
    }
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

 */
