<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Validator;

class ArticleController extends Controller
{
    //
    function createArticle(Request $req){
        if($req->user()->role_id !=1){
            $Response=[
                'success'=>false,
                'message'=>"you are unauthorized to access this" ,
                'status'=>500
            ];
            return response()->json($Response);
        }
        $validators=Validator::make($req->all(),[
            'title'=>'required',
            'description'=>'required',
            'titleImage'=>'required|file|mimes:png,jpg,jpeg',
            'articleImage'=>'required|file|mimes:png,jpg,jpeg',
            'link'=>'required',
            'content'=>'required',
            'user_id'=>'required'

        ]);
        if($validators->fails())
        {
            $Response=[
                'success'=>false,
                'message'=>$validators->errors(),
                'status'=>500
            ];
            return response()->json($Response);
    }


    try{
    $articleImagePath=uploadImage($req->file('articleImage'),'articleImages');
    $titleImagePath=uploadImage($req->file('titleImage'),'articleImages');

    $article=Article::create([
        'title'=>$req->title,
        'description'=>$req->description,
        'titleImage'=>$titleImagePath,
        'articleImage'=>$articleImagePath,
        'link'=>$req->link,
        'content'=>$req->content,
        'user_id'=>$req->user_id
    ]);
    $Response=[
        'success'=>true,
        'data'=>$article,
        'status'=>200
    ];
    return response()->json($Response);
}
catch(\Exception $ex){

    $Response=[
        'success'=>false,
        'message'=>$ex,
        'status'=>500
    ];
    return response()->json($Response);
}
}
####End Function#############


function getArticles(){
    $articles=Article::orderBy('created_at','desc')->get();
    if(is_null($articles)){
        $Response=[
            'success'=>false,
            'message'=>'There are no articles',
            'status'=>400
        ];
        return response()->json($Response);
    }
    $Response=[
        'success'=>true,
        'data'=>$articles,
        'status'=>200
    ];
    return response()->json($Response);
}
################end function###########
}

