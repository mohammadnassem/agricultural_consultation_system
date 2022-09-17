<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\PlantRepositoryInterface;
use App\Http\Requests\plantCalculatorRequest;
use App\Http\Requests\PlantRequest;
use App\Http\Requests\startPlantationRequest;
use App\Models\PlantSchedule;
use App\Models\PlantUser;
use App\Models\Stage;
use App\Models\Step;
use App\Models\User;
use App\Models\UserPlant;
use App\Traits\GeneralTrait;
use Illuminate\Support\Carbon;


class PlantsController extends Controller
{
    use GeneralTrait;

    private $plantRepository;

    public function __construct(PlantRepositoryInterface $plantRepository)
    {
        $this->plantRepository = $plantRepository;
    }

    public function getTaskForBlant($id)
    {
        $plant = $this->plantRepository->getOne($id);
        if (!$plant) {
            return $this->returnError("400", "This plant does not exist");
        } else {
            $res = $plant->plantSchedules()->get();
            return $this->returnData('step', $res);
        }
    }

    public function deletePlantUser($id)
    {
        $plantUser = PlantUser::find($id);
        if($plantUser){
            $plantUser->delete();
            return $this->returnSuccessMessage("plantUser Delete Successfully");
        }else{
            return $this->returnError("400", "This plantUser does not exist");
        }
    }

    public function getAllStep($id)
    {
        $plant = $this->plantRepository->getOne($id);
        if (!$plant) {
            return $this->returnError("400", "This plant does not exist");
        } else {
            $arr = array();
            $plantSchedules = $plant->plantSchedules()->get();
            foreach ($plantSchedules as $key => $value) {
                $res = PlantSchedule::where('id', $value['id'])->get();
                $step = Step::with(['stage' => function ($q) {
                }])->where('plant_schedule_id', $res[0]['id'])->get();
                $arr[] = $step;
            }


            return $this->returnData('Steps', $arr);
        }
    }

    public function getPlantByUser($id)
    {
        $user = User::find($id);
        $res = $user->Plants()->with('Diseases')->get();
        return $this->returnData('plant', $res);
    }

    protected function getAllPlants()
    {
        $plants = $this->plantRepository->all();
        return $this->returnData('plants', $plants);
    }

    protected function getPlantById($id)
    {
        $plant = $this->plantRepository->getOne($id);
        if (!$plant)
            return $this->returnError("400", "This plant does not exist");
        return $this->returnData('plant', $plant);
    }

    protected function getPlantSchedule($id)
    {
        $sched = PlantSchedule::where('plant_id', $id)->get();
        return $sched;
    }
    protected function getAllPlantUser()
    {
        $sched = PlantUser::groupBy(['plant_id','city'])
        ->selectRaw('sum(area) as area, plant_id,city')
        ->get();
        return $this->returnData('plantUser', $sched);

    }


    protected function statistics()
    {
      //  $sched = PlantUser::where(['is_finished'=> false])->sum('area')->groupBy('plant_id')->get();
      $sched = PlantUser::groupBy('plant_id')
      ->selectRaw('sum(area) as area, plant_id')
      ->get();


        return $this->returnData('statistics', $sched);

    }
    protected function startPlantation(startPlantationRequest $request)
    {
        try {
            $val = $request->validated();
            $stage = Stage::where('plant_id', $val['plant_id'])->orderBy('step', 'ASC')->first();
            $res = array_merge($request->validated(), ['stage_id' => $stage->id]);
            $res['is_clean'] = Carbon::now();
            $res['is_protected'] = Carbon::now();
            $res['watering_date'] = Carbon::now();
            $res = PlantUser::create($res);
            return $this->returnSuccessMessage("start Plantation successfully");
        } catch (\Exception $exception) {
            return $this->returnError("400", "Invalid Data");
        }
    }

    public function plantCalculator(plantCalculatorRequest $request)
    {
        try {
            $data = $request->validated();
            $space = isset($data['length']) ? $data['length'] : 0.3;
            $between = isset($data['width']) ? $data['width'] : 0.7;
            $area = $data['area'];
            $res = $area / ($space * $between);
            return $this->returnData("plants", (int)$res, 'the number of plant is ');
        } catch (\Exception $exception) {
            return $this->returnError("400", "Invalid Data");
        }
    }

    protected function addPlant(PlantRequest $request)
    {
if($request->hasFile('image')){
    $file = $request->file('image');
    $uploadpath = "images/plant";
    $orgenalimage = $file->getClientOriginalName();
    $file_name = $orgenalimage;
    $file->move($uploadpath, $file_name);
}

        $res = $this->plantRepository->create($request->validated());
        if ($res == null) {
            return $this->returnError("400", "Invalid Data");
        }

        return $this->returnSuccessMessage("Plant added successfully");
    }

    protected function deletePlant($id)
    {
        $res = $this->plantRepository->delete($id);
        if ($res == 0) {
            return $this->returnError("400", "The plant does not exist");
        }

        return $this->returnSuccessMessage("500", "The plant has been removed successfully");
    }

    protected function updatePlant(PlantRequest $request, $id)
    {
        $res = $this->plantRepository->update($request->validated(), $id);
        if ($res == null) {
            return $this->returnError("400", "Invalid Data");
        }
        return $this->returnSuccessMessage("Plant Update successfully");
    }
}
