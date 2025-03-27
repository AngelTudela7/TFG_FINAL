$('#comment-form').on('submit', function(event) {
    event.preventDefault();
    var comentario = $('textarea[name="comentario"]').val();
    var ticket_id = <?php echo $fila['id']; ?>; // El ID del ticket

    $.ajax({
        url: 'agregar_comentario.php',
        method: 'POST',
        data: {
            comentario: comentario,
            ticket_id: ticket_id
        },
        success: function(response) {
            // Mostrar el comentario recién agregado
            $('#comments-section').append(response);
            $('textarea[name="comentario"]').val(''); // Limpiar el campo
        },
        error: function() {
            alert("Error al agregar comentario");
        }
    });
});