    
        </div>

        <!-- ================= Jquery ================= -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        


        

        <!-- stylesheet -->
        <link href="<?php echo base_url(); ?>assets/style.css" rel="stylesheet" media="none" onload="if(media!='all')media='all'">
        <link href="<?php echo base_url(); ?>assets/w3.css" rel="stylesheet" media="none" onload="if(media!='all')media='all'">

        <!-- datatable -->
        <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.16/datatables.min.css"/> -->
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.16/datatables.min.js" defer></script>
        
        <script>
        $(document).ready(function(){
            $(window).load(function(){
                $('.loader').fadeOut();
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
                $('.loader').fadeIn();
                $('#myDiv').fadeOut();
            });
        });
        </script>
    </body>
</html>
