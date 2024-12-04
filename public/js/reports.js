'use strict'



let ban_buttons = document.querySelectorAll("main#reports table.table tbody tr.report button.ban i")
let trash_buttons = document.querySelectorAll("main#reports table.table tbody tr.report button.trash i")
let ignore_buttons = document.querySelectorAll("main#reports table.table tbody tr.report button.ignore i")

console.log(ban_buttons)
console.log(trash_buttons)
console.log(ignore_buttons)

for (let ban_button of ban_buttons) ban_button.addEventListener("click", ban_author)
for (let trash_button of trash_buttons) trash_button.addEventListener("click", delete_content)
for (let ignore_button of ignore_buttons) ignore_button.addEventListener("click", ignore_report)


function ban_author(event) {
    event.preventDefault();

    let report_id = event.target.parentNode.parentNode.parentNode.getAttribute('data-id')

    console.log(report_id)

    sendAjaxRequest('delete', '/reports/treat_report/' + report_id, {reason : 'ban_author'}, reportHandler);

}

function delete_content(event) {
    event.preventDefault();

    let report_id = event.target.parentNode.parentNode.parentNode.getAttribute('data-id')

    console.log(report_id)

    sendAjaxRequest('delete', '/reports/treat_report/' + report_id, {reason : 'delete_content'}, reportHandler);

}

function ignore_report(event) {
    event.preventDefault();

    let report_id = event.target.parentNode.parentNode.parentNode.getAttribute('data-id')

    console.log(report_id)

    sendAjaxRequest('delete', '/reports/treat_report/' + report_id, {reason : 'ignore_report'}, reportHandler);

}

function reportHandler() {
    let response = JSON.parse(this.responseText)
    console.log(response)

    let empty = false

    if (response.success) //deleted content
    {
        let reports = document.querySelectorAll("main#reports table.table tbody tr.report")
        for(let report of reports)
        {
            if(report.getAttribute('data-id') == response.id)
            {
                report.remove()
                if (reports.length === 1)
                    empty = true
            }
        }
        
    }

    
    let messages = document.querySelector("main#reports > div.messages")
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
        empty_div.innerHTML = "Reports list is empty."
        document.querySelector("main#reports").appendChild(empty_div)
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


/*   WTF is this?


let type_buttons = document.querySelectorAll("main#reports div#side_nav #types p")
let vertical_line = document.querySelector("main#reports div#side_nav img#vertical_line")

console.log(type_buttons)
console.log(vertical_line)

type_buttons.forEach(button => {
    button.addEventListener("click", changeButton)
});

function changeButton(){

    console.log("button!")
    type_buttons.forEach(button => {
        button.style.fontWeight = "normal"
        button.style.color = "rgb(170, 170, 170)"
    })

    this.style.fontWeight = "bold"
    this.style.color = "rgb(130, 130, 130)"
    vertical_line.style.gridRowStart = this.id

}*/