<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\PlantScheduleRepositoryInterface;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\PlantScheduleRequest;
use App\Models\Stage;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class PlantScheduleController extends Controller
{

    use GeneralTrait;
    private  $PlantScheduleRepository;
    public function __construct(PlantScheduleRepositoryInterface $PlantScheduleRepository)
    {
        $this->PlantScheduleRepository = $PlantScheduleRepository;
    }


    protected function getAllPlantSchedules()
    {
        $plantSchedules = $this->PlantScheduleRepository->all();
        return $this->returnData('PlantSchedule', $plantSchedules);
    }

    protected function getPlantScheduleById($id)
    {
        $plantSchedule = $this->PlantScheduleRepository->getOne($id);
        if (!$plantSchedule)
            return $this->returnError("400", "This PlantSchedule does not exist");
        return $this->returnData('PlantSchedule', $plantSchedule);
    }




    protected function addPlantSchedule(PlantScheduleRequest $request)
    {


        $res = $this->PlantScheduleRepository->create($request->validated());
        if ($res == null) {
            return $this->returnError("400", "Invalid Data");
        }
        return $this->returnSuccessMessage("PlantSchedule added successfully");
    }

    protected function deletePlantSchedule($id)
    {
        $res =  $this->PlantScheduleRepository->delete($id);
        if ($res == 0) {
            return $this->returnError("400", "The PlantSchedule  does not exist");
        }

        return $this->returnSuccessMessage("500", "The PlantSchedule has been removed successfully");
    }

    protected function updatePlantSchedule(PlantScheduleRequest $request, $id)
    {
        $res =  $this->PlantScheduleRepository->update($request->validated(), $id);
        if ($res == null) {
            return $this->returnError("400", "Invalid Data");
        }
        return $this->returnSuccessMessage("PlantSchedule Update successfully");
    }


    protected function getScheduleWork($id)
    {
        $arry = array();
        $plantSchedule = $this->PlantScheduleRepository->getOne($id);
        if (!$plantSchedule) {
            return $this->returnError("400", "This PlantSchedule does not exist");
        } else {
            $arr = Stage::where('plant_id', $plantSchedule['plant_id'])->get();
            $Stages =  collect($arr)->sortBy(['step'])->toArray();
            $sum = 0;
            foreach ($Stages as $key => $value) {
                Stage::where('id', $value['id'])->update(['week' => $sum]);
                $sum = $sum + $value['interval'];
            }

            $steps = $plantSchedule->steps()->get();


            foreach ($steps as $key => $value) {
                $res = $value->stage()->first();
                $value['stageName'] = $res->name;
                $value['duration'] = $value['interval'] + $res->week;
                $value['step'] = $res->step;
                $arry[] = $value;
            }

            $reselt = collect($arry)->sortBy(['step', 'duration'])->toArray();

            return $this->returnData('PlantSchedule', $reselt);



        }
        //  ->where('stage_id',3)
        //  return $this->returnData('PlantSchedule',$plantSchedule);

    }
}
