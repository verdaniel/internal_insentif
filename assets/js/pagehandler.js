$(document).ready(function(){
    $(window).load(function(){
        $('.loader').fadeOut();
        $('#myDiv').fadeIn();
    });
    $(".datatable").dataTable();
    $(".person_box").each(function(){
        var isi=$(this).html();
        console.log("woiwowiowiwoiwoiwoiwoiw");
        if(isi >= 30){
            var container=$(this).parent();
            container.css("background-color","palegreen");
        }
    });
    $( ".btn-ber-loading" ).click(function() {
        $('.loader').fadeIn();
        $('#myDiv').fadeOut();
    });
});