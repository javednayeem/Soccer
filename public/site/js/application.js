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

    $('#transferRequestForm').on('submit', function(e) {
        e.preventDefault();

        // Reset UI
        $('#successMessage, #errorMessage, #pendingWarning').addClass('d-none');
        $('#submitBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Submitting...');

        $.ajax({
            url: "{{ route('transfer.request.submit') }}",
            type: "POST",
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {

                $('#submitBtn').prop('disabled', false).html('<i class="fas fa-paper-plane me-1"></i> Submit Transfer Request');

                if (response.success) {
                    $('#successText').text(response.message);
                    $('#successMessage').removeClass('d-none');
                    $('#transferRequestForm')[0].reset();
                    $('#player_id').prop('disabled', true).html('<option selected disabled>-- Select Your Name --</option>');
                }
            },

            error: function(xhr) {

                $('#submitBtn').prop('disabled', false).html('<i class="fas fa-paper-plane me-1"></i> Submit Transfer Request');

                let response = xhr.responseJSON;

                if (xhr.status === 409) {
                    $('#pendingText').text(response.message);
                    $('#pendingWarning').removeClass('d-none');
                }
                else if (xhr.status === 422) {
                    let firstError = Object.values(response.errors)[0][0];
                    $('#errorText').text(firstError);
                    $('#errorMessage').removeClass('d-none');
                }
                else {
                    $('#errorText').text(response.message ?? 'Something went wrong. Please try again.');
                    $('#errorMessage').removeClass('d-none');
                }
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