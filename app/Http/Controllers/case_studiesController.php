<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Case_Studies;
use Illuminate\Support\Facades\Storage;

class case_studiesController extends Controller
{
    public function index(Request $request) {
        // return "avc";
        $requestType= $request->query('request');
        if( $requestType === 'table') {
            $case_studies = Case_Studies::all();
            return response()->json($case_studies);
        } else return view("admin.case_studies.list");
    }

    public function create(Request $request) {
        if( $request->method() === 'GET') return view("admin.case_studies.add");
        // Update Request
        $success = false;
        $message = "Something went wrong";
        $imageStatus = [];

        $request->validate([
             // 'overview_image' => ['required', 'dimensions:width=360,height=379', 'mimes:jpg,jpeg,jfif,png'],
            // 'banner_image' => ['required', 'dimensions:width=1920,height=300', 'mimes:jpg,jpeg,jfif,png'],
            'overview_image' => ['required', 'mimes:jpg,jpeg,jfif,png'],
            'banner_image' => ['required', 'mimes:jpg,jpeg,jfif,png'],
            'title' => 'required',
            'overview' => 'required',
            'description' => 'required'
        ]);
        $overview_image = false;
        $banner_image = false;
        if($request->file()) {
            if($overview_image = $request->file('overview_image')->store('uploads/case_studies/', 'public')) $imageStatus['overview_image'] = [true, "successfully uploaded"];
            if($banner_image = $request->file('banner_image')->store('uploads/case_studies/', 'public')) $imageStatus['banner_image'] = [true, "successfully uploaded"];
        }
        if($overview_image === false || $banner_image === false)
        {
            $message = "Unable to upload image";
            if($overview_image !== false)Storage::disk('public')->delete($overview_image);
            if($banner_image !== false)Storage::disk('public')->delete($banner_image);
        } else
        {
            $caseStudies = Case_Studies::create([
                'title' => $request['title'],
                'overview' => $request['overview'],
                'description' => $request['description']
            ]);

            if($caseStudies)
            {
                $success = true;
                $message = "Successfully uploaded";
                Storage::disk('public')->move($overview_image, "uploads/case_studies/OverviewImage{$caseStudies->id}.jpg");
                Storage::disk('public')->move($banner_image, "uploads/case_studies/BannerImage{$caseStudies->id}.jpg");
            } else
            {
                if($overview_image !== false)Storage::disk('public')->delete($overview_image);
                if($banner_image !== false)Storage::disk('public')->delete($banner_image);
            }
        }
        return response()->json(['success' => $success, 'message' => $message, 'Image' => $imageStatus]);
    }

    public function update(Request $request) {
        $caseStudies = Case_Studies::findOrFail(request() -> id);
        if(!$caseStudies) return redirect() -> back();

        if( $request->method() === 'GET') return view("admin.case_studies.edit", ["data" => $caseStudies]);

        /* | Update Request | */
        $success = false;
        $message = "Something went wrong";
        $imageStatus = [];

        $request->validate([
            'overview_image' => ['dimensions:width=360,height=379', 'mimes:jpg,jpeg,jfif,png'],
            'banner_image' => ['dimensions:width=1920,height=300', 'mimes:jpg,jpeg,jfif,png'],
            'title' => 'required',
            'overview' => 'required',
            'description' => 'required'
        ]);
        $overview_image = false;
        $banner_image = false;
        if($request->file()) {
            if($request->file('overview_image')) {
                if($overview_image = $request->file('overview_image')->storeAs('uploads/case_studies/', 'OverviewImage'.request() -> id.'.jpg', 'public'))$imageStatus['overview_image'] = [true, "successfully uploaded"];
            }
            if($request->file('banner_image')) {
                if($banner_image = $request->file('banner_image')->storeAs('uploads/case_studies/', 'BannerImage'.request() -> id.'.jpg', 'public'))$imageStatus['banner_image'] = [true, "successfully uploaded"];
            }
        }

        $caseStudies -> title = $request['title'];
        $caseStudies -> overview = $request['overview'];
        $caseStudies -> description = $request['description'];
        $caseStudies -> save();
        if($caseStudies)
        {
            $success = true;
            $message = "Successfully updated";
        }
        return response()->json(['success' => $success, 'message' => $message, 'Image' => $imageStatus, 'updated' => $caseStudies]);
    }

    public function delete() {
        $success = false;
        $message = "Something went wrong";

        $caseStudies = Case_Studies::findOrFail(request() -> id);
        if($caseStudies)
        {
            $caseStudies -> delete();
            if($caseStudies)
            {
                $success = true;
                $message = "Successfully deleted";
                Storage::disk('public')->delete('uploads/case_studies/OverviewImage'.request() -> id. '.jpg');
                Storage::disk('public')->delete('uploads/case_studies/BannerImage'.request() -> id. '.jpg');
            }
        }
        
        return response()->json(['success' => $success, 'message' => $message]);
    }
}
