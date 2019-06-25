    <script src="<?php echo base_url(); ?>assets/js/vendor/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/vendor/Chart.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/vendor/chartjs-plugin-datalabels.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/vendor/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/vendor/fullcalendar.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>assets/js/vendor/datatables.min.js"></script> -->
    <script src="<?php echo base_url(); ?>assets/js/vendor/perfect-scrollbar.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/vendor/owl.carousel.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/vendor/progressbar.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/vendor/jquery.barrating.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/vendor/select2.full.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/vendor/nouislider.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/vendor/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/vendor/Sortable.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/vendor/mousetrap.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            // Ajax setup csrf token.
            var csfrData = {};
            csfrData['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
            $.ajaxSetup({
                data: csfrData,
                cache: false
            });
        });
        
        function loadContentWithParams(id, params) {
            $.ajax({
                url: "<?php echo base_url().'home/load_content/'; ?>" + id,
                type: "POST",
                data: params,
                success: function (data) {
                    $( "#main-content" ).html( data );
                },
                error: function (xhr, status, error) {
                    swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
                }
            });
            return;
        }

        // $(".nav-item").on('click', function(){
        //     var nav = $(this).attr('data-source');

        //     if(!nav){

        //     }else{
        //         var menu_id = $(this).attr('menu-id');
        //         $(".nav-item").removeClass("active");

        //         $(this).addClass("active");
        //         $(this).parent("ul").parent("li").addClass("active");

        //         loadContentWithParams(nav,{menu_id:menu_id});
                

        //         setMenuClassNames(0, true);
                
        //     }

        // });

        $("[type='number']").keypress(function (evt) {
            evt.preventDefault();
        });
    
    </script>
    
    <script src="<?php echo base_url(); ?>assets/js/dore.script.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>

    <!-- begin swal -->
    <script src="<?php echo base_url(); ?>assets/swal/sweetalert.min.js"></script>

    <!-- begin jqgrid -->
    <script src="<?php echo base_url(); ?>assets/jqgrid/src/jquery.jqGrid.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
    
    <!-- <script src="http://themicon.co/theme/angle/v3.8.8/backend-jquery/vendor/jqgrid/js/jquery.jqGrid.js" type="text/javascript"></script> -->
    <!-- <script src="http://themicon.co/theme/angle/v3.8.8/backend-jquery/vendor/jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script> -->

    <!-- bootgrid -->
    <script src="<?php echo base_url(); ?>assets/bootgrid/jquery.bootgrid.min.js" type="text/javascript"></script>

    
</body>

</html>
