<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\DiseasesRepositoryInterface;
use App\Http\Requests\DiseaseRequest;
use App\Http\Requests\PlantRequest;
use App\Models\Stage;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\Plant;

class DiseasesController extends Controller
{
    use GeneralTrait;
    private  $diseasesRepository;
    public function __construct(DiseasesRepositoryInterface $plantRepository)
    {
        $this->diseasesRepository = $plantRepository;
    }


    protected function getAllDiseases() {
        $plants = $this->diseasesRepository->all();
        return $this->returnData('diseases',$plants);


    }

    protected function getDiseaseById($id) {
        $disease= $this->diseasesRepository->getOne($id);
        if(!$disease)
            return $this->returnError("400","This Disease does not exist");
        return $this->returnData('disease',$disease);
    }




    protected function addDisease(DiseaseRequest $request) {


        $res=  $this->diseasesRepository->create($request->validated());
        if($res == null){
            return $this->returnError("400","Invalid Data");
        }
        return $this->returnSuccessMessage("Disease added successfully");


    }

    protected function deleteDisease($id) {
        $res=  $this->diseasesRepository->delete($id);
        if($res == 0){
            return $this->returnError("400","The Disease  does not exist");

        }

        return $this->returnSuccessMessage("500","The Disease has been removed successfully");


    }

    protected function updateDiseases(DiseaseRequest $request, $id) {
        $res=  $this->diseasesRepository->update($request->validated(),$id);
        if($res == null){
            return $this->returnError("400","Invalid Data");
        }
        return $this->returnSuccessMessage("Diseases Update successfully");

    }

    protected function getDiseasesByPlant($id){
        $plant=Plant::find($id);
        if(!$plant){
            return $this->returnError("400","The plant  does not exist");

        }else{
            $res = $plant->Diseases()->get();
            return $this->returnData('diseases',$res);
        }
    }

    protected function getDiseasesByStage($id){
        $plant=Stage::with('Diseases')->where('plant_id',$id)->get();
           return $this->returnData('diseases',$plant);

    }

}
