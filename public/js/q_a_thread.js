'use strict'

let reportButtons = document.querySelectorAll("body a.report_button i")
let removeQuestionsButtons = document.querySelectorAll("body div.question div.remove i.canremove")
let removeAnswersButtons = document.querySelectorAll("body div.answer div.remove i.canremove")
let removeCommentsButtons = document.querySelectorAll("body div.comment div.remove i.canremove")
// console.log(reportButtons)
for(let reportButton of reportButtons) reportButton.addEventListener('click', showUpReportInfo)

//for(let removeQuestionButton of removeQuestionsButtons) removeQuestionButton.addEventListener('click', removeQuestion)
for(let removeAnswerButton of removeAnswersButtons) removeAnswerButton.addEventListener('click', removeAnswer)
for(let removeCommentButton of removeCommentsButtons) removeCommentButton.addEventListener('click', removeComment)

// let editButtons = document.querySelectorAll(".signs .edit")
// for(let editButton of editButtons) editButton.addEventListener('click', editContent)

function showUpReportInfo(event) {
    event.target.parentNode.parentNode.querySelector("div.reportPopUpWindow div#report_done_window").setAttribute("hidden", true)
}

let acceptButtons = document.querySelectorAll("body div.reportPopUpWindow div#going_to_report_window div.modal-footer button")
for(let acceptButton of acceptButtons) acceptButton.addEventListener('click', thanksReportWindow)

function thanksReportWindow(event) {
    console.log()
    let buttons = event.target.parentNode.parentNode.querySelectorAll("div.modal-body div label input");
    let reason = null
    let message = null
    for (let p of buttons) {
        if (p.checked) {
            reason = p.value
            if (p.value === "other") {
                message = event.target.parentNode.parentNode.querySelector("div.modal-body div input[name='reason']").value
                if (message.trim() === "") message = "no reason given"
            }
            else if (p.value ===  "inconv_or_disres") {
                message = "disrespectful"
            }
            else if(p.value === "not_val") {
                message = "not valuable"
            }
            break
        }
    }

    if (reason != null) {
        event.preventDefault()
        console.log("Reason: " + reason)
        console.log("Message: " + message)
        
        event.target.parentNode.parentNode.parentNode.setAttribute("hidden", true)
        event.target.parentNode.parentNode.parentNode.parentNode.querySelector("#report_done_window").removeAttribute("hidden")
    
        let reportFlag = event.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.querySelector("i")
        reportFlag.setAttribute('class', reportFlag.getAttribute("class") + " " + "reported")
        reportFlag.removeAttribute('data-toggle')
        reportFlag.removeAttribute('data-target')

        let question_id = document.querySelector('main#q_a_thread div.question').getAttribute('data-id')
        let content_id = event.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.getAttribute('data-id')
        console.log(question_id, content_id)
        
        sendAjaxRequest('post', '/question/report_content/'+content_id, {message: message, id_question: question_id}, reportContentHandler);

    }

}

function reportContentHandler() {
    let response = JSON.parse(this.responseText)
    console.log(response.success)
    console.log(response.message)
}
//Route::delete('question/{id_question}/answer/{id_answer}/comment/{id_comment}', 'QuestionController@removeComment')->name('removeComment');


function removeQuestion(event) {
    event.preventDefault();

    let question_id = event.target.parentNode.parentNode.parentNode.parentNode.getAttribute('data-id')

    console.log(question_id)
    //sendAjaxRequest('delete', question_id, {question_id: question_id}, removeQuestionHandler);
}

function removeAnswer(event) {
    event.preventDefault();

    let answer = event.target.parentNode.parentNode.parentNode.parentNode

    console.log(answer)

    let answer_id = answer.getAttribute('data-id')

    console.log(answer_id)
    

    sendAjaxRequest('delete', '/question/answer/' + answer_id, {}, removeAnswerHandler);

    //answer.remove()
}

function removeComment(event) {
    event.preventDefault()

    let comment = event.target.parentNode.parentNode.parentNode.parentNode

    console.log(comment)

    let comment_id = comment.getAttribute('data-id')

    console.log(comment_id)

    sendAjaxRequest('delete', '/question/answer/comment/' + comment_id, {}, removeCommentHandler);
}


function removeQuestionHandler() {
    window.location.pathname = 'questions';
}

