<?php
	if(isset($_GET['campaing']) && isset($_GET['n']) && isset($_GET['y'])){
		$newY = substr($_GET['y'], 2);
		$globito="";
		if(isset($_GET['dpid']) && isset($_GET['dp'])){
			$globito .= mb_strtoupper($ndp)." P ";
			// $globito .= "P".$_GET['dp']." ";	
		}
		$globito .= "C".$_GET['n']."/".$newY;
		
?>
	<span class="btn enviar2" style="position:fixed;bottom:1vh;right:0;z-index:1000000;width:130px;">
		<?=$globito?>
	</span>
			
<?php } ?>


<?php if(!empty($_GET['campaing'])){ ?>

<input type="hidden" value="<?php echo $_GET['campaing'] ?>" class='campaing'>

<?php } ?>

<?php if(!empty($_GET['n'])){ ?>

<input type="hidden" value="<?php echo $_GET['n'] ?>" class='num_campaing'>

<?php } ?>

<?php if(!empty($_GET['y'])){ ?>

<input type="hidden" value="<?php echo $_GET['y'] ?>" class='year_campaing'>

<?php } ?>

<?php if(!empty($_GET['dpid'])){ ?>

<input type="hidden" value="<?php echo $_GET['dpid'] ?>" class='despacho_id'>

<?php } ?>

<?php if(!empty($_GET['dp'])){ ?>

<input type="hidden" value="<?php echo $_GET['dp'] ?>" class='num_despacho'>

<?php } ?>

<footer class="main-footer">

    <div class="pull-right hidden-xs string">

      <b>Version</b> 1.0.0

    </div>

    <strong class="string">Copyright &copy; 2021-2023 <a href="https://stylecollection.org">Style Collection</a>.</strong> <span class="string">Todos los derechos reservados.</span>

  </footer>