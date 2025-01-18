@extends('layouts.etudiant')

@section('title', 'Student Dashboard - Rapport')

@section('content')
    
    <style>
         

        .content-header {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            align-items: center;

        }

        .content-header h1 {
            margin: 0;
        }

        .student-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px solid white;
            object-fit: cover;
        }

        .details-container {
            display: flex;
            padding: 20px;
            justify-content: space-between;
            margin-top: 20px;
        }

        .details-section {
            flex: 1;
            margin-right: 20px;
        }

        .details-section:last-child {
            margin-right: 0;
        }

        .details-section table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-section table td {
            padding: 8px 0;
        }

        .details-section table td:first-child {
            font-weight: bold;
        }
        .button-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;

        }

        .button-row {
            display: flex;
            justify-content: center;
            gap: 200px;
            margin: 20px 0;
        }
        .button-row1 {
            display: flex;
            justify-content: center;
            gap: 200px;
            margin: 20px 0;
            margin-top: 10%
        }

        .btn {
            display: inline-block;
            padding: 20px 30px;
            font-size: 25px;
            color: #ffffff;
            background-color:#005522 ;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #005522;
        }

        .study-btn {
            padding: 20px 40px;
            border-radius: 50px;
            margin-top: 20px;
        }

        .form-container {
            margin: 20px;
            padding: 20px;
            background-color: #ffffff;
            color: black;
            border-radius: 10px;
        }

        .form-container input,
        .form-container select,
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-container button {
            padding: 15px;
            background-color: #005522;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .form-container button:hover {
            background-color: #005522;
        }

        /* Drag-and-Drop Area */
        .drag-drop-area {
            border: 2px dashed #005522;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            color: #005522;
        }

        .drag-drop-area.hover {
            background-color: #e6f9e6;
            border-color: #005522;
        }

        .drag-drop-area p {
            font-size: 16px;
        }

        .file-input {
            display: none;
        }
        .input-wrapper {
            position: relative;
            width: 300px;
        }

        label {
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
            color: #333;
        }

        .input-with-link {
            width: 100%;
            padding: 10px;
            padding-right: 90px; /* Adjust space for the link */
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            color: #888;
            cursor: not-allowed; /* Indicates that the input is disabled */
        }

        .input-link {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            color: #005522;
            text-decoration: none;
            font-size: 16px;
            pointer-events: auto; /* Makes the link clickable even with input disabled */
        }

        .input-link:hover {
            text-decoration: underline;
        }

        /* Disabled state styles */
        .input-with-link:disabled {
            background-color: #f1f1f1;
            color: #bbb;
        }

        #notes-link-container {
            display: block;
            margin-top: 20px;
        }
        .form-container {
            font-family: Arial, sans-serif;

        }

        .form-container label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        .form-container input[name="deadline-rapport"] {
            margin-top: 5px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            max-width: 300px;
        }

        .text-danger {
            color: red;
            font-weight: bold;
        }
        .expired-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
            display: none; /* Caché par défaut */
        }
        .swal-modal {
        width: 300px !important; /* Largeur de la boîte */
        padding: 20px !important; /* Ajout de padding */
        font-size: 16px;
        height: 350px !important;
    }
    </style>
<body>
    
    <!-- Main Content -->
    <div class="main-content">
        
        <div class="content-header">
            <h1>Rapport Information</h1>
            <div class="form-container">
                <label for="deadline-rapport">Deadline - Dépôt de Rapport :</label>
                <input type="text" id="deadline-rapport" name="deadline_rapport" class="text-danger" value="{{ $deadline->date_deadline_rapport }}" disabled>
             </div>
        </div>
        @if (Session::has('error'))
    <script>
        swal("Message", "{{ Session::get('error') }}", 'error', {
            button: true,
            button: "OK",
            timer: 3000,
            dangerMode: true,
            className: "swal-modal",
        });
    </script>
@endif

@if (Session::has('success'))
    <script>
        swal("Message", "{{ Session::get('success') }}", 'success', {
            button: true,
            button: "OK",
            timer: 3000,
            dangerMode: true,
            className: "swal-modal",
        });
    </script>
@endif

<!-- Form Container -->
        <div class="form-container">
            <form method="POST" action="{{ route('submitRapport') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden"  name="idStudent" value='{{$id_user}}'>
                <div>
                    <label for="titre">Titre</label>
                    <input type="text" id="titre" name="titre" required>
                </div>
                <div>
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" required >
                </div>

                <!-- Notes Link -->
                <div id="notes-link-container" style="display: none;">
                    <label for="disabled-input">Remarque:</label>
                    <div style="position: relative;">
                    <input type="text" id="disabled-input" class="input-with-link"
                   placeholder="Voici les remarques" value="Some remarks here" disabled>
                     <a href="#" class="input-link">Allez vers</a>
        </div>
                </div>
                <div>
                    <label for="contenu">Contenu</label>
                    <!-- Drag-and-drop or File input -->
                    <div id="drag-drop-area" class="drag-drop-area">
                        <p>Drag and drop your Word document here, or click to select a file</p>
                        <input type="file" name="contenu" id="contenu" class="file-input" accept=".docx,.doc">
                    </div>
                </div>
<br><br>

                <div>
                    <button type="submit">Submit Rapport</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        // Obtenir la date actuelle
        const today = new Date();

        // Formater la date en 'YYYY-MM-DD'
        const formattedDate = today.toISOString().split('T')[0];
        document.getElementById('date').value = formattedDate;


    </script>
    <script>
        // Drag-and-drop functionality
        const dropArea = document.getElementById('drag-drop-area');
        const fileInput = document.getElementById('contenu');
        const statusSelect = document.getElementById('status');
        const notesLinkContainer = document.getElementById('notes-link-container');
        const notesLink = document.getElementById('notes-link');

        dropArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropArea.classList.add('hover');
        });

        dropArea.addEventListener('dragleave', () => {
            dropArea.classList.remove('hover');
        });

        dropArea.addEventListener('drop', (e) => {
            e.preventDefault();
            dropArea.classList.remove('hover');
            const files = e.dataTransfer.files;
            if (files.length) {
                fileInput.files = files;
            }
        });

        dropArea.addEventListener('click', () => {
            fileInput.click();
        });

        // Show/hide Notes link based on status selection
        statusSelect.addEventListener('change', () => {
            if (statusSelect.value === 'non_valid') {
                notesLinkContainer.style.display = 'block'; // Show the Notes link when "non valid"
            } else {
                notesLinkContainer.style.display = 'none'; // Hide the Notes link when "valid"
            }
        });
    </script>
</body>

@endsection