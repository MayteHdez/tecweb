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
        
        do {
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
        } while (count($filas) === 0); // Repetir hasta encontrar al menos una secuencia válida
        
        // Mostrar resultados

        echo "<table border='1'>";
        echo "<tr><th>Columna 1</th><th>Columna 2</th><th>Columna 3</th></tr>";
        foreach ($filas as $fila) {
            echo "<tr>";
            foreach ($fila as $numero) {
                echo "<td>$numero</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    

    ?>
