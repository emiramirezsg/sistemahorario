@section('content')
<div class="container">
    <!-- Mostrar los horarios existentes aquí -->
    <button id="generateSchedulesButton" class="btn btn-primary">Generar Horarios</button>
</div>

<!-- Agregar JavaScript para manejar el clic del botón -->
<script>
document.getElementById('generateSchedulesButton').addEventListener('click', function() {
    // Realizar una solicitud AJAX para generar los horarios
    fetch('/generate-schedules', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        // Aquí puedes actualizar la vista o redirigir al usuario según sea necesario
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
</script>
@endsection


