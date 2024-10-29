// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
  };


function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    //document.getElementById("description").value = JsonString;

    // SE LISTAN TODOS LOS PRODUCTOS
    //listarProductos();
}

$(document).ready(function(){
    let edit = false;

    console.log('jQuery is Working');
    fetchProducts();
    $('#product-result').hide();

    $('#search').keyup(function(e){
        if($('#search').val()){
            let search = $('#search').val();
            $.ajax({
                url: 'backend/product-search.php',
                type: 'POST', //POST 
                data:{search},
                success: function(response){
                    let products = JSON.parse(response);
                    let template ='';
                    products.forEach(product =>{
                        template += `<li> ${product.nombre}</li>`//hace que muestre solo el nombre d elo que estas buscando
                    });
                    $('#container').html(template);
                    $('#product-result').show();
            }
       });

        }       

});

$(document).ready(function() {
    // Función para validar los campos
    function validateField(fieldId, isValid, message) {
        if (isValid) {
            $(`#${fieldId}-status`).html(''); // Limpia el mensaje de error si es válido
        } else {
            $(`#${fieldId}-status`).html(`<small class="text-danger">${message}</small>`); // Muestra el mensaje de error
        }
    }

    // Validaciones al perder el foco
    $('#name').on('blur', function() {
        const nombre = $(this).val().trim();
        validateField('nombre', nombre.length > 0 && nombre.length <= 100, 'El nombre es requerido y debe tener 100 caracteres o menos');

        // Verificar si el nombre existe en la BD
        if (nombre) {
            $.ajax({
                url: './backend/product-check-name.php',
                type: 'GET',
                data: { nombre },
                success: function(response) {
                    const exists = JSON.parse(response).exists;
                    if (exists) {
                        $('#name-status').html(`<small class="text-danger">El nombre ya existe en la base de datos</small>`);
                    }
                }
            });
        }
    });

    $('#marca').on('blur', function() {
        const marca = $(this).val();
        validateField('marca', marca !== '', 'La marca es requerida');
    });

    $('#modelo').on('blur', function() {
        const modelo = $(this).val();
        validateField('modelo', /^[a-zA-Z0-9]+$/.test(modelo) && modelo.length <= 25, 'El modelo debe ser alfanumérico y tener 25 caracteres o menos');
    });

    $('#precio').on('blur', function() {
        const precio = parseFloat($(this).val());
        validateField('precio', !isNaN(precio) && precio > 99.99, 'El precio debe ser mayor a 99.99');
    });

    $('#detalles').on('blur', function() {
        const detalles = $(this).val();
        validateField('detalles', detalles.length <= 250, 'Los detalles deben tener 250 caracteres o menos');
    });

    $('#unidades').on('blur', function() {
        const unidades = parseInt($(this).val());
        validateField('unidades', unidades >= 0, 'Las unidades deben ser mayores o iguales a 0');
    });

    $('#product-form').submit(function(e) {
        e.preventDefault(); // Evita que se envíe el formulario de forma tradicional

        // Validaciones finales antes de enviar
        const nombre = $('#name').val().trim();
        const marca = $('#marca').val();
        const modelo = $('#modelo').val().trim();
        const precio = parseFloat($('#precio').val());
        const unidades = parseInt($('#unidades').val());
        const detalles = $('#detalles').val().trim();

        let isValid = true;

        if (nombre.length === 0 || nombre.length > 100) {
            validateField('nombre', false, 'El nombre es requerido y debe tener 100 caracteres o menos');
            isValid = false;
        }

        if (marca === '') {
            validateField('marca', false, 'La marca es requerida');
            isValid = false;
        }

        if (!/^[a-zA-Z0-9]+$/.test(modelo) || modelo.length > 25) {
            validateField('modelo', false, 'El modelo debe ser alfanumérico y tener 25 caracteres o menos');
            isValid = false;
        }

        if (isNaN(precio) || precio <= 99.99) {
            validateField('precio', false, 'El precio debe ser mayor a 99.99');
            isValid = false;
        }

        if (detalles.length > 250) {
            validateField('detalles', false, 'Los detalles deben tener 250 caracteres o menos');
            isValid = false;
        }

        if (isNaN(unidades) || unidades < 0) {
            validateField('unidades', false, 'Las unidades deben ser mayores o iguales a 0');
            isValid = false;
        }

        // Si todas las validaciones son correctas, enviar el formulario
        if (isValid) {
            const postData = {
                name: nombre,
                precio: precio,
                unidades: unidades,
                modelo: modelo,
                marca: marca,
                detalles: detalles || 'Sin detalles', // Valor por defecto si está vacío
                imagen: $('#imagen').val() || 'img/default.png' // Valor por defecto si está vacío
            };

            let url = edit === false ? 'backend/product-add.php' : 'backend/product-edit.php';

            // Enviar los datos al servidor
            $.post(url, postData, function(response) {
                let responseData = JSON.parse(response); // Asegúrate de que la respuesta sea un JSON válido
                $('#container').html(`<div class="alert alert-${responseData.status}">${responseData.message}</div>`);
                fetchProducts(); // Función para actualizar la lista de productos
                $('#product-result').show();
                $('#product-form').trigger('reset'); // Resetea el formulario después del envío
            }).fail(function() {
                $('#container').html(`<div class="alert alert-danger">Error al agregar producto</div>`);
            });
        }
    });
});


    function fetchProducts(){
        $.ajax({
            url: 'backend/product-list.php',
            type: 'GET',
            success: function(response){
                let products = JSON.parse(response);
                let template = '';
                products.forEach(product =>{
                    template += `
                        <tr productId = "${product.id}">
                            <td>${product.id}</td>
                            <td>
                                <a href= "#" class="task-item">${product.nombre}</a>
                            </td>
                            <td>
                            <strong>precio:</strong>${product.precio} <br>
                            <strong>unidades:</strong>${product.unidades} <br>
                            <strong>modelo:</strong>${product.modelo} <br>
                            <strong>marca:</strong>${product.marca} <br>
                            <strong>detalles:</strong>${product.detalles} <br>
                            </td>
                            <td>
                                <button class= "task-delete btn btn-danger">
                                    Delete
                                </button>
                            </td>
                        </tr>

                    `
                });
                $('#products').html(template);


    }
})}

$(document).on('click', '.task-delete', function(){
    if(confirm('¿Estas seguro de querer eliminarlo?')){
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('productId');
        $.post('backend/product-delete.php', {id}, function(response){
            let responseData = JSON.parse(response); // Asegúrate de que la respuesta sea un JSON válido
            $('#container').html(`<div class="alert alert-${responseData.status}">${responseData.message}</div>`);  
            fetchProducts();
            $('#product-result').show();
        });
    }
});

$(document).on('click', '.task-item', function(){
    let element = $(this)[0].parentElement.parentElement;
    let id = $(element).attr('productId');
    $.post('backend/product-single.php',{id}, function(response){
        //console.log(response);
        const product = JSON.parse(response);
        $('#name').val(product.nombre);
        //const descripcion = `precio: ${product.precio}\nunidades: ${product.unidades}\nmodelo: ${product.modelo}\nmarca: ${product.marca}\ndetalles: ${product.detalles}\nimagen: ${product.imagen}`;
        const descripcion = `{
            "precio": ${product.precio},
            "unidades": ${product.unidades},
            "modelo": "${product.modelo}",
            "marca": "${product.marca}",
            "detalles": "${product.detalles}",
            "imagen": "${product.imagen}"
          }`;
        $('#description').val(descripcion);
        $('#productId').val(product.id);
        edit = true;

    })

});
})
//})
