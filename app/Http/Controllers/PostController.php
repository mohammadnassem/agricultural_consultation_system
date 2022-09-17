<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\PostRepositoryInterface;
use App\Http\Requests\DiseaseRequest;
use App\Http\Requests\PostRequest;
use App\Traits\GeneralTrait;


class PostController extends Controller
{

    use GeneralTrait;
    private  $postRepository;
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }


    protected function getAllPosts() {
        $posts = $this->postRepository->all();
        foreach ($posts as $post) {
            $post['user'] = $post->user;
            $post['comments'] = $post->comments;
        }

        return $this->returnData('post',$posts);


    }

    protected function getPostById($id) {
        $post= $this->postRepository->getOne($id);
        if(!$post){
            return $this->returnError("400","This Post does not exist");
        }else{
            $post['user'] = $post->user;
            $comments = $post->comments;    //try
            $post['comments'] = $post->comments;

        foreach ($comments as $c) {
            $c['user'] = $c->user;
        }
        return $this->returnData('post',$post);
        }
    }




    protected function addPost(PostRequest $request) {


        $res= $this->postRepository->create($request->validated());
        if($res == null){
            return $this->returnError("400","Invalid Data");
        }
        return $this->returnSuccessMessage("Post added successfully");


    }

    protected function deletePost($id) {
        $res=  $this->postRepository->delete($id);
        if($res == 0){
            return $this->returnError("400","The Post  does not exist");

        }

        return $this->returnSuccessMessage("500","The Post has been removed successfully");


    }

    protected function updatePost(PostRequest $request, $id) {
        $res=  $this->postRepository->update($request->validated(),$id);
        if($res == null){
            return $this->returnError("400","Invalid Data");
        }
        return $this->returnSuccessMessage("Post Update successfully");

    }



}
