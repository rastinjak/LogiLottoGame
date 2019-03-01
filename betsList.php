<?php
    require_once 'db_engine.php';

    $db = new Baza();
    $db->printBets();
    //$db->InLast3Minutes();
    
?>