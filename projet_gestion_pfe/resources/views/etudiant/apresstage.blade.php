@extends('layouts.etudiant')

@section('title', 'Student Dashboard - Après stage')

@section('content')
<style>
    

    .content-header {
        display: flex;
        justify-content: space-between;
        padding: 20px;
        align-items: center;
        margin-top: 20px;
    }

    .content-header h1 {
        margin: 0;
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
        margin: 20px;
    }

    .form-container label {
        font-weight: bold;
        display: block;
        margin-top: 10px;
    }

    .form-container input[name='deadline_rapport'] {
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
</style>


<body>

    @if (Session::get('error'))
    <script>
        swal("message", "{{Session::get('error')}}", 'error', {
            button: true,
            button: "OK",
            timer: 3000,
            dangerMode: true,
        })
    </script>
    @endif
    @if (Session::get('success'))
    <script>
        swal("message", "{{Session::get('success')}}", 'success', {
            button: true,
            button: "OK",
            timer: 3000,
            successMode: true,
        })
    </script>
    @endif
    <!-- Main Content -->
    <div class="main-content">


        <!-- Deadline -->
        <div class="form-container">
            <label for="deadline-rapport">Deadline - Dépôt de documents:</label>
            <input type="text" id="deadline-rapport" name="deadline_rapport" class="text-danger" value="{{ $deadline->date_deadline_rapport }}" disabled>
        </div>
        <div class="content-header">
            <h1>Documents de stage</h1>
        </div>

        <!-- Form Container -->
        <div class="form-container">
            <form method="POST" action="{{ route('submitDocumentsfin') }}" enctype="multipart/form-data">
                @csrf
                <!-- Content (File upload) -->
                <input type="hidden" name="idStudent" value='{{$id_user}}'>
                <div>
                    <label for="contenu">Contenu</label>
                    <div id="drag-drop-area" class="drag-drop-area">
                        <p>Drag and drop your document zip here, or click to select a file</p>
                        <input type="file" name="contenu" id="contenu" class="file-input">
                    </div>
                </div>


                <br><br>
                <!-- Submit Button -->
                <div>
                    <button type="submit">Submit Documents</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Drag-and-drop functionality
        const dropArea = document.getElementById('drag-drop-area');
        const fileInput = document.getElementById('contenu');

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
    </script>
</body>


@endsection