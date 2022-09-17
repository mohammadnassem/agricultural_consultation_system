<?php

namespace App\Http\Controllers;

use App\Http\Requests\WeatherRequest;
use App\Models\PlantUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Traits\GeneralTrait;
use mysql_xdevapi\Exception;
use phpDocumentor\Reflection\Types\Object_;
use Carbon\Carbon;

class WeatherController extends Controller
{

    use GeneralTrait;
    public  function currentWeather($id)
    {
        try {
            $user = PlantUser::where('id', $id)->first();
            if ($user) {
                $obj = new \stdClass();
                $response = Http::get('https://api.openweathermap.org/data/2.5/weather?lat=' . $user->lat . '&lon=' . $user->long . '&appid=' . key_weather);
                $res = json_decode($response->body(), true);
                $obj->temp = ($res['main']['temp'] - 273.15);
                $obj->humidity = $res['main']['humidity'];
                $obj->pressure = $res['main']['pressure'];
                $obj->wind = $res['wind']['speed'];
                $obj->lat = $user->lat;
                $obj->long =  $user->long;
                $obj->city = $res['name'];
                $obj->description = $res['weather'][0]['main'];
                $obj->icon = $res['weather'][0]['icon'];
                return $this->returnData('weather', $obj);
            } else {
                return $this->returnError("400", "This user does not exist");
            }
        } catch (\Exception $e) {
            return $this->returnError("400", "Error Weather Api");
        }
    }
    public  function gistUserWeather(WeatherRequest $request)
    {
        try {
           $req =$request->validated();
            if ($req) {
                $obj = new \stdClass();
                $response = Http::get('https://api.openweathermap.org/data/2.5/weather?lat='. $req['lat'] . '&lon='. $req['long'] .'&appid='. key_weather);
                $res = json_decode($response->body(), true);
                $obj->temp =(double)($res['main']['temp'] - 273.15);
                $obj->humidity = $res['main']['humidity'];
                $obj->pressure = $res['main']['pressure'];
                $obj->wind = $res['wind']['speed'];
                $obj->city = $res['name'];
                $obj->lat = $req['lat'];
                $obj->long = $req['long'];
                $obj->description = $res['weather'][0]['main'];
                $obj->icon = $res['weather'][0]['icon'];
                return $this->returnData('weather',  $obj);
            } else {
                return $this->returnError("400", "This lat or long does not exist");
            }
        } catch (\Exception $e) {
            return $this->returnError("400", "Error Weather Api");
        }
    }
}
