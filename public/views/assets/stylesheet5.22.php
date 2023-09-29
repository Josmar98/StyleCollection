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

/*=================================================*/
  /* CINTILLO 4-22 */
/*=================================================*/


.box1cintillo{
  width:100%;
}
.box2cintillo{
  width:10%;
  position:absolute;
  left:8%;
  top:15%;
  /*margin:auto;*/
}

/*=================================================*/
  /* EMBLEMA 4-22 */
/*=================================================*/
.box1emblema{
  width:100%;
  /*background:red;*/
}
.box2emblema{
  width:60%;
  position:absolute;
  left:20%;
  top:20%;
  margin: auto; 
}


/*=================================================*/
  /* Copas 4-22 */
/*=================================================*/

.box1copas{
  position:absolute;
  bottom:0;
  left:5%;
  width:25%;
  /*background:blue;*/
}
.box2copas img{
  width:40vh !important;
  height:32vh !important;
}
.box2copas{
  /*max-width:100%;*/
  /*width:125%;*/
  /*height:75vh;*/
  /*margin-right:0%;*/
  /*margin:auto;*/
  /*margin-left:12.5%;*/
  /*background:orange;*/
}

/*=================================================*/
  /* Botella 4-22 */
/*=================================================*/

.box1botella{
  position:absolute;
  bottom:0;
  right:0;
  width:23%;
  /*background:blue;*/
}
.box2botella img{
  width:110vh !important;
  height:45vh !important;
}
.box2botella{
  /*max-width:100%;*/
  /*width:125%;*/
  /*height:75vh;*/
  /*margin-right:0%;*/
  /*margin:auto;*/
  /*margin-left:12.5%;*/
  /*background:orange;*/
}

/*=================================================*/
   /* LOGOTIPO 4-22 */
/*=================================================*/

.box1logotipotop{
  display:none;
}
.box1logotipobottom{
  position:absolute;
  bottom:10%;
  width:40%;
  left:25%;
  /*background:red !important;*/
}
.box2logotipo{
  margin:auto;
  margin-left:25%;
  width:75%;
  /*background:blue;*/
}
/*=================================================*/


/*=================================================*/
@media screen and (min-width: 1024px) and (max-width: 1280px){
  .box1botella{
    /*background:blue;*/
  }
  .box2cintillo{
    width:10%;
    position:absolute;
    /*right:9%;*/
    top:15%;
  }
}


@media screen and (min-width: 860px) and (max-width: 1024px){
  .box1botella{
    position:absolute;
    /*bottom:5%;*/
    right:0;
    width:25%;
    /*background:red;*/
  }
  .box2botella img{
    /*width:117.5vh !important;*/
    height:45vh !important;
  }
  .box2emblema{
    width:65%;
    position:absolute;
    /*margin: auto; */
    left:17.5%;
    top:27.5%;
  }
  .box2cintillo{
    width:15vh;
    position:absolute;
    /*right:9%;*/
    top:15%;
  }
  .box1copas{
    position:absolute;
    bottom:0;
    left:1%;
    width:30%;
    /*background:blue;*/
  }
  .box2copas img{
    width:80vh !important;
    height:35vh !important;
  }
  .box1logotipobottom{
    /*position:absolute;*/
    bottom:12.5%;
    width:40%;
    /*background:red !important;*/
  }
  .box2logotipo{
    margin:auto;
    margin-left:12.5%;
    width:100%;
    /*background:blue;*/
  }
}


@media screen and (min-width: 640px) and (max-width: 860px){
  .box2cintillo{
    width:15vh;
    position:absolute;
    right:9%;
    top:15%;
  }
  .box1botella{
    /*background:green;*/
  }
  .box2botella img{
    width:80vh !important;
    height:40vh !important;
    /*height:auto !important;*/
  }
  .box2botella{
    width:100%;
    /*margin-left:0%;*/
  }
  .box1copas{
    /*background:green;*/
    position:absolute;
    bottom:0;
    left:1%;
    width:30%;
    /*background:blue;*/
  }
  .box2copas img{
    /*height:auto !important;*/
    width:75vh !important;
    height:30vh !important;
  }
  
  .box2copas{
    width:100%;
    /*margin-left:0%;*/
  }
  .box2emblema{
    width:70%;
    position:absolute;
    left:15%;
    top:30%;
  }
  .box1logotipobottom{
    position:absolute;
    bottom:10%;
    width:50%;
  }
  .box2logotipo{
    margin:auto;
    margin-left:6%;
    width:90%;
    /*background:blue;*/
  }
}


