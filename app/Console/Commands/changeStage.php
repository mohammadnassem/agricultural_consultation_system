<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Models\Plant;
use App\Models\PlantUser;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class changeStage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:stage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command this apple to change stage for the farmer';

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
                $stages = Plant::find($plantUser->plant_id)->stages()->orderBy('step', 'asc')->get();
                $now = Carbon::now();
                $end = Carbon::parse($plantUser['created_at']);
                $diff = $now->diffInDays($end);
                $sum  = 0;
                foreach ($stages as  $value) {

                    if ($diff > $sum) {
                        $sum = $sum + $value->interval;

                    }
                    if ($diff <= $sum) {

                        if($plantUser->stage_id != $value->id){
                            $plantUser->stage_id=$value->id;

                            $plantUser->save();
                            $plant = Plant::find($plantUser->plant_id);
                            $user = User::find($plantUser->user_id);
                            $token = $user->tokenNotif;
                            $title = "الوقت يمضي";
                            $body= "عمل رائع الوقت يمضي الان اصبحت في مرحلة".$value->name . "  للحقل $plant->name الذي مساحتة  $plantUser->area الموجود في  $plantUser->city";
                            notifcation($token,$title,$body);
                            $notification = new Notification();
                            $notification->title=$title;
                            $notification->body=$body;
                            $user->notification()->save($notification);

                            break;
                        }else{
                            break;
                        }
                    }

                }
            }

        return 0;
    }catch (\Exception $e){

        }
    }
}
