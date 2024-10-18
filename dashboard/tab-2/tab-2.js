// Get modal element
var modal = document.getElementById("updateModal");
var closeModal = document.getElementsByClassName("close")[0];

// Function to open modal and fill it with data
function openUpdateModal(employee) {
    document.getElementById("employeeId").value = employee.id;
    document.getElementById("employeeName").value = employee.name;
    document.getElementById("employeeEmail").value = employee.email;
    document.getElementById("employeePhone").value = employee.phone;
    document.getElementById("employeePosition").value = employee.position;

    modal.style.display = "block";
}

// Close modal when (x) is clicked
closeModal.onclick = function() {
    modal.style.display = "none";
}

// Close modal when clicking anywhere outside of the modal
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}


document.getElementById("updateForm").onsubmit = function(event) {
    event.preventDefault();
    modal.style.display = "none";
}


document.getElementById("deleteButton").onclick = function() {

    modal.style.display = "none";
}
