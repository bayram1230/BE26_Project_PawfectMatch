<?php

function cleanInput($input) {
    $data = trim($input);          
    $data = strip_tags($data);      
    $data = htmlspecialchars($data); 
    return $data;
}

?>
