<?php
    require("ConcreteClass1.php");

    $files = array("1.csv", "2.csv", "3.csv");

    $concrete1 = new ConcreteClass1($files);
    $concrete1->GetFileContent();
    $concrete1->GenerateNewFile();
?>