$(document).ready(function () {

    //upload files
    $("#btnUpload").click(function (e) {
        e.preventDefault();

        var fd = new FormData();
        var file_data = $('input[type="file"]')[0].files; // for multiple files
        for (var i = 0; i < file_data.length; i++) {
            fd.append(i, file_data[i]);
        }
        var other_data = $('form').serializeArray();
        $.each(other_data, function (key, input) {
            fd.append(input.name, input.value);
        });
        $.ajax({
            url: 'upload.php',
            data: fd,
            contentType: false,
            processData: false,
            type: 'POST'
        }).done(function (resp) {
            console.log($("#tableResults"));

            $("#tableResults").html(resp);
        });


    });


    //delete data from DB and table
    $("body").on("click", ".delete", function () {

        var id = parseInt($(this).closest("tr").find(".id").html().trim()),
            $this = $(this);
console.log($this);
        $.post("delete.php", {
            id: id
        }).done(function (resp) {

            if (resp == 'true') {

                console.log('joined');

                $this.closest("tr").remove();

            } else {

                $("#wrapper").html(resp)

            }

        });
    });
});
