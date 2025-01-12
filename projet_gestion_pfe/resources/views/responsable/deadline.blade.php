@extends('layouts.responsable')

@section('title', 'Liste des Affectations')

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
        background-color: #508C9B;
        border-color: #508C9B;
    }

    .date-rapport, .date-stage {
        border: 2px solid #ccc;
        border-radius: 5px;
        padding: 5px;
        font-size: 16px;
        background-color: #f9f9f9;
    }

    .date-rapport:focus, .date-stage:focus {
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.8);
    }
</style>

@if (Session::get('error'))
<script>
    swal("message", "{{ Session::get('error') }}", 'error', {
        button: true,
        button: "OK",
        timer: 3000,
        dangerMode: true,
        className: "swal-modal",
    });
</script>
@endif

@if (Session::get('success'))
<script>
    swal("message", "{{ Session::get('success') }}", 'success', {
        button: true,
        button: "OK",
        timer: 3000,
        dangerMode: true,
        className: "swal-modal",
    });
</script>
@endif

<div class="container mt-5">
    <h1 class="mb-4">Deadline</h1>

    <!-- Button trigger modal -->
    <a class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
        Ajouter
    </a>
    <br><br>
    <table>
        <thead>
            <tr>
                <th>Type de Deadline</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Stage</td>
                <td>{{ $deadline->date_deadline_stage ?? ' ' }}</td>
                <td>
                    <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModalStage">modifier</a>
                    <form action="{{ route('deadline.deleteStage', ['id' => $deadline->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-success  btn-sm">Supprimer</button>
                    </form>
                </td>
            </tr>
            <tr>
                <td>Rapport</td>
                <td>{{ $deadline->date_deadline_rapport ?? ' ' }}</td>
                <td>
                    <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModalRapport">modifier</a>
                    <form action="{{ route('deadline.deleteRapport', ['id' => $deadline->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-success  btn-sm">Supprimer</button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addModalLabel">Ajouter deadlines</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('deadline.add') }}">
                @csrf
                <div class="modal-body">
                    <div>
                        <label for="date-stage">Date de stage :</label>
                        <input type="date" name="date_deadline_stage" class="date-stage">
                    </div>
                    <div>
                        <label for="date-rapport">Date de rapport :</label>
                        <input type="date" name="date_deadline_rapport" class="date-rapport">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-sm">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal Stage -->
<div class="modal fade" id="editModalStage" tabindex="-1" aria-labelledby="editModalStageLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalStageLabel">Modifier Deadline Stage</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('deadline.Stage', ['id' => $deadline->id]) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div>
                        <label for="edit-date-stage">Date de stage :</label>
                        <input type="date" name="date_deadline_stage" class="date-stage" value="{{ $deadline->date_deadline_stage }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-sm">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal Rapport -->
<div class="modal fade" id="editModalRapport" tabindex="-1" aria-labelledby="editModalRapportLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalRapportLabel">Modifier Deadline Rapport</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('deadline.Rapport', ['id' => $deadline->id]) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div>
                        <label for="edit-date-rapport">Date de rapport :</label>
                        <input type="date" name="date_deadline_rapport" class="date-rapport" value="{{ $deadline->date_deadline_rapport }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-sm">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
