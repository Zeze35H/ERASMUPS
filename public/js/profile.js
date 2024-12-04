let followTags = document.querySelector(
    "main#user_profile form.followtags button[type='submit']"
);

followTags.addEventListener("click", follow);

function follow(event) {
    event.preventDefault();

    let text = event.target.parentNode.querySelector("input").value.trim();
    let user_id = event.target.parentNode.getAttribute("data-id");
    console.log(user_id) 
    if (text == "") {
        event.target.parentNode.querySelector("input").value = "";
    } else {
        let tagsArray = text.split(" ");
        let removeDup = removeDuplicates(tagsArray);
        sendAjaxRequest('put', '/user/' + user_id + '/follow', {tags:removeDup.join(" ")}, followHandler);
    }
}

function removeDuplicates(tagsArray) {
    let newArray = [];
    for (let tag of tagsArray) {
        if (!newArray.includes(tag)) newArray.push(tag);
    }
    return newArray;
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

function followHandler() {
    let response = JSON.parse(this.responseText)
    let followedtags = document.querySelector("main#user_profile div#followedtags")

    for(let tag of response.tags) {
        let button = document.createElement("button")
        button.setAttribute("style","margin-top: 0.7em")
        button.setAttribute("type","button")
        button.setAttribute("class","btn btn-light btn-sm tag")

        let span = document.createElement("span")
        span.innerHTML = tag
        span.addEventListener('click',searchByTag)
        button.appendChild(span)

        let cross = document.createElement("i")
        cross.setAttribute("class", "fas fa-times")
        cross.setAttribute("style", "margin-left: 5px")
        cross.addEventListener('click', removeTag)
        button.appendChild(cross)
        
        followedtags.appendChild(button)
    }

    document.querySelector("main#user_profile form.followtags input").value = ""
}

function searchByTag(event){
    window.location.href = '/questions?search_tag=' + event.target.innerHTML;
}

let removeFollowedTagButton = document.querySelectorAll("main#user_profile div#followedtags button i")
for (let button of removeFollowedTagButton) button.addEventListener('click', removeTag)

function removeTag(event) {
    let tagText = event.target.parentNode.querySelector("span").innerText
    let user_id = event.target.parentNode.parentNode.getAttribute("data-id");
    // console.log(tagText)
    // event.target.parentNode.remove()
    sendAjaxRequest('delete', '/user/' + user_id + '/follow', {tag:tagText}, unFollowHandler);
}

function unFollowHandler() {
    let response = JSON.parse(this.responseText)
    console.log(response)

    let tags = document.querySelectorAll("main#user_profile div#followedtags button span")
    for (let tag of tags) {
        if (tag.innerText === response.tag) {
            tag.parentNode.remove()
            break
        }
    }
}