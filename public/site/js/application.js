$(document).on('click', '.player-detail-btn', function(e) {
    e.preventDefault();
    var playerId = $(this).data('player-id');
    console.log('Player ID clicked:', playerId);

    $('#playerModal').modal('show');

    loadPlayerDetails(playerId);
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
