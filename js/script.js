$(document).ready(function () {

    var uploader = $("#progressbar"),
        uploadWrapper = uploader.parent();


    $("#btnUpload").click(function (e) {

        e.preventDefault();

        uploadWrapper.show();
        var fd = new FormData();
        var file_data = $('input[type="file"]')[0].files; // for multiple files
        if (file_data.length == 0) {
            return false;
        }
        for (var i = 0; i < file_data.length; i++) {
            fd.append(i, file_data[i]);
        }
        var other_data = $('form').serializeArray();
        $.each(other_data, function (key, input) {
            fd.append(input.name, input.value);
        });

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
            $("#tableResults").html(resp);
            uploader.css("width", 0);
            uploadWrapper.hide();
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

                $("#tableResults").html(resp)

            }

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
            if(typeof tdData != 'undefined'){
                tdData = tdData.toLowerCase();
                var foundPos = tdData.indexOf(value, tdData);
                if (foundPos == -1){
                    $(this).hide();
                }else {
                    $(this).show();
                }
                //console.log(foundPos);
            }
        });
    });
});
