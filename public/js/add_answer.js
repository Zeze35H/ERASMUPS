let addButton = document.querySelector('main#q_a_thread div.add_answer_form div form button')
// addButton.addEventListener('click', addAnswer);

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

function addAnswer(event) {
    event.preventDefault();

    let content = event.target.parentNode.querySelector('textarea').value.trim()
    if (content !== "") content = clearString(content)

    let question_id = event.target.parentNode.getAttribute("data-id")

    sendAjaxRequest('post', '/question/' + question_id + '/answer/add', {text_answer: content}, updatePage);

    event.target.parentNode.querySelector('textarea').value = ""
}

function updatePage() {
    console.log(this.responseText)
    let answer = JSON.parse(this.responseText)

    if (answer.success) createAnswer(answer)
    else createErrorMessage()
    
}

function createErrorMessage() {
    let error = document.createElement("span")
    error.setAttribute("class", "error")

    error.innerHTML = "An answer can not be empty"

    let textarea = document.querySelector("main#q_a_thread div.add_answer_form form textarea")
    textarea.parentNode.insertBefore(error, textarea.nextSibling)
}

function createAnswer(answer) {
    console.log(answer);
    //let newElem = document.createElement('div')
    //newElem.setAttribute('class', "answer row")
    // newElem.setAttribute('data-id', answer.id);

    

    /*newElem.innerHTML = '<div class="col-md-3 answer_opt">'
    if (answer.deleted) {
        newElem.innerHTML += "<div class='user'>"

        let image = answer.user_path.split("/")[0]
        if (image === "images") newElem.innerHTML += "<img class='avatar' src={{asset(" + answer.user_path + ")}} alt='user profile picture' width='50' height='50'><br>"
        else newElem.innerHTML += "<img class='avatar' src=" + answer.user_path + " alt='user profile picture' width='50' height='50'><br>"

        newElem.innerHTML += "<span class='deleteduser' style='font-style: italic;'>Deleted User</span>></div>"
    }
    else {
        newElem.innerHTML += "<div class='user'> <a href='../pages/user_profile.php'  style='text-decoration: none;'>"

        let image = answer.user_path.split("/")[0]
        if (image === "images") newElem.innerHTML += "<img class='avatar' src={{asset(" + answer.user_path + ")}} alt='user profile picture' width='50' height='50'><br>"
        else newElem.innerHTML += "<img class='avatar' src=" + answer.user_path + " alt='user profile picture' width='50' height='50'><br>"

        newElem.innerHTML += "<span class='notdeleteduser'>" + answer.username + "</span></a></div>"
    }
    
    newElem.innerHTML += '<div class="score">'

    if (answer.userLoggedIn !== answer.username && answer.userLoggedIn !== null) {
        newElem.innerHTML += '<i class="fas fa-chevron-up canvote"></i>'
    }
    else {
        newElem.innerHTML += '<i class="fas fa-chevron-up cannotvote"></i>'
    }
    newElem.innerHTML += '<span>' + answer.score + '</span>'
    if (answer.userLoggedIn !== answer.username && answer.userLoggedIn !== null) {
        newElem.innerHTML += '<i class="fas fa-chevron-down canvote"></i>'
    }
    else {
        newElem.innerHTML += '<i class="fas fa-chevron-down cannotvote"></i>'
    }

    newElem.innerHTML += '</div><div class="signs"><div class="star">'
    
    if (answer.selected) {
        if (answer.userLoggedIn === answer.username_question) {
            newElem.innerHTML += '<i class="fas fa-star canelect elected"></i>'
        }
        else {
            newElem.innerHTML = '<i class="fas fa-star cannotelect elected"></i>'
        }
    }
    else {
        if (answer.userLoggedIn === answer.username_question) {
            newElem.innerHTML += '<i class="fas fa-star canelect"></i>'
        }
        else {
            newElem.innerHTML += '<i class="fas fa-star cannotelect"></i>'
        }
    }

    newElem.innerHTML += '</div><div class="answer_reports">'

    if (answer.userLoggedIn !== answer.username && answer.userLoggedIn !== null) {
        newElem.innerHTML += '<i data-toggle="modal" data-target="#popupanswer{{$answer->id}}" class="far fa-flag canreport"></i>'
        newElem.innerHTML += reportPopUp('answer', answer.id)

    }
    else 
        newElem.innerHTML += '<i class="far fa-flag cannotreport"></i>'

    newElem.innerHTML += ' </div> <div class="remove">'

    if (answer.userLoggedIn === answer.username)
        newElem.innerHTML += '<i class="far fa-trash-alt canremove"></i>'
    else
        newElem.innerHTML += '<i class="far fa-trash-alt cannotremove"></i>'

    newElem.innerHTML += '</div></div></div><div class="col-md-7 card answer_body"><div class="card-body"><p class="card-text">'
    newElem.innerHTML = '<div class="col-md-7 card answer_body"><div class="card-body"><p class="card-text">'
    newElem.innerHTML += answer.text + '</p><div class="date"><p><strong> Date: </strong>'
    newElem.innerHTML += answer.timestamp + '</p></div></div></div></div><section class="comments"></section>'*/

    let div = document.createElement("div")
    div.setAttribute("class", "col-md-7 card answer_body")

    let div1 = document.createElement("div")
    div1.setAttribute("class", "card-body")

    let p = document.createElement("p")
    p.setAttribute("class", "card-text")
    p.innerHTML = answer.text
    div1.appendChild(p)

    let div2 = document.createElement("div")
    div2.setAttribute("class", "date") 

    let p1 = document.createElement("p")
    p1.setAttribute("class", "card-text")
    p1.innerHTML = "<strong> Date: </strong>" + answer.timestamp
    div2.appendChild(p1)

    div.appendChild(div1)
    div.appendChild(div2)

    /*let section = document.createElement("section")
    section.setAttribute("class", "comments")
    if (answer.userLoggedIn ) {
        newElem.innerHTML += '<div class="row input_row">'
                           + '<div class="post_comment col-md-6 offset-md-4">'
                           + '<form class="post_comment" method="POST" action="{{ route(\'addComment\', [' + answer.question_id + ', ' + answer.id + ']) }}">'
                            + '{{ csrf_field() }}'
                            + '<textarea name="text_comment' + answer.id + '" class="form-control" id="exampleFormControlTextarea1" rows="2" cols="70" placeholder="Comment this answer"></textarea>'
                            + '<button class="btn btn-default button_small">Post Comment</button>'
                            + '</form>'
                            + '</div> '
                            + '</div>'
    }*/

    //document.querySelector("main#q_a_thread section.answers").appendChild(newElem)
    document.querySelector("main#q_a_thread section.answers").appendChild(div)

    let success = document.createElement("div")
    success.setAttribute("class", "row")

    success.innerHTML = '<div class="offset-md-2 col-md-8 success">Your answer was added sucessfully to our database!</div>'

    let questionBody = document.querySelector("main#q_a_thread > div.question")
    questionBody.parentNode.insertBefore(success, questionBody)
}

