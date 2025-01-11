<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - Rapport</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: rgb(0, 0, 0);
            display: flex;
            height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            height: 1000px;
            background-color: #134B70;
            color: rgb(255, 255, 255);
            display: flex;
            flex-direction: column;
            text-align: center;
        }

        .sidebar .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar .logo img {
            width: 100px;
        }

        .sidebar a {
            display: block;
            padding: 15px 20px;
            color: rgb(255, 255, 255);
            text-decoration: none;
            font-size: 18px;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: #ffffff;
            color: #134B70;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .sidebar .nouveau-btn {
            margin: 20px auto;
            background-color: #ffffff;
            color: #134B70;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
        }

        .sidebar .nouveau-btn:hover {
            background-color: #005522;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: #006D24;
            padding: 10px 20px;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-right: 15px;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .logout {
            background: white;
            color: black;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout:hover {
            background-color: #f1f1f1;
        }

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
            background-color: #134B70;
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
            border: 2px dashed #134B70;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            color: #134B70;
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
/* Step Buttons */
.step-buttons {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .step-button {
            padding: 10px 30px;
            font-size: 18px;
            color: #fff;
            background-color: #134B70;
            border: none;
            border-radius: 5px;
            cursor: not-allowed;
            margin: 0 10px;
        }

        /* Step Buttons */
.step-buttons {
    display: flex;
    justify-content: center;
    margin: 20px 0;
}

.step-button {
    padding: 10px 30px;
    font-size: 18px;
    border: none;
    border-radius: 5px;
    cursor: not-allowed;
    margin: 0 10px;
}

/* Active button (green) */
.step-button.active {
    background-color: #134B70;
    color: white;
}

/* Inactive button (white) */
.step-button.inactive {
    background-color: #ffffff;
    color: #134B70;
    border: 1px solid #134B70;
}
    </style>
</head>
<body>
    <!-- Sidebar -->
    <x-sidebar />

    <!-- Main Content -->
    <div class="main-content">
        <x-dashnav/>

        <div class="content-header">
            <h1>Document de stage</h1>
        </div>
        <!-- Step Buttons -->
        <div class="step-buttons">
            <button class="step-button active">Étape 1</button>
            <span>&rarr;</span>
            <button class="step-button active">Étape 2</button>
        </div>

        <!-- Form Container -->
        <div class="form-container">
            @if(session('error'))
            <div style="color: red; font-weight: bold;">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
        <div style="color: green; font-weight: bold;">
            {{ session('success') }}
        </div>
    @endif
            <form method="POST" action="{{ route('submitDocuments') }}" enctype="multipart/form-data">
                @csrf
                <!-- Content (File upload) -->
                <input type="hidden"  name="idStudent" value="{{$id_user}}">
                <div>
                    <label for="contenu">Contenu</label>
                    <div id="drag-drop-area" class="drag-drop-area">
                        <input type="file" name="contenu" id="contenu" class="file-input" placeholder="Drag and drop your fichier zip here, or click to select a file">
                    </div>
                </div>



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
</html>
