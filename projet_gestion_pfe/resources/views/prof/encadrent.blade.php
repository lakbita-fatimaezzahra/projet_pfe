@extends('layouts.prof')

@section('title', 'Liste des Stagiaires')

@section('content')
<style>
    .container {
        max-width: 95%;
        margin: 0 auto;
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
        color: #005522;
        font-weight: bold;
        text-align: center;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #005522;
        color: white;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    .btn-success {
        background-color: #005522;
        border-color: #005522;
        font-size: 1rem;
        padding: 8px 20px;
        border-radius: 5px;
    }
    .btn-info {
        background-color: #005522;
        border-color: #005522;
        font-size: 1rem;
        padding: 8px 20px;
        border-radius: 5px;

    }
    .btn-info:hover {
        background-color: #1a6ba0;
        border-color: #1a6ba0;
    }

    .btn-success:hover {
        background-color: #1a6ba0;
        border-color: #1a6ba0;
    }

    /* Center Modal */
    .modal {
    display: none; /* Initially hidden */
    position: fixed;
    top: 0; /* Start at the top of the page */
    left: 0; /* Start at the left of the page */
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    background: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    justify-content: center; /* Center content horizontally */
    align-items: center; /* Center content vertically */
}

    .modal-content {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        width: 50%;
        position: relative;
    }

    .modal-header .close {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 1.5rem;
        border: none;
        background: transparent;
    }
    
</style>

<div class="container mt-5">
    <h1 class="mb-4">Liste des Stagiaires</h1>
    @include('components.flashbag')
    <table>
        <thead>
            <tr>
                <th>Étudiant</th>
                <th>Département</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $stage)
            <tr>
                <td>{{ $stage->etudiant_name }}</td>
                <td>{{ $stage->departement_libelle }}</td>
                <td>
                    <button class="btn btn-success btn-sm open-planning-modal" 
                            data-stage-id="{{ $stage->stage_id }}" 
                            data-stage-name="{{ $stage->etudiant_name }}">
                        Planning
                    </button>
        
                    <a href="{{ url('/showplannings/' . $stage->stage_id) }}" class="btn btn-info">
                        Commentaire
                    </a>
                    
        
                    <!-- 'Afficher' button to show plannings with comments -->
                  
                </td>
            </tr>
            @endforeach
        </tbody>
        
    </table>
</div>

<!-- Modal for Adding Planning -->
<div class="modal" id="planningModal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Ajouter Planning pour <span id="stageName"></span></h5>
            <button type="button" class="close" onclick="closeModal()">&times;</button>
        </div>
        <form action="" method="POST" id="planningForm">
            @csrf
            <input type="hidden" id="stageId" name="stage_id">
            
            <!-- Error Container -->
            <div id="errorContainer" style="display: none; color: red; margin-bottom: 10px;"></div>

            <div class="modal-body">
                <!-- Date -->
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
                <!-- Heure début -->
                <div class="form-group">
                    <label for="heure_debut">Heure début</label>
                    <input type="time" class="form-control" id="heure_debut" name="heure_debut" required>
                </div>
                <!-- Heure fin -->
                <div class="form-group">
                    <label for="heure_fin">Heure fin</label>
                    <input type="time" class="form-control" id="heure_fin" name="heure_fin" required>
                </div>
                <!-- Emplacement -->
                <div class="form-group">
                    <label for="emplacement">Emplacement</label>
                    <select class="form-control" id="emplacement" name="emplacement" required>
                        <option value="à distance">À distance</option>
                        <option value="présentiel">Présentiel</option>
                    </select>
                </div>
                <!-- Salle (only for Présentiel) -->
                <div class="form-group" id="salleContainer" style="display: none;">
                    <label for="salle_id">Salle</label>
                    <select class="form-control" id="salle_id" name="salle_id"></select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="closeModal()">Fermer</button>
                <button type="submit" class="btn btn-success">Ajouter Planning</button>
            </div>
        </form>
    </div>
</div>


