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
// Validación de campos
function validateField(fieldId, isValid, errorMessage) {
    const field = $('#' + fieldId);
    const statusField = $('#' + fieldId + '-status'); // Elemento para mostrar el estado del campo

    if (isValid) {
        field.removeClass('is-invalid').addClass('is-valid'); // Agrega clases de validación
        statusField.html(''); // Limpia el mensaje de error
    } else {
        field.removeClass('is-valid').addClass('is-invalid');
        statusField.html(`<small class="text-danger">${errorMessage}</small>`); // Muestra el mensaje de error
    }
}


$(document).ready(function() {
    // Función de validación
    function validateField(fieldId, isValid, errorMessage) {
        if (!isValid) {
            $(`#${fieldId}-status`).html(`<small class="text-danger">${errorMessage}</small>`);
            return false;
        } else {
            $(`#${fieldId}-status`).html('');
            return true;
        }
    }

    // Validaciones al perder el foco en los campos
    $('#name').on('blur', function() {
        const name = $(this).val().trim();
        validateField('name', name.length > 0 && name.length <= 100, 'El nombre es requerido y debe tener 100 caracteres o menos');

        // Verificar si el nombre existe en la BD
        if (name) {
            $.ajax({
                url: './backend/product-check-name.php',
                type: 'GET',
                data: { nombre: name },
                success: function(response) {
                    const exists = JSON.parse(response).exists;
                    if (exists) {
                        $('#name-status').html(`<small class="text-danger">El nombre ya existe en la base de datos</small>`);
                    }
                },
                error: function() {
                    $('#name-status').html(`<small class="text-danger">Error al verificar el nombre</small>`);
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
        validateField('unidades', !isNaN(unidades) && unidades >= 0, 'Las unidades deben ser mayores o iguales a 0');
    });

    $('#product-form').submit(function(e) {
        e.preventDefault(); // Evita que se envíe el formulario de forma tradicional
    
        // Validación de los campos del formulario
        const name = $('#name').val().trim();
        const marca = $('#marca').val().trim();
        const modelo = $('#modelo').val().trim();
        const precio = parseFloat($('#precio').val());
        const unidades = parseInt($('#unidades').val());
        const detalles = $('#detalles').val() || 'Sin detalles';
        const imagen = $('#imagen').val() || 'imgdefault.png'; // Posible error: 'img/default.png'
    
        const isValid = validateField('name', name.length > 0 && name.length <= 100, 'El nombre es requerido y debe tener 100 caracteres o menos') &&
                        validateField('marca', marca !== '', 'La marca es requerida') &&
                        validateField('modelo', /^[a-zA-Z0-9]+$/.test(modelo) && modelo.length <= 25, 'El modelo debe ser alfanumérico y tener 25 caracteres o menos') &&
                        validateField('precio', !isNaN(precio) && precio > 99.99, 'El precio debe ser mayor a 99.99') &&
                        validateField('detalles', detalles.length <= 250, 'Los detalles deben tener 250 caracteres o menos') &&
                        validateField('unidades', !isNaN(unidades) && unidades >= 0, 'Las unidades deben ser mayores o iguales a 0');
    
        if (isValid) {
            const postData = {
                nombre: name,
                precio: precio,
                unidades: unidades,
                modelo: modelo,
                marca: marca,
                detalles: detalles,
                imagen: imagen
            };
    
            let url = edit === false ? 'backend/product-add.php' : 'backend/product-edit.php';
    
            // Comienza la llamada AJAX
            $.post(url, postData, function(response) {
                console.log(response); // Para depurar y ver la respuesta del servidor
    
                let responseData;
                try {
                    responseData = JSON.parse(response);
                    $('#container').html(`<div class="alert alert-${responseData.status}">${responseData.message}</div>`);
                    
                    // Actualizar la lista de productos
                    fetchProducts();
                    
                    // Mostrar el resultado
                    $('#product-result').show();
                    
                    // Limpiar el formulario
                    $('#product-form').trigger('reset');
                } catch (error) {
                    console.error("Error parsing JSON:", error);
                    $('#container').html('<div class="alert alert-danger">Error al procesar la respuesta del servidor</div>');
                }
            }).fail(function() {
                $('#container').html('<div class="alert alert-danger">Error al agregar producto</div>');
            });
        }
    });
    
});
// Listar productos
function fetchProducts() {
    $.ajax({
        url: 'backend/product-list.php',
        type: 'GET',
        dataType: 'json', // Asegúrate de que jQuery trate la respuesta como JSON
        success: function(response) {
            console.log('Raw response:', response);  // Mostrar la respuesta en la consola

            // Verificar si la respuesta contiene la propiedad 'data' y si es un array
            if (response.status === 'success' && Array.isArray(response.data)) {
                let template = '';
                response.data.forEach(product => {
                    // Generar la tabla de productos
                    template += 
                        `<tr productId="${product.id}">
                            <td>${product.id}</td>
                            <td>
                                <a href="#" class="task-item">${product.nombre}</a>
                            </td>
                            <td>
                                <strong>Precio:</strong> ${product.precio} <br>
                                <strong>Unidades:</strong> ${product.unidades} <br>
                                <strong>Modelo:</strong> ${product.modelo} <br>
                                <strong>Marca:</strong> ${product.marca} <br>
                                <strong>Detalles:</strong> ${product.detalles} <br>
                            </td>
                            <td>
                                <button class="task-delete btn btn-danger">Eliminar</button>
                            </td>
                        </tr>`;
                });
                $('#products').html(template);  // Inyectar el HTML generado en el contenedor
            } else {
                console.error('Error: La respuesta no contiene un array de productos.');
            }
        },
        error: function(xhr, status, error) {
            // Manejo de errores de la solicitud AJAX
            console.error('Error en la solicitud AJAX:', status, error);
        }
    });
}






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