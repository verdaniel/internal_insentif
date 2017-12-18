<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Insentif</title>

        
        
        
        <!-- ================= Jquery ================= -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <!-- ================== BEGIN BASE JS ================== -->
        <script src="<?php echo base_url(); ?>assets/bootstrap/js/pace.min.js" async></script>
        <script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js" async></script>
        <script src="<?php echo base_url();?>assets/bootstrap/js/apps.min.js" async></script>

        <!-- Bootstrap -->
        <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        

        <!-- stylesheet -->
        <link href="<?php echo base_url(); ?>assets/style.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/w3.css" rel="stylesheet">

        <!-- datatable -->
        <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.16/datatables.min.css"/> -->
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.16/datatables.min.js"></script>
        
        <script>
        $(document).ready(function(){
            $(window).load(function(){
                // PAGE IS FULLY LOADED  
                // FADE OUT YOUR OVERLAYING DIV
                $('#loader').fadeOut();
                $('#myDiv').fadeIn();
            });
            $(".datatable").dataTable();
            $(".person_box").each(function(){
                var isi=$(this).html();
                
                if(isi >= 30){
                    var container=$(this).parent();
                    container.css("background-color","palegreen");
                }
            });
            $( ".btn-ber-loading" ).click(function() {
                $('#loader').fadeIn();
                $('#myDiv').fadeOut();
            });
        });
        </script>
    </head>
    <body>
        