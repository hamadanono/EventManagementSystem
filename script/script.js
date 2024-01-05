/***********************|
|    GLOBAL FUNCTION    |
|***********************/
function popup_message(text) {
    document.getElementById("popup_message").innerText = text;
    document.getElementById("popup").style.display = "flex";
}

function popup_page_stay(text) {
    document.getElementById("popup_message_stay").innerText = text;
    document.getElementById("popup_page_stay").style.display = "flex";
}