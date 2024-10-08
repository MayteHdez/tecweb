<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 05</title>
</head>
<body>
<?php
    echo "<p>Ejercicio 1</p>";
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

    echo "<br><p>Ejercicio 2</p>";
    $a = "ManejadorSQL";
    $b = 'MySQL';
    $c = &$a;
    
    echo "<p>Primer bloque de asignaciones:</p>";
    echo "<p>$a</p>";
    echo "<p>$b</p>";
    echo "<p>$c</p>";

    $a = "PHP server";
    $b = &$a;

    echo "<p>Segundo bloque de asignaciones:</p>";
    echo "<p>$a</p>";
    echo "<p>$b</p>";
    echo "<p>$c</p>";

    unset($a, $b, $c);

    echo "<br><p>Ejercicio 3</p>";
    $a = "PHP5";
    echo "<p>$a (tipo: " . gettype($a) . ")</p>";

    $z[] = &$a;
    echo "<p>{$z[0]} (tipo: " . gettype($z) . ")</p>";

    $b = "5a version de PHP";
    echo "<p>$b (tipo: " . gettype($b) . ")</p>";

    $c = $b*10;
    echo "<p>$c (tipo: " . gettype($c) . ")</p>";

    $a .= $b;
    echo "<p>$a (tipo: " . gettype($a) . ")</p>";

    $b *= $c;
    echo "<p> $b (tipo: " . gettype($b) . ")</p>";

    $z[0] = "MySQL";
    echo "<p>{$z[0]} (tipo: " . gettype($z) . ")</p>";

    echo "<p>Componentes del array \$z:</p>";
    echo "<pre>";
    print_r($z);
    echo "</pre>";

    unset($a, $b, $c, $z);

    echo "<br><p>Ejercicio 4</p>";
    $a = "PHP5";
    echo "<p>" . $GLOBALS['a'] . " (tipo: " . gettype($GLOBALS['a']) . ")</p>";
    
    $z[] = &$a;
    echo "<p>" . $GLOBALS['z'][0] . " (tipo: " . gettype($GLOBALS['z']) . ")</p>";
    
    $b = "5a version de PHP";
    echo "<p>" . $GLOBALS['b'] . " (tipo: " . gettype($GLOBALS['b']) . ")</p>";
    
    $c = $b * 10;
    echo "<p>" . $GLOBALS['c'] . " (tipo: " . gettype($GLOBALS['c']) . ")</p>";
    
    $a .= $b;
    echo "<p>" . $GLOBALS['a'] . " (tipo: " . gettype($GLOBALS['a']) . ")</p>";
    
    $b *= $c;
    echo "<p>" . $GLOBALS['b'] . " (tipo: " . gettype($GLOBALS['b']) . ")</p>";
    
    $z[0] = "MySQL";
    echo "<p>" . $GLOBALS['z'][0] . " (tipo: " . gettype($GLOBALS['z']) . ")</p>";
    
    echo "<pre>";
    print_r($GLOBALS['z']);
    echo "</pre>";

    unset($a, $b, $c, $z, $GLOBALS['a'], $GLOBALS['b'], $GLOBALS['c'], $GLOBALS['z']);

    echo "<br><p>Ejercicio 5</p>";
    $a = "7 personas";
    $b = (integer) $a;
    $a = "9E3";
    $c = (double) $a;

    echo "$a<br>";
    echo "$b<br>";
    echo "$c<br>";

    unset($a, $b, $c);

    echo "<br><p>Ejercicio 6</p>";
    $a = "0";
    $b = "TRUE";
    $c = FALSE;
    $d = ($a OR $b);
    $e = ($a AND $c);
    $f = ($a XOR $b);

    var_dump((bool)$a);
    echo "<br>";
    var_dump((bool)$b); 
    echo "<br>";
    var_dump((bool)$c);
    echo "<br>"; 
    var_dump((bool)$d);
    echo "<br>"; 
    var_dump((bool)$e);
    echo "<br>"; 
    var_dump((bool)$f); 
    echo "<br><br>";

    echo "Valor de \$c: " . var_export($c, true) . "<br>";
    echo "Valor de \$e: " . var_export($e, true) . "<br>";
    unset($a, $b, $c, $d, $e, $f);

    echo "<br><p>Ejercicio 7</p>";
    $apache_version = $_SERVER['SERVER_SOFTWARE'];
    $php_version = phpversion();

    $server_os = php_uname();

    $client_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

    echo "Versión de Apache: $apache_version<br>";
    echo "Versión de PHP: $php_version<br>";
    echo "Sistema operativo del servidor: $server_os<br>";
    echo "Idioma del navegador del cliente: $client_language<br>";
   
    ?> 
    <p>
    <a href="https://validator.w3.org/markup/check?uri=referer"><img
      src="https://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a>
    </p>
</body>
</html>
