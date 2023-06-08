<?php

use App\Models\Cv;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CvController;
use App\Http\Controllers\CoversController;
use App\Http\Controllers\MemoryController;
use App\Http\Controllers\AproposController;
use App\Http\Controllers\EducationsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\ExperiencesController;
use App\Http\Controllers\AddInformationsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

 /*Route::get('/dashboard', function () {
    return view('cvs.index');
})->middleware(['auth'])->name('cvs');

require __DIR__.'/auth.php';*/







Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/a-propos',[ AproposController::class, 'index'])->name('apropos');

Route::get('/update-last-activity', function () {
    if (auth()->check()) {
        auth()->user()->update(['last_activity' => now()]);
    }
});
// route pour les memoires
Route::post('/memory/approuver/{id}', [MemoryController::class, 'approuver'])->name('memory.approuver');
Route::get('/memory/affected',[ MemoryController::class, 'affected'])->name('memory.affected');
Route::get('/memory/undone',[ MemoryController::class, 'undone'])->name('memory.undone');
Route::get('/memory/done',[ MemoryController::class, 'done'])->name('memory.done');
Route::put('/memory/makedone/{memory}',[ MemoryController::class, 'makedone'])->name('memory.makedone');
Route::put('/memory/makeundone{memory}',[ MemoryController::class, 'makeundone'])->name('memory.makeundone');
Route::get('/memory/{memory}/affectedTo/{user}',[ MemoryController::class, 'affectedto'])->name('memory.affectedto');

//route pour les lettre de motivations
Route::post('/covers/approuver/{id}', [CoversController::class, 'approuver'])->name('covers.approuver');
Route::get('/covers/affected',[ CoversController::class, 'affected'])->name('covers.affected');
Route::get('/covers/undone',[ CoversController::class, 'undone'])->name('covers.undone');
Route::get('/covers/done',[ CoversController::class, 'done'])->name('covers.done');
Route::put('/covers/makedone/{cover}',[ CoversController::class, 'makedone'])->name('covers.makedone');
Route::put('/covers/makeundone{cover}',[ CoversController::class, 'makeundone'])->name('covers.makeundone');
Route::get('/covers/{cover}/affectedTo/{user}',[ CoversController::class, 'affectedto'])->name('covers.affectedto');

// route pour les CV
Route::delete('/cvs/{cv}/educations/{education}', [EducationsController::class, 'destroy'])->name('cvs.educations.destroy');

//Route::delete('/cvs/{cv}/educations/{education}', [CvController::class, 'destroyEducation'])->name('cvs.educations.destroy');
Route::delete('/cvs/{cv}/experiences/{experience}', [CvController::class, 'destroyExperience'])->name('cvs.experiences.destroy');
Route::delete('/cvs/{cv}/add-informations/{addInformation}', [CvController::class, 'destroyAddInformation'])->name('cvs.add-informations.destroy');



Route::post('/cvs/approuver/{id}', [CvController::class, 'approuver'])->name('cvs.approuver');
Route::get('/cvs/telechargement/fichier', [ CvController::class, 'telecharger'])->name('cvs.telecharger');
Route::get('/cvs/telechargement', [ CvController::class, 'telechargement'])->name('cvs.telechargement');
Route::get('/cvs/affected',[ CvController::class, 'affected'])->name('cvs.affected');
Route::get('/cvs/undone',[ CvController::class, 'undone'])->name('cvs.undone');
Route::get('/cvs/done',[ CvController::class, 'done'])->name('cvs.done');
Route::put('/cvs/makedone/{cv}',[ CvController::class, 'makedone'])->name('cvs.makedone');
Route::put('/cvs/makeundone{cv}',[ CvController::class, 'makeundone'])->name('cvs.makeundone');
Route::get('/cvs/{cv}/affectedTo/{user}',[ CvController::class, 'affectedto'])->name('cvs.affectedto');

Route::get('/cvs/{id}/download/{password}', /*function ($id, $password) {
    $user = Cv::findOrFail($id);
    if ($user->download_pass === $password) {
        print('hermane');
        return Response::download($user->url);
    } else {
       
        abort(403, 'Unauthorized action.');
    }
}*/ [ CvController::class, 'download'])->name('cvs.download');


Route::resource('covers', CoversController::class);
Route::resource('memory', MemoryController::class);

Route::resource('educations', EducationsController::class)->except(['create', 'store','destroy']);
Route::post('/cvs/{cv}/educations/store', [EducationsController::class, 'store'])->name('educations.store');
Route::delete('/cvs/{cv}/educations/{education}', [EducationsController::class, 'destroy'])->name('educations.destroy');


Route::resource('infos', AddInformationsController::class)->except(['create', 'store']);
Route::post('/cvs/{cv}/infos/store', [AddInformationsController::class, 'store'])->name('infos.store');

Route::resource('experiences', ExperiencesController::class)->except(['create', 'store']);
Route::post('/cvs/{cv}/experiences/store', [ExperiencesController::class, 'store'])->name('experiences.store');



Route::resource('cvs', CvController::class);
Route::resource('/admin/users', UsersController::class)  ;

