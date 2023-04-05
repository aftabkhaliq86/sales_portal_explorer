<?php
/*if ($page_name=='agent_profile.php') {
?>

<?php
}
else {
?> 

<?php
}*/
?>

<!-- jQuery -->
        <script src="vendors/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap -->
		<script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- Bootstrap Select -->
        <script src="js/bootstrap-select-ico.min.js"></script>
		<script src="js/bootstrap-select.min.js"></script>

        <!-- FastClick -->
        <script src="vendors/fastclick/lib/fastclick.js"></script>
        <!-- NProgress -->
        <script src="vendors/nprogress/nprogress.js"></script>
        <!-- Chart.js -->
        <script src="vendors/Chart.js/dist/Chart.min.js"></script>
        <!-- gauge.js -->
        <script src="vendors/gauge.js/dist/gauge.min.js"></script>
        <!-- bootstrap-progressbar -->
        <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
        <!-- iCheck -->
        <script src="vendors/iCheck/icheck.min.js"></script>
        <!-- Skycons -->
        <script src="vendors/skycons/skycons.js"></script>
        <!-- Flot -->
        <script src="vendors/Flot/jquery.flot.js"></script>
        <script src="vendors/Flot/jquery.flot.pie.js"></script>
        <script src="vendors/Flot/jquery.flot.time.js"></script>
        <script src="vendors/Flot/jquery.flot.stack.js"></script>
        <script src="vendors/Flot/jquery.flot.resize.js"></script>
        <!-- Flot plugins -->
        <script src="vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
        <script src="vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
        <script src="vendors/flot.curvedlines/curvedLines.js"></script>
        <!-- DateJS -->
        <script src="vendors/DateJS/build/date.js"></script>
        <!-- JQVMap -->
        <script src="vendors/jqvmap/dist/jquery.vmap.js"></script>
        <script src="vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
        <script src="vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
        <!-- bootstrap-daterangepicker -->
        <!--<script src="vendors/moment/min/moment.min.js"></script>
        <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>-->
		
        <!-- jQuery Smart Wizard -->
        <script src="vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
		
        <!-- twitter-bootstrap-wizard-master -->
        <script src="vendors/twitter-bootstrap-wizard-master/jquery.bootstrap.wizard.js"></script>
        <script src="vendors/twitter-bootstrap-wizard-master/prettify.js"></script>
        <script type="text/javascript">
			$(document).ready(function () {
				$('#rootwizard').bootstrapWizard({onTabShow: function (tab, navigation, index) {
						var $total = navigation.find('li').length;
						var $current = index + 1;
						var $percent = ($current / $total) * 100;
						$('#rootwizard .progress-bar').css({width: $percent + '%'});
					}});
				$('#rootwizard .finish').click(function () {
					alert('Finished!, Starting over!');
					$('#rootwizard').find("a[href*='tab1']").trigger('click');
				});
			});
        </script>
		
        <!-- Datatables -->
        <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
        <script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
        <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
        <script src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
        <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
        <script src="vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
        <script src="vendors/jszip/dist/jszip.min.js"></script>
        <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
        <script src="vendors/pdfmake/build/vfs_fonts.js"></script>

        <script>
$(document).ready(function(){
	$('.search').on('keyup',function(){
        var searchTerm = $(this).val().toLowerCase();
		
        $('#menu ul li').each(function(){
            var lineStr = $(this).text().toLowerCase();
			
			if(lineStr.indexOf(searchTerm) === -1){
				$(".nav.side-menu>li").addClass('active');
				$('#menu ul>li>ul').css('display', 'block');
				$(this).hide();
            }else{
				$(this).show();
            }
			
        });
		
    });
	
	 $('.search').keyup(function(e)
		{
		 if(e.keyCode == 8) {
			 $(".nav.side-menu>li").removeClass('active');
			 //$('.nav.side-menu>li').css('display', 'none');
			 $('.nav.child_menu').css('display', 'none');
		 }
		});
	
});
</script>
<!--$(".nav.side-menu>li").removeClass('active');
	$('#menu ul>li>ul').css('display', 'none');
	//$('.nav.child_menu').css('display', 'none');-->        
        <!-- Date and time picker -->
		<script type="text/javascript" src="js/datepickers_bs/bootstrap-datetimepicker.js" charset="UTF-8"></script>
        <script type="text/javascript" src="js/datepickers_bs/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
        <script type="text/javascript">
            $('.form_datetime').datetimepicker({
                //language:  'fr',
                weekStart: 1,        
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                forceParse: 0,
                showMeridian: 1
            });
        </script>
        <!-- Date and time picker end -->
        
        <!-- Custom Theme Scripts -->
        <script src="js/custom.js"></script>
    
</body>

</html>