<script>
   $(document).ready(function () {
    // Open modal and set dynamic data
    $('.open-planning-modal').on('click', function () {
        let stageId = $(this).data('stage-id');
        let stageName = $(this).data('stage-name');

        $('#stageId').val(stageId);
        $('#stageName').text(stageName);

        $('#planningModal').fadeIn();
        let formAction = '/stages/' + stageId + '/planning';
        $('#planningForm').attr('action', formAction);
    });

    // Close modal
    function closeModal() {
        $('#planningModal').fadeOut(); // Hide modal
        $('#errorContainer').hide().html(''); // Clear error messages
        $('#planningForm')[0].reset(); // Reset the form
        $('#salleContainer').hide(); // Hide salle selection if visible
    }

    // Show/hide salle selection
    $('#emplacement').on('change', function () {
        if ($(this).val() === 'présentiel') {
            $('#salleContainer').show();
            fetchAvailableSalles();
        } else {
            $('#salleContainer').hide();
        }
    });

    // Fetch available salles via AJAX
    function fetchAvailableSalles() {
        let stageId = $('#stageId').val();

        $.ajax({
            url: '/available-salles/' + stageId,
            method: 'GET',
            success: function (data) {
                $('#salle_id').empty();
                if (data.length > 0) {
                    data.forEach(function (salle) {
                        $('#salle_id').append('<option value="' + salle.id + '">' + salle.libelle + ' (' + salle.emplacement + ')</option>');
                    });
                } else {
                    $('#salle_id').append('<option>No available salles</option>');
                }
            },
            error: function (error) {
                console.log('Error fetching salles:', error);
            }
        });
    }

    // Form submission
    $('#planningForm').on('submit', function (e) {
        e.preventDefault(); // Prevent default submission

        let formAction = $(this).attr('action');
        let formData = $(this).serialize();

        $.ajax({
            url: formAction,
            method: 'POST',
            data: formData,
            success: function (response) {
                alert(response.message); // Success feedback
                closeModal();
                location.reload(); // Reload to reflect changes
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = '';

                    for (let field in errors) {
                        if (errors.hasOwnProperty(field)) {
                            errorMessages += errors[field].join('<br>') + '<br>';
                        }
                    }
                    $('#errorContainer').html(errorMessages).fadeIn();
                } else {
                    console.error('Unexpected error:', xhr);
                }
            }
        });
    });
});


</script>

<!-- Add the modal HTML to the bottom of the Blade file -->
<div class="modal fade" id="planningModal" tabindex="-1" aria-labelledby="planningModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="planningModalLabel">Liste des Plannings pour : <span id="stageName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Planning ID</th>
                            <th>Date Début</th>
                            <th>Date Fin</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody id="planningTableBody">
                        <!-- Rows will be populated dynamically via AJAX -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modify the button to trigger the modal -->


<script>
    document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.open-upload-comment-modal').forEach(button => {
        button.addEventListener('click', function () {
            const stageId = this.getAttribute('data-stage-id');
            const stageName = this.getAttribute('data-stage-name');

            // Set stage name in modal
            document.getElementById('stageName').textContent = stageName;

            // Clear previous table content
            const tableBody = document.getElementById('planningTableBody');
            tableBody.innerHTML = '<tr><td colspan="4">Chargement...</td></tr>';

            // Fetch plannings for the stage
            fetch(`/api/plannings/${stageId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        tableBody.innerHTML = ''; // Clear loading message
                        data.plannings.forEach(planning => {
                            const row = `
                                <tr>
                                    <td>${planning.id}</td>
                                    <td>${planning.date_debut}</td>
                                    <td>${planning.date_fin}</td>
                                    <td>${planning.description}</td>
                                </tr>`;
                            tableBody.insertAdjacentHTML('beforeend', row);
                        });
                    } else {
                        tableBody.innerHTML = '<tr><td colspan="4">Aucun planning trouvé.</td></tr>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    tableBody.innerHTML = '<tr><td colspan="4">Erreur lors de la récupération des données.</td></tr>';
                });

            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('planningModal'));
            modal.show();
        });
    });
});

</script>



@endsection
