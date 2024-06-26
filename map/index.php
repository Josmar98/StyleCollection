<?php
if(file_exists('locations.php')){
    if(is_file('locations.php')){
        require 'locations.php';
    }
}
if(file_exists('maps.php')){
    if(is_file('maps.php')){
        require 'maps.php';
    }
}
?>