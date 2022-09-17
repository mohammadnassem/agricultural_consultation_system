<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DiseasesController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PlantScheduleController;
use App\Http\Controllers\PlantsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\WeatherController;
use App\Models\DiseasePlant;
use App\Models\Notification;
use App\Models\PlantUser;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

use App\Models\User;
use App\Models\Plant;
use App\Models\Disease;
use App\Models\Post;
use App\Models\Comment;
use App\Models\PlantSchedule;
use App\Models\UserPlant;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

Route::post('/test', function () {



});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


//Plants Controller
Route::get('/getAllPlants', [PlantsController::class, 'getAllPlants']);
Route::get('/getPlantById/{id}', [PlantsController::class, 'getPlantById']);
Route::post('/addPlant', [PlantsController::class, 'addPlant']);
Route::post('/deletePlant/{id}', [PlantsController::class, 'deletePlant']);
Route::post('/updatePlant/{id}', [PlantsController::class, 'updatePlant']);
Route::get('/getTaskForBlant/{id}', [PlantsController::class, 'getTaskForBlant']);
Route::get('/getAllStep/{id}', [PlantsController::class, 'getAllStep']);
Route::post('/plantCalculator', [PlantsController::class, 'plantCalculator']);


Route::get('/getPlantSchedule/{id}', [PlantsController::class, 'getPlantSchedule']);
Route::post('/startPlantation', [PlantsController::class, 'startPlantation']);
Route::post('/deletePlantUser/{id}', [PlantsController::class, 'deletePlantUser']);
Route::get('/getPlantByUser/{id}', [PlantsController::class, 'getPlantByUser']);
Route::get('/getAllPlantUser', [PlantsController::class, 'getAllPlantUser']);
Route::get('/statistics', [PlantsController::class, 'statistics']);
//Diseases Controller
Route::get('/getAllDiseases', [DiseasesController::class, 'getAllDiseases']);
Route::get('/getDiseaseById/{id}', [DiseasesController::class, 'getDiseaseById']);
Route::post('/addDisease', [DiseasesController::class, 'addDisease']);
Route::post('/deleteDisease/{id}', [DiseasesController::class, 'deleteDisease']);
Route::post('/updateDiseases/{id}', [DiseasesController::class, 'updateDiseases']);
Route::get('/getDiseasesByPlant/{id}', [DiseasesController::class, 'getDiseasesByPlant']);
Route::get('/getDiseasesByStage/{id}', [DiseasesController::class, 'getDiseasesByStage']);
///////PostController
Route::get('/getAllPosts', [PostController::class, 'getAllPosts']);
Route::get('/getPostById/{id}', [PostController::class, 'getPostById']);
Route::post('/addPost', [PostController::class, 'addPost']);
Route::post('/deletePost/{id}', [PostController::class, 'deletePost']);
Route::post('/updatePost/{id}', [PostController::class, 'updatePost']);


/////CommentController


Route::get('/getAllComments', [CommentController::class, 'getAllComments']);
Route::get('/getCommentById/{id}', [CommentController::class, 'getCommentById']);
Route::post('/addComment', [CommentController::class, 'addComment']);
Route::post('/deleteComment/{id}', [CommentController::class, 'deleteComment']);
Route::post('/updateComment/{id}', [CommentController::class, 'updateComment']);

/////plantScheduleController

Route::get('/getAllPlantSchedules', [PlantScheduleController::class, 'getAllPlantSchedules']);
Route::get('/getPlantScheduleById/{id}', [PlantScheduleController::class, 'getPlantScheduleById']);
Route::post('/addPlantSchedule', [PlantScheduleController::class, 'addPlantSchedule']);
Route::post('/deletePlantSchedule/{id}', [PlantScheduleController::class, 'deletePlantSchedule']);
Route::post('/updatePlantSchedule/{id}', [PlantScheduleController::class, 'updatePlantSchedule']);
Route::get('/getScheduleWork/{id}', [PlantScheduleController::class, 'getScheduleWork']);


///////////////////////////////////StageController


Route::get('/getAllStages', [StageController::class, 'getAllStages']);
Route::get('/getStageById/{id}', [StageController::class, 'getStageById']);
Route::post('/addStage', [StageController::class, 'addStage']);
Route::post('/deleteStage/{id}', [StageController::class, 'deleteStage']);
Route::post('/updateStage/{id}', [StageController::class, 'updateStage']);
Route::get('/getallStageWithStep/{id}', [StageController::class, 'getallStageWithStep']);
///////////////////////////////////NotificationController


Route::get('/getAllNotifications', [NotificationController::class, 'getAllNotifications']);
Route::get('/getNotificationById/{id}', [NotificationController::class, 'getNotificationById']);
Route::get('/getNotificationByUser/{id}', [NotificationController::class, 'getNotificationByUser']);
Route::post('/addNotification', [NotificationController::class, 'addNotification']);
Route::post('/deleteNotification/{id}', [NotificationController::class, 'deleteNotification']);
Route::post('/updateNotification/{id}', [NotificationController::class, 'updateNotification']);

///////////////////StepController/////////

Route::get('/getAllSteps', [StepController::class, 'getAllSteps']);
Route::get('/getStepById/{id}', [StepController::class, 'getStepById']);
Route::post('/addStep', [StepController::class, 'addStep']);
Route::post('/deleteStep/{id}', [StepController::class, 'deleteStep']);
Route::post('/updateStep/{id}', [StepController::class, 'updateStep']);

//////////////////////////////////////////////WeatherController///////////

Route::get('/currentWeather/{id}', [WeatherController::class, 'currentWeather']);
Route::post('/gistUserWeather', [WeatherController::class, 'gistUserWeather']);


//FORUM
//Route::get('/getAllPosts', [ForumController::class, 'getAllPosts']);
//Route::get('/getSinglePost/{post_id}', [ForumController::class, 'getSinglePost']);
//Route::post('/addPost', [ForumController::class, 'addPost']);
//Route::post('/addComment/{post_id}', [ForumController::class, 'add']);
