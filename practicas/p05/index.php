<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Práctica 05</title>
</head>
<body>
<?php
    $_myvar = "_myvar";
    $_7var = "_7var";
    $myvar = "myvar";
    $var7 = "var7";
    $_element1 = "_element1";
    //$house*5 = "house*5"; Marca un error de sintaxis
    
    echo "<p>$_myvar</p>";
    echo "<p>$_7var</p>";
    echo "<p>$myvar</p>";
    echo "<p>$var7</p>";
    echo "<p>$_element1</p>";
    //echo "<p>$house*5 </p>";

    unset($_myvar, $_7var, $myvar, $var7, $_element1);

    
    ?> 
</body>
</html>
