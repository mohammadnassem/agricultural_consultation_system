<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\NotificationRepositoryInterface;
use App\Http\Requests\NotificationRequest;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use GeneralTrait;
    private  $NotificationRepository;
    public function __construct(NotificationRepositoryInterface $NotificationRepository)
    {
        $this->NotificationRepository = $NotificationRepository;
    }


    protected function getAllNotifications() {
        $comments = $this->NotificationRepository->all();
        return $this->returnData('Notifications',$comments);


    }

    protected function getNotificationById($id) {
        $Notification= $this->NotificationRepository->getOne($id);
        if(!$Notification)
            return $this->returnError("400","This Notification does not exist");
        return $this->returnData('Notification',$Notification);
    }

    protected function getNotificationByUser($id) {
        $user= User::find($id);
        if($user) {
            $Notification  =$user->notification;
            if (!$Notification)
                return $this->returnError("400", "This Notification does not exist");
            return $this->returnData('Notification', $Notification);
        }else{
            return $this->returnError("400", "This User does not exist");
        }
    }


    protected function addNotification(NotificationRequest $request) {


        $res= $this->NotificationRepository->create($request->validated());
        if($res == null){
            return $this->returnError("400","Invalid Data");
        }
        return $this->returnSuccessMessage("Notifications added successfully");


    }

    protected function deleteNotification($id) {
        $res=  $this->NotificationRepository->delete($id);
        if($res == 0){
            return $this->returnError("400","The Notifications  does not exist");

        }

        return $this->returnSuccessMessage("500","The Notifications has been removed successfully");


    }

    protected function updateNotification(NotificationRequest $request, $id) {
        $res=  $this->NotificationRepository->update($request->validated(),$id);
        if($res == null){
            return $this->returnError("400","Invalid Data");
        }
        return $this->returnSuccessMessage("Notifications Update successfully");

    }



}
