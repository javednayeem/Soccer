$(document).on('click', '.player-detail-btn', function(e) {
    e.preventDefault();
    var playerId = $(this).data('player-id');
    console.log('Player ID clicked:', playerId);

    $('#playerModal').modal('show');

    loadPlayerDetails(playerId);
});


$(document).ready(function() {

    $('#from_team_id').change(function() {
        var from_team_id = $('#from_team_id').val();
        loadPlayers(from_team_id);
    });


    $("#submit_transfer_request").click(function(){

        var player_id = $('#player_id').val();
        var from_team_id = $('#from_team_id').val();
        var to_team_id = $('#to_team_id').val();
        var transfer_notes = $('#transfer_notes').val();

        $.ajax({
            url: '/transfer-request',
            type: 'POST',
            data: {
                player_id: player_id,
                from_team_id: from_team_id,
                to_team_id: to_team_id,
                transfer_notes: transfer_notes,
                "_token": $('#token').val()
            },
            success: function (response) {

                if (response.status === 'success') {

                    alert(response.message)

                }

                else alert(response.message);

            },
            error: function (error) {
                showErrorNotification();
            }
        });

    });

});


$('#playerModal').on('hidden.bs.modal', function() {

    var playerModalBodyContent = '<div class="text-center py-5">' +
        '<div class="spinner-border text-primary" role="status">' +
        '<span class="sr-only">Loading...</span>' +
        '</div></div>';

    $('#playerModalBody').html(playerModalBodyContent);

});


function loadPlayerDetails(playerId) {

    var playerModalBodyContent = '<div class="text-center py-5">' +
        '<div class="spinner-border text-primary" role="status">' +
        '<span class="sr-only">Loading...</span></div>' +
        '<p class="mt-2 text-muted">Loading player details...</p></div>';

    $('#playerModalBody').html(playerModalBodyContent);
    $('#playerModal').modal('show');

    $.ajax({
        url: '/player/' + playerId,
        type: 'GET',
        success: function(response) {
            $('#playerModalBody').html(response);
        },
        error: function(xhr, status, error) {
            var errorMessageContent = '<div class="text-center py-5">' +
                '<p class="text-danger">Error loading player details. Please try again.</p>' +
                '<small class="text-muted">Error: ' + error + '</small></div>';
            $('#playerModalBody').html(errorMessageContent);
        }
    });
}


function loadPlayers(teamId) {

    $('#player_id').prop('disabled', true).html('<option selected disabled>-- Select Your Name --</option>');
    $('#noPlayers').hide();
    $('#playerLoading').show();

    if (!teamId) {
        $('#playerLoading').hide();
        return;
    }

    $.ajax({
        url: '/get/team/' + teamId + '/players',
        type: 'GET',
        dataType: 'json',
        success: function(response) {

            $('#playerLoading').hide();

            if (response.success && response.players.length > 0) {

                $('#player_id').prop('disabled', false);

                $.each(response.players, function(index, player) {
                    $('#player_id').append('<option value="'+ player.id +'">'+ player.first_name +' '+ player.last_name +' (#'+ player.jersey_number +')</option>');
                });

            } else {
                $('#noPlayers').show();
            }
        },
        error: function() {
            $('#playerLoading').hide();
            $('#noPlayers').show();
        }
    });
}
