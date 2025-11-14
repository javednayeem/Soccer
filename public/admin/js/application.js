$(document).ready(function() {

    $("#add_player_button").click(function(){

        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var team_id = $('#team_id').val();
        var nationality = $('#nationality').val();
        var position = $('#position').val();
        var jersey_number = $('#jersey_number').val();
        var height = $('#height').val();
        var weight = $('#weight').val();
        var date_of_birth = $('#date_of_birth').val();

        if (first_name != "" && last_name != "" && team_id != "" && nationality != "" && position != "" && date_of_birth != "") {

            var formData = new FormData();
            formData.append("first_name", first_name);
            formData.append("last_name", last_name);
            formData.append("team_id", team_id);
            formData.append("nationality", nationality);
            formData.append("position", position);
            formData.append("jersey_number", jersey_number);
            formData.append("height", height);
            formData.append("weight", weight);
            formData.append("date_of_birth", date_of_birth);
            formData.append("photo", $('#photo')[0].files[0]);

            showProcessingNotification();

            $.ajax({
                url: '/add/player',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('#token').val()
                },
                success: function (response) {
                    showSuccessNotification('New Player Added!');
                    $('#add_player_modal').modal('hide');
                    reloadCurrentPage();
                },
                error: function (error) {
                    showErrorNotification();
                }
            });
        } else {
            showErrorNotification('Please fill all required fields!');
        }
    });


    $("#edit_player_button").click(function(){

        var player_id = $('#player_id').val();
        var first_name = $('#edit_first_name').val();
        var last_name = $('#edit_last_name').val();
        var team_id = $('#edit_team_id').val();
        var nationality = $('#edit_nationality').val();
        var position = $('#edit_position').val();
        var jersey_number = $('#edit_jersey_number').val();
        var height = $('#edit_height').val();
        var weight = $('#edit_weight').val();
        var date_of_birth = $('#edit_date_of_birth').val();

        if (first_name != "" && last_name != "" && team_id != "" && nationality != "" && position != "" && date_of_birth != "") {

            var formData = new FormData();
            formData.append("id", player_id);
            formData.append("first_name", first_name);
            formData.append("last_name", last_name);
            formData.append("team_id", team_id);
            formData.append("nationality", nationality);
            formData.append("position", position);
            formData.append("jersey_number", jersey_number);
            formData.append("height", height);
            formData.append("weight", weight);
            formData.append("date_of_birth", date_of_birth);
            formData.append("photo", $('#edit_photo')[0].files[0]);

            showProcessingNotification();

            $.ajax({
                url: '/edit/player',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('#token').val()
                },
                success: function (response) {
                    showSuccessNotification('Player Info Updated!');
                    $('#edit_player_modal').modal('hide');
                    reloadCurrentPage();
                },
                error: function (error) {
                    showErrorNotification();
                }
            });
        } else {
            showErrorNotification('Please fill all required fields!');
        }
    });

});

function editPlayer(button) {
    $("#player_id").val(button.getAttribute('data-id'));
    $("#edit_first_name").val(button.getAttribute('data-first-name'));
    $("#edit_last_name").val(button.getAttribute('data-last-name'));
    $("#edit_team_id").val(button.getAttribute('data-team-id'));
    $("#edit_nationality").val(button.getAttribute('data-nationality'));
    $("#edit_position").val(button.getAttribute('data-position'));
    $("#edit_jersey_number").val(button.getAttribute('data-jersey-number'));
    $("#edit_height").val(button.getAttribute('data-height'));
    $("#edit_weight").val(button.getAttribute('data-weight'));
    $("#edit_date_of_birth").val(button.getAttribute('data-date-of-birth'));

    var photoPath = button.getAttribute('data-photo');
    $("#edit_player_photo").attr("src", photoPath ? '/' + photoPath : '/site/images/players/default_player.jpg');

    $('#edit_player_modal').modal('show');
}


function deletePlayer(player_id) {
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonClass: 'btn btn-success mr-2',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function () {

        showProcessingNotification();

        $.ajax({
            url: '/delete/player',
            type: 'POST',
            data: {
                player_id: player_id,
                "_token": $('#token').val()
            },
            success: function (response) {
                showSuccessNotification('Player Has Been Deleted');
                $('#player_' + player_id).remove();
            },
            error: function (error) {
                showErrorNotification();
            }
        });

    });
}


function viewSelectedImage(input, imageId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#' + imageId).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}


function showProcessingNotification() {

    $.toast({
        heading: '<h5 class="text-white"><i class="mdi mdi-spin mdi-loading mr-2"></i>Checking...</h5>',
        text: '<h5 class="mt-2 text-white">Processing Your Request</h5>',
        // icon: 'success',
        bgColor: '#E67E22',
        showHideTransition: 'slide',
        allowToastClose: false,
        //hideAfter: 10000,
        hideAfter: false,
        //autoHide: true,
        //loader: true,
        position: 'top-right',
    });

}


function showSuccessNotification(message) {

    $.toast().reset('all');

    $.toast({
        heading: '<h5 class="text-white">Done!</h5>',
        text: '<h5 class="mt-2 text-white">'+message+'</h5>',
        icon: 'success',
        showHideTransition: 'slide',
        //bgColor: 'green',
        //textColor: '#eee',
        allowToastClose: false,
        hideAfter: 3000,
        loader: true,
        position: 'top-right',
    });

}


function showWarningNotification(message) {

    $.toast().reset('all');

    $.toast({
        heading: '<h5 class="text-white">Warning!</h5>',
        text: '<h5 class="mt-2 text-white">'+message+'</h5>',
        icon: 'warning',
        showHideTransition: 'slide',
        //bgColor: 'green',
        //textColor: '#eee',
        allowToastClose: false,
        hideAfter: 3000,
        loader: true,
        position: 'top-right',
    });

}


function showErrorNotification(message) {

    $.toast().reset('all');

    message = typeof message !== 'undefined' ? message : 'Something Went Wrong!';

    $.toast({
        heading: '<h5 class="text-white">Error!</h5>',
        text: '<h5 class="mt-2 text-white">'+message+'</h5>',
        icon: 'error',
        showHideTransition: 'slide',
        //bgColor: 'green',
        //textColor: '#eee',
        allowToastClose: false,
        hideAfter: 3000,
        loader: true,
        position: 'top-right',
    });

}


function reloadCurrentPage() {
    window.location = window.location.pathname;
}
