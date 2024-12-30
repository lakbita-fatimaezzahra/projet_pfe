<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\prof\ProfController;
use App\Http\Controllers\prof\RespController;
use App\Http\Controllers\studentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('etudiant/home');
});

// admin
//etudiant
Route::get('/readst', [EtudiantController::class, 'index'])->name('etudiants.index');
Route::get('/etudiants', [EtudiantController::class, 'index'])->name('etudiant.index');
Route::get('/etudiants/create', [EtudiantController::class, 'create'])->name('etudiant.create');
Route::post('/etudiants', [EtudiantController::class, 'store'])->name('etudiant.store');
Route::delete('/etudiants/{id}', [EtudiantController::class, 'destroy'])->name('etudiant.destroy');
//professeur
Route::get('/admin/professeur', [ProfesseurController::class, 'index'])->name('admin.professeur.read');
Route::get('/admin/professeur/create', [ProfesseurController::class, 'create'])->name('admin.professeur.create');
Route::post('/admin/professeur/store', [ProfesseurController::class, 'store'])->name('admin.professeur.store');
Route::get('/admin/professeur/{id}/update', [ProfesseurController::class, 'edit'])->name('admin.professeur.update');
Route::put('/admin/professeur/{id}', [ProfesseurController::class, 'update'])->name('admin.professeur.update.submit');
Route::delete('professeurs/{id}', [ProfesseurController::class, 'destroy'])->name('admin.professeur.delete');
//departement
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('departement', DepartementController::class);
});
Route::get('departements/{id}/filieres', [DepartementController::class, 'showFilieres'])->name('admin.departement.filieres');
//filières
Route::prefix('admin/departement/{departementId}')->group(function () {
    // Liste des filières
Route::get('filieres', [FiliereController::class, 'index'])->name('admin.departement.filieres');

    // Ajouter une filière
Route::get('filieres/create', [FiliereController::class, 'create'])->name('admin.filiere.create');

Route::post('filieres', [FiliereController::class, 'store'])->name('admin.filiere.store');

Route::post('filieres', [FiliereController::class, 'store'])->name('admin.filiere.store');

});
Route::delete('admin/departement/{departementId}/filieres/{id}', [FiliereController::class, 'destroy'])->name('admin.filiere.destroy');







//stage/rapport
Route::get('/avant', function () {
    return view('etudiant/avantstage',compact('id_user'));
});

Route::get('/etap2', function () {

    $id_user = session('user_id'); // Récupération de l'id de l'utilisateur
    return view('etudiant/etape2', compact('id_user'));
})->name('documents');
Route::get('/stage', function () {
    $id_user = session('user_id'); //

    return view('etudiant/stage',compact('id_user'));
});
Route::get('/apres', function () {
    return view('etudiant/apresstage');
});
Route::match(['get', 'post'],'/submit-stage', [StageController::class, 'store'])->name('submitStage');
Route::get('/avantstage', [StageController::class, 'insertstage'])->name('avantStage');
Route::get('/rapport', [RapportController::class, 'create'])->name('rapport.create');
Route::post('/rapport', [RapportController::class, 'submitRapport'])->name('submitRapport');
Route::post('/Stage_documents', [StageController::class, 'submitDocuments'])->name('submitDocuments');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/student', [studentController::class, 'index'])->name('student');
// Login Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('Showlogin');
Route::post('login', [LoginController::class, 'login'])->name('login');;
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
// Password Reset Routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset']);

//prof
Route::get('/home',[ProfController::class,'home'])->name('home');

//responsable

Route::get('responsable/responsable', [RespController::class, 'responsable'])->name('responsable');
Route::get('responsable/liststage', [RespController::class, 'liststage'])->name('liststage');
Route::get('/assign-prof/{stageId}', [RespController::class, 'showAssignForm'])->name('showAssignForm');
Route::post('/assign-prof', [RespController::class, 'matchAndAssign'])->name('matchAndAssign');
