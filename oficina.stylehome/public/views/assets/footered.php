
<!-- jQuery 3 -->
<script src="public/vendor/bower_components/jquery/dist/jquery.min.js"></script>
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
<script src="public/vendor/plugins/DataTables/DataTables/js/dataTables.responsive.min.js"></script>
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
<!-- <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script> -->
<!-- AdminLTE for demo purposes -->
<!-- <script src="public/vendor/dist/js/demo.js"></script> -->
<!-- page script -->
<style>
th{font-size:.85em !important;}
</style>
<script>
$(document).ready(function(){
          // var inFormOrLink;
    // $('a[href]:not([target]),a[href][target=_self]').live('click', function(){ inFormOrLink = true; });
    // $('form').bind('submit', function(){ inFormOrLink = true; });
    // $(window).bind('beforeunload', function(event){
    //   var returnValue = undefined;
    //   if(!inFormOrLink){
    //     returnValue = "Seguro que quiere cerrar?";
    //   }
    //   event.returnValue = returnValue;
    //   return returnValue;
    // });


      // alert('JAJAJA');

    // var widthImage = $(".RealImage").width();
    // $(".imageImage").attr("style","height:"+30+"vh;width:"+30+"vh");
    var widthImage2 = $(".ReadlImage2").width();
    $(".imageImage2").attr("style","height:"+widthImage2+"px;width:"+widthImage2+"px");
    $(window).resize(function(){
      // var widthImage = $(".RealImage").width();
      // $(".imageImage").attr("style","height:"+30+"vh;width:"+30+"vh");
  
      var widthImage2 = $(".ReadlImage2").width();
      $(".imageImage2").attr("style","height:"+widthImage2+"px;width:"+widthImage2+"px");
    }); 
});
  $(function () {
    $('.datatable').DataTable({
      "language": {
        "url": "public/vendor/plugins/DataTables/spanish.json",
        'info': true,
      },
      responsive: true,
    });
    $('.datatable2').DataTable({
      "language": {
        "url": "public/vendor/plugins/DataTables/spanish.json",
      },
      "order": [[ 0, "desc" ]],
      responsive: true,
    });
    $('.datatable1').DataTable({
      "language": {
        "url": "public/vendor/plugins/DataTables/spanish.json",
      },
      "order": [[ 1, "desc" ]],
      responsive: true,
    });
    $('.datatable3').DataTable({
      "language": {
        "url": "public/vendor/plugins/DataTables/spanish.json",
      },
      "order": [[ 1, "asc" ],[ 2, "asc" ]],
      responsive: true,
    });
    $('.datatable31').DataTable({
      "language": {
        "url": "public/vendor/plugins/DataTables/spanish.json",
      },
      "order": [[ 1, "desc" ]],
      responsive: true,
    });
    $('#datatable').DataTable({
      "language": {
        "url": "public/vendor/plugins/DataTables/spanish.json",
        'info': true,
      },
      responsive: true,
    });
    $('#datatable2').DataTable({
      "language": {
        "url": "public/vendor/plugins/DataTables/spanish.json",
      },
      "order": [[ 0, "desc" ]],
      responsive: true,
    });
    $('#datatable1').DataTable({
      "language": {
        "url": "public/vendor/plugins/DataTables/spanish.json",
      },
      "order": [[ 1, "asc" ]],
      responsive: true,
    });
    $('#mini-datatable').DataTable({
      "language": {
        "url": "public/vendor/plugins/DataTables/spanish.json",
        'info': true,
        'pageLength': 5,
      },
      responsive: true,
    });
    $('#datatableOrder').DataTable({
      "language": {
        "url": "public/vendor/plugins/DataTables/spanish.json",
      },
      "order": [[ 2, "desc" ],[ 3, "desc" ]],
      responsive: true,
    });
    $('#datatable3').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });
    $('.select2').select2();
    $("input").attr("autocomplete","off");
    

  });


</script>
<style>
th{text-align:center;} 

@media screen and (max-width:780px){
  tbody,table{font-size:0.89em} 
  .contenido{font-size:1.4em}
  .contenido2{font-size:1.1em}
  th{font-size:65%}
  .xs-none{display: none};
}
/*@media screen and (max-width:480px){
  tbody,table{font-size:75%;} 
  .contenido{font-size:160%}
  th{font-size:65%}
}*/
</style>