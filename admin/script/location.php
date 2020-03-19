<?php 

// set this function to set the $location path to the url
function redirect_to($location){
    if($location != null){
        header("Location: ".$location);
        exit;
    }
}
