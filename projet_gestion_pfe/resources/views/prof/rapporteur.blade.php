@extends('layouts.prof')

@section('title', 'Liste des Rapports')

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
        color: #134B70;
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
        background-color: #134B70;
        color: white;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    .btn-success {
        background-color: #134B70;
        border-color: #134B70;
        font-size: 1rem;
        padding: 8px 20px;
        border-radius: 5px;
    }

    .btn-success:hover {
        background-color: #0b3a58;
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        width: 50%;
    }
</style>

<div class="container mt-5">
    <h1 class="mb-4">Liste des Rapports</h1>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Étudiant</th>
                <th>Titre</th>
                <th>Contenu</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $rapport)
                <tr>
                    <td>{{ $rapport->etudiant_name }}</td>
                    <td>{{ $rapport->rapport_titre }}</td>
                    <td>
                        <a href="{{ route('download.rapport', $rapport->rapport_id) }}" class="btn btn-success btn-sm">
                            {{ $rapport->rapport_contenu }}
                        </a>
                    </td>
                    <td>
                        <select class="status-select" data-rapport-id="{{ $rapport->rapport_id }}">
                            <option value="validé" {{ $rapport->rapport_status == 'validé' ? 'selected' : '' }}>Validé</option>
                            <option value="corrigé" {{ $rapport->rapport_status == 'corrigé' ? 'selected' : '' }}>Corrigé</option>
                            <option value="en cours" {{ $rapport->rapport_status == 'en cours' ? 'selected' : '' }}>En cours</option>
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-success upload-doc-btn" data-rapport-id="{{ $rapport->rapport_id }}">
                            <i class="fas fa-plus-circle"></i> Commentaire
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal for Uploading Document -->
<div id="uploadDocumentModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un Commentaire</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="uploadDocumentForm" method="post" >
                    @csrf
                    <input type="hidden" name="rapport_id" id="rapport_id" value={{$rapport->rapport_id}}>
                    <div class="form-group">
                        <label for="document">Choisir un Document</label>
                        <input type="file" name="document" id="document" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        // Handle status change
        $('.status-select').on('change', function () {
            let rapportId = $(this).data('rapport-id');
            let status = $(this).val();

            $.ajax({
                url: '{{ route("rapport.updateStatus") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    rapport_id: rapportId,
                    status: status
                },
                success: function (response) {
                    if (response.success) {
                        alert(response.message);
                    } else {
                        alert('Failed to update status.');
                    }
                },
                error: function () {
                    alert('An error occurred while updating status.');
                }
            });
        });

        // Open the modal for uploading a document
        $('.upload-doc-btn').on('click', function () {
            let rapportId = $(this).data('rapport-id');
            $('#rapport_id').val(rapportId);
            $('#uploadDocumentModal').modal('show');
        });

        // Handle document upload
        $('#uploadDocumentForm').on('submit', function (e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: '{{ route("rapport.uploadDocument") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        alert(response.message);
                        $('#uploadDocumentModal').modal('hide');
                        location.reload();
                    } else {
                        alert('Failed to upload document.');
                    }
                },
                error: function (xhr) {
                    alert('An error occurred: ' + xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
