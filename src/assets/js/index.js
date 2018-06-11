$(".delete-row").click(function() {

    var rowNumber = $(this).attr('data-id');

    $.ajax({
        url: '/file-parser/delete',
        method: 'POST',
        data: {rowNumber:rowNumber, filePath: filePath},
        success: function (response) {
            location.reload();
        }
    });
});


$(".update-row").click(function() {
    var rowNumber = $(this).attr('data-id');

    $.ajax({
        url: '/file-parser/get-row-data',
        method: 'POST',
        data: {rowNumber:rowNumber, filePath: filePath},
        success: function (response) {
            var updateDiv = $('#file-row-update');
            $(updateDiv).empty();

            $.each(response, function (key, value) {
                var updateInputBlock = '<div>' +
                        '<label>' + key +
                            '<input class="form-control row-update" type="text"' +
                                ' name="row-update-' + key + '"' +
                                ' id="row-update-' + key + '"' +
                                ' data-key="' + key + '"' +
                                ' value="' + value + '">' +
                        '</label>' +
                    '</div>';
                $(updateDiv).append(updateInputBlock);
            });
            $('#file-update-row').attr('data-id-row', rowNumber);
        }
    });
});

$("#file-update-row").click(function() {
    var rowNumber = $(this).attr('data-id-row');
    var rowData = {};
    $('#file-row-update input.row-update').each(function (key, input) {
        rowData[$(input).attr('data-key')] = input.value;
    });

    $.ajax({
        url: '/file-parser/update',
        method: 'POST',
        data: {rowNumber:rowNumber, filePath: filePath, rowData: JSON.stringify(rowData)},
        success: function () {
            location.reload();
        }
    });
});
