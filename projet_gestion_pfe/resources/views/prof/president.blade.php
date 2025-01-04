@extends('layouts.prof')

@section('title', 'Tableau de Bord')

@section('content')
    <div class="content-header">
        <div>
            <h1>President  {{ session('user_data')->last_name ." ".session('user_data')->name }}!</h1>
            <p>List des stagiaires</p>
        </div>
    </div>

    <div class="details-container">
        <div class="details-section">
            <table>
                
                <tr>
                    <td>Nom et Prénom</td>
                    <td>{{ session('user_data')->last_name ." ".session('user_data')->name }}</td>
                </tr>
                <tr>
                    <td>Campus</td>
                    <td>EMSI CENTRE</td>
                </tr>
                <!-- Ajoutez les autres données ici -->
            </table>
        </div>
    </div>
@endsection
