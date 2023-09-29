	







<!-- jQuery UI 1.11.4 -->

<!-- <script src="public/vendor/bower_components/jquery-ui/jquery-ui.min.js"></script> -->

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

<script>

  $.widget.bridge('uibutton', $.ui.button);

</script>

<!-- Bootstrap 3.3.7 -->

<script src="public/vendor/bower_components/bootstrap/dist/js/bootstrap.js"></script>

<!-- Morris.js charts -->

<!-- <script src="public/vendor/bower_components/raphael/raphael.min.js"></script> -->

<!-- <script src="public/vendor/bower_components/morris.js/morris.min.js"></script> -->

<!-- Sparkline -->

<script src="public/vendor/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>

<!-- jvectormap -->

<script src="public/vendor/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>

<script src="public/vendor/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- jQuery Knob Chart -->

<script src="public/vendor/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>

<!-- daterangepicker -->

<script src="public/vendor/bower_components/moment/min/moment.min.js"></script>

<script src="public/vendor/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- datepicker -->

<script src="public/vendor/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<!-- Bootstrap WYSIHTML5 -->

<script src="public/vendor/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<!-- Slimscroll -->

<script src="public/vendor/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

<!-- FastClick -->

<script src="public/vendor/bower_components/fastclick/lib/fastclick.js"></script>

<!-- AdminLTE App -->

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->

<script src="public/vendor/dist/js/pages/dashboard.js"></script>

<!-- AdminLTE for demo purposes -->



<script src="public/vendor/plugins/DataTables/datatables.js"></script>

<!-- <script src="public/vendor/plugins/DataTables/DataTables/js/jquery.dataTables.js"></script> -->



<script src="public/vendor/plugins/DataTables/DataTables/js/dataTables.bootstrap.js"></script>

<!-- SlimScroll -->

<script src="public/vendor/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

<!-- FastClick -->

<script src="public/vendor/bower_components/fastclick/lib/fastclick.js"></script>

<!-- AdminLTE App -->

<script src="public/vendor/dist/js/adminlte.js"></script>

<script src="public/vendor/plugins/sweetalert/sweet-alert.js"></script>

<script src="public/vendor/plugins/select2/js/select2.js"></script>

<script src="public/assets/js/validacionCampos.js"></script>

<script src="public/assets/js/volver.js"></script>

<!-- AdminLTE for demo purposes -->

<!-- <script src="public/vendor/dist/js/demo.js"></script> -->

<!-- page script -->

<style>







@media screen and (min-width:780px) and (max-width:780px){

    

}

/*@media screen and (max-width:480px){

  tbody,table{font-size:75%;} 

  .contenido{font-size:160%}

  th{font-size:65%}

}*/

</style>

<script>

$(document).ready(function(){

	var barTop = $(".navbar").height();

    var resto = 20;

    var resto = 0;

    $(".head").attr("style","height:"+(barTop-resto)+"px");

    $(window).resize(function(){

      var barTop = $(".navbar").height();

      console.log(barTop);

      $(".head").attr("style","height:"+(barTop-resto)+"px");

      

    }); 

});

</script>