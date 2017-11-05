$(document).ready(function () {

    // Prompt before delete the selected worker
    
    $('#clear1').click(function (e) {
            
            var r = confirm("Are you sure you want to delete selected workers?");
            if (r == false) {
                $("#updateForm").submit(function (e) {
                    e.preventDefault();
                });
            } else {
                document.getElementById("delitem").textContent = "This is some text";
            }
    });

});

