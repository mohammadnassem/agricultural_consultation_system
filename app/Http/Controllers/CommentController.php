<?php

namespace App\Http\Controllers;
use App\Http\Interfaces\CommentRepositoryInterface;
use App\Http\Interfaces\PostRepositoryInterface;
use App\Http\Requests\CommentRequest;
use App\Traits\GeneralTrait;


class CommentController extends Controller
{

    use GeneralTrait;
    private  $CommentRepository;
    public function __construct(CommentRepositoryInterface $CommentRepository)
    {
        $this->CommentRepository = $CommentRepository;
    }


    protected function getAllComments() {
        $comments = $this->CommentRepository->all();
        return $this->returnData('Comments',$comments);


    }

    protected function getCommentById($id) {
        $comment= $this->CommentRepository->getOne($id);
        if(!$comment)
            return $this->returnError("400","This Comment does not exist");
        return $this->returnData('Comment',$comment);
    }




    protected function addComment(CommentRequest $request) {


        $res= $this->CommentRepository->create($request->validated());
        if($res == null){
            return $this->returnError("400","Invalid Data");
        }
        return $this->returnSuccessMessage("Comment added successfully");


    }

    protected function deleteComment($id) {
        $res=  $this->CommentRepository->delete($id);
        if($res == 0){
            return $this->returnError("400","The Comment  does not exist");

        }

        return $this->returnSuccessMessage("500","The Comment has been removed successfully");


    }

    protected function updateComment(CommentRequest $request, $id) {
        $res=  $this->CommentRepository->update($request->validated(),$id);
        if($res == null){
            return $this->returnError("400","Invalid Data");
        }
        return $this->returnSuccessMessage("Comment Update successfully");

    }



}
