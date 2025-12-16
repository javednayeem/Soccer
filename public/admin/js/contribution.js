$(document).ready(function () {

    $("#contribution_year").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years"
    });

    $('#team_filter').change(function () {

        var teamId = $(this).val();
        $('#select_all').prop('checked', false);

        if (teamId === '') {
            $('#player_table_body').html('');
            return;
        }

        $.ajax({
            url: '/get/team/' + teamId + '/players',
            method: 'GET',
            success: function (res) {

                if (!res.success) {
                    alert('Failed to load players');
                    return;
                }

                var html = '';

                if (res.players.length === 0) {
                    html += '<tr>';
                    html += '<td colspan="6" class="text-center text-muted">';
                    html += 'No active players found';
                    html += '</td>';
                    html += '</tr>';
                }

                $.each(res.players, function (index, player) {

                    html += '<tr>';

                    html += '<td>';
                    html += '<div class="custom-control custom-checkbox">';
                    html += '<input type="checkbox" class="custom-control-input player_checkbox" ';
                    html += 'id="player_' + player.id + '" value="' + player.id + '">';
                    html += '<label class="custom-control-label" for="player_' + player.id + '"></label>';
                    html += '</div>';
                    html += '</td>';

                    html += '<td>' + player.first_name + ' ' + (player.last_name ? player.last_name : '') + '</td>';

                    html += '<td>';
                    html += '<span class="badge badge-info">' + res.teamName + '</span>';
                    html += '</td>';

                    html += '<td>' + player.position + '</td>';
                    html += '<td>' + (player.phone_no ? player.phone_no : '') + '</td>';
                    html += '<td>' + (player.email ? player.email : '') + '</td>';

                    html += '</tr>';
                });

                $('#player_table_body').html(html);
            },
            error: function () {
                alert('Something went wrong');
            }
        });
    });

    $('#select_all').on('change', function () {
        $('.player_checkbox').prop('checked', $(this).prop('checked'));
    });

    $('#insert_attendance_contribution_button').click(function () {

        var players = [];

        $('.player_checkbox:checked').each(function () {
            players.push($(this).val());
        });

        if (players.length === 0) {
            alert('Please select at least one player');
            return;
        }

        var params = {
            attendance_date: $('#attendance_date').val(),
            amount: $('#amount').val(),
            players: players
        };

        showProcessingNotification();

        $.ajax({
            url: '/contribution/insert',
            method: 'POST',
            data: {
                params: params,
                "_token": $('#token').val()
            },
            success: function (res) {
                showSuccessNotification('Contribution inserted successfully');
                $('.player_checkbox').prop('checked', false);
                $('#select_all').prop('checked', false);
            },
            error: function () {
                showErrorNotification();
            }
        });
    });

});
