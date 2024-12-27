@extends('layouts.responsable')

@section('title', 'Affecter un Rôle')

@section('content')
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #007035;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: #333333;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
            padding: 10px;
            width: 100%;
        }

        .form-control:focus {
            border-color: #007035;
            box-shadow: 0 0 5px rgba(0, 112, 53, 0.5);
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
        }

        .mt-4 {
            margin-top: 20px;
        }
    </style>

    <div class="container mt-5">
        <h1 class="mb-4">Affecter un Rôle</h1>
        <form action="{{ route('responsable.assign-role') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="prof_id" class="form-label">Professeur</label>
                <select class="form-control" id="prof_id" name="prof_id" required>
                    @foreach ($professors as $professor)
                        <option value="{{ $professor->id }}">{{ $professor->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="stage_id" class="form-label">Stage</label>
                <select class="form-control" id="stage_id" name="stage_id" required>
                    @foreach ($stages as $stage)
                        <option value="{{ $stage->id }}">{{ $stage->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Rôle</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="encadrant">Encadrant</option>
                    <option value="rapporteur">Rapporteur</option>
                    <option value="examinateur">Examinateur</option>
                    <option value="president">Président</option>
                </select>
            </div>

            <div class="mt-4"></div>

            <div class="btn-group">
                <button type="submit" class="btn btn-success">Affecter</button>
                <a href="{{ route('responsable.index') }}" class="btn btn-danger">Annuler</a>
            </div>
        </form>
    </div>
@endsection