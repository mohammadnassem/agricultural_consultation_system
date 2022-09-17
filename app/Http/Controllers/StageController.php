<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\CommentRepositoryInterface;
use App\Http\Interfaces\StageRepositoryInterface;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\StageRequest;
use App\Models\Plant;
use App\Models\Stage;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class StageController extends Controller
{

    use GeneralTrait;
    private  $StageRepository;
    public function __construct(StageRepositoryInterface $StageRepository)
    {
        $this->StageRepository = $StageRepository;
    }


    protected function getAllStages()
    {
        $Stages = $this->StageRepository->all();
        return $this->returnData('Stages', $Stages);
    }

    protected function getStageById($id)
    {
        $Stage = $this->StageRepository->getOne($id);
        if (!$Stage)
            return $this->returnError("400", "This Stage does not exist");
        return $this->returnData('Stage', $Stage);
    }




    protected function addStage(StageRequest $request)
    {

        $res = $this->StageRepository->create($request->validated());
        if ($res == null) {
            return $this->returnError("400", "Invalid Data");
        }

        return $this->returnSuccessMessage("Stage added successfully");
    }

    protected function deleteStage($id)
    {
        $res =  $this->StageRepository->delete($id);
        if ($res == 0) {
            return $this->returnError("400", "The Stage  does not exist");
        }

        return $this->returnSuccessMessage("500", "The Stage has been removed successfully");
    }

    protected function updateStage(StageRequest $request, $id)
    {
        $res =  $this->StageRepository->update($request->validated(), $id);
        if ($res == null) {
            return $this->returnError("400", "Invalid Data");
        }
        return $this->returnSuccessMessage("Stage Update successfully");
    }

    protected function getallStageWithStep($id)
    {
        $plant = Plant::find($id);
        if (!$plant) {
            return $this->returnError("400", "This Plant does not exist");
        } else {
            $Stages = Stage::with(['steps' => function ($query) {
                return $query->orderBy('interval', 'ASC');
            }])->where('plant_id', $plant->id)->orderBy('step', 'ASC')->get();

            return $this->returnData('Stages', $Stages);
        }
    }
}
