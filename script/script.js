/***********************|
|    GLOBAL VARIABLE    |
|***********************/
var formstat = false;

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

function popup_form(){
    document.getElementById("popup_form").style.display = "flex";
}

/**********************|
|    AUTO OPEN POPUP   |
|**********************/
function auto_open_popup(id){
    if(formstat == false){
        document.getElementById(id).style.display = "flex";
    }
    else{
        document.getElementById(id).style.display = "none";
    }
}

function auto_popup_message(text) {
    formstat = true;
    document.getElementById("popup_message").innerText = text;
    document.getElementById("popup").style.display = "flex";
}

/***********************|
|       RESET FORM      |
|***********************/
function reset_form(text) {
    var form = document.getElementById(text);
    form.reset();
}