<style>

/*
				INICIO BANNER AND FOOTER
*/
.logoicon{ font-size:2.5em; }
.logoicon2{ font-size:1.8em; }
.barsidebar{ margin-top:10px; max-height:100vh; min-height:100vh; overflow:auto; position:fixed; }
.icon-enlace-menu{ color:#000; margin:0% 2%; font-size:1.2em; }
.icon-enlace-menu:active{ color:#FFF; }
.icon-enlace-menu:hover{ color:#000; cursor:pointer; }
.barcorte, .list-corte{ display:none; }


/*
        FIN BANNER AND FOOTER
*/




/*
      INICIO PAGINA
*/
.fondoGeneral{
  width:100%;height:100%;position:absolute;top:0%;left:0;overflow:none;opacity:.7;
}
.box2logotipo{
  position:absolute;top:14%;left:44%;width:12%;
}
.box2emblema{
  position:absolute;top:29%;width:50%;left:25%;
}
.box2detalle1{
  /* position:absolute; */
  /* width:100%; */
  object-position: center;
  object-fit: cover;
}
.box2detalle2{
  position:absolute;width:75%;top:20%;left:12%;
  filter:drop-shadow(0px 0px 0px #000);
}
.box2cintillo{
  position:absolute;bottom:5%;left:4%;width:10%;
}


@media screen and (min-width: 1024px) and (max-width: 1280px){
  .fondoGeneral{
    width:100%;height:100%;position:absolute;top:0%;left:0;overflow:none;opacity:.7;
  }
  .box2logotipo{
    /* background:red; */
    position:absolute;top:14%;left:44%;width:12%;
  }
  .box2emblema{
    position:absolute;top:29%;width:50%;left:25%;
  }
  .box2detalle1{
    /* 
    position:fixed;
    margin-left:-10.5%;
    object-fit:cover;
    justify-content: center;
    */
    /* width:137vh; */
    /* background:red;  */
    object-position: center;
    object-fit: cover;
  }
  .box2detalle2{
    position:absolute;
    width:80%;
    top:40%;
    filter:drop-shadow(0px 0px 0px #000);
  }
  .box2cintillo{
    position:absolute;bottom:5%;left:4%;width:10%;
  }
}


@media screen and (min-width: 981px) and (max-width: 1024px){
  .fondoGeneral{
    width:100%;height:100%;position:absolute;top:0%;left:0;overflow:none;opacity:.7;
  }
  .box2logotipo{
    /* background:blue; */
    position:absolute;top:16%;left:44%;width:12%;
  }
  .box2emblema{
    position:absolute;top:31%;width:50%;left:25%;
  }
  .box2detalle1{
    /* position:absolute;width:78.1%;top:12%;left:11%; */
    object-fit: cover;
    object-position: center;
  }
  .box2detalle2{
    position:absolute;width:75%;top:20%;left:12%;
    filter:drop-shadow(0px 0px 0px #000);
  }
  .box2cintillo{
    position:absolute;bottom:5%;left:4%;width:10%;
  }
}

@media screen and (min-width: 931px) and (max-width: 980px){
  .fondoGeneral{
    width:100%;height:100%;position:absolute;top:0%;left:0;overflow:none;opacity:.7;
  }
  .box2logotipo{
    /* background:green; */
    position:absolute;top:22%;left:40%;width:20%;
  }
  .box2emblema{
    position:absolute;top:36%;width:65%;left:17.5%;
  }
  .box2detalle1{
    position:absolute;
    width:127vh;
    margin-left:-15%;
    object-fit:cover;
    justify-content: center;
    /* background:red;  */
  }
  .box2detalle2{
    position:absolute;width:75%;top:20%;left:12%;
    filter:drop-shadow(0px 0px 0px #000);
  }
  .box2cintillo{
    position:absolute;bottom:5%;left:4%;width:10%;
  }
}
@media screen and (min-width: 861px) and (max-width: 930px){
  .fondoGeneral{
    width:100%;height:100%;position:absolute;top:0%;left:0;overflow:none;opacity:.7;
  }
  .box2logotipo{
    /* background:blue; */
    position:absolute;top:22%;left:40%;width:20%;
  }
  .box2emblema{
    position:absolute;top:36%;width:65%;left:17.5%;
  }
  .box2detalle1{
    position:absolute;
    width:127vh;
    /* margin-top:5%; */
    margin-left:-18%;
    object-fit:cover;
    justify-content: center;
    /* background:red;  */
  }
  .box2detalle2{
    position:absolute;width:75%;top:20%;left:12%;
    filter:drop-shadow(0px 0px 0px #000);
  }
  .box2cintillo{
    position:absolute;bottom:5%;left:4%;width:10%;
  }
}

@media screen and (min-width: 810px) and (max-width: 860px){
  .fondoGeneral{
    width:100%;height:100%;position:absolute;top:0%;left:0;overflow:none;opacity:.7;
  }
  .box2logotipo{
    /* background:pink; */
    position:absolute;top:22%;left:39%;width:22%;
  }
  .box2emblema{
    position:absolute;top:36%;width:75%;left:12.5%;
  }
  .box2detalle1{
    position:absolute;
    width:135vh;
    margin-left:-27.5%;
    object-fit:cover;
    justify-content: center;
    /* background:red;  */
  }
  .box2detalle2{
    position:absolute;width:75%;top:20%;left:12%;
    filter:drop-shadow(0px 0px 0px #000);
  }
  .box2cintillo{
    position:absolute;bottom:5%;left:4%;width:10%;
  }
}
@media screen and (min-width: 760px) and (max-width: 810px){
  .fondoGeneral{
    width:100%;height:100%;position:absolute;top:0%;left:0;overflow:none;opacity:.7;
  }
  .box2logotipo{
    /* background:red; */
    position:absolute;top:22%;left:37.5%;width:24%;
  }
  .box2emblema{
    position:absolute;top:36%;width:75%;left:12.5%;
  }
  .box2detalle1{
    position:absolute;
    width:135vh;
    margin-left:-33%;
    object-fit:cover;
    justify-content: center;
    /* background:red;  */
  }
  .box2detalle2{
    position:absolute;width:75%;top:20%;left:12%;
    filter:drop-shadow(0px 0px 0px #000);
  }
  .box2cintillo{
    position:absolute;bottom:5%;left:4%;width:10%;
  }
}
/* 641px */
@media screen and (min-width: 710px) and (max-width: 760px){
  .fondoGeneral{
    width:100%;height:100%;position:absolute;top:0%;left:0;overflow:none;opacity:.7;
  }
  .box2logotipo{
    /* background:blue; */
    position:absolute;top:22%;left:37.5%;width:24%;
  }
  .box2emblema{
    position:absolute;top:36%;width:78%;left:11%;
  }
  .box2detalle1{
    position:absolute;
    width:135vh;
    margin-left:-40%;
    object-fit:cover;
    justify-content: center;
    /* background:red;  */
  }
  .box2detalle2{
    position:absolute;width:75%;top:20%;left:12%;
    filter:drop-shadow(0px 0px 0px #000);
  }
  .box2cintillo{
    position:absolute;bottom:5%;left:4%;width:10%;
  }
}
@media screen and (min-width: 660px) and (max-width: 710px){
  .fondoGeneral{
    width:100%;height:100%;position:absolute;top:0%;left:0;overflow:none;opacity:.7;
  }
  .box2logotipo{
    /* background:yellow; */
    position:absolute;top:22%;left:37.5%;width:24%;
  }
  .box2emblema{
    position:absolute;top:36%;width:78%;left:11%;
  }
  .box2detalle1{
    position:absolute;
    width:135vh;
    margin-left:-44%;
    object-fit:cover;
    justify-content: center;
    /* background:red;  */
  }
  .box2detalle2{
    position:absolute;width:75%;top:20%;left:12%;
    filter:drop-shadow(0px 0px 0px #000);
  }
  .box2cintillo{
    position:absolute;bottom:5%;left:4%;width:10%;
  }
}
@media screen and (min-width: 610px) and (max-width: 660px){
  .fondoGeneral{
    width:100%;height:100%;position:absolute;top:0%;left:0;overflow:none;opacity:.7;
  }
  .box2logotipo{
    /* background:red; */
    position:absolute;top:22%;left:35%;width:26%;
  }
  .box2emblema{
    position:absolute;top:36%;width:80%;left:10%;
  }
  .box2detalle1{
    position:absolute;
    width:135vh;
    margin-left:-52%;
    object-fit:cover;
    justify-content: center;
    /* background:red;  */
  }
  .box2detalle2{
    position:absolute;width:75%;top:20%;left:12%;
    filter:drop-shadow(0px 0px 0px #000);
  }
  .box2cintillo{
    position:absolute;bottom:5%;left:4%;width:10%;
  }
}

@media screen and (min-width: 571px) and (max-width: 609px){
  .fondoGeneral{
    width:100%;height:100%;position:absolute;top:0%;left:0;overflow:none;opacity:.7;
  }
  .box2logotipo{
    /* background:purple; */
    position:absolute;top:22%;left:35%;width:26%;
  }
  .box2emblema{
    position:absolute;top:36%;width:80%;left:10%;
  }
  .box2detalle1{
    position:absolute;
    width:135vh;
    margin-left:-58%;
    object-fit:cover;
    justify-content: center;
    /* background:red;  */
  }
  .box2detalle2{
    position:absolute;width:75%;top:20%;left:12%;
    filter:drop-shadow(0px 0px 0px #000);
  }
  .box2cintillo{
    position:absolute;bottom:5%;left:4%;width:10%;
  }
}

@media screen and (min-width: 520px) and (max-width: 570px){
  .fondoGeneral{
    width:100%;height:100%;position:absolute;top:0%;left:0;overflow:none;opacity:.7;
  }
  .box2logotipo{
    /* background:green; */
    position:absolute;top:22%;left:35%;width:26%;
  }
  .box2emblema{
    position:absolute;top:36%;width:80%;left:10%;
  }
  .box2detalle1{
    position:absolute;
    width:135vh;
    margin-left:-67%;
    object-fit:cover;
    justify-content: center;
    /* background:red;  */
  }
  .box2detalle2{
    position:absolute;width:75%;top:20%;left:12%;
    filter:drop-shadow(0px 0px 0px #000);
  }
  .box2cintillo{
    position:absolute;bottom:5%;left:4%;width:10%;
  }
}

@media screen and (min-width: 471px) and (max-width: 519px){
  .fondoGeneral{
    width:100%;height:100%;position:absolute;top:0%;left:0;overflow:none;opacity:.7;
  }
  .box2logotipo{
    /* background:red; */
    position:absolute;top:22%;left:35%;width:26%;
  }
  .box2emblema{
    position:absolute;top:36%;width:80%;left:10%;
  }
  .box2detalle1{
    position:absolute;
    width:135vh;
    margin-left:-67%;
    object-fit:cover;
    justify-content: center;
    /* background:red;  */
  }
  .box2detalle2{
    position:absolute;width:75%;top:20%;left:12%;
    filter:drop-shadow(0px 0px 0px #000);
  }
  .box2cintillo{
    position:absolute;bottom:5%;left:4%;width:10%;
  }
}
@media screen and (min-width: 421px) and (max-width: 470px){
  .fondoGeneral{
    width:100%;height:100%;position:absolute;top:0%;left:0;overflow:none;opacity:.7;
  }
  .box2logotipo{
    /* background:yellow; */
    position:absolute;top:22%;left:35%;width:26%;
  }
  .box2emblema{
    position:absolute;top:36%;width:80%;left:10%;
  }
  .box2detalle1{
    position:absolute;
    width:135vh;
    margin-left:-67%;
    object-fit:cover;
    justify-content: center;
    /* background:red;  */
  }
  .box2detalle2{
    position:absolute;width:75%;top:20%;left:12%;
    filter:drop-shadow(0px 0px 0px #000);
  }
  .box2cintillo{
    position:absolute;bottom:5%;left:4%;width:10%;
  }
}
@media screen and (min-width: 361px) and (max-width: 420px){
  .fondoGeneral{
    width:100%;height:100%;position:absolute;top:0%;left:0;overflow:none;opacity:.7;
  }
  .box2logotipo{
    /* background:blue; */
    position:absolute;top:22%;left:35%;width:26%;
  }
  .box2emblema{
    position:absolute;top:36%;width:80%;left:10%;
  }
  .box2detalle1{
    position:absolute;
    width:135vh;
    margin-left:-75%;
    object-fit:cover;
    justify-content: center;
    /* background:red;  */
  }
  .box2detalle2{
    position:absolute;width:75%;top:20%;left:12%;
    filter:drop-shadow(0px 0px 0px #000);
  }
  .box2cintillo{
    position:absolute;bottom:5%;left:4%;width:10%;
  }
}

@media screen and (min-width: 276px) and (max-width: 360px){
  .fondoGeneral{
    width:100%;height:100%;position:absolute;top:0%;left:0;overflow:none;opacity:.7;
  }
  .box2logotipo{
    /* background:#44AACC; */
    position:absolute;top:22%;left:35%;width:26%;
  }
  .box2emblema{
    position:absolute;top:36%;width:80%;left:10%;
  }
  .box2detalle1{
    position:absolute;
    width:135vh;
    margin-left:-75%;
    object-fit:cover;
    justify-content: center;
    /* background:red;  */
  }
  .box2detalle2{
    position:absolute;
    width:80%;
    top:40%;
    filter:drop-shadow(0px 0px 0px #000);
  }
  .box2cintillo{
    position:absolute;bottom:5%;left:4%;width:10%;
  }
}
@media screen and (min-width: 100px) and (max-width: 275px){
  .fondoGeneral{
    width:100%;height:100%;position:absolute;top:0%;left:0;overflow:none;opacity:.7;
  }
  .box2logotipo{
    /* background:green; */
    position:absolute;top:22%;left:35%;width:26%;
  }
  .box2emblema{
    position:absolute;top:36%;width:80%;left:10%;
  }
  .box2detalle1{
    position:absolute;
    width:135vh;
    margin-left:-85%;
    object-fit:cover;
    justify-content: center;
    /* background:red;  */
  }
  .box2detalle2{
    position:absolute;width:75%;top:20%;left:12%;
    filter:drop-shadow(0px 0px 0px #000);
  }
  .box2cintillo{
    position:absolute;bottom:5%;left:4%;width:10%;
  }
}









.d-none{ display:none; }
th{text-align:center;} 
/*.seccion1Cintillo{ position:absolute;top:13% !important;left:47%; }*/
.seccion1Cintillo3{ margin:4vh 75vh;width:17vh;}
/*.seccion1Emblema{ position:absolute;top:25%;left:28%;width:50%; }*/
.seccion1Emblema3{ width:100vh;margin:0vh 20%; }
/*.seccion1Separador{ position:absolute;left:5%;top:50%;width:90%;background:#CCC;border:1px solid #ccc }*/
/*.seccion1Productos{ position:absolute;right:1%;bottom:-20%;width:30%; }*/
.seccion1Productos3{ width:30%; margin:-11% 75%; z-index:0; }

.seccion1Logotipo3{ position:absolute;bottom:3%;width:30%;margin:1% 27.5%; }
/*.seccion1Logotipo{ position:absolute;left:27.5%;bottom:7%;width:30%; }*/

.seccion1Fondo{ margin:0;padding:0;background:url('public/assets/img/resources/fondo3.22.png');background-size:100% 100%;box-sizing:border-box;position:relative;height:90.5vh; }

.imgFondoResor{ width:100%;height:90vh; }

.seccionFull{ position:relative;width:100%;height:100%; }
.seccionFull9{ position:relative;width:100%;height:90%; }
.seccionFull8{ position:relative;width:100%;height:80%; }
.seccionFull7{ position:relative;width:100%;height:70%; }
.seccionFull6{ position:relative;width:100%;height:60%; }
.seccionFull5{ position:relative;width:100%;height:50%; }
.seccionFull4{ position:relative;width:100%;height:40%; }
.seccionFull3{ position:relative;width:100%;height:30%; }
.seccionFull2{ position:relative;width:100%;height:20%; }
.seccionFull1{ position:relative;width:100%;height:10%; }
.seccionFooter{ position:relative; /*width: height:40vh;*/ }
.contentTitle{ font-size:3.5em; }
.contentTitle2{ font-size:2.5em; }

.btnContent2{ font-size:1.2em; background:#FFF;color:<?=$fucsia?>; border:0px solid #FFF;border-radius:10px;padding:10px }
.btnContent2:hover,.btnContent2:focus, .btnContent2:active{color:#fff;background:#DC1966}


.btnContent{ font-size:1.5em; background:#FFF;color:<?=$fucsia?>; border:0px solid #FFF;border-radius:10px;bottom:7%;position:absolute;left:0%;padding:10px }
.btnContent:hover,.btnContent:focus, .btnContent:active{color:#fff;background:#DC1966}
.inrow{ padding:5% 10%; }
<?php $tam = "5"; ?>
.separate-left{ font-size:<?php echo $tam ."em"; ?>; position:absolute; z-index:100; opacity:100; }
.separate-right{ font-size:<?php echo $tam ."em"; ?>; position:absolute; right:0; z-index:100; opacity:100; }
.cols-order1{ display:none; }
.cols-order2{ display:block; }

/*
			FIN PAGINA
*/

@media screen and (min-width: 1025px) and (max-width: 1280px){
.imgFondoResor{ height:80vh; }
.seccion1Emblema{ width:50%;left:27.5%; }

}

@media screen and (min-width: 992px) and (max-width: 1024px){
.seccion1Productos{ ;width:100%;position:absolute;left:-8%;top:15vh; }
.seccion1Emblema{ width:30%;left:27%; }
.btnContent{ bottom:8%; }
.seccion1Fondo{ height:88vh; }
.seccion1Fondo{ height:88vh }
.imgFondoResor{ height:50vh; }

    footer{ font-size:2em; }
    footer small{ font-size:.9em; }
  .cols-order1{ display:block; }
  .cols-order2{ display:none; }

  .salto{display:none; }
  .logoicon{ font-size:3.5em;}
  .logopc{ font-size:1.5em;}
  .icon-enlace-menu{ font-size:1.3em;}
  .barsidebar{ margin-top:20px;}
  .barlarge{ display:none;}
  .barcorte, .list-corte{ display:block;}
}

@media screen and (min-width: 787px) and (max-width: 991px){
.seccion1Productos{width:120%;position:absolute;left:-10%;top:20vh;}
.seccion1Emblema{ top:5%;left:19%;width:45%; }
.btnContent{ bottom:9%; }
.seccion1Fondo{ height:88vh; }

    footer{ font-size:2em; }
    footer small{ font-size:.9em; }
    .btnContent{ font-size:1.8em;}
	.cols-order1{ display:block; }
	.cols-order2{ display:none; }

  .salto{display:none;}
  .logoicon{ font-size:3.5em;}
  .logopc{ font-size:1.5em;}
  .icon-enlace-menu{ font-size:1.3em;}
  .barsidebar{ margin-top:20px;}
  .barlarge{ display:none;}
  .barcorte, .list-corte{ display:block;}
}
@media screen and (min-width: 690px) and (max-width: 786px){
	
.seccion1Productos{ width:120%;left:-10%;top:30vh; }
.seccion1Emblema{ margin:0% 10%;position:absolute;top:12%;left:20%;width:46%;}
.btnContent{ bottom:10%; }
.seccion1Fondo{ height:88vh; }


  .salto{display:none;}
  .logoicon{ font-size:3em; }
  .logopc{ font-size:1.5em; }
  .icon-enlace-menu{ font-size:1.15em; }
  .barsidebar{ margin-top:10px; }  
  .barlarge{display:none;}
  .barcorte, .list-corte{display:block;}
}
@media screen and (min-width: 550px) and (max-width: 689px){

.seccion1Productos{ width:120%;left:-10%;top:30vh; }
.seccion1Emblema{ margin:0% 10%;position:absolute;top:15%;left:19%;width:47%;}
.btnContent{ bottom:11%; }
.seccion1Fondo{ height:88vh; }


  .salto{display:none;}
  .icon-enlace-menu{ font-size:1.15em;}
  .logopc{ font-size:1.5em;}
  .barsidebar{ margin-top:-50px;}  
  .barlarge{ display:none;}
  .barcorte, .list-corte{ display:block;}
}
@media screen and (min-width: 481px) and (max-width: 550px){

.seccion1Productos{ width:120%;left:-10%;top:30vh; }
.seccion1Emblema{ margin:0% 10%;position:absolute;top:18%;left:18.5%;width:48%;}
.btnContent{ bottom:12%; }
.seccion1Fondo{ height:88vh; }

  .salto{display:none;}
  .logoicon{ font-size:2em;}
  .logopc{ font-size:1.5em;}
  .icon-enlace-menu{ font-size:1.1em; margin:0% 1.4%;}
  .barsidebar{ margin-top:-50px;}  
  .barlarge{ display:none;}
  .barcorte, .list-corte{ display:block;}
}
@media screen and (min-width: 350px) and (max-width: 480px){

.btnContent{ bottom:13%; }
.seccion1Fondo{ height:88vh; }
.seccion1Productos{ width:120%;left:-10%;top:30vh; }
.seccion1Emblema{ margin:0% 10%;position:absolute;top:19%;left:16%;width:50%; }

  .salto{display:none;}
  .logoicon{ font-size:2em; }
  .logopc{ font-size:1.5em; }
  .icon-enlace-menu{ font-size:1em; margin:0% 0.8%; }
  .barsidebar{ margin-top:-60px; }  
  .barlarge{ display:none; }
  .barcorte, .list-corte{ display:block; }
}
@media screen and (min-width: 100px) and (max-width: 349px){
.seccion1Productos{ width:100%;left:0%;top:30vh; }
.seccion1Emblema{ margin:0% 10%;position:absolute;top:20%;left:16%;width:50%; }
.btnContent{ bottom:14%; }
.seccion1Fondo{ height:88vh; }

  .barlarge{ display:none; }
  .barcorte, .list-corte{ display:block; }
}

*/




</style>