function addClickEvent( length ) {
    for ( let i = 0; i < length; i++) {
        edit[i].addEventListener( "click", (e) => editClick(i) );
        deleteButton[i].addEventListener( "click", (e) => deleteClick(i) );
        cancelEdit[i].addEventListener( "click", (e) => cancelEditClick(i) );
        cancelDelete[i].addEventListener( "click", (e) => cancelDeleteClick(i) );
    }
}


function editClick( i ) {
    form[i].style.display = "block";
    edit[i].style.display = "none";
    deleteButton[i].style.display = "none";
}


function cancelEditClick( i ) {
    form[i].style.display = "none";
    edit[i].style.display = "block";
    deleteButton[i].style.display = "block";
}


function deleteClick( i ) {
    deleteButton[i].style.display = "none";
    deleteConfirmation[i].style.display = "block";
    edit[i].style.display = "none";
}


function cancelDeleteClick( i ) {
    edit[i].style.display = "block";
    deleteButton[i].style.display = "block";
    deleteConfirmation[i].style.display = "none";
}


var edit = document.getElementsByClassName("editButton");
var form = document.getElementsByClassName("editComment");
var cancelEdit = document.getElementsByClassName("cancelEdit");
var cancelDelete = document.getElementsByClassName("cancelDelete");
var deleteButton = document.getElementsByClassName("delete-button");
var deleteConfirmation = document.getElementsByClassName("delete-confirmation");

var editLength = edit.length

// START
addClickEvent( editLength );