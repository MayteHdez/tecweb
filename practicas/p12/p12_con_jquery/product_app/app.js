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
    document.getElementById("description").value = JsonString;

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


$('#product-form').submit(function(e){
    const postData = {
        name: $('#name').val(),
        description: $('#description').val(),
        id: $('#productId').val()
    };

    let url = edit === false ? 'backend/product-add.php' : 'backend/product-edit.php';
    

    $.post(url, postData, function(response) {

            //AGREGADOOOOOOOOOOO
            let responseData = JSON.parse(response); // Asegúrate de que la respuesta sea un JSON válido
            $('#container').html(`<div class="alert alert-${responseData.status}">${responseData.message}</div>`);  
            fetchProducts();
            $('#product-result').show();
            
            $('#name').val('');
            init();
            //$('#product-form').trigger('reset');
    });
    e.preventDefault();    
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
