<?php
    try {        
               
        $pdo = new PDO('mysql:host=143.106.241.3;dbname=cl200471;charset=utf8', 'cl200471', 'cl*16042004');
        
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $output = 'Conexão on. <br>';
    } catch (PDOException $e) {
        $output = 'Conexão off, erro : ' . $e . '<br>';
    }
    
?>