@media screen and (min-width: 520px) and (max-width: 640px){
  /*=================================================*/
    /* CINTILLO 4-22 */
  /*=================================================*/
  .box1cintillo{
    width:100%;
  }
  .box2cintillo{
    width:15vh;
    position:absolute;
    left:9%;
    top:12.5%;
  }
  /*=================================================*/
    /* EMBLEMA 4-22 */
  /*=================================================*/
  .box2emblema{
    width:80%;
    margin:auto;
    position:absolute;
    left:10%;
    right:10%;
    top:30%;
    z-index:10;
  }
  /*=================================================*/
    /* ESCALERAS 4-22 */
  /*=================================================*/
  .box1botella{
    position:absolute;
    bottom:0;
    right:0;
    width:60%;
    /*background:yellow;*/
  }
  .box2botella img{
    /*width:117.5vh !important;*/
    height:auto !important;
  }
  .box2botella{
    /*margin:auto;*/
    width:70%;
    margin-left:30%;
  }

  /*=================================================*/
    /* ESCALERAS 4-22 */
  /*=================================================*/
  .box1copas{
    position:absolute;
    bottom:0;
    left:0;
    width:50%;
    /*background:yellow;*/
  }
  .box2copas img{
    /*width:117.5vh !important;*/
    /*height:auto !important;*/
  }
  .box2copas{
    /*margin:auto;*/
    width:70%;
    margin-right:30%;
  }

  /*=================================================*/
     /* LOGOTIPO 4-22 */
  /*=================================================*/
  .box1logotipobottom{
    display:none;
  }
  .box1logotipotop{
    position:absolute;
    top:12%;
    right:2%;
    width:45%;
    display:block;
  }
  .box2logotipo{
    margin:auto;
    margin-left:15%;
    width:80%;
  }
  /*=================================================*/
}

@media screen and (min-width: 360px) and (max-width: 520px){
  /*=================================================*/
    /* CINTILLO 4-22 */
  /*=================================================*/
  .box1cintillo{
    width:100%;
  }
  .box2cintillo{
    width:12vh;
    position:absolute;
    left:9%;
    top:10%;
  }
  /*=================================================*/
    /* EMBLEMA 4-22 */
  /*=================================================*/
  .box2emblema{
    width:95%;
    margin:auto;
    position:absolute;
    left:2.5%;
    right:2.5%;
    top:33%;
    z-index:10;
  }
  /*=================================================*/
    /* ESCALERAS 4-22 */
  /*=================================================*/
  .box1botella{
    position:absolute;
    /*bottom:7.5%;*/
    right:0;
    width:60%;
    /*background:purple;*/
  }
  .box2botella img{
    /*width:180vh !important;*/
    /*height:auto !important;*/
    height:35vh !important;
  }
  .box2botella{
    /*margin:auto;*/
    /*background:pink;*/
    width:60%;
    margin-left:40%;
  }

  /*=================================================*/
    /* ESCALERAS 4-22 */
  /*=================================================*/
  .box1copas{
    position:absolute;
    /*bottom:7.5%;*/
    right:0;
    width:60%;
    /*background:purple;*/
  }
  .box2copas img{
    /*width:180vh !important;*/
    /*height:auto !important;*/
    height:30vh !important;
  }
  .box2copas{
    /*margin:auto;*/
    /*background:pink;*/
    width:60%;
    margin-right:40%;
  }
  /*=================================================*/
     /* LOGOTIPO 4-22 */
  /*=================================================*/
  .box1logotipobottom{
    display:none;
  }
  .box1logotipotop{
    position:absolute;
    top:10%;
    right:2%;
    width:50%;
    display:block;
    /*background:red;*/
  }
  .box2logotipo{
    margin:auto;
    margin-left:10%;
    width:90%;
    /*background:blue;*/
  }
  /*=================================================*/
}

@media screen and (min-width: 100px) and (max-width: 360px){
  /*=================================================*/
    /* CINTILLO 4-22 */
  /*=================================================*/
  .box1cintillo{
    width:100%;
  }
  .box2cintillo{
    width:10vh;
    position:absolute;
    left:9%;
    top:12%;
  }
  /*=================================================*/
    /* EMBLEMA 4-22 */
  /*=================================================*/
  .box2emblema{
    width:95%;
    margin:auto;
    position:absolute;
    left:2.5%;
    right:2.5%;
    top:33%;
    z-index:10;
    /*background:blue;*/
  }
  /*=================================================*/
    /* ESCALERAS 4-22 */
  /*=================================================*/
  .box1botella{
    position:absolute;
    /*bottom:7.5%;*/
    right:0;
    width:60%;
    /*background:purple;*/
  }
  .box2botella img{
    /*width:117.5vh !important;*/
    /*height:auto !important;*/
    height:35vh !important;
  }
  .box2botella{
    /*margin:auto;*/
    width:70%;
    margin-left:30%;
    /*background:orange;*/
  }

  /*=================================================*/
    /* ESCALERAS 4-22 */
  /*=================================================*/
  .box1copas{
    position:absolute;
    /*bottom:7.5%;*/
    right:0;
    width:60%;
    /*background:purple;*/
  }
  .box2copas img{
    /*width:117.5vh !important;*/
    /*height:auto !important;*/
    height:27vh !important;
  }
  .box2copas{
    /*margin:auto;*/
    width:70%;
    margin-right:30%;
    /*background:orange;*/
  }
  /*=================================================*/
     /* LOGOTIPO 4-22 */
  /*=================================================*/
  .box1logotipobottom{
    display:none;
  }
  .box1logotipotop{
    position:absolute;
    top:12%;
    right:2%;
    width:50%;
    display:block;
    /*background:red;*/
  }
  .box2logotipo{
    margin:auto;
    margin-left:10%;
    width:90%;
    /*background:blue;*/
  }
  /*=================================================*/
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
.btnContent{ font-size:1.5em; background:<?=$fucsia?>; border:0px solid #FFF;border-radius:10px;color:#FFF;bottom:7%;position:absolute;left:0%;padding:10px }
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