<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeSharing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KnowledgeSharingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $requestType= $request->query('request');
        if( $requestType === 'table') {
            $knwoledge_sharing = KnowledgeSharing::all();
            return response()->json($knwoledge_sharing);
        } else {
            return view('admin.knowledge_sharing.list'); 
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.knowledge_sharing.add'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'overview_image' => ['required', 'dimensions:width=360,height=379', 'mimes:jpg,jpeg,jfif,png'],
            // 'banner_image' => ['required', 'dimensions:width=1920,height=300', 'mimes:jpg,jpeg,jfif,png'],
            'title' => 'required',
            'overview' => 'required',
            'description' => 'required'
        ]);
        
        $overview_image = time().'_overview.'.$request->overview_image->extension(); 
        $banner_image = time().'_banner.'.$request->banner_image->extension(); 
        $ppts = [];
        if($request->hasfile('ppts')){
            foreach($request->file('ppts') as $file)
            {
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path('uploads/knowledge_sharing'), $name); 
                $ppts[] = $name;  
            }
        }
        $ppts = implode(',',$ppts);
        $request->overview_image->move(public_path('uploads/knowledge_sharing'), $overview_image);
        $request->banner_image->move(public_path('uploads/knowledge_sharing'), $banner_image);
        $knowledgeSharing = KnowledgeSharing::create([
            'title' => $request['title'],
            'overview' => $request['overview'],
            'description' => $request['description'],
            'overview_image' => $overview_image,
            'banner_image' => $banner_image,
            'files' => $ppts
        ]);

        return redirect()->route('knowledge_sharing.list')->with('success',"addedd");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KnowledgeSharing  $knowledgeSharing
     * @return \Illuminate\Http\Response
     */
    public function show(KnowledgeSharing $knowledgeSharing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KnowledgeSharing  $knowledgeSharing
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $KnowledgeSharing = KnowledgeSharing::find($id);
        return view('admin.knowledge_sharing.edit',compact('KnowledgeSharing'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KnowledgeSharing  $knowledgeSharing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            // 'overview_image' => ['required', 'dimensions:width=360,height=379', 'mimes:jpg,jpeg,jfif,png'],
            // 'banner_image' => ['required', 'dimensions:width=1920,height=300', 'mimes:jpg,jpeg,jfif,png'],
            'title' => 'required',
            'overview' => 'required',
            'description' => 'required'
        ]);
        $knowledgeSharing = KnowledgeSharing::find($request->id);

        if($request->hasfile('overview_image')){
            $overview_image = time().'_overview.'.$request->overview_image->extension(); 
            $request->overview_image->move(public_path('uploads/knowledge_sharing'), $overview_image);
            $knowledgeSharing->overview_image = $overview_image;
        }

        if($request->hasfile('banner_image')){
            $banner_image = time().'_banner.'.$request->banner_image->extension(); 
            $request->banner_image->move(public_path('uploads/knowledge_sharing'), $banner_image);
            $knowledgeSharing->banner_image = $banner_image;
        }

        $ppts = [];
        if($request->hasfile('ppts')){
            foreach($request->file('ppts') as $file)
            {
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path('uploads/knowledge_sharing'), $name); 
                $ppts[] = $name;  
            }
        }
        $old_ppts = $knowledgeSharing->files;
        $old_ppts = explode(',',$old_ppts);
        $ppts = array_merge($old_ppts,$ppts);
        $ppts = implode(',',$ppts);
        $knowledgeSharing->title = $request->title;
        $knowledgeSharing->overview = $request->overview;
        $knowledgeSharing->description = $request->description;
        
        if($knowledgeSharing->save()){
            return redirect()->route('knowledge_sharing.list')->with('success',"addedd");
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KnowledgeSharing  $knowledgeSharing
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $success = false;
        $message = "Something went wrong";

        $knowledgeSharing = KnowledgeSharing::findOrFail($id);
        if($knowledgeSharing)
        {
            
            if($knowledgeSharing -> delete())
            {
                $success = true;
                $message = "Successfully deleted";
            }
        }
        
        return response()->json(['success' => $success, 'message' => $message]);
    }

    public function delete_image($id,$name){
        $knowledgeSharing = KnowledgeSharing::find($id);
        $files = explode(',',$knowledgeSharing->files);
        $key = array_search($name,$files);
        unset($files[$key]);
        $files = implode(',',$files);
        $knowledgeSharing->files = $files;
        if($knowledgeSharing->save()){
            return redirect()->route('knowledge_sharing.edit',$id);
        }
    }
}
