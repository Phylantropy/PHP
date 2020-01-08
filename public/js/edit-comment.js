function addClickEvent( length ) {
    for ( let i = 0; i < length; i++) {
        edit[i].addEventListener( "click", (e) => form[i].style.display = "block" );
        edit[i].addEventListener( "click", (e) => edit[i].style.display = "none" );

        deleteButton[i].addEventListener( "click", (e) => deleteButton[i].style.display = "none" );
        deleteButton[i].addEventListener( "click", (e) => deleteConfirmation[i].style.display = "block" );
    }
}

var edit = document.getElementsByClassName("editButton");
var form = document.getElementsByClassName("editComment");
var deleteButton = document.getElementsByClassName("delete-button-P");
var deleteConfirmation = document.getElementsByClassName("delete-confirmation");

var editLength = edit.length

// START
addClickEvent( editLength );