function removeAnswerHandler() {

    //console.log(this.responseText)
    let response = JSON.parse(this.responseText)
    let message;
    //console.log(response)

    let answers = document.querySelectorAll("body div.answer_block")
    for(let answer of answers)
    {
        if(answer.getAttribute('data-id') == response.answer_id)
        {
            if (response.success)
            {
                answer.remove()
                message = "Succesfuly deleted answer!"
            }
            else
            {
                message = "Succesfuly removed ownership from answer!"

                let div_user = answer.querySelector('div.user')
                let div_score = answer.querySelector('div.score')
                let div_signs = answer.querySelector('div.signs')

                console.log(div_user)
                console.log(div_user)

                let new_user = document.createElement("div")
                new_user.setAttribute("class","user")

                let new_img = document.createElement("img")
                new_img.setAttribute("class","avatar")
                new_img.setAttribute("src",response.src)
                new_img.setAttribute("alt","user profile picture")
                new_img.setAttribute("width","50")
                new_img.setAttribute("height","50")
                
                let br = document.createElement("br")

                let new_span = document.createElement("span")
                new_span.setAttribute("class","deleteduser")
                new_span.innerHTML = response.username
                
                new_user.appendChild(new_img)
                new_user.appendChild(br)
                new_user.appendChild(new_span)

                console.log(new_user)

                div_user.remove()
                div_signs.remove()
                div_score.parentNode.insertBefore(new_user,div_score)
            }
            break;
        }
    }

    //Feedback msg
    let divX = document.createElement("div")
    divX.setAttribute("class", "close_button")
    let cross = document.createElement("i")
    cross.setAttribute("class","fas fa-times")
    cross.setAttribute("onclick", "closeContentAlert(this)")
    divX.appendChild(cross)

    let question = document.querySelector('div.question');
    let div1 = document.createElement("div")
    div1.setAttribute("class", "row")
    let div2 = document.createElement("div")
    div2.setAttribute("class", "offset-md-2 col-md-8 success")
    div2.appendChild(divX)
    div2.innerHTML += message
    div1.appendChild(div2)
    question.parentNode.insertBefore(div1,question)
}

