<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validation des champs
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'users' => 'required|in:etudiant,admin,professeur,responsable', // Validation du rôle
        ]);

        $data = $request->all();
        $remember = $request->remember ?? false;
        $fieldType = filter_var($data['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if ($fieldType === 'email' && !preg_match('/@emsi-uca\.ma$/', $data['email'])) {
            return back()->withErrors(['login' => 'L\'email doit appartenir au domaine @emsi-uca.ma'])->withInput();
        }
        // Choisir le guard selon le type d'utilisateur
        $guard = match ($data['users']) {
            'etudiant' => 'etudiant',
            'admin' => 'administrateur',
            'professeur' => 'profs',
            'responsable' => 'profs',
            default => null,
        };

        // Tentative d'authentification
        if ($guard && Auth::guard($guard)->attempt([$fieldType => $data['email'], 'password' => $data['password']], $remember)) {
          // Récupérer l'utilisateur authentifié
            $user = Auth::guard($guard)->user();

            if ($guard === 'etudiant') {

                // Récupérer les données complètes de l'étudiant
                $etudiant = \App\Models\Etudiant::with(['groupe', 'departement','departement.filieres'])
                ->where('id', $user->id)
                ->first();

                if ($etudiant) {


                    // Ajouter les données à la session
                    $request->session()->put('etudiant_data', $etudiant);

                }
            }
            elseif ($guard === 'profs' && $data['users'] === 'responsable') {
                // Récupérer les données complètes du professeur responsable
                $responsable = \App\Models\Prof::all()
                ->where('id', $user->id)
                ->where('role', 'responsable')
                ->first();
    
                if ($responsable) {
                    // Ajouter les données à la session
                    $request->session()->put('responsable_data', $responsable);
                } else {
                    // Si l'utilisateur n'a pas le rôle 'responsable', rediriger vers la page de connexion avec une erreur
                    return back()->withErrors(['login' => 'Vous n\'avez pas les autorisations nécessaires pour accéder à cette section.'])->withInput();
                }}

            // Gérer les cookies si demandé
            if ($remember) {
                setcookie("mail", $data['email'], time() + 3600);
                setcookie("password", $data['password'], time() + 3600);
            } else {
                setcookie("mail", "");
                setcookie("password", "");
            }

            $request->session()->regenerate();
            if ($user) {
                // Stocker les données générales dans la session
                $request->session()->put('user_id', $user->id);
                $request->session()->put('user_data', $user);

                // Redirection selon le rôle
                return match ($data['users']) {
                    'etudiant' => to_route('student'),
                    'admin'=>to_route('dashboard'),
                    'professeur' => to_route('home'),
                    'responsable' => to_route('index'),
                    default => back(),
                };
            }
        }

        return back()->withErrors(['login' => 'Email/Username ou mot de passe incorrect'])->withInput();
    }


public function logout(Request $request)
{
    // Déconnexion de l'utilisateur
    Auth::logout();

    // Invalidation de la session
    $request->session()->invalidate();

    // Régénération du token CSRF
    $request->session()->regenerateToken();

    // Rediriger l'utilisateur vers la page de connexion après la déconnexion
    return redirect()->route('login');  // Ou une autre route de votre choix
}
}
