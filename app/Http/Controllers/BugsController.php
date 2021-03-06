<?php

namespace App\Http\Controllers;

use App\Bug;
use App\BugAttachment;
use App\Project;
use App\User;
use App\Charts\BugChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BugsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $bug = Bug::orderBy('project_id')
        // ->pluck('project_id','status');

        $bug = DB::table('bugs')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total','status');
        //return $bug->keys();

        //return $bug->values();


        if (Auth::user()->user_group=='Developer'){
            $bugs = Bug::where('assigned',Auth::user()->name.' '.Auth::user()->lastname)->get();
        }
        elseif (Auth::user()->user_group=='Test Engineer'){
            $bugs = Bug::where('reporter', Auth::user()->name .' '.Auth::user()->lastname)->get();
        }
        else{
            $bugs = Bug::all();
        }

        return view('bugs.index', compact('bugs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($project_id =null)//null is the default value assigned if id not entered
    {
        //
        $devs = User::where('user_group','Developer')->get();

        $projects = null;

        if(!$project_id){
            $projects = Project::where('user_id',Auth::user()->id)->get();
        }else{
            $projects = Project::where('id',$project_id)->first();
        }
        return view('bugs.create',['project_id'=>$project_id,'projects'=>$projects,'devs'=> $devs]);
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
        $this->validate($request,[
            'due_date' => 'date|after:today'
        ]);
        if(Auth::check()) {
            $bug = Bug::create([
                'project_id'=>$request->input('project_id'),
                'title'=>$request->input('title'),
                'reporter'=>Auth::user()->name.' '.Auth::user()->lastname,
                'type'=>$request->input('bug_type'),
                'description' =>$request->input('description'),
                'priority'=>$request->input('priority'),
                'assigned' => $request->input('assigned'),
                'due_date'=>$request->input('due_date')
            ]);
            //dd($bug);
            //if bug was created successfully
            if ($bug) {
                return redirect()->to('/projects/'.$request->input('project_id'))
                    //return redirect()->route('bugs.show', ['bug' => $bug->id])
                    ->with('success', 'Bug created successfully');
            }
        }
        //if not created successfully
        return back()->withInput()->with('errors','Error creating new bug');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bug  $bug
     * @return \Illuminate\Http\Response
     */
    public function show(Bug $bug)
    {
        //
        $bug = Bug::where('id',$bug->id)->first();
        $devs = User::where('user_group','Developer')->get();

        $comments = $bug->comments;


        return view('bugs.show',['bug'=>$bug,'comments'=>$comments,'devs'=>$devs]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bug  $bug
     * @return \Illuminate\Http\Response
     */
    public function edit(Bug $bug)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bug  $bug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bug $bug)
    {
        //
        $this->validate($request,[
            'due_date' => 'date|after:today'
        ]);
        $bugUpdate = Bug::where('id',$bug->id)
            ->update([
                'type'=>$request->input('bug_type'),
                'description'=>$request->input('description'),
                'priority'=>$request->input('priority'),
                'assigned'=>$request->input('dev'),
                'due_date'=>$request->input('due_date'),
                'status'=>$request->input('status')
            ]);
        if($bugUpdate){
            return redirect()->to('/bugs/'.$bug->id)
                ->with('success','Bug Status changed successfully');


        }
    }


    public function search_bugs(Request $request)
    {
        if(Auth::user()->user_group == 'Developer'){
            $bugs = Bug::where('title','like','%' . $request->get('Query').'%')
                ->where('assigned',Auth::user()->name. ' '.Auth::user()->lastname)
                ->get();
        }

        elseif (Auth::user()->user_group == 'Test Engineer'){
            $bugs = Bug::where('title', 'like','%'. $request->get('Query').'%')
                ->where('reporter', Auth::user()->name .' '.Auth::user()->lastname)
                ->get();

        }

        else {
            $bugs = Bug::where('title','like','%'.$request->get('Query').'%')
                ->get();


        }

        return json_encode($bugs);
    }

    public function attachmentUpload(Request $request){
        $this->validate($request,[
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);
        $devs = User::where('user_group','Developer')->get();
        $bug = Bug::find($request->input('bug_id'));
        $comments = $bug->comments;

        if ($request->hasFile('attachments')){

            foreach ($request->attachments as $file){
                $filename = $file->getClientOriginalName();
                //print_r($filename);

                $destinationPath = public_path('uploads/attachments');
                $file->move($destinationPath, $filename);

                $attAdded = BugAttachment::create([
                    'att_name'=>$filename,
                    'bug_id'=>$request->input('bug_id')
                ]);


            }
            if ($attAdded){
                // return view('bugs.show',compact('devs','bug','comments'));

                return redirect()->to('/bugs/'.$bug->id)
                    ->with('success','Attachments added successfully');
            }
        }
        return back()->with('errors','Error adding attachments');

    }


    public function destroy(Bug $bug)
    {
        //
        $findBug = Bug::find($bug->id);
        $comments = $findBug->comments();

        if($findBug ->delete()){
            $comments->delete();
            return redirect()->route('bugs.index')
                ->with('success',"$findBug->title".' (bug) deleted successfully');
        }
        return back()->withInput()->with('errors','Bug could not be deleted');
    }
}
