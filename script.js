$(document).ready(function () {

    //show preloader
    $("#btnUpload").click(function () {

        $('.loader').show();

    });

    //delete data from DB and table
    $(".delete").click(function () {
        
        var id = parseInt($(this).closest("tr").find(".id").html().trim()),
            $this = $(this);

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
