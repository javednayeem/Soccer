$(document).ready(function() {

    $("#add_player_button").click(function(){

        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var team_id = $('#create_team_id').val();
        var phone_no = $('#phone_no').val();
        var email = $('#email').val();
        var nationality = $('#nationality').val();
        var position = $('#position').val();
        var jersey_number = $('#jersey_number').val();
        var height = $('#height').val();
        var weight = $('#weight').val();
        var date_of_birth = $('#date_of_birth').val();

        if (first_name != "" && team_id != "" && nationality != "" && position != "" && date_of_birth != "") {

            var formData = new FormData();
            formData.append("first_name", first_name);
            formData.append("last_name", last_name);
            formData.append("team_id", team_id);
            formData.append("phone_no", phone_no);
            formData.append("email", email);
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
        var phone_no = $('#edit_phone_no').val();
        var email = $('#edit_email').val();
        var nationality = $('#edit_nationality').val();
        var position = $('#edit_position').val();
        var jersey_number = $('#edit_jersey_number').val();
        var height = $('#edit_height').val();
        var weight = $('#edit_weight').val();
        var date_of_birth = $('#edit_date_of_birth').val();
        var player_status = $('#edit_player_status').val();
        var payment_status = $('#edit_payment_status').val();

        if (first_name != "" && team_id != "" && nationality != "" && position != "" && date_of_birth != "") {

            var formData = new FormData();

            formData.append("id", player_id);
            formData.append("first_name", first_name);
            formData.append("last_name", last_name);
            formData.append("team_id", team_id);
            formData.append("phone_no", phone_no);
            formData.append("email", email);
            formData.append("nationality", nationality);
            formData.append("position", position);
            formData.append("jersey_number", jersey_number);
            formData.append("height", height);
            formData.append("weight", weight);
            formData.append("date_of_birth", date_of_birth);
            formData.append("player_status", player_status);
            formData.append("payment_status", payment_status);
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


    $("#add_league_button").click(function(){

        var name = $('#name').val();
        var season = $('#season').val();
        var subtitle = $('#subtitle').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var is_active = $('#is_active').is(':checked') ? 1 : 0;

        if (name != "" && season != "" && start_date != "" && end_date != "") {

            showProcessingNotification();

            $.ajax({
                url: '/add/league',
                type: 'POST',
                data: {
                    name: name,
                    season: season,
                    subtitle: subtitle,
                    start_date: start_date,
                    end_date: end_date,
                    is_active: is_active,
                    "_token": $('#token').val()
                },
                success: function (response) {
                    showSuccessNotification('New League Added!');
                    $('#add_league_modal').modal('hide');
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


    $("#edit_league_button").click(function() {

        var league_id = $('#league_id').val();
        var name = $('#edit_name').val();
        var season = $('#edit_season').val();
        var subtitle = $('#edit_subtitle').val();
        var start_date = $('#edit_start_date').val();
        var end_date = $('#edit_end_date').val();
        var is_active = $('#edit_is_active').is(':checked') ? 1 : 0;

        if (name != "" && season != "" && start_date != "" && end_date != "") {
            showProcessingNotification();

            $.ajax({
                url: '/edit/league',
                type: 'POST',
                data: {
                    id: league_id,
                    name: name,
                    season: season,
                    subtitle: subtitle,
                    start_date: start_date,
                    end_date: end_date,
                    is_active: is_active,
                    "_token": $('#token').val()
                },
                success: function (response) {
                    showSuccessNotification('League Updated Successfully!');
                    $('#edit_league_modal').modal('hide');
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


    $("#add_match_button").click(function(){
        var league_id = $('#league_id').val();
        var home_team_id = $('#home_team_id').val();
        var away_team_id = $('#away_team_id').val();
        var match_date = $('#match_date').val();
        var match_time = $('#match_time').val();
        var venue = $('#venue').val();
        var status = $('#status').val();
        var home_team_score = $('#home_team_score').val();
        var away_team_score = $('#away_team_score').val();
        var match_week = $('#match_week').val();

        if (league_id != "" && home_team_id != "" && away_team_id != "" && match_date != "" && match_time != "" && venue != "" && status != "") {

            // Check if home and away teams are different
            if (home_team_id === away_team_id) {
                showErrorNotification('Home and Away teams cannot be the same!');
                return;
            }

            showProcessingNotification();

            $.ajax({
                url: '/add/match',
                type: 'POST',
                data: {
                    league_id: league_id,
                    home_team_id: home_team_id,
                    away_team_id: away_team_id,
                    match_date: match_date,
                    match_time: match_time,
                    venue: venue,
                    status: status,
                    home_team_score: home_team_score,
                    away_team_score: away_team_score,
                    match_week: match_week,
                    "_token": $('#token').val()
                },
                success: function (response) {
                    showSuccessNotification('New Match Added!');
                    $('#add_match_modal').modal('hide');
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


    $("#edit_match_button").click(function(){
        var match_id = $('#match_id').val();
        var league_id = $('#edit_league_id').val();
        var home_team_id = $('#edit_home_team_id').val();
        var away_team_id = $('#edit_away_team_id').val();
        var match_date = $('#edit_match_date').val();
        var match_time = $('#edit_match_time').val();
        var venue = $('#edit_venue').val();
        var status = $('#edit_status').val();
        var home_team_score = $('#edit_home_team_score').val();
        var away_team_score = $('#edit_away_team_score').val();
        var match_week = $('#edit_match_week').val();

        if (league_id != "" && home_team_id != "" && away_team_id != "" && match_date != "" && match_time != "" && venue != "" && status != "") {

            // Check if home and away teams are different
            if (home_team_id === away_team_id) {
                showErrorNotification('Home and Away teams cannot be the same!');
                return;
            }

            showProcessingNotification();

            $.ajax({
                url: '/edit/match',
                type: 'POST',
                data: {
                    id: match_id,
                    league_id: league_id,
                    home_team_id: home_team_id,
                    away_team_id: away_team_id,
                    match_date: match_date,
                    match_time: match_time,
                    venue: venue,
                    status: status,
                    home_team_score: home_team_score,
                    away_team_score: away_team_score,
                    match_week: match_week,
                    "_token": $('#token').val()
                },
                success: function (response) {
                    showSuccessNotification('Match Updated Successfully!');
                    $('#edit_match_modal').modal('hide');
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


    $("#add_user_button").click(function(){
        var name = $('#name').val().trim();
        var email = $('#email').val().trim();
        var password = $('#password').val();
        var role = $('#role').val();

        if (!name || !email || !password || !role) {
            showErrorNotification('Please fill all required fields');
            return;
        }

        if (password.length < 6) {
            showErrorNotification('Password must be at least 6 characters long');
            return;
        }

        var formData = new FormData();
        formData.append("name", name);
        formData.append("email", email);
        formData.append("password", password);
        formData.append("role", role);
        formData.append("phone", $('#phone').val().trim());
        formData.append("address", $('#address').val().trim());
        formData.append("user_image", $('#user_image')[0].files[0]);

        showProcessingNotification();

        $.ajax({
            url: '/add/user',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('#token').val()
            },
            success: function (response) {
                showSuccessNotification(response.message);
                $('#add_user_modal').modal('hide');
                reloadCurrentPage();
            },
            error: function (xhr) {
                showErrorNotification(error);
            }
        });
    });


    $("#edit_user_button").click(function(){

        var id = $('#user_id').val();
        var name = $('#edit_name').val().trim();
        var email = $('#edit_email').val().trim();
        var role = $('#edit_role').val();
        var team_id = $('#edit_team_id').val();

        if (!name || !email || !role) {
            showErrorNotification('Please fill all required fields');
            return;
        }

        var formData = new FormData();
        formData.append("id", id);
        formData.append("name", name);
        formData.append("email", email);
        formData.append("role", role);
        formData.append("team_id", team_id);
        formData.append("phone", $('#edit_phone').val().trim());
        formData.append("address", $('#edit_address').val().trim());
        formData.append("user_image", $('#edit_user_image')[0].files[0]);

        showProcessingNotification();

        $.ajax({
            url: '/edit/user',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('#token').val()
            },
            success: function (response) {
                showSuccessNotification(response.message);
                $('#edit_user_modal').modal('hide');
                reloadCurrentPage();
            },
            error: function (xhr) {
                showErrorNotification(error);
            }
        });
    });


    $("#change_password_button").click(function(){

        var userId = $('#password_user_id').val();
        var newPassword = $('#new_password').val();
        var confirmPassword = $('#new_password_confirmation').val();

        if (!newPassword) {
            showErrorNotification('Please enter a new password');
            return;
        }

        if (newPassword.length < 6) {
            showErrorNotification('Password must be at least 6 characters long');
            return;
        }

        if (newPassword !== confirmPassword) {
            showErrorNotification('Passwords do not match');
            return;
        }

        showProcessingNotification();

        $.ajax({
            url: '/change-password',
            type: 'POST',
            data: {
                user_id: userId,
                new_password: newPassword,
                new_password_confirmation: confirmPassword,
                "_token": $('#token').val()
            },
            success: function (response) {
                showSuccessNotification(response.message);
                $('#changePasswordModal').modal('hide');
            },
            error: function (xhr) {
                showErrorNotification();
            }
        });
    });


    $('#event_team_id').change(function() {

        var teamId = $(this).val();

        if (teamId) {
            // Show loading state
            $('#event_player_id').html('<option value="">Loading players...</option>');

            $.ajax({
                url: '/get/team/' + teamId + '/players',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('#token').val()
                },
                success: function(response) {

                    if (response.success && response.players.length > 0) {

                        var options = '<option value="">Select Player</option>';

                        response.players.forEach(function(player) {
                            options += '<option value="' + player.id + '">' + player.first_name + ' ' + player.last_name + ' (#' + (player.jersey_number || 'N/A') + ')' + '</option>';
                        });

                        $('#event_player_id').html(options);
                    }

                    else {
                        $('#event_player_id').html('<option value="">No active players found</option>');
                    }

                },
                error: function(error) {
                    $('#event_player_id').html('<option value="">Error loading players</option>');
                }
            });
        }

        else {
            $('#event_player_id').html('<option value="">Select Player</option>');
        }

    });


    $("#add_team_button").click(function(){

        var name = $('#name').val();
        var team_manager = $('#team_manager').val();
        var team_status = $('#team_status').val();

        if (name != "" && team_manager != "" && team_status != "") {

            var formData = new FormData();
            formData.append("name", name);
            formData.append("short_name", $('#short_name').val());
            formData.append("team_manager", team_manager);
            formData.append("manager_email", $('#manager_email').val());
            formData.append("manager_phone", $('#manager_phone').val());
            formData.append("note", $('#note').val());
            formData.append("payment_reference_number", $('#payment_reference_number').val());
            formData.append("team_status", team_status);
            formData.append("logo", $('#logo')[0].files[0]);
            formData.append("team_image", $('#team_image')[0].files[0]);

            showProcessingNotification();

            $.ajax({
                url: '/add/team',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('#token').val()
                },
                success: function (response) {
                    showSuccessNotification('New Team Added!');
                    $('#add_team_modal').modal('hide');
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


    $("#edit_team_button").click(function(){

        var team_id = $('#team_id').val();
        var name = $('#edit_name').val();
        var team_manager = $('#edit_team_manager').val();
        var team_status = $('#edit_team_status').val();

        if (name != "" && team_manager != "" && team_status != "") {

            var formData = new FormData();
            formData.append("id", team_id);
            formData.append("name", name);
            formData.append("short_name", $('#edit_short_name').val());
            formData.append("team_manager", team_manager);
            formData.append("manager_email", $('#edit_manager_email').val());
            formData.append("manager_phone", $('#edit_manager_phone').val());
            formData.append("note", $('#edit_note').val());
            formData.append("payment_reference_number", $('#edit_payment_reference_number').val());
            formData.append("team_status", team_status);
            formData.append("logo", $('#edit_logo')[0].files[0]);
            formData.append("team_image", $('#edit_team_image')[0].files[0]);

            showProcessingNotification();

            $.ajax({
                url: '/edit/team',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('#token').val()
                },
                success: function (response) {
                    showSuccessNotification('Team Info Updated!');
                    $('#edit_team_modal').modal('hide');
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


    $("#add_event_button").click(function(){

        var event_id = $('#event_id').val();
        var event_name = $('#event_name').val();
        var event_description = $('#summernote-editor').val();
        var event_date = $('#event_date').val();
        var status = $('#event_status').is(':checked')?1:0;
        var default_event = $('#default_event').is(':checked')?1:0;
        var featured_event = $('#featured_event').is(':checked')?1:0;

        if (event_name != "") {

            var formData = new FormData();
            formData.append("event_id", event_id);
            formData.append("event_name", event_name);
            formData.append("event_description", event_description);
            formData.append("event_date", event_date);
            formData.append("status", status);
            formData.append("default_event", default_event);
            formData.append("featured_event", featured_event);
            formData.append("event_image", $('#event_image')[0].files[0]);

            showProcessingNotification();

            $.ajax({
                url: '/add/event',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('#token').val()
                },
                success: function (response) {

                    if (event_id == '0') showSuccessNotification('New Event Created!');
                    else showSuccessNotification('Event Updated!');

                    reloadCurrentPage();

                },
                error: function (error) {
                    showErrorNotification();
                }
            });
        }
    });

});

function editPlayer(button) {

    $("#player_id").val(button.getAttribute('data-id'));
    $("#edit_first_name").val(button.getAttribute('data-first-name'));
    $("#edit_last_name").val(button.getAttribute('data-last-name'));
    $("#edit_team_id").val(button.getAttribute('data-team-id'));
    $("#edit_phone_no").val(button.getAttribute('data-phone-no') || '');
    $("#edit_email").val(button.getAttribute('data-email') || '');
    $("#edit_nationality").val(button.getAttribute('data-nationality'));
    $("#edit_position").val(button.getAttribute('data-position'));
    $("#edit_jersey_number").val(button.getAttribute('data-jersey-number') || '');
    $("#edit_height").val(button.getAttribute('data-height') || '');
    $("#edit_weight").val(button.getAttribute('data-weight') || '');

    var dateOfBirth = button.getAttribute('data-date-of-birth');
    $("#edit_date_of_birth").val(dateOfBirth);

    $("#edit_player_status").val(button.getAttribute('data-player-status'));
    $("#edit_payment_status").val(button.getAttribute('data-payment-status'));

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


function viewTeamPlayer(teamId) {
    // Show loading state
    $('#loadingPlayers').show();
    $('#teamPlayersContent').hide();
    $('#noPlayersMessage').hide();

    // Show modal
    $('#view_team_players_modal').modal('show');

    // Fetch team players via AJAX
    $.ajax({
        url: '/get/team/' + teamId + '/players',
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('#token').val()
        },
        success: function(response) {
            // Hide loading
            $('#loadingPlayers').hide();
            $('#teamPlayersContent').show();

            if (response.success) {
                // Update team name in title
                $('#teamNameTitle').text('Players of ' + response.teamName);

                // Clear previous data
                $('#teamPlayersTable').empty();

                if (response.players.length > 0) {
                    // Populate players table
                    $.each(response.players, function(index, player) {

                        var statusBadge = player.player_status == '1'
                            ? '<span class="badge badge-success">Active</span>'
                            : '<span class="badge badge-danger">Inactive</span>';

                        var playerRow =
                            '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td>' +
                            '<div class="d-flex align-items-center">' +
                            '<img src="/' + player.photo + '" alt="' + player.first_name + '" ' +
                            'class="rounded-circle mr-2" width="35" height="35" ' +
                            'onerror="this.onerror=null; this.src=\'/site/images/players/default_player.jpg\'">' +
                            '<div>' +
                            player.first_name + ' ' + player.last_name +
                            '</div>' +
                            '</div>' +
                            '</td>' +
                            '<td>' + player.position + '</td>' +
                            '<td>' + (player.jersey_number || 'N/A') + '</td>' +
                            '<td>' + player.nationality + '</td>' +
                            '<td>' + (player.phone_no || 'N/A') + '</td>' +
                            '<td>' + (player.email || 'N/A') + '</td>' +
                            '<td>' + statusBadge + '</td>' +
                            '</tr>';

                        $('#teamPlayersTable').append(playerRow);
                    });
                } else {
                    $('#noPlayersMessage').show();
                }
            } else {
                showErrorNotification('Failed to load players');
            }
        },
        error: function(error) {
            $('#loadingPlayers').hide();
            showErrorNotification('Error loading players');
            console.error('Error:', error);
        }
    });
}


function editLeague(button) {
    $("#league_id").val(button.getAttribute('data-id'));
    $("#edit_name").val(button.getAttribute('data-name'));
    $("#edit_season").val(button.getAttribute('data-season'));
    $("#edit_subtitle").val(button.getAttribute('data-subtitle'));
    $("#edit_start_date").val(button.getAttribute('data-start-date'));
    $("#edit_end_date").val(button.getAttribute('data-end-date'));

    if (button.getAttribute('data-is-active') == '1') {
        $('#edit_is_active').prop('checked', true);
    } else {
        $('#edit_is_active').prop('checked', false);
    }

    $('#edit_league_modal').modal('show');
}


function deleteLeague(league_id) {
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
            url: '/delete/league',
            type: 'POST',
            data: {
                league_id: league_id,
                "_token": $('#token').val()
            },
            success: function (response) {
                showSuccessNotification('League Has Been Deleted');
                $('#league_' + league_id).remove();
            },
            error: function (error) {
                showErrorNotification();
            }
        });
    });
}


function editMatch(button) {
    $("#match_id").val(button.getAttribute('data-id'));
    $("#edit_league_id").val(button.getAttribute('data-league-id'));
    $("#edit_home_team_id").val(button.getAttribute('data-home-team-id'));
    $("#edit_away_team_id").val(button.getAttribute('data-away-team-id'));
    $("#edit_match_date").val(button.getAttribute('data-match-date'));
    $("#edit_match_time").val(button.getAttribute('data-match-time'));
    $("#edit_venue").val(button.getAttribute('data-venue'));
    $("#edit_status").val(button.getAttribute('data-status'));
    $("#edit_home_team_score").val(button.getAttribute('data-home-team-score') || '');
    $("#edit_away_team_score").val(button.getAttribute('data-away-team-score') || '');
    $("#edit_match_week").val(button.getAttribute('data-match-week') || '');

    $('#edit_match_modal').modal('show');
}


function deleteMatch(match_id) {
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
            url: '/delete/match',
            type: 'POST',
            data: {
                match_id: match_id,
                "_token": $('#token').val()
            },
            success: function (response) {
                showSuccessNotification('Match Has Been Deleted');
                $('#match_' + match_id).remove();
            },
            error: function (error) {
                showErrorNotification();
            }
        });
    });
}


function editUser(id, name, email, user_image, role) {

    $('#user_id').val(id);
    $('#edit_name').val(name);
    $('#edit_email').val(email);
    $('#edit_role').val(role);
    $("#update_user_image").attr("src", '/images/users/' + user_image);

    $('#edit_user_modal').modal('show');
}


function deleteUser(id) {

    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonClass: 'btn btn-danger',
        cancelButtonClass: 'btn btn-success',
        buttonsStyling: false
    }).then(function () {

        var params = {
            id: id
        };

        $.ajax({
            url: '/delete/user',
            type: 'POST',
            format: 'JSON',
            data: {params: params, "_token": $('#token').val()},

            success: function (response) {
                $("#user_" + id).remove();
                showSuccessNotification('User Has Been Deleted!');
            },
            error: function (error) {
                showErrorNotification();
            }
        });

    });
}


function removeProfilePicture() {

    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonClass: 'btn btn-danger mr-2',
        cancelButtonClass: 'btn btn-success',
        buttonsStyling: false
    }).then(function () {


        $.ajax({
            url: '/remove/profilePicture',
            type: 'POST',
            format: 'JSON',
            data: {"_token": $('#token').val()},

            success: function (response) {
                showSuccessNotification('Profile Picture Removed, Default Picture Restored');
                reloadCurrentPage();
            },
            error: function (error) {
                showErrorNotification();
            }
        });

    });
}


function addEvent(matchId) {

    $('#event_match_id').val(matchId);
    $('#event_team_id').val('');
    $('#event_player_id').html('<option value="">Select Player</option>');
    $('#event_type').val('goal');
    $('#event_minute').val('');
    $('#event_description').val('');

    $('#addEventModal').modal('show');
}


function saveEvent() {

    var matchId = $('#event_match_id').val();
    var playerId = $('#event_player_id').val();
    var teamId = $('#event_team_id').val();
    var type = $('#event_type').val();
    var minute = $('#event_minute').val();
    var description = $('#event_description').val();

    //console.log('matchId: ' + matchId);

    if (!playerId || !teamId) {
        showErrorNotification('Please fill all required fields!');
        return;
    }

    showProcessingNotification();

    $.ajax({
        url: '/match/' + matchId + '/add-event',
        type: 'POST',
        data: {
            player_id: playerId,
            team_id: teamId,
            type: type,
            minute: minute,
            description: description,
            "_token": $('#token').val()
        },
        success: function (response) {
            showSuccessNotification(response.message);
            $('#addEventModal').modal('hide');
            reloadCurrentPage();
        },
        error: function () {
            showErrorNotification();
        }
    });

}


function quickGoal(matchId, teamId, playerId, eventType) {

    var matches = JSON.parse($('#live_matches_json').val());
    var match = null;
    if (playerId === undefined) playerId = 0;
    if (eventType === undefined) eventType = 'goal';

    for (var i = 0; i < matches.length; i++) {
        if (matches[i].id === matchId) {
            match = matches[i];
            break;
        }
    }

    if (!match) {
        //console.error('Match not found:', matchId);
        //return;
    }

    $('#event_match_id').val(matchId);
    $('#event_team_id').val(teamId);
    $('#event_type').val('goal');
    $('#event_minute').val('');
    $('#event_description').val('');

    $.ajax({
        url: '/get/team/' + teamId + '/players',
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('#token').val()
        },
        success: function(response) {

            var options = '<option value="">Select Player</option>';


            response.players.forEach(function(player) {

                //console.log('Player ID: ' + player.id + ' ===== Sent Player ID: ' + playerId);

                var selectedPlayerId = '';

                if (player.id == playerId) {
                    selectedPlayerId = 'selected';
                }
                options += '<option value="' + player.id + '" '+ selectedPlayerId +'>' + player.first_name + ' ' + player.last_name + '</option>';
            });

            $('#event_player_id').html(options);
            $('#event_type').val(eventType).trigger('change');
            $('#addEventModal').modal('show');
        },
        error: function(error) {

        }
    });
}


function deleteEvent(matchId, eventId) {
    swal({
        title: 'Are you sure?',
        text: "This event will be removed from the match!",
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
            url: '/match/' + matchId + '/delete-event',
            type: 'POST',
            data: {
                event_id: eventId,
                "_token": $('#token').val()
            },
            success: function (response) {
                showSuccessNotification(response.message);
                reloadCurrentPage();
            },
            error: function () {
                showErrorNotification();
            }
        });
    });
}


function finishMatch(matchId) {
    swal({
        title: 'Finish Match?',
        text: "This will mark the match as finished and update league standings!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, finish it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonClass: 'btn btn-success mr-2',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function () {
        showProcessingNotification();

        $.ajax({
            url: '/match/' + matchId + '/finish',
            type: 'POST',
            data: {
                "_token": $('#token').val()
            },
            success: function (response) {
                showSuccessNotification(response.message);
                reloadCurrentPage();
            },
            error: function () {
                showErrorNotification();
            }
        });
    });
}


function updateScore(matchId) {
    // Show loading state
    $('#updateScoreModal').modal('show');
    $('#score_loading').show();
    $('#score_content').hide();
    $('#motm_section').hide();

    // Load match details and players
    $.ajax({
        url: '/match/' + matchId + '/events',
        type: 'GET',
        success: function (response) {
            if (response.success) {
                var match = response.match;

                $('#score_match_id').val(matchId);
                $('#home_team_name').text(match.home_team.name);
                $('#away_team_name').text(match.away_team.name);
                $('#home_score').val(match.home_team_score ? match.home_team_score : 0);
                $('#away_score').val(match.away_team_score ? match.away_team_score : 0);

                // Load players for Man of the Match selection
                loadMatchPlayers(matchId);
            } else {
                showErrorNotification('Failed to load match details');
                $('#updateScoreModal').modal('hide');
            }
        },
        error: function () {
            showErrorNotification('Failed to load match details');
            $('#updateScoreModal').modal('hide');
        }
    });
}


function loadMatchPlayers(matchId) {
    $.ajax({
        url: '/match/' + matchId + '/players',
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('#token').val()
        },
        success: function (response) {
            if (response.success) {
                var options = '<option value="">Select Man of the Match</option>';

                if (response.players.length > 0) {
                    var currentTeam = '';

                    response.players.forEach(function(player) {
                        // Add team header if team changed
                        if (player.team_name !== currentTeam) {
                            currentTeam = player.team_name;
                            options += '<optgroup label="' + currentTeam + '">';
                        }

                        var selected = (player.id == response.current_motm) ? 'selected' : '';
                        options += '<option value="' + player.id + '" ' + selected + '>' +
                            player.first_name + ' ' + player.last_name +
                            ' (#' + (player.jersey_number || 'N/A') + ')' +
                            '</option>';
                    });

                    // Close the last optgroup
                    options += '</optgroup>';
                } else {
                    options += '<option value="" disabled>No players found</option>';
                }

                $('#man_of_the_match').html(options);

                // Show content
                $('#score_loading').hide();
                $('#score_content').show();
                $('#motm_section').show();
            } else {
                showErrorNotification('Failed to load players');
                $('#updateScoreModal').modal('hide');
            }
        },
        error: function () {
            showErrorNotification('Failed to load players');
            $('#updateScoreModal').modal('hide');
        }
    });
}


function saveScore() {
    var matchId = $('#score_match_id').val();
    var homeScore = $('#home_score').val();
    var awayScore = $('#away_score').val();
    var manOfTheMatch = $('#man_of_the_match').val();

    if (homeScore === '' || awayScore === '') {
        showErrorNotification('Please enter both scores');
        return;
    }

    showProcessingNotification();

    $.ajax({
        url: '/match/' + matchId + '/update-score',
        type: 'POST',
        data: {
            home_team_score: parseInt(homeScore),
            away_team_score: parseInt(awayScore),
            man_of_the_match: manOfTheMatch || null,
            "_token": $('#token').val()
        },
        success: function (response) {
            showSuccessNotification(response.message);
            $('#updateScoreModal').modal('hide');
            // Reload page to reflect changes
            setTimeout(function() {
                window.location.reload();
            }, 1000);
        },
        error: function (xhr) {
            var errorMessage = 'Failed to update score';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            showErrorNotification(errorMessage);
        }
    });
}


function viewMatchEvents(matchId) {

    $('#matchEventsModal').modal('show');
    $('#eventsLoading').show();
    $('#eventsContent').hide();
    $('#noEvents').hide();

    $.ajax({
        url: '/match/' + matchId + '/events',
        type: 'GET',
        success: function (response) {

            $('#eventsLoading').hide();

            if (response.success && response.match) {

                var match = response.match;

                $('#matchTitle').text(match.home_team.name + ' vs ' + match.away_team.name);
                $('#matchScore').text('Final Score: ' + (match.home_team_score || 0) + ' - ' + (match.away_team_score || 0));

                var resultHtml = '';

                if (match.home_team_score !== null && match.away_team_score !== null) {
                    if (match.home_team_score > match.away_team_score) resultHtml = '<span class="badge badge-success">Home Win</span>';
                    else if (match.away_team_score > match.home_team_score) resultHtml = '<span class="badge badge-success">Away Win</span>';
                    else resultHtml = '<span class="badge badge-info">Draw</span>';
                }

                else resultHtml = '<span class="badge badge-warning">Score Pending</span>';

                $('#matchResult').html(resultHtml);

                if (response.events && response.events.length > 0) {

                    var eventsHtml = '';

                    response.events.forEach(function(event) {

                        var badgeClass = '';
                        var eventText = '';

                        switch(event.type) {
                            case 'goal':
                                badgeClass = 'badge-success';
                                eventText = 'Goal';
                                break;
                            case 'assist':
                                badgeClass = 'badge-info';
                                eventText = 'Assist';
                                break;
                            case 'yellow_card':
                                badgeClass = 'badge-warning';
                                eventText = 'Yellow Card';
                                break;
                            case 'red_card':
                                badgeClass = 'badge-danger';
                                eventText = 'Red Card';
                                break;
                            case 'substitution_in':
                                badgeClass = 'badge-primary';
                                eventText = 'Sub In';
                                break;
                            case 'substitution_out':
                                badgeClass = 'badge-secondary';
                                eventText = 'Sub Out';
                                break;
                            default:
                                badgeClass = 'badge-light';
                                eventText = event.type;
                        }

                        eventsHtml +=
                            '<tr>' +
                            '<td>' + event.minute + '\'</td>' +
                            '<td>' +
                            (event.team_id === match.home_team_id ? match.home_team.name : match.away_team.name) +
                            '</td>' +
                            '<td>' + event.player.first_name + ' ' + (event.player.last_name || '') + '</td>' +
                            '<td><span class="badge ' + badgeClass + '">' + eventText + '</span></td>' +
                            '<td>' + (event.description || '-') + '</td>' +
                            '</tr>';
                    });

                    $('#eventsTableBody').html(eventsHtml);
                    $('#eventsContent').show();

                }

                else $('#noEvents').show();

            }

            else $('#noEvents').show();

        },

        error: function () {
            $('#eventsLoading').hide();
            showErrorNotification('Failed to load match events');
        }

    });
}


function changePasswordModal(userId, userName) {
    $('#password_user_id').val(userId);
    $('#changePasswordModal .modal-title').text('Change Password - ' + userName);
    $('#new_password').val('');
    $('#new_password_confirmation').val('');
    $('#changePasswordModal').modal('show');
}


function applyFilters() {

    var search = $('#searchInput').val();
    var role = $('#roleFilter').val();

    var url = new URL(window.location.href);
    var params = new URLSearchParams(url.search);

    if (search) params.set('search', search);
    else params.delete('search');

    if (role) params.set('role', role);
    else params.delete('role');

    window.location.href = url.pathname + '?' + params.toString();
}


function clearFilters() {
    window.location.href = window.location.pathname;
}


function editTeam(button) {
    $("#team_id").val(button.getAttribute('data-id'));
    $("#edit_name").val(button.getAttribute('data-name'));
    $("#edit_short_name").val(button.getAttribute('data-short-name') || '');
    $("#edit_team_manager").val(button.getAttribute('data-team-manager'));
    $("#edit_manager_email").val(button.getAttribute('data-manager-email') || '');
    $("#edit_manager_phone").val(button.getAttribute('data-manager-phone') || '');
    $("#edit_note").val(button.getAttribute('data-note') || '');
    $("#edit_payment_reference_number").val(button.getAttribute('data-payment-reference-number') || '');
    $("#edit_team_status").val(button.getAttribute('data-team-status'));

    var logoPath = button.getAttribute('data-logo');
    var teamImagePath = button.getAttribute('data-team-image');

    // Set logo preview
    if (logoPath && logoPath !== 'default_team.png') {
        // Check if path already contains the full URL
        if (logoPath.startsWith('http') || logoPath.startsWith('/')) {
            $("#edit_team_logo").attr("src", logoPath);
        } else {
            $("#edit_team_logo").attr("src", '/site/images/teams/' + logoPath);
        }
    } else {
        $("#edit_team_logo").attr("src", '/site/images/teams/default_team.png');
    }

    // Set team image preview
    if (teamImagePath && teamImagePath !== 'default_team_image.png') {
        // Check if path already contains the full URL
        if (teamImagePath.startsWith('http') || teamImagePath.startsWith('/')) {
            $("#edit_team_image_preview").attr("src", teamImagePath);
        } else {
            $("#edit_team_image_preview").attr("src", '/site/images/teams/' + teamImagePath);
        }
    } else {
        $("#edit_team_image_preview").attr("src", '/site/images/teams/default_team_image.png');
    }

    $('#edit_team_modal').modal('show');
}


function deleteTeam(team_id) {

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
            url: '/delete/team',
            type: 'POST',
            data: {
                team_id: team_id,
                "_token": $('#token').val()
            },
            success: function (response) {
                showSuccessNotification('Team Has Been Deleted');
                $('#team_' + team_id).remove();
            },
            error: function (error) {
                if (error.responseJSON && error.responseJSON.message) {
                    showErrorNotification(error.responseJSON.message);
                } else {
                    showErrorNotification();
                }
            }
        });

    });
}


function updateTeamActiveStatus(teamId) {
    var checkbox = $('#active_' + teamId);
    var isActive = checkbox.is(':checked') ? '1' : '0';
    var label = checkbox.next('label.form-check-label');

    showProcessingNotification();

    $.ajax({
        url: '/update/team-active-status',
        type: 'POST',
        data: {
            team_id: teamId,
            active: isActive,
            "_token": $('#token').val()
        },
        success: function (response) {
            showSuccessNotification('Team status updated successfully!');

            // Update the label text
            label.text(isActive === '1' ? 'Active' : 'Inactive');

            // Optional: Update row styling for visual feedback
            var teamRow = $('#team_' + teamId);
            if (isActive === '1') {
                teamRow.removeClass('bg-light');
                teamRow.find('.status-badge').removeClass('bg-secondary').addClass('bg-success');
            } else {
                teamRow.addClass('bg-light');
                teamRow.find('.status-badge').removeClass('bg-success').addClass('bg-secondary');
            }
        },
        error: function (xhr, status, error) {
            showErrorNotification('Failed to update team status!');

            // Revert the checkbox to its previous state
            checkbox.prop('checked', !checkbox.is(':checked'));

            // Revert the label text
            label.text(checkbox.is(':checked') ? 'Active' : 'Inactive');

            console.error('Error updating team status:', error);
        }
    });
}


function calculatePTS() {

    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, calculate it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonClass: 'btn btn-success mr-2',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function () {

        showProcessingNotification();

        $.ajax({
            url: '/calculate-pts',
            type: 'POST',
            data: {"_token": $('#token').val()},
            success: function (response) {
                showSuccessNotification('PTS Calculation Done!');
            },
            error: function (error) {

            }
        });

    });
}


function calculatePlayerStatistics() {

    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, calculate it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonClass: 'btn btn-success mr-2',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function () {

        showProcessingNotification();

        $.ajax({
            url: '/calculate-player-statistics',
            type: 'POST',
            data: {"_token": $('#token').val()},
            success: function (response) {
                showSuccessNotification('Player Statistics Calculation Done!');
            },
            error: function (error) {

            }
        });

    });
}


function createNewEvent() {

    $("#event_id").val(0);
    $("#event_name").val('');
    $("#event_description").val('');
    $("#event_date").val('');

    $("#event_image").attr("src", '/site/images/events/default_event.jpg');

    $('#event_status').prop('checked', true);

    $('#modal_title').text('Add New Event');
    $('#add_event_modal').modal('show');
}


function editEvent(button) {

    var event_id = button.getAttribute('data-id');
    var event_name = button.getAttribute('data-name');
    var event_description = button.getAttribute('data-description');
    var event_image = button.getAttribute('data-image');
    var event_date = button.getAttribute('data-date');
    var status = button.getAttribute('data-status');
    var default_event = button.getAttribute('data-default-event');
    var featured_event = button.getAttribute('data-featured-event');

    // Populate the modal with the event data
    $("#event_id").val(event_id);
    $("#event_name").val(event_name);
    $("#event_date").val(event_date);

    // Use summernote's API to set the content
    $('#summernote-editor').summernote('code', event_description);

    $("#add_event_image").attr("src", '/site/images/events/' + event_image);

    if (status == '1') $('#event_status').prop('checked', true);
    else $('#event_status').prop('checked', false);

    if (default_event == '1') $('#default_event').prop('checked', true);
    else $('#default_event').prop('checked', false);

    if (featured_event == '1') $('#featured_event').prop('checked', true);
    else $('#featured_event').prop('checked', false);

    $('#modal_title').text('Edit Event');
    $('#add_event_modal').modal('show');
}


function destroyEvent(event_id) {

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

        var params = {
            event_id: event_id
        };

        showProcessingNotification();

        $.ajax({
            url: '/delete/event',
            type: 'POST',
            format: 'JSON',
            data: {params: params, "_token": $('#token').val()},

            success: function (response) {
                showSuccessNotification('Event Has Been Deleted');
                $('#event_' + event_id).remove();
            },
            error: function (error) {
                showErrorNotification();
            }
        });

    });

}


function updateTransferStatus(id, transfer_status) {

    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, ' +transfer_status,
        cancelButtonText: 'No, cancel!',
        confirmButtonClass: 'btn btn-success mr-2',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function () {

        showProcessingNotification();

        $.ajax({
            url: '/update/transfer-status',
            type: 'POST',
            data: {
                id: id,
                transfer_status: transfer_status,
                "_token": $('#token').val()
            },
            success: function (response) {
                showSuccessNotification(response.message);
                $('#player_transfer_' + id).remove();
            },
            error: function (error) {

            }
        });

    });
}
