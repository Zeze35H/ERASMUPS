'use strict'

// let reportButtons = document.querySelectorAll("body main#q_a_thread div.reports img.reported")

// for(let reportButton of reportButtons)
//     reportButton.addEventListener('click', openPopUpReportWindow)

// function openPopUpReportWindow() {
//     let popUp = document.querySelector("body div#report_pop_up")
//     popUp.removeAttribute("hidden")
//     popUp.querySelector("div h3 span i#close").addEventListener('click', closePopUpReportWindow)
//     popUp.querySelector("div form div input[type='submit']").addEventListener('click', submitReport)
// }

// function closePopUpReportWindow(event) {
//     event.target.parentNode.parentNode.parentNode.parentNode.setAttribute("hidden", true)
//     let options = event.target.parentNode.parentNode.parentNode.querySelectorAll("form input[name='report']")
//     clearReportOptions(options)
// }

// function submitReport(event) {
//     event.preventDefault();
//     event.target.parentNode.parentNode.parentNode.parentNode.setAttribute("hidden", true)
//     let reportDoneWindow = event.target.parentNode.parentNode.parentNode.parentNode.parentNode.querySelector("div#report_pop_up_done")
//     reportDoneWindow.removeAttribute("hidden")
//     reportDoneWindow.querySelector("div div i#close").addEventListener('click', closePopUpReportDoneWindow)
//     reportDoneWindow.querySelector("div div button").addEventListener('click', closePopUpReportDoneWindow)
//     clearReportOptions(event.target.parentNode.parentNode.parentNode.querySelectorAll("form input[name='report']"))
// }

// function closePopUpReportDoneWindow(event) {
//     event.target.parentNode.parentNode.parentNode.setAttribute("hidden", true)
// }

// function clearReportOptions(options) {
//     for(let option of options)  if(option.getAttribute("select") !== null) option.removeAttribute("select")
// }

let reportButtons = document.querySelectorAll("body a.report_button i")
console.log(reportButtons)
for(let reportButton of reportButtons) reportButton.addEventListener('click', showUpReportInfo)

function showUpReportInfo(event) {
    console.log(event.target.parentNode.parentNode.querySelector("div.reportPopUpWindow div#going_to_report_window"))
    console.log(event.target.parentNode.parentNode.querySelector("div.reportPopUpWindow div#going_to_report_window").removeAttribute("hidden"))
    console.log(event.target.parentNode.parentNode.querySelector("div.reportPopUpWindow div#report_done_window"))
    event.target.parentNode.parentNode.querySelector("div.reportPopUpWindow div#report_done_window").setAttribute("hidden", true)
}

let acceptButtons = document.querySelectorAll("body div.reportPopUpWindow div#going_to_report_window div.modal-footer button")
for(let acceptButton of acceptButtons) acceptButton.addEventListener('click', thanksReportWindow)

function thanksReportWindow(event) {
    event.target.parentNode.parentNode.setAttribute("hidden", true)
    event.target.parentNode.parentNode.parentNode.querySelector("#report_done_window").removeAttribute("hidden")
}