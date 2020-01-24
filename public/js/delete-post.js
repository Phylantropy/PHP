function deleteClick() {
    editButton.style.display = "none";
    deleteButton.style.display = "none";
    deleteConfirmation.style.display = "block";
}

function cancelDeleteClick() {
    editButton.style.display = "block";
    deleteButton.style.display = "block";
    deleteConfirmation.style.display = "none";
}


function addDeleteEvent() {
    deleteButton.addEventListener("click", (e) => deleteClick() );
    cancelDelete.addEventListener( "click", (e) => cancelDeleteClick() );
}


var editButton = document.getElementById("editButton");
var deleteButton = document.getElementById("delete-button");
var cancelDelete = document.getElementById("cancelDelete");
var deleteConfirmation = document.getElementById("delete-confirmation");

//START
addDeleteEvent();