@extends('layouts.prof')

@section('title', 'Tableau de Bord')

@section('content')
    <div class="content-header">
        <div>
            <h1>Examinateur {{ session('user_data')->last_name ." ".session('user_data')->name }}!</h1>
            <p>List des stagiaires</p>
        </div>
    </div>

    <div class="details-container">
        <div class="details-section">
            <table>
                
                
            </table>
        </div>
    </div>
@endsection
