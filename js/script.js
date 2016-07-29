$(document).ready(function () {

    var uploader = $("#progressbar"),
        uploadWrapper = uploader.parent();


    $("#btnUpload").click(function (e) {

        e.preventDefault();

        var page = parseInt($("#paginator").find("li.active").html());

        var fd = new FormData();
        var file_data = $('input[type="file"]')[0].files; // for multiple files
        if (file_data.length == 0) {
            return false;
        }
        uploadWrapper.show();
        for (var i = 0; i < file_data.length; i++) {
            fd.append(i, file_data[i]);
        }
        var other_data = $('form').serializeArray();
        $.each(other_data, function (key, input) {
            fd.append(input.name, input.value);
        });
        fd.append('page', page);

        $.ajax({
            url: "upload.php",
            type: "POST",
            data: fd,
            contentType: false,
            cache: false,
            processData: false,
            xhr: function () {
                //upload Progress
                var xhr = $.ajaxSettings.xhr();
                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', function (event) {
                        var percent = 0;
                        var position = event.loaded || event.position;
                        var total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil(position / total * 100);
                        }
                        //update progressbar
                        uploader.css("width", +percent + "%");
                    }, true);
                }
                return xhr;
            },
        }).done(function (resp) {
            console.log(resp)
            $("#tableResults").html(resp);
            uploader.css("width", 0);
            uploadWrapper.hide();
        });
    });


    //delete data from DB and table
    $("body").on("click", ".delete", function () {

        var page = parseInt($("#paginator").find("li.active").html());

        var id = parseInt($(this).closest("tr").find(".id").html().trim()),
            $this = $(this);
        $.post("delete.php", {
            id: id,
            page: page
        }).done(function (resp) {
            $("#tableResults").html(resp)
        });
    });

    var config = {
        body: $('body'),
        tableTr: 'table tr'
    }
    //search
    config.body.on('input', '#contact-list-search', function () {
        var value = $(this).val().toLowerCase();
        config.body.find(config.tableTr).each(function () {
            // if($this.find
            var tdData = $($(this).find('td')[1]).html();
            console.log(tdData);
            if (typeof tdData != 'undefined') {
                tdData = tdData.toLowerCase();
                var foundPos = tdData.indexOf(value, tdData);
                if (foundPos == -1) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
                //console.log(foundPos);
            }
        });
    });

    //paginator
    config.body.on('click', '#paginator a', function (e) {
        e.preventDefault();
        var limit = parseInt($(this).html());
        $.ajax({
            url: 'paginator.php',
            type: 'POST',
            data: {page: limit}
        }).done(function (res) {
            $('#tableResults').html(res);
        })
    });
});
