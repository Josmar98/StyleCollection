<?php





if (is_file('public/views/'.$url.'.php')) {
    require_once 'public/views/'.$url.'.php';

}else{

    require_once 'public/views/error404.php';

}



?>