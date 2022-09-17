<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Models\PlantUser;
use App\Models\Stage;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Models\Plant;

class watering extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'watering:alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command use for send alert to user for watering the plant';

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
                $stages = Stage::find($plantUser->stage_id);
                $now = Carbon::now();
                $end = Carbon::parse($plantUser['watering_date']);
                $diff = $now->diffInDays($end);
                  $plant = Plant::find($plantUser->plant_id);
                if ($diff > $stages->watering_period) {
                    $plantUser->watering_date = $now;
                    $plantUser->save();
                    $user = User::find($plantUser->user_id);
                    $token = $user->tokenNotif;
                    $title = "  الحقل بحاجة للماء";
                    if($plantUser->soil_type == "clay soil" || $plantUser->soil_type =="التربة الطينية"){

                        $body="حقل  $plant->name الذي مساحتة $plantUser->area بحاجة  لكمية ماء 3 ساعات  $plantUser->city الموجود " ;
                        notifcation($token,$title,$body);
                        $notification = new Notification();
                        $notification->title=$title;
                        $notification->body=$body;
                        $user->notification()->save($notification);
                    }else if($plantUser->soil_type == "Celtic soil" || $plantUser->soil_type =="التربة السلتية"){

                        $body="حقل  $plant->name الموجود   $plantUser->city  الذي مساحتة $plantUser->area بحاجة  لكمية ماء 4 ساعات";
                        notifcation($token,$title,$body);
                        $notification = new Notification();
                        $notification->title=$title;
                        $notification->body=$body;
                        $user->notification()->save($notification);
                    }else{

                        $body="حقل  $plant->name الموجود   $plantUser->city  الذي مساحتة $plantUser->area بحاجة  لكمية ماء 6 ساعات";
                        notifcation($token,$title,$body);
                        $notification = new Notification();
                        $notification->title=$title;
                        $notification->body=$body;
                        $user->notification()->save($notification);
                    }

                }
            }

            return 0;
        }catch (\Exception $e){

        }
    }
}
