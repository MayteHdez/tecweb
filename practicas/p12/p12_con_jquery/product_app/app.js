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
    console.log('jQuery is Working');
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
})
});


$('#product-form').submit(function(e){
    const postData = {
        name: $('#name').val(),
        description: $('#description').val()
    };
    $.post('backend/product-add.php', postData, function(response) {
            console.log(response);
            $('#name').val('');
            init();
            //$('#product-form').trigger('reset');
    });
    e.preventDefault();    
    });

    $.ajax({
        url: 'backend/product-list.php',
        type: 'GET',
        success: function(response){
            let products = JSON.parse(response);
            let template = '';
            products.forEach(product =>{
                template += `
                    <tr>
                        <td>${product.id}</td>
                        <td>${product.nombre}</td>
                        <td>${product.detalles}</td>
                    </tr>
                `
            });
            $('#products').html(template);


    }
})

    
//});
