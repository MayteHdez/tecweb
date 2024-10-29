$(document).ready(function(){
    let edit = false;

    $('#product-result').hide();
    listarProductos();

    // FUNCIONES DE VALIDACIÓN
    function validateField(field, condition, message) {
      if (!condition) {
        $(`#${field}-status`).html(`<small class="text-danger">${message}</small>`);
        return false;
      } else {
        $(`#${field}-status`).html('');
        return true;
      }
    }

    $('#nombre').on('blur', function() {
      const nombre = $(this).val();
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
              $('#nombre-status').html(`<small class="text-danger">El nombre ya existe en la base de datos</small>`);
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

    // SUBMIT FORMULARIO
    $('#product-form').submit(e => {
      e.preventDefault();
      
      let valid = true;
      
      valid &= validateField('nombre', $('#nombre').val().length > 0 && $('#nombre').val().length <= 100, 'El nombre es requerido y debe tener 100 caracteres o menos');
      valid &= validateField('marca', $('#marca').val() !== '', 'La marca es requerida');
      valid &= validateField('modelo', /^[a-zA-Z0-9]+$/.test($('#modelo').val()) && $('#modelo').val().length <= 25, 'El modelo debe ser alfanumérico y tener 25 caracteres o menos');
      valid &= validateField('precio', parseFloat($('#precio').val()) > 99.99, 'El precio debe ser mayor a 99.99');
      valid &= validateField('unidades', parseInt($('#unidades').val()) >= 0, 'Las unidades deben ser mayores o iguales a 0');
      
      if (valid) {
        let postData = {
          nombre: $('#nombre').val(),
          marca: $('#marca').val(),
          modelo: $('#modelo').val(),
          precio: parseFloat($('#precio').val()),
          detalles: $('#detalles').val() || 'NA',
          unidades: parseInt($('#unidades').val()),
          imagen: $('#imagen').val() || 'img/default.png',
          id: $('#productId').val()
        };

        const url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';
        
        $.post(url, postData, (response) => {
          let respuesta = JSON.parse(response);
          alert(respuesta.msg);

          $('#product-form').trigger('reset');
          listarProductos();
        });
      } else {
        alert('Por favor, revisa los campos antes de agregar el producto.');
      }
    });

    function listarProductos() {
      $.ajax({
        url: './backend/product-list.php',
        type: 'GET',
        success: function(response) {
          const productos = JSON.parse(response);
          let template = '';
          productos.forEach(producto => {
            template += `
              <tr>
                <td>${producto.id}</td>
                <td>${producto.nombre}</td>
                <td>${producto.detalles}</td>
              </tr>
            `;
          });
          $('#productos').html(template);
        }
      });
    }
});