function reportPopUp(type, id) {
    return '<div class="modal fade reportPopUpWindow" id="' + type + id + '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-type=' + type + 'data-id=' + id + '>'
        + '<div class="modal-dialog modal-dialog-centered" role="document">'
        + '<div id="going_to_report_window" class="modal-content">'
        + '<div class="modal-header">'
        + '<h5 class="modal-title" id="exampleModalCenterTitle">Why are you reporting this?</h5>'
        + '<a class="close_report_window" data-dismiss="modal"> <i class="fas fa-times"></i> </a>'
        + '</div>'
        + '<form>'
        + '<div class="modal-body">'
        + '<div><label><input required type="radio" name="report" value="inconv_or_disres"> It\'s inconvenient/disrespectful</label></div>'
        + '<div><label><input required type="radio" name="report" value="not_val"> It does not add anything valuable</label></div>'
        + '<div><label><input required type="radio" name="report" value="other"> Other</label><input type="text" name="reason" placeholder="Reason"></div>'
        + '</div>'
        + '<div class="modal-footer">'
        + '<button type="submit" class="btn btn-danger">Report</button>'
        + '</div>'
        + '</form>'
        + '</div>'
        + '<div id="report_done_window" class="modal-content" hidden>'
        + '<div class="modal-header">'
        + '<a class="close_report_window" data-dismiss="modal"> <i class="fas fa-times"></i> </a>'
        + '</div>'
        + '<div class="modal-body">'
        + '<p>We will review your report!</p>'
        + '<p>Thank you for your feedback.</p>'
        + '</div>'
        + '<div class="modal-footer">'
        + '<button type="button" class="btn btn-secondary" data-dismiss="modal">Accept</button>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '</div>'
}

function clearString(string) {
    let ret = ""
    let word = ""

    for (let i of string) {
        if (i !== " ") word += i
        else if (word !== "") {
            ret += word + " "
            word = ""
        }
    }

    return ret.trim()
}