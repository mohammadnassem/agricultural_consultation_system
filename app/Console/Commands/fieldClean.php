<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Models\PlantUser;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Models\Plant;


class fieldClean extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'field:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'alert to field cleaning';

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
                $now = Carbon::now();
                $end = Carbon::parse($plantUser->is_clean);
                $diff = $now->diffInDays($end);
                $plant = Plant::find($plantUser->plant_id);
                if ($diff > 6) {
                    $user = User::find($plantUser->user_id);
                    $plantUser->is_clean = $now;
                 $plantUser->save();
                    $token = $user->tokenNotif;
                    $title = "الحقل بحاجة للتعشيب";
                    $body="حقل $plant->name الذي مساحتة  $plantUser->area الموجود في  $plantUser->city بحاججة للتعشيب";
                    notifcation($token,$title,$body);
                    $notification = new Notification();
                    $notification->title=$title;
                    $notification->body=$body;
                    $user->notification()->save($notification);
                }

            }
        return 0;
    }catch (\Exception $e){

        }
    }
}
