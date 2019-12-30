function showDeleteP() {
    var deleteButton = document.getElementById("delete-confirmation");
    var deleteButtonP = document.getElementById("delete-button-P");
    deleteButtonP.style.display = "none";
    deleteButton.style.display = "block";
}

function addDeleteEvent() {
    document.getElementById("delete-button").addEventListener("click", showDeleteP );
}

addDeleteEvent();