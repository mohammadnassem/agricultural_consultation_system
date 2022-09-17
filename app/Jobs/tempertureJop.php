<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Models\PlantUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Throwable;

class tempertureJop implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $data;
    public $tries = 4;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->data->each(function ($plant) {
            foreach ($plant->Users as $user) {
                try {
                    $response = Http::get('https://api.openweathermap.org/data/2.5/weather?lat=' . $user->pivot->lat . '&lon=' . $user->pivot->long . '&appid=' . key_weather);
                    $res = json_decode($response->body(), true);
                    $humidity = $res['main']['humidity'];
                    $now = Carbon::now();
                    $end = Carbon::parse($user->pivot->is_protected);
                    $diff = $now->diffInDays($end);
                    if ($diff > 2 && $humidity > 10) {
                        PlantUser::where('id', $user->pivot->id)->update(['is_protected' => Carbon::now()]);
                        $token = $user->tokenNotif;
                        $title = "درجة الرطوبة عالية";
                        $body="الرطوبة العالية تساعد على زيادة الامراض لذلك ينصح برش النبات بمبيد وقائي"."  للحقل $plant->name الذي مساحتة ". $user->pivot->area." الموجود في " . $user->pivot->city;
                        notifcation($token,$title,$body);

                        $notification = new Notification();
                        $notification->title=$title;
                        $notification->body=$body;
                        $user->notification()->save($notification);
                    }
                } catch (Throwable $e) {
                    if ($this->attempts() > 3) {
                        throw $e;
                    }

                    $this->release(180);
                    return;
                }

            }

        });
    }
}
