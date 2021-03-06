<?php

namespace App\Http\Controllers;

use App\Comment;
use Faker\Provider\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if(Auth::check()) {
            $this->validate($request,[
                'body'=>'required|string',
                'attachment' => 'mimes:jpeg,png,jpg,mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts|max:12000'
            ],[
                'body.required' => 'Please fill the comment field before posting comment'
            ]);



            $comment = Comment::create([
                'body'=>$request->input('body'),
                'url'=>$request->input('url'),
                'commentable_type'=>$request->input('commentable_type'),
                'commentable_id'=>$request->input('commentable_id'),
                'user_id'=>Auth::user()->id
            ]);
            //if project was created successfully

            if($request->hasFile('attachment')){

                $file = $request->file('attachment');

//                $input['file'] = rand() . '.' . $file->getClientOriginalExtension();
                $input['file'] =  $file->getClientOriginalName();

//                dd($input['file']);
                $destinationPath = public_path('uploads/attachments');
                $file->move($destinationPath, $input['file']);
                $comment = Comment::where('body',$request->input('body'))
                    ->update(['attachments'=> $input['file']]);
            }
            if ($comment) {
                return back()->with('success', 'Comment added successfully');
            }
        }
        return back()->with('errors','Error posting comment');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //$comment = Comment::find($comment->id);

        $commentUpdate = Comment::find($comment->id)
            ->update([
                'body'=>$request->input('body'),
                'url'=>$request->input('url')
            ]);
        if ($commentUpdate){
            return redirect()->to('/bugs/'.$comment->commentable_id)
                ->with('success','Comment edited successfully');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //

        $findComment = Comment::find($comment->id);
//        dd($findComment);

        if ($findComment->delete()){
//            return redirect()->to('/bugs/'.$comment->commentable_id)
//                ->with('success',"Comment successfully deleted");
            return 1;
        }else{
            return 3;
        }
//        return back()->with('errors',"Error removing comment");
    }
}
