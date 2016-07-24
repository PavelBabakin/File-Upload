$(document).ready(function () {
    $(".delete").click(function () {
        
        var id = parseInt($(this).closest("tr").find(".id").html().trim());
        var $this = $(this);
        $.post("delete.php", {id: id}).done(function (resp) {
                if (resp == 'true') {
                    console.log('joined');
                    $this.closest("tr").remove();
                } else {
                    $("#wrapper").html(resp)
                }
            
            });
    });
});
