<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Section gauche -->
        <div class="hidden md:flex w-1/2 items-center justify-center bg-cover bg-center"
             style="background-image: url('{{ asset('images/Mac.png') }}');">
        </div>

        <!-- Section droite -->
        <div class="w-full md:w-1/2 flex items-center justify-center bg-white">
            <div class="w-full max-w-md px-6">
                <div class="text-center mb-6">
                    <img src="{{ asset('images/emsilogo.png') }}" alt="Logo" class="w-24 mx-auto mb-4">
                    <h2 class="text-2xl font-semibold text-gray-700">Ravi de vous revoir</h2>
                </div>
                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf
                    @error('login')
                    <span style="color: red"> {{$message}}</span>
                    <br>
                    @enderror
                    <select name="users" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                        <option value="admin">Administrateur</option>
                        <option value="professeur">Professeur</option>
                        <option value="etudiant">Étudiant</option>
                        <option value="responsable">Responsable</option>
                    </select>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-600">Email ou nom d'utilisateur</label>
                        <input type="text" name="email" id="email"
                               class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-green-300 focus:border-green-500"
                               @if (isset($_COOKIE['mail'])) value="{{ $_COOKIE['mail'] }}" @endif
                               required>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-600">Mot de passe</label>
                        <input type="password" name="password" id="password"
                               class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-green-300 focus:border-green-500"
                               @if (isset($_COOKIE['password'])) value="{{ $_COOKIE['password'] }}" @endif
                               required>
                    </div>
                    <div class="flex items-center justify-between">
                        <label class="flex items-center text-sm text-gray-600">
                            <input type="checkbox" name="remember" class="form-checkbox h-4 w-4 text-green-500">
                            <span class="ml-2">Se souvenir de moi</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm text-green-500 hover:underline">Mot de passe oublié ?</a>
                    </div>
                    <button type="submit"
                            class="w-full bg-green-500 text-white py-2 rounded-md hover:bg-green-600 transition">
                        Se connecter
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
