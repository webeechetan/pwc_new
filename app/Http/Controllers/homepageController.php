<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomePage;

class homepageController extends Controller
{
    /*
    | Index
    -------------- */
    public function index()
    {
        $HomePage = HomePage::first();
        if($HomePage) return view('admin.pages.homepage', ["homepage" => $HomePage]);
    }

    /* 
    | Update 
    -------------- */
    public function update(Request $request) {

        $success = false;
        $message = "Something went wrong";
        $HomePage = HomePage::findOrFail($request->id);
        if($HomePage)
        {
            // if(!$Event) return redirect() -> back();
            if( $request->method() === 'GET') return response()->json(['success' => true, 'message' => "Success", 'homepage' => $HomePage]);

            /* | Update Request | */
            $imageStatus = [];
            switch($request['section'])
            {
                case "banner":
                    $request->validate([
                        'banner_image' => ['dimensions:width=1920,height=875', 'mimes:jpg,jpeg,jfif,png'],
                        'banner_title' => 'required',
                        'banner_caption1' => 'required',
                        'banner_caption2' => 'required',
                        'banner_subtitle' => 'required',
                        'banner_button' => 'required',
                    ]);
                    $banner_image = false;
                    if($request->file()) {
                        if($request->file('banner_image')) {
                            if($banner_image = $request->file('banner_image')->storeAs('uploads/homepage/', 'banner.jpg', 'public')) $imageStatus['banner_image'] = [true, "successfully uploaded"];
                        }
                    }
                    $HomePage -> banner_title = $request['banner_title'];
                    $HomePage -> banner_caption1 = $request['banner_caption1'];
                    $HomePage -> banner_caption2 = $request['banner_caption2'];
                    $HomePage -> banner_subtitle = $request['banner_subtitle'];
                    $HomePage -> banner_button = $request['banner_button'];
                    $HomePage -> banner_button_action = $request['banner_button_action'];
                    break;
                case "s1":
                    $request->validate([
                        's1_count1' => 'required',
                        's1_heading1' => 'required',
                        's1_count2' => 'required',
                        's1_heading2' => 'required',
                        's1_count3' => 'required',
                        's1_heading3' => 'required',
                        's1_count4' => 'required',
                        's1_heading4' => 'required',
                    ]);
                    $HomePage -> s1_count1 = $request['s1_count1'];
                    $HomePage -> s1_heading1 = $request['s1_heading1'];
                    $HomePage -> s1_count2 = $request['s1_count2'];
                    $HomePage -> s1_heading2 = $request['s1_heading2'];
                    $HomePage -> s1_count3 = $request['s1_count3'];
                    $HomePage -> s1_heading3 = $request['s1_heading3'];
                    $HomePage -> s1_count4 = $request['s1_count4'];
                    $HomePage -> s1_heading4 = $request['s1_heading4'];
                    break;
                case "s2":
                    $request->validate([
                        's2_image' => ['dimensions:width=737,height=737', 'mimes:jpg,jpeg,jfif,png'],
                        's2_heading' => 'required',
                        's2_title' => 'required',
                        's2_description' => 'required'
                    ]);
                    $s2_image = false;
                    if($request->file()) {
                        if($request->file('s2_image')) {
                            if($s2_image = $request->file('s2_image')->storeAs('uploads/homepage/', 's2_image.jpg', 'public')) $imageStatus['s2_image'] = [true, "successfully uploaded"];
                        }
                    }
                    $HomePage -> s2_heading = $request['s2_heading'];
                    $HomePage -> s2_title = $request['s2_title'];
                    $HomePage -> s2_description = $request['s2_description'];
                    break;
                case "event":
                    $request->validate([
                        'event_title' => 'required',
                        'event_subtitle' => 'required',
                    ]);
                    $HomePage -> event_title = $request['event_title'];
                    $HomePage -> event_subtitle = $request['event_subtitle'];
                    break;
                case "case_study":
                    $request->validate([
                        'case_study_title' => 'required',
                        'case_study_subtitle' => 'required',
                    ]);
                    $HomePage -> case_study_title = $request['case_study_title'];
                    $HomePage -> case_study_subtitle = $request['case_study_subtitle'];
                    break;
                case 'knowledge_sharing':
                    $request->validate([
                        'knowledge_title' => 'required',
                        'knowledge_subtitle' => 'required',
                    ]);
                    $HomePage -> knowledge_title = $request['knowledge_title'];
                    $HomePage -> knowledge_subtitle = $request['knowledge_subtitle'];
                    break;
                case "s3":
                    $request->validate([
                        's3_heading' => 'required',
                        's3_title' => 'required',
                        's3_description' => 'required',
                        's3_email' => 'required',
                        's3_contact_heading' => 'required',
                        's3_contact_subheading' => 'required',
                    ]);
                    $HomePage -> s3_heading = $request['s3_heading'];
                    $HomePage -> s3_title = $request['s3_title'];
                    $HomePage -> s3_description = $request['s3_description'];
                    $HomePage -> s3_email = $request['s3_email'];
                    $HomePage -> s3_contact_heading = $request['s3_contact_heading'];
                    $HomePage -> s3_contact_subheading = $request['s3_contact_subheading'];
                    break;
            }

            $HomePage->save();
            if($HomePage){
                $success = true;
                $message = "Successfully updated";
            }
        }
        return response()->json(['success' => $success, 'message' => $message, 'Image' => $imageStatus, 'section' => $request['section']]);
    }
}
