function getDatos()
        {
            var nombre = window.prompt("Nombre","");
            var edad = window.prompt("Edad","");

            var div1 = document.getElementById('nombre');
            div1.innerHTML = '<h3> Nombre: '+ nombre + '</h3>';

            var div2 = document.getElementById('edad');
            div2.innerHTML = '<h3> Edad: '+ edad + '</h3>';
        }

function ej1()
{
    let div1 = document.getElementById("div1");
    div1.innerHTML = "Hola Mundo";     
}

function ej2()
{
    var nombre = 'Juan';
    var edad = 10;
    var altura = 1.92;
    var casado = false;

    var div2 = document.getElementById("div2");
    div2.innerHTML = `
        Nombre: ${nombre} <br>
        Edad: ${edad} <br>
        Altura: ${altura} <br>
        Casado: ${casado}
    `;
}

function ej3() {
    var nombre;
    var edad;
    nombre = prompt('Ingresa tu nombre:', '');
    edad = prompt('Ingresa tu edad:', '');

    let div3 = document.getElementById("div3"); 
    div3.innerHTML = `Hola ${nombre}, así que tienes ${edad} años.`;  
}


function ej4()
{
    var valor1;
    var valor2;
    valor1 = prompt('Introducir primer número:', '');
    valor2 = prompt('Introducir segundo número', '');
    var suma = parseInt(valor1)+parseInt(valor2);
    var producto = parseInt(valor1)*parseInt(valor2);
    document.getElementById('div4').innerHTML = 
        'La suma es ' + suma + '<br>El producto es ' + producto;
}

function ej5()
{
    var nombre;
    var nota;
    nombre = prompt('Ingresa tu nombre:', '');
    nota = prompt('Ingresa tu nota:', '');
    if (nota >= 4) {
        document.getElementById('div5').innerHTML = 
            nombre + ' está aprobado con un ' + nota;
    }
}

function ej6()
{
    var num1,num2;
    num1 = prompt('Ingresa el primer número:', '');
    num2 = prompt('Ingresa el segundo número:', '');
    num1 = parseInt(num1);
    num2 = parseInt(num2);        
        if (num1 > num2) {
            document.getElementById('div6').innerHTML = 'El mayor es ' + num1;
        } else {
            document.getElementById('div6').innerHTML = 'El mayor es ' + num2;
        }
    }
    

function ej7()
{
    var nota1,nota2,nota3;

    nota1 = prompt('Ingresa 1ra. nota:', '');
    nota2 = prompt('Ingresa 2da. nota:', '');
    nota3 = prompt('Ingresa 3ra. nota:', '');

    //Convertimos los 3 string en enteros
    nota1 = parseInt(nota1);
    nota2 = parseInt(nota2);
    nota3 = parseInt(nota3);

    var pro;
    pro = (nota1+nota2+nota3)/3;

    if (pro >= 7) {
        resultado = 'Aprobado';
    } else if (pro>= 4) {
        resultado = 'Regular';
    } else {
        resultado = 'Reprobado';
    }

    document.getElementById('div7').innerHTML = resultado;
}

function ej8()
{
    var valor;
    valor = prompt('Ingresar un valor comprendido entre 1 y 5:', '' );
    //Convertimos a entero
    valor = parseInt(valor);
    switch (valor) {
        case 1: texto = 'uno'; break;
        case 2: texto = 'dos'; break;
        case 3: texto = 'tres'; break;
        case 4: texto = 'cuatro'; break;
        case 5: texto = 'cinco'; break;
        default: texto = 'Debe ingresar un valor comprendido entre 1 y 5.'; break;
    }

    document.getElementById('div8').innerHTML = texto;
}

function ej9()
{
    var col;
    col = prompt('Ingresa el color con que quierar pintar el fondo de la ventana (rojo, verde, azul)' , '' );
    switch (col) {
        case 'rojo': document.bgColor='#ff0000';
                break;
        case 'verde': document.bgColor='#00ff00';
                break;
        case 'azul': document.bgColor='#0000ff';
                break;
    }
}

function ej10()
{
    var x;
    x=1;
    var resultado = '';
    while (x<=100) {
        resultado += x + '<br>';
        x=x+1;
    }

    document.getElementById('div10').innerHTML = resultado;
}

function ej11()
{
    var x=1;
    var suma=0;
    var valor;
    while (x<=5){
        valor = prompt('Ingresa el valor:', '');
        valor = parseInt(valor);
        suma += valor;
        x = x+1;
    }
    document.getElementById('div11').innerHTML = 'La suma de los valores es ' + suma + '<br>';
}

function ej12()
{
    var valor;
    var resultado = '';
do{
    valor = prompt('Ingresa un valor entre 0 y 999:', '');
    valor = parseInt(valor);
    resultado += 'El valor ' + valor + ' tiene ';
        
        if (valor < 10) {
            resultado += 'Tiene 1 dígito';
        } else if (valor < 100) {
            resultado += 'Tiene 2 dígitos';
        } else if (valor < 1000) {
            resultado += 'Tiene 3 dígitos';
        }
        
        resultado += '<br>';
    } while (valor != 0);

    document.getElementById('div12').innerHTML = resultado; 
}

function ej13()
{
    var f;
    var resultado = '';
    for(f=1; f<=10; f++)
    {
        resultado += f + ' ';
    }    
    document.getElementById('div13').innerHTML = resultado;
}

function ej14()
{
    var resultado = '';
    resultado += 'Cuidado<br>';
    resultado += 'Ingresa tu documento correctamente<br>';
    resultado += 'Cuidado<br>';
    resultado += 'Ingresa tu documento correctamente<br>';
    resultado += 'Cuidado<br>';
    resultado += 'Ingresa tu documento correctamente<br>';

    document.getElementById('div14').innerHTML = resultado;
}

function ej15()
{
    
}

function ej16()
{
    
}

function ej17()
{
    
}

function ej18()
{
    
}