@extends('layouts.responsable')

@section('title', 'Mettre à jour un Rôle')

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

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
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
        <h1 class="mb-4">Mettre à jour un Rôle</h1>
        <form action="{{ route('responsable.update-role') }}" method="POST">
            @csrf
            @method('PUT')
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
                <label for="old_role" class="form-label">Ancien Rôle</label>
                <select class="form-control" id="old_role" name="old_role" required>
                    <option value="encadrant">Encadrant</option>
                    <option value="rapporteur">Rapporteur</option>
                    <option value="examinateur">Examinateur</option>
                    <option value="president">Président</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="new_role" class="form-label">Nouveau Rôle</label>
                <select class="form-control" id="new_role" name="new_role" required>
                    <option value="encadrant">Encadrant</option>
                    <option value="rapporteur">Rapporteur</option>
                    <option value="examinateur">Examinateur</option>
                    <option value="president">Président</option>
                </select>
            </div>

            <div class="mt-4"></div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('responsable.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
@endsection