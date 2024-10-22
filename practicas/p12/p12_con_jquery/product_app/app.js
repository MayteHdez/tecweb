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

$(function(){
    console.log('jQuery is Working');
    $('#product-result').hide();

    $('#search').keyup(function(e){
        if($('#search').val()){
            let search = $('#search').val();
            $.ajax({
                url: 'backend/product-search.php',
                type: 'POST', //POST O GET???
                data:{search},
                success: function(response){
                    let products = JSON.parse(response);
                    let template ='';
                    products.forEach(product =>{
                        template += `<li> ${product.name}</li>`
                    });
                    $('#container').html(template);
                    $('#product-result').show();
            }
       });

        }       
})
});

$('#product-form').submit(function(e){
    e.preventDefault();

    const postData = {
        nombre: $('#name').val(),
        descripcion: $('#description').val()
    };

    $.ajax({
        url: 'backend/product-add.php',
        type: 'POST',
        contentType: 'application/json', // Aseguramos que se envíe como JSON
        data: JSON.stringify(postData), // Convertimos a JSON
        success: function(response) {
            console.log(response);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
    
});
