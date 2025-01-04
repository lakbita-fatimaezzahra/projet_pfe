<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\etudiant\StageController;
use App\Http\Controllers\etudiant\RapportController;
use App\Http\Controllers\etudiant\studentController;
use App\Http\Controllers\admin\EtudiantController;
use App\Http\Controllers\admin\ProfesseurController;
use App\Http\Controllers\admin\DepartementController;
use App\Http\Controllers\admin\FiliereController;
use App\Http\Controllers\admin\GroupeController;
use App\Http\Controllers\prof\ProfController;
use App\Http\Controllers\prof\EncadrentController;
use App\Http\Controllers\prof\ExaminateurController;
use App\Http\Controllers\prof\RapporteurController;
use App\Http\Controllers\prof\PresidentController;
use App\Http\Controllers\prof\RespController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('etudiant/home');
});

// admin
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    //etudiant
        Route::get('/readst', [EtudiantController::class, 'index'])->name('etudiants.read');
        Route::get('/etudiants', [EtudiantController::class, 'index'])->name('etudiant.index');
        Route::get('/etudiants/create', [EtudiantController::class, 'create'])->name('etudiant.create');
        Route::post('/etudiants', [EtudiantController::class, 'store'])->name('etudiant.store');
        Route::get('/etudiants/{id}/edit', [EtudiantController::class, 'edit'])->name('etudiant.edit');
        Route::put('/etudiants/{id}', [EtudiantController::class, 'update'])->name('etudiant.update');
        Route::delete('/etudiants/{id}', [EtudiantController::class, 'destroy'])->name('etudiant.destroy');

        //Importer fichier csv
        Route::post('/etudiant/import', [EtudiantController::class, 'import'])->name('etudiant.import');

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
        // Afficher le formulaire de modification
        Route::get('admin/departement/{departementId}/filieres/{id}/edit', [FiliereController::class, 'edit'])->name('admin.filiere.edit');
        // Mettre à jour une filière
        Route::put('admin/departement/{departementId}/filieres/{id}', [FiliereController::class, 'update'])->name('admin.filiere.update');

        Route::delete('admin/departement/{departementId}/filieres/{id}', [FiliereController::class, 'destroy'])->name('admin.filiere.destroy');
    // Groupes
        Route::prefix('admin/departement')->group(function () {
            Route::get('/filiere/{filiereId}/groupes', [GroupeController::class, 'index'])->name('admin.groupes.index');
            Route::get('/filiere/{filiereId}/groupes/create', [GroupeController::class, 'create'])->name('admin.groupes.create');
            Route::post('/filiere/{filiereId}/groupes', [GroupeController::class, 'store'])->name('admin.groupes.store');
            Route::get('/filiere/{filiereId}/groupes/{id}/edit', [GroupeController::class, 'edit'])->name('admin.groupes.edit');
            Route::put('/filiere/{filiereId}/groupes/{id}', [GroupeController::class, 'update'])->name('admin.groupes.update');
            Route::delete('/filiere/{filiereId}/groupes/{id}', [GroupeController::class, 'destroy'])->name('admin.groupes.destroy');
        });




//stage/rapport
Route::get('/avant', function () {
    return view('etudiant/avantstage',compact('id_user'));
});

Route::get('/etap2', function () {

    $id_user = session('user_id'); // Récupération de l'id de l'utilisateur
    return view('etudiant/etape2', compact('id_user'));
})->name('documents');
Route::get('/stage',[StageController::class, 'readStage'])->name('Stage');

Route::get('/apres', [StageController::class,'finStage'])->name('documentsfinal');
Route::match(['get', 'post'],'/submit-stage', [StageController::class, 'store'])->name('submitStage');
Route::get('/avantstage', [StageController::class, 'insertstage'])->name('avantStage');
Route::get('/rapport', [RapportController::class, 'create'])->name('rapport.create');
Route::post('/rapport', [RapportController::class, 'submitRapport'])->name('submitRapport');
Route::post('/Stage_documents', [StageController::class, 'submitDocuments'])->name('submitDocuments');
Route::match(['get', 'post'],'/Stage_documents_fin', [StageController::class, 'submitDocumentsfin'])->name('submitDocumentsfin');

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
Route::get('/prof',[ProfController::class,'home'])->name('home');
//encadrent
Route::get('/Encadrent',[EncadrentController::class,'ListStageEncadrent'])->name('Encadrent');
//rapporteur
Route::get('/Rapporteur',[RapporteurController::class,'Rapporteur'])->name('Rapporteur');
//examinateur
Route::get('/Examinateur',[ExaminateurController::class,'Examinateur'])->name('Examinateur');
//president
Route::get('/President',[PresidentController::class,'President'])->name('President');
//responsable
Route::get('responsable/responsable', [RespController::class, 'responsable'])->name('responsable');
//list des stagiaires
Route::get('responsable/liststage', [RespController::class, 'liststage'])->name('liststage');
Route::get('/assign-stage/{stageId}', [RespController::class, 'showAssignForm'])->name('showAssignForm');
Route::post('/assign-stage', [RespController::class, 'matchAndAssign'])->name('matchAndAssign');
Route::get('responsable/listrapport', [RespController::class, 'listrapport'])->name('listrapport');
//list des rapports
Route::get('/assign-rapport/{stageId}', [RespController::class, 'showAssignFormRapport'])->name('showAssignFormRapport');
Route::match(['get', 'post'],'/assign-rapport', [RespController::class, 'matchAndAssignRapport'])->name('matchAndAssignRapport');
Route::get('responsable/listrapport', [RespController::class, 'listrapport'])->name('listrapport');

