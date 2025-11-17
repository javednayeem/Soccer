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


    $("#edit_league_button").click(function(){
        var league_id = $('#league_id').val();
        var name = $('#edit_name').val();
        var season = $('#edit_season').val();
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

        var name = $('#name').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var role = $('#role').val();
        var designation = $('#designation').val();
        var responsibility = $('#responsibility').val();

        if (name != "") {

            var formData = new FormData();
            formData.append("name", name);
            formData.append("email", email);
            formData.append("password", password);
            formData.append("role", role);
            formData.append("designation", designation);
            formData.append("responsibility", responsibility);
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
                    showSuccessNotification('New User Added!');
                    reloadCurrentPage();
                },
                error: function (error) {
                    showErrorNotification();
                }
            });
        }
    });


    $("#edit_user_button").click(function(){

        var id = $('#user_id').val();
        var name = $('#edit_name').val();
        var email = $('#edit_email').val();
        var role = $('#edit_role').val();
        var designation = $('#edit_designation').val();
        var responsibility = $('#edit_responsibility').val();

        if (name != "") {

            var formData = new FormData();
            formData.append("id", id);
            formData.append("name", name);
            formData.append("email", email);
            formData.append("role", role);
            formData.append("designation", designation);
            formData.append("responsibility", responsibility);
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
                    showSuccessNotification('User Updated!');
                    reloadCurrentPage();
                },
                error: function (error) {
                    showErrorNotification();
                }
            });
        }
    });


    $('#event_team_id').change(function() {
        var teamId = $(this).val();

        if (teamId) {
            $.ajax({
                url: '/team/' + teamId + '/players',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('#token').val()
                },
                success: function(response) {
                    var options = '<option value="">Select Player</option>';

                    response.players.forEach(function(player) {
                        options += '<option value="' + player.id + '">' + player.first_name + ' ' + player.last_name + '</option>';
                    });

                    $('#event_player_id').html(options);
                },
                error: function(error) {
                    console.error('Error loading players:', error);
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
        url: '/team/' + teamId + '/players',
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


function editUser(id, name, email, user_image, role, designation, responsibility) {

    $('#user_id').val(id);
    $('#edit_name').val(name);
    $('#edit_email').val(email);
    $('#edit_role').val(role);
    $('#edit_designation').val(designation);
    $('#edit_responsibility').val(responsibility);

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


function updateScore(matchId) {

    var matches = JSON.parse($('#live_matches_json').val());
    var match = null;

    // Find match manually (ES5 compatible)
    for (var i = 0; i < matches.length; i++) {
        if (matches[i].id == matchId) {
            match = matches[i];
            break;
        }
    }

    if (!match) {
        console.error('Match not found:', matchId);
        return;
    }

    $('#score_match_id').val(matchId);
    $('#home_team_name').text(match.home_team.name);
    $('#away_team_name').text(match.away_team.name);
    $('#home_score').val(match.home_team_score ? match.home_team_score : 0);
    $('#away_score').val(match.away_team_score ? match.away_team_score : 0);

    $('#updateScoreModal').modal('show');
}


function saveScore() {
    const matchId = $('#score_match_id').val();
    const homeScore = $('#home_score').val();
    const awayScore = $('#away_score').val();

    showProcessingNotification();

    $.ajax({
        url: '/match/' + matchId + '/update-score',
        type: 'POST',
        data: {
            home_team_score: homeScore,
            away_team_score: awayScore,
            "_token": $('#token').val()
        },
        success: function (response) {
            showSuccessNotification(response.message);
            $('#updateScoreModal').modal('hide');

            $('#home_score_' + matchId).text(homeScore);
            $('#away_score_' + matchId).text(awayScore);
        },
        error: function () {
            showErrorNotification();
        }
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
    const matchId = $('#event_match_id').val();
    const playerId = $('#event_player_id').val();
    const teamId = $('#event_team_id').val();
    const type = $('#event_type').val();
    const minute = $('#event_minute').val();
    const description = $('#event_description').val();

    if (!playerId || !teamId || !minute) {
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


function quickGoal(matchId, teamId) {

    var matches = JSON.parse($('#live_matches_json').val());
    var match = null;

    // Manual find() replacement
    for (var i = 0; i < matches.length; i++) {
        if (matches[i].id == matchId) {
            match = matches[i];
            break;
        }
    }

    if (!match) {
        console.error('Match not found:', matchId);
        return;
    }

    $('#event_match_id').val(matchId);
    $('#event_team_id').val(teamId);
    $('#event_type').val('goal');
    $('#event_minute').val('');
    $('#event_description').val('');

    // Load players for selected team
    $.ajax({
        url: '/team/' + teamId + '/players',
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('#token').val()
        },
        success: function(response) {
            var options = '<option value="">Select Player</option>';

            response.players.forEach(function(player) {
                options += '<option value="' + player.id + '">' +
                    player.first_name + ' ' + player.last_name +
                    '</option>';
            });

            $('#event_player_id').html(options);
            $('#addEventModal').modal('show');
        },
        error: function(error) {
            console.error('Error loading players:', error);
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


setInterval(function() {
    if (window.location.pathname.indexOf('live-matches') !== -1) {
        reloadCurrentPage();
    }
}, 30000);
