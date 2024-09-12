<?php

function mult5y7($num) {

            if ($num%5==0 && $num%7==0)
            {
                echo '<h3>R= El número '.$num.' SÍ es múltiplo de 5 y 7.</h3>';
            }
            else
            {
                echo '<h3>R= El número '.$num.' NO es múltiplo de 5 y 7.</h3>';
            }
        }

    function generarSecuenciaValida() {
        $filas = [];
        $iteraciones = 0;
        $numerosGenerados = 0;

        function verificarSecuencia($numeros) {
            return ($numeros[0] % 2 != 0 && $numeros[1] % 2 == 0 && $numeros[2] % 2 != 0);
        }
        
        function generarNumeroAleatorio($min, $max) {
            return rand($min, $max);
        }
        
        while(count($filas)<4) {
            $numeros = [
                generarNumeroAleatorio(1, 1000),
                generarNumeroAleatorio(1, 1000),
                generarNumeroAleatorio(1, 1000)
            ];
            
            $numerosGenerados += 3;
            $iteraciones++;
            
            if (verificarSecuencia($numeros)) {
                $filas[] = $numeros;
            }
        }
        
 
        echo "<table border='1'>";
        echo "<tr><th>impar</th><th>par</th><th>impar</th></tr>";
        foreach ($filas as $fila) {
            echo "<tr>";
            foreach ($fila as $numero) {
                echo "<td>$numero</td>";
            }
            echo "</tr>";
        }
        echo "</table>";

        echo "<p>Iteraciones: $iteraciones</p>";
        echo "<p>Números generados: $numerosGenerados</p>";
    }

    function numeroEntero($num) {
        $min =1;
        $max =1000;
        do {
            $numAleatorio = rand($min, $max);
        }while($numAleatorio % $num!=0);
        echo $numAleatorio.' es el primer número entero obtenido aleatoriamente, múltiplo de '.$num;
    }

    function tabla() {
        $arreglo = array();
        for ($i = 97; $i <= 122; $i++) {
            $arreglo[$i] = chr($i); 
        }

        echo "<table border='1'>";
        echo "<tr><th>Índice</th><th>Letra</th></tr>";
        foreach ($arreglo as $key => $value) {
            echo "<tr>";
            echo "<td>$key</td>";  
            echo "<td>$value</td>";  
            echo "</tr>";
        }
        echo "</table>";
    }

    ?>