function removeCommentHandler() {
    
    console.log(this.responseText)
    let response = JSON.parse(this.responseText)
    let message;
    console.log(response)

    let comments = document.querySelectorAll("body div.comment")
    for(let comment of comments)
    {
        if(comment.getAttribute('data-id') == response.comment_id)
        {
            if (response.success) //deleted content
            {   
                comment.remove()
                message = "Succesfuly deleted comment!"
            }
            else
            {
                message = "Succesfuly removed ownership from comment!"

                let div_user = comment.querySelector('div.user')
                let div_score = comment.querySelector('div.score')
                let div_signs = comment.querySelector('div.signs')

                console.log(div_user)
                console.log(div_user)

                let new_user = document.createElement("div")
                new_user.setAttribute("class","user")

                let new_img = document.createElement("img")
                new_img.setAttribute("class","avatar")
                new_img.setAttribute("src",response.src)
                new_img.setAttribute("alt","user profile picture")
                new_img.setAttribute("width","50")
                new_img.setAttribute("height","50")
                
                let br = document.createElement("br")

                let new_span = document.createElement("span")
                new_span.setAttribute("class","deleteduser")
                new_span.innerHTML = response.username
                
                new_user.appendChild(new_img)
                new_user.appendChild(br)
                new_user.appendChild(new_span)

                console.log(new_user)

                div_user.remove()
                div_signs.remove()
                div_score.parentNode.insertBefore(new_user,div_score)
            }

            break;
        }
            
    }


    //Feedback msg
    let divX = document.createElement("div")
    divX.setAttribute("class", "close_button")
    let cross = document.createElement("i")
    cross.setAttribute("class","fas fa-times")
    cross.setAttribute("onclick", "closeContentAlert(this)")
    divX.appendChild(cross)
    

    let question = document.querySelector('div.question');
    let div1 = document.createElement("div")
    div1.setAttribute("class", "row")
    let div2 = document.createElement("div")
    div2.setAttribute("class", "offset-md-2 col-md-8 success")
    div2.appendChild(divX)
    div2.innerHTML += message
    div1.appendChild(div2)
    question.parentNode.insertBefore(div1,question)
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

let close_buttons = document.querySelectorAll("main#q_a_thread div button.close_topic")
for (let button of close_buttons) button.addEventListener('click', closeTopic)

function closeTopic() {
    let question_id = document.querySelector("main#q_a_thread div.question").getAttribute('data-id')
    sendAjaxRequest('put', '/question/' + question_id, {}, closeTopicHandler);
}

function closeTopicHandler() {
    // Remove 'Mark as Solved' button
    document.querySelector("main#q_a_thread div.close_section").remove()

    // Remove all forms
    let answer = document.querySelector("main#q_a_thread div.add_answer_form")
    if(answer != null) answer.remove()
    let commentForms = document.querySelectorAll("main#q_a_thread section.answers div.answer_block div.add_comment_form")
    for(let commentForm of commentForms)
        commentForm.remove()

    // Adds success message
    let mainSection = document.querySelector("main#q_a_thread")
    let newElem = document.createElement("div")
    console.log(commentForms)
    newElem.setAttribute('class', 'offset-md-2 col-md-8 close_message')
    newElem.innerHTML = '<i class="fa fa-check"></i> This Q&A was marked as solved!';
    mainSection.insertBefore(newElem, document.querySelector("main#q_a_thread div.question"))
}


function closeContentAlert(obj){
    alert = obj.parentNode.parentNode.remove()
}


// ------------ Question Voting ---------------


let voteUpButtons = document.querySelectorAll("main#q_a_thread div.question div.score i.canvote.up")
let voteDownButtons = document.querySelectorAll("main#q_a_thread div.question div.score i.canvote.down")

for (let voteUpButton of voteUpButtons) voteUpButton.addEventListener('click', clickedVoteUp)
for (let voteDownButton of voteDownButtons) voteDownButton.addEventListener('click', clickedVoteDown)

function clickedVoteUp(event) {
    let classes = event.target.getAttribute("class").split(" ")
    if (!classes.includes("votedUp")) VoteUp(event)
    else removeVoteUp(event)
}

function clickedVoteDown(event) {
    let classes = event.target.getAttribute("class").split(" ")
    if (!classes.includes("votedDown")) VoteDown(event)
    else removeVoteDown(event)
}

function removeVoteUp(event) {
    let question_id = event.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.querySelector("div.question").getAttribute("data-id")
    sendAjaxRequest('delete', '/question/' + question_id + '/vote', {}, removeVoteHandler);
}

function removeVoteDown(event) {
    let question_id = event.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.querySelector("div.question").getAttribute("data-id")
    sendAjaxRequest('delete', '/question/' + question_id + '/vote', {}, removeVoteHandler);
}


function VoteUp(event) {  
    console.log()
    console.log("votar up")

    let question_id = event.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.querySelector("div.question").getAttribute("data-id")
    let value = true
    sendAjaxRequest('put', '/question/' + question_id + '/vote', {value:value}, voteHandler);
}

function VoteDown(event) {  
    console.log()
    event.preventDefault()
    console.log("votar down")

    let value = false
    let question_id = event.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.querySelector("div.question").getAttribute("data-id")
    sendAjaxRequest('put', '/question/' + question_id + '/vote', {value:value}, voteHandler);
}    

function voteHandler() {
    let response = JSON.parse(this.responseText)
    console.log(response)
    console.log(response.id)
    console.log(response.user_id)
    console.log(response.value)

    let questions = document.querySelectorAll("main#q_a_thread div.question")

    for (let question of questions) {
        if (response.value == true && question.getAttribute("data-id") === response.id){

            console.log(response.value)

            let up = question.querySelector("div.score i.up")
            up.setAttribute("class", up.getAttribute("class") + " votedUp")

            let score = question.querySelector("div.score span")
            score.innerHTML = response.score
  
            console.log(up)
            let down = question.querySelector("div.score i.down")
            let classes = down.getAttribute("class").split(" ")
            if (classes.includes("votedDown"))
                down.setAttribute("class", "fas fa-chevron-down canvote down")    
        }
        else if (response.value == false && question.getAttribute("data-id") === response.id){
            console.log(response.value)
            let down = question.querySelector("div.score i.down")
            console.log("votos")
            console.log(down)

            down.setAttribute("class", down.getAttribute("class") + " votedDown")

            let score = question.querySelector("div.score span")
            score.innerHTML = response.score

            let up = question.querySelector("div.score i.up")
            let classes = up.getAttribute("class").split(" ")
            if (classes.includes("votedUp"))
            up.setAttribute("class", "fas fa-chevron-up canvote up")    
        }   
        
    }
}

function removeVoteHandler() {

    let response = JSON.parse(this.responseText)
    console.log(response.value)
    console.log("remover voto pq já tá votado")


    let questions = document.querySelectorAll("main#q_a_thread div.question")

    for (let question of questions) {
        
            let score = question.querySelector("div.score span")
            score.innerHTML = response.score
  
            let up = question.querySelector("main#q_a_thread div.question div.score i.canvote.up")
            console.log(up)

            up.setAttribute("class", "fas fa-chevron-up canvote up")    
       
            console.log(response.value)

            let down = question.querySelector("main#q_a_thread div.question div.score i.canvote.down")
            down.setAttribute("class", "fas fa-chevron-down canvote down") 
     
    }
}


// ------------ Answer Voting ---------------

let voteUpAnswerButtons = document.querySelectorAll("main#q_a_thread div.answer div.score .upanswer")
let voteDownAnswerButtons = document.querySelectorAll("main#q_a_thread div.answer div.score .downanswer")

for (let voteUpAnswerButton of voteUpAnswerButtons) voteUpAnswerButton.addEventListener('click', clickedVoteAnswerUp)
for (let voteDownAnswerButton of voteDownAnswerButtons) voteDownAnswerButton.addEventListener('click', clickedVoteAnswerDown)

function clickedVoteAnswerUp(event) {
    let classes = event.target.getAttribute("class").split(" ")
    if (!classes.includes("votedUp")) VoteAnswerUp(event)
    else removeVoteAnswerUp(event)
}

function clickedVoteAnswerDown(event) {
    let classes = event.target.getAttribute("class").split(" ")
    if (!classes.includes("votedDown")) VoteAnswerDown(event)
    else removeVoteAnswerDown(event)
}

function removeVoteAnswerUp(event) {
    let answerId = event.target.parentNode.parentNode.parentNode.getAttribute("data-id")
    sendAjaxRequest('delete', '/question/answer/' + answerId + '/vote', {}, removeVoteAnswerHandler);
}

function removeVoteAnswerDown(event) {
    let answerId = event.target.parentNode.parentNode.parentNode.getAttribute("data-id")
    sendAjaxRequest('delete', '/question/answer/' + answerId + '/vote', {}, removeVoteAnswerHandler);
}

function VoteAnswerUp(event) {  
    console.log()
    console.log("votar up answer ")
    let answerId = event.target.parentNode.parentNode.parentNode.getAttribute("data-id")
    let value = true
    sendAjaxRequest('put', '/question/answer/' + answerId + '/vote', {value:value}, voteAnswerHandler);
}

function VoteAnswerDown(event) {  
    console.log()
    event.preventDefault()
    console.log("votar down answer")
    let answerId = event.target.parentNode.parentNode.parentNode.getAttribute("data-id")
    let value = false
    sendAjaxRequest('put', '/question/answer/' + answerId + '/vote', {value:value}, voteAnswerHandler);
}    

function voteAnswerHandler() {  
    console.log("votar up answer handler")

    let response = JSON.parse(this.responseText)
    let answers = document.querySelectorAll("main#q_a_thread div.answer")

    for (let answer of answers) {
        if (response.value == true && answer.getAttribute("data-id") === response.id_answer){

            console.log(response.value)

            let up = answer.querySelector("div.score i.upanswer")
            up.setAttribute("class", up.getAttribute("class") + " votedUp")

            let score = answer.querySelector("div.score span")
            score.innerHTML = response.score
  
            console.log(up)
            let down = answer.querySelector("div.score i.downanswer")
            let classes = down.getAttribute("class").split(" ")
            if (classes.includes("votedDown"))
                down.setAttribute("class", "fas fa-chevron-down canvote downanswer")    
        }
        else if (response.value == false && answer.getAttribute("data-id") === response.id_answer){
            console.log(response.value)
            let down = answer.querySelector("div.score i.downanswer")
            console.log("votos answer")
            console.log(down)

            down.setAttribute("class", down.getAttribute("class") + " votedDown")

            let score = answer.querySelector("div.score span")
            score.innerHTML = response.score

            let up = answer.querySelector("div.score i.upanswer")
            let classes = up.getAttribute("class").split(" ")
            if (classes.includes("votedUp"))
            up.setAttribute("class", "fas fa-chevron-up canvote upanswer")    
        }     
    }
}

function removeVoteAnswerHandler() {
    console.log("remover handler")

    let response = JSON.parse(this.responseText)
    console.log("remover voto pq já tá votado")

    let answers = document.querySelectorAll("main#q_a_thread div.answer")

    for (let answer of answers) {
        
            let score = answer.querySelector("div.score span")
            score.innerHTML = response.score
  
            let up = answer.querySelector("div.score i.upanswer")
            up.setAttribute("class", "fas fa-chevron-up canvote upanswer")    
       
            let down = answer.querySelector("div.score i.downanswer")
            down.setAttribute("class", "fas fa-chevron-down canvote downanswer") 
     
    }
}

// ------------ Comment Voting ---------------


let voteUpComentButtons = document.querySelectorAll("main#q_a_thread section.comments div.comment div.comment_opt div.score .upcomment")
let voteDownCommentButtons = document.querySelectorAll("main#q_a_thread section.comments div.comment div.comment_opt div.score .downcomment")

for (let voteUpComentButton of voteUpComentButtons) voteUpComentButton.addEventListener('click', clickedVoteCommentUp)
for (let voteDownCommentButton of voteDownCommentButtons) voteDownCommentButton.addEventListener('click', clickedVoteCommentDown)

function clickedVoteCommentUp(event) {
    let classes = event.target.getAttribute("class").split(" ")
    if (!classes.includes("votedUp")) VoteCommentUp(event)
    else removeVoteCommentUp(event)
}

function clickedVoteCommentDown(event) {
    let classes = event.target.getAttribute("class").split(" ")
    if (!classes.includes("votedDown")) VoteCommentDown(event)
    else removeVoteCommentDown(event)
}

function removeVoteCommentUp(event) {
    let comment_id = event.target.parentNode.parentNode.parentNode.parentNode.getAttribute("data-id")
    sendAjaxRequest('delete', '/question/answer/comment/' + comment_id + '/vote', {}, removeVoteCommentHandler);
}

function removeVoteCommentDown(event) {
    let comment_id = event.target.parentNode.parentNode.parentNode.parentNode.getAttribute("data-id")
    sendAjaxRequest('delete', '/question/answer/comment/' + comment_id + '/vote', {}, removeVoteCommentHandler);
}

function VoteCommentUp(event) {  
    console.log()
    console.log("votar up comment ")
    let comment_id = event.target.parentNode.parentNode.parentNode.parentNode.getAttribute("data-id")
    let value = true

    sendAjaxRequest('put', '/question/answer/comment/' + comment_id + '/vote', {value:value}, voteCommentHandler);
}

function VoteCommentDown(event) {  
    console.log()
    event.preventDefault()
    console.log("votar down comment")
    let comment_id = event.target.parentNode.parentNode.parentNode.parentNode.getAttribute("data-id")
    
    let value = false
    sendAjaxRequest('put', '/question/answer/comment/' + comment_id + '/vote', {value:value}, voteCommentHandler);
}    

function voteCommentHandler() {  

    let response = JSON.parse(this.responseText)
    console.log(response)

    let comments = document.querySelectorAll("main#q_a_thread section.comments div.comment div.comment_opt")

    for (let comment of comments) {
        console.log(comment)

        if (response.value == true && comment.parentNode.getAttribute("data-id") === response.id_comment){

            console.log(response.value)

            let up = comment.querySelector("div.score i.upcomment")
            up.setAttribute("class", up.getAttribute("class") + " votedUp")

            let score = comment.querySelector("div.score span")
            score.innerHTML = response.score
  
            console.log(up)
            let down = comment.querySelector("div.score i.downcomment")
            let classes = down.getAttribute("class").split(" ")
            if (classes.includes("votedDown"))
                down.setAttribute("class", "fas fa-chevron-down canvote downcomment")    
        }
        else if (response.value == false && comment.parentNode.getAttribute("data-id") === response.id_comment){
            console.log("down handler")

            console.log(response.value)
            let down = comment.querySelector("div.score i.downcomment")
            console.log("votos comment")
            console.log(down)

            down.setAttribute("class", down.getAttribute("class") + " votedDown")

            let score = comment.querySelector("div.score span")
            score.innerHTML = response.score

            let up = comment.querySelector("div.score i.upcomment")
            let classes = up.getAttribute("class").split(" ")
            if (classes.includes("votedUp"))
            up.setAttribute("class", "fas fa-chevron-up canvote upcomment")    
        }   
        
    }
}

function removeVoteCommentHandler() {

    let response = JSON.parse(this.responseText)
    console.log(response)
    console.log("remover voto pq já tá votado")

    let comments = document.querySelectorAll("main#q_a_thread section.comments div.comment div.comment_opt")

    for (let comment of comments) {
        
            let score = comment.querySelector("div.score span")
            score.innerHTML = response.score
  
            let up = comment.querySelector("div.score i.upcomment")
            up.setAttribute("class", "fas fa-chevron-up canvote upcomment")    
       
            let down = comment.querySelector("div.score i.downcomment")
            down.setAttribute("class", "fas fa-chevron-down canvote downcomment") 
     
    }
}




// ---------------------------------------
// FAV ANSWER

let favAnswerButtons = document.querySelectorAll("main#q_a_thread section.answers div.signs div.star i.canelect")
for (let favAnswerButton of favAnswerButtons) favAnswerButton.addEventListener('click', clickedStar)

function clickedStar(event) {
    let classes = event.target.getAttribute("class").split(" ")
    if (!classes.includes("elected")) selectFavAnswer(event)
    else removeFavAnswer(event)
}

function selectFavAnswer(event) {
    let answerId = event.target.parentNode.parentNode.getAttribute("data-id")
    
    sendAjaxRequest('put', '/question/answer/' + answerId + '/favAnswer', {}, selectFavAnswerHandler);
}

function removeFavAnswer(event) {
    let answerId = event.target.parentNode.parentNode.getAttribute("data-id")
    
    sendAjaxRequest('delete', '/question/answer/' + answerId + '/favAnswer', {}, removeFavAnswerHandler);
}

function selectFavAnswerHandler() {
    let response = JSON.parse(this.responseText)
    let answers = document.querySelectorAll("main#q_a_thread section.answers div.answer_block")

    for (let answer of answers) {
        if (answer.getAttribute("data-id") === response.id){
            // Puts star yellow
            let star = answer.querySelector("div.signs div.star i")
            star.setAttribute("class", star.getAttribute("class") + " elected")
        }
        else {
            // Removes previous yellow star
            let star = answer.querySelector("div.signs div.star i")
            let classes = star.getAttribute("class").split(" ")
            if (classes.includes("elected"))
                star.setAttribute("class", "fas fa-star canelect")
        }
    }
}

function removeFavAnswerHandler() {
    let response = JSON.parse(this.responseText)
    let answers = document.querySelectorAll("main#q_a_thread section.answers div.answer_block")

    for (let answer of answers) {
        if (answer.getAttribute("data-id") === response.id){
            // Removes the yellow from the star
            let star = answer.querySelector("div.signs div.star i")
            star.setAttribute("class", "fas fa-star canelect")
        }
    }
}

/* ---------------------------------------- */
// EDIT

// Questions
let editQuestionButton = document.querySelector("main#q_a_thread div.question div.question_opt div.signs div.edit i")
if (editQuestionButton !== null) editQuestionButton.addEventListener('click', editQuestion1)

function editQuestion1(event) {
    // Remove Listeners
    event.target.removeEventListener('click', editQuestion1)

    // Put visible and invisible
    event.target.parentNode.parentNode.parentNode.parentNode.querySelector("div.question_body div.notedit").setAttribute("hidden", true)
    event.target.parentNode.parentNode.parentNode.parentNode.querySelector("div.question_body div.edit").removeAttribute("hidden")

    // Listeners to buttons
    event.target.parentNode.parentNode.parentNode.parentNode.querySelector("div.question_body div.edit div button[type='submit']").addEventListener('click', editQuestionDoneHandler)
    event.target.parentNode.parentNode.parentNode.parentNode.querySelector("div.question_body div.edit div button[type='button']").addEventListener('click', editQuestionCancelHandler)
}

function editQuestionCancelHandler(event) {
    // Remove Listeners
    event.target.removeEventListener('click', editQuestionCancelHandler)
    event.target.parentNode.querySelector("button[type='submit']").removeEventListener('click', editQuestionDoneHandler)

    // Put visible and invisible
    event.target.parentNode.parentNode.parentNode.setAttribute("hidden", true)
    event.target.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit").removeAttribute("hidden")

    // Reset content
    let titleInput = event.target.parentNode.parentNode.querySelector("div input[name='title']")
    let bodyInput = event.target.parentNode.parentNode.querySelector("div textarea[name='text']")
    if (titleInput != null) {
        titleInput.value = event.target.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit > h1").innerText
        bodyInput.value = event.target.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit > p").innerText
    }
    event.target.parentNode.parentNode.querySelector("div input[name='tags']").value = event.target.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit div#tags > p").innerText

    // Listener to button
    event.target.parentNode.parentNode.parentNode.parentNode.parentNode.querySelector("div.signs div.edit i").addEventListener('click', editQuestion1)
}

function editQuestionDoneHandler(event) {
    event.preventDefault()
    
    // Edit info
    let title =  null
    if (event.target.parentNode.parentNode.querySelector("div input[name='title']") !== null)
        title = event.target.parentNode.parentNode.querySelector("div input[name='title']").value
    let body =  null
    if (event.target.parentNode.parentNode.querySelector("div textarea[name='text']") !== null)
        body = event.target.parentNode.parentNode.querySelector("div textarea[name='text']").value
    let tags = event.target.parentNode.parentNode.querySelector("div input[name='tags']").value.replace(/  +/g, ' ')

    // Send request
    let question_id = event.target.parentNode.parentNode.parentNode.parentNode.parentNode.getAttribute("data-id")

    if(body !== null) sendAjaxRequest('post', '/question/' + question_id + '/edit', {title: title, text: body, tags: tags}, updateQuestionEditHandler)
    else sendAjaxRequest('post', '/question/' + question_id + '/edit', {tags: tags, isMod: true}, updateQuestionEditHandler)
}

function updateQuestionEditHandler() {
    let response = JSON.parse(this.responseText)
    let question = response[0]

    let doneButton = document.querySelector("main#q_a_thread div.question div.question_body div.edit form div button[type='submit']")

    // Remove Listeners
    doneButton.removeEventListener('click', editQuestionDoneHandler)
    doneButton.parentNode.querySelector("button[type='button']").removeEventListener('click', editQuestionCancelHandler)

    if (response.edited === true){
        // Put new info
        doneButton.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit h1").innerHTML = question.title
        doneButton.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit p.card-text").innerHTML = question.text
        addTags(doneButton.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit div#tags"), question.tags)
        doneButton.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit div.date p").innerHTML = ""
        doneButton.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit div.date p:last-child").innerHTML = '<small style="color: grey">Created at: ' + question.created_at + '</small><br>'
        doneButton.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit div.date p:last-child").innerHTML += '<small style="color: grey">Edited at: ' + question.edited_at + '</small>'

        // Reset content
        let titleInput = doneButton.parentNode.parentNode.querySelector("div input[name='title']")
        let bodyInput = doneButton.parentNode.parentNode.querySelector("div textarea[name='text']")
        if (titleInput != null) {
            titleInput.value = question.title
            bodyInput.value = question.text
        }
        doneButton.parentNode.parentNode.querySelector("div input[name='tags']").value = question.tags
        doneButton.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit div#tags > p").innerText = question.tags

        // Add Success Message
        let messages = doneButton.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.querySelector("div.messages")
        add_message(messages, "Question edited!")
    } else {
        let messages = doneButton.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.querySelector("div.messages")
        if(response.edited === "empty")
            add_message_failure(messages, "Question could not be edited! Please don't erase body and/or title.") 
        else if(response.edited === "duplicate")
            add_message_failure(messages, "Question could not be edited! Please don't put duplicate tags.") 
        else
            add_message_failure(messages, "Question could not be edited! Please try again.") 

        // Reset content
        let titleInput = doneButton.parentNode.parentNode.querySelector("div input[name='title']")
        let bodyInput = doneButton.parentNode.parentNode.querySelector("div textarea[name='text']")
        if (titleInput != null) {
            titleInput.value = doneButton.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit > h1").innerText
            bodyInput.value = doneButton.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit > p").innerText
        }
        doneButton.parentNode.parentNode.querySelector("div input[name='tags']").value = doneButton.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit div#tags > p").innerText
    }

    // Put visible and invisible
    doneButton.parentNode.parentNode.parentNode.setAttribute("hidden", true)
    doneButton.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit").removeAttribute("hidden")

    // Listener to button
    doneButton.parentNode.parentNode.parentNode.parentNode.parentNode.querySelector("div.signs div.edit i").addEventListener('click', editQuestion1)
}

function addTags(place, tags) {
    if (tags.trim() !== "") {
        // Remove previous tags
        let currTags = place.querySelectorAll("button")
        for (let tag of currTags)
            tag.remove()

        // Add new tags
        let tagsArray = tags.split(" ")
        for (let tag of tagsArray) {
            let newTag = document.createElement("button")
            newTag.setAttribute("class", "btn btn-light btn-sm tag")
            newTag.setAttribute("type", "button")
            newTag.innerHTML = tag
            newTag.addEventListener('click',searchByTag)

            place.appendChild(newTag)
        }
    } else {
        let currTags = place.querySelectorAll("button")
        for (let tag of currTags)
            tag.remove()
    }
}

// Answers
let editAnswerButtons = document.querySelectorAll("main#q_a_thread section.answers div.answer_opt div.signs div.edit i")
for (let editAnswerButton of editAnswerButtons) editAnswerButton.addEventListener('click', editAnswer1)

function editAnswer1(event) {
    // Remove Listeners
    event.target.removeEventListener('click', editAnswer1)

    // Put visible and invisible
    event.target.parentNode.parentNode.parentNode.parentNode.querySelector("div.answer_body div.notedit").setAttribute("hidden", true)
    event.target.parentNode.parentNode.parentNode.parentNode.querySelector("div.answer_body div.edit").removeAttribute("hidden")

    // Listeners to buttons
    event.target.parentNode.parentNode.parentNode.parentNode.querySelector("div.answer_body div.edit div button[type='submit']").addEventListener('click', editAnswerDoneHandler)
    event.target.parentNode.parentNode.parentNode.parentNode.querySelector("div.answer_body div.edit div button[type='button']").addEventListener('click', editAnswerCancelHandler)
}

function editAnswerCancelHandler(event) {
    // Remove Listeners
    event.target.removeEventListener('click', editAnswerCancelHandler)
    event.target.parentNode.querySelector("button[type='submit']").removeEventListener('click', editAnswerDoneHandler)

    // Put visible and invisible
    event.target.parentNode.parentNode.parentNode.setAttribute("hidden", true)
    event.target.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit").removeAttribute("hidden")

    // Reset content
    event.target.parentNode.parentNode.querySelector("div textarea").value = event.target.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit > p").innerText

    // Listener to button
    event.target.parentNode.parentNode.parentNode.parentNode.parentNode.querySelector("div.signs div.edit i").addEventListener('click', editAnswer1)
}

function editAnswerDoneHandler(event) {
    event.preventDefault()
    
    // Edit info
    let body = event.target.parentNode.parentNode.querySelector("div textarea[name='text']").value

    // Send request
    let answer_id = event.target.parentNode.parentNode.parentNode.parentNode.parentNode.getAttribute("data-id")
    sendAjaxRequest('post', '/question/answer/' + answer_id + '/edit', {text: body}, updateAnswerEditHandler);
}

function updateAnswerEditHandler() {
    let response = JSON.parse(this.responseText)
    let answerCont = response[0]

    let answers = document.querySelectorAll("main#q_a_thread section.answers div.answer")
    let doneButton = null
    for (let answer of answers) {
        if (answer.getAttribute("data-id") == answerCont.id){
            doneButton = answer.querySelector("div.answer_body div.edit button[type='submit']")
            break
        }
    }

    // Remove Listeners
    doneButton.removeEventListener('click', editAnswerDoneHandler)
    doneButton.parentNode.querySelector("button[type='button']").removeEventListener('click', editAnswerCancelHandler)

    if (response.edited === true){
        // Put new info
        doneButton.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit p.card-text").innerHTML = answerCont.text
        doneButton.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit div.date p").innerHTML = ""
        doneButton.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit div.date p:last-child").innerHTML = '<small style="color: grey">Created at: ' + answerCont.created_at + '</small><br>'
        doneButton.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit div.date p:last-child").innerHTML += '<small style="color: grey">Edited at: ' + answerCont.edited_at + '</small>'
    
        // Update content form
        doneButton.parentNode.parentNode.querySelector("div textarea").value = answerCont.text

        // Add Success Message
        let messages = doneButton.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.querySelector("div.messages")
        add_message(messages, "Answer edited!")
    }
    else {
        // Update content form
        doneButton.parentNode.parentNode.querySelector("div textarea").value = doneButton.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit > p").innerText
    }

    // Put visible and invisible
    doneButton.parentNode.parentNode.parentNode.setAttribute("hidden", true)
    doneButton.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit").removeAttribute("hidden")

    // Listener to button
    doneButton.parentNode.parentNode.parentNode.parentNode.parentNode.querySelector("div.signs div.edit i").addEventListener('click', editAnswer1)
}

// Comments
let editCommentButtons = document.querySelectorAll("main#q_a_thread section.answers section.comments div.comment_opt div.signs div.edit i")
for (let editCommentButton of editCommentButtons) editCommentButton.addEventListener('click', editComment1)

function editComment1(event) {
    // Remove Listeners
    event.target.removeEventListener('click', editComment1)

    // Put visible and invisible
    event.target.parentNode.parentNode.parentNode.parentNode.querySelector("div.comment_body div.notedit").setAttribute("hidden", true)
    event.target.parentNode.parentNode.parentNode.parentNode.querySelector("div.comment_body div.edit").removeAttribute("hidden")

    // Listeners to buttons
    event.target.parentNode.parentNode.parentNode.parentNode.querySelector("div.comment_body div.edit div button[type='submit']").addEventListener('click', editCommentDoneHandler)
    event.target.parentNode.parentNode.parentNode.parentNode.querySelector("div.comment_body div.edit div button[type='button']").addEventListener('click', editCommentCancelHandler)
}

function editCommentCancelHandler(event) {
    // Remove Listeners
    event.target.removeEventListener('click', editCommentCancelHandler)
    event.target.parentNode.querySelector("button[type='submit']").removeEventListener('click', editCommentDoneHandler)

    // Put visible and invisible
    event.target.parentNode.parentNode.parentNode.setAttribute("hidden", true)
    event.target.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit").removeAttribute("hidden")

    // Reset content
    event.target.parentNode.parentNode.querySelector("div textarea").value = event.target.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit > p").innerText

    // Listener to button
    event.target.parentNode.parentNode.parentNode.parentNode.parentNode.querySelector("div.signs div.edit i").addEventListener('click', editComment1)
}

function editCommentDoneHandler(event) {
    event.preventDefault()
    
    // Edit info
    let body = event.target.parentNode.parentNode.querySelector("div textarea[name='text']").value
    
    // Send request
    let comment_id = event.target.parentNode.parentNode.parentNode.parentNode.parentNode.getAttribute("data-id")
    sendAjaxRequest('post', '/question/answer/comment/' + comment_id +  '/edit', {text: body}, updateCommentEditHandler);
}

function updateCommentEditHandler() {
    let response = JSON.parse(this.responseText)
    let commentCont = response[0]

    let comments = document.querySelectorAll("main#q_a_thread section.answers section.comments div.comment")
    let doneButton = null
    for (let comment of comments) {
        if (comment.getAttribute("data-id") == commentCont.id){
            doneButton = comment.querySelector("div.comment_body div.edit button[type='submit']")
            break
        }
    }

    // Remove Listeners
    doneButton.removeEventListener('click', editCommentDoneHandler)
    doneButton.parentNode.querySelector("button[type='button']").removeEventListener('click', editCommentCancelHandler)

    if (response.edited === true) {
        // Put new info
        doneButton.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit p.card-text").innerHTML = commentCont.text
        doneButton.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit div.date p").innerHTML = ""
        doneButton.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit div.date p:last-child").innerHTML = '<small style="color: grey">Created at: ' + commentCont.created_at + '</small><br>'
        doneButton.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit div.date p:last-child").innerHTML += '<small style="color: grey">Edited at: ' + commentCont.edited_at + '</small>'

        // Update content form
        doneButton.parentNode.parentNode.querySelector("div textarea").value = commentCont.text

        // Add Success Message
        let messages = doneButton.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.querySelector("div.messages")
        add_message(messages, "Comment edited!")
    }
    else {
        // Update content form
        doneButton.parentNode.parentNode.querySelector("div textarea").value = doneButton.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit > p").innerText
    }

    // Put visible and invisible
    doneButton.parentNode.parentNode.parentNode.setAttribute("hidden", true)
    doneButton.parentNode.parentNode.parentNode.parentNode.querySelector("div.notedit").removeAttribute("hidden")

    // Listener to button
    doneButton.parentNode.parentNode.parentNode.parentNode.parentNode.querySelector("div.signs div.edit i").addEventListener('click', editComment1)
}

// Auxiliar para as mensagens
function add_message(spot, message) {
    let div = document.createElement("div")
    div.setAttribute("class", "offset-md-2 col-md-8 success")
    
    let cross = document.createElement("div")
    cross.setAttribute("class", "close_button")
    let crossElem = document.createElement("i")
    crossElem.setAttribute("class", "fas fa-times")
    cross.appendChild(crossElem)
    div.appendChild(cross)

    crossElem.addEventListener('click', close_message)

    let p = document.createElement("p")
    p.setAttribute("class", "text_message")
    p.innerHTML = message
    div.appendChild(p)

    spot.appendChild(div)
}

function add_message_failure(spot, message) {
    let div = document.createElement("div")
    div.setAttribute("class", "offset-md-2 col-md-8 failure")
    
    let cross = document.createElement("div")
    cross.setAttribute("class", "close_button")
    let crossElem = document.createElement("i")
    crossElem.setAttribute("class", "fas fa-times")
    cross.appendChild(crossElem)
    div.appendChild(cross)

    crossElem.addEventListener('click', close_message)

    let p = document.createElement("p")
    p.setAttribute("class", "text_message")
    p.innerHTML = message
    div.appendChild(p)

    spot.appendChild(div)
}

function close_message(event) {
    event.target.parentNode.parentNode.remove()
}