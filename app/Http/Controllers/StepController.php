<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\CommentRepositoryInterface;
use App\Http\Interfaces\StepRepositoryInterface;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\StepRequest;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class StepController extends Controller
{

    use GeneralTrait;
    private  $StepRepository;
    public function __construct(StepRepositoryInterface $StepRepository)
    {
        $this->StepRepository = $StepRepository;
    }


    protected function getAllSteps() {
        $Steps = $this->StepRepository->all();
        return $this->returnData('Steps',$Steps);


    }

    protected function getStepById($id) {
        $Step= $this->StepRepository->getOne($id);
        if(!$Step)
            return $this->returnError("400","This Step does not exist");
        return $this->returnData('Step',$Step);
    }




    protected function addStep(StepRequest $request) {


        $res= $this->StepRepository->create($request->validated());
        if($res == null){
            return $this->returnError("400","Invalid Data");
        }
        return $this->returnSuccessMessage("Step added successfully");


    }

    protected function deleteStep($id) {
        $res=  $this->StepRepository->delete($id);
        if($res == 0){
            return $this->returnError("400","The Step  does not exist");

        }

        return $this->returnSuccessMessage("500","The Step has been removed successfully");


    }

    protected function updateStep(StepRequest $request, $id) {
        $res=  $this->StepRepository->update($request->validated(),$id);
        if($res == null){
            return $this->returnError("400","Invalid Data");
        }
        return $this->returnSuccessMessage("Step Update successfully");

    }



}
