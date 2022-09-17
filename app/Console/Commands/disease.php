<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Models\Plant;
use App\Models\PlantUser;
use App\Models\Stage;
use App\Models\User;
use Illuminate\Console\Command;

class disease extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alert:disease';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command alert user about the disease';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $plantUsers = PlantUser::all();
            foreach ($plantUsers as $plantUser) {
                $stages = Stage::where('plant_id', $plantUser->plant_id)->find($plantUser->stage_id);

                $plant = Plant::find($plantUser->plant_id);
                $plants = $plant->Diseases;
              $des=  $plants->last();
        if($des){
                $user = User::find($plantUser->user_id);
                $token = $user->tokenNotif;
                $title = "مرض ال ". $des->name;
                $body="يعتبر هذا المرض من اهم الامراض التي تصيب النبات في ". $stages->name ." راقب حقل $plant->name الذي مساحتة  $plantUser->area الموجود في  $plantUser->city ";
                notifcation($token,$title,$body);
                $notification = new Notification();
                $notification->title=$title;
                $notification->body=$body;
                $user->notification()->save($notification);
            }}
        return 0;
    }catch (\Exception $e){

}
    }
}
