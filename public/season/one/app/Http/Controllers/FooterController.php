<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Footer;
use App\Models\Common;

class FooterController extends Controller
{
    /*
    | Index
    -------------- */
    public function index()
    {
        $footer = Footer::findOrFail(1);
        $quick_links = Common::where('type', 'footer_quick_links') -> select('id', 'content1', 'content2') ->get();
        if($footer) return view('admin.template_part.footer', ["footer" => $footer, 'quick_links' => $quick_links]);
    }

    /*
    | Update 
    -------------- */
    public function update(Request $request) {
        $success = false;
        $message = "Something went wrong";
        $footer = Footer::findOrFail(1);
        if($footer)
        {
            // if(!$Event) return redirect() -> back();
            if( $request->method() === 'GET') return response()->json(['success' => true, 'message' => "Success", 'footer' => $footer]);

            /* | Update Request | */
            switch($request['section'])
            {
                case "overview":
                    $request->validate([
                        'description' => 'required',
                    ]);
                    $footer -> description = $request['description'];
                    break;
                case "quick":
                    $request->validate([
                        'quick_link_title' => 'required'
                    ]);
                    $footer -> quick_link_title = $request['quick_link_title'];
                    $menu = $request['menu'];
                    $url = $request['url'];
                    $id = $request['id'];
                    Common::whereNotIn('id', $id)->where('type', 'footer_quick_links')->delete();
                    for($i = 0; $i < count($menu); $i++)
                    {
                        if($id[$i] == '0')
                        {
                            Common::create([
                                'type' => 'footer_quick_links',
                                'content1' => $menu[$i],
                                'content2' => $url[$i]
                            ]);
                        } else
                        {
                            $quickLinks = Common::findOrFail($id[$i]);
                            if($quickLinks)
                            {
                                $quickLinks -> content1 = $menu[$i];
                                $quickLinks -> content2 = $url[$i];
                                $quickLinks -> save();
                            }
                        }
                    }
                    break;
                case "copyright":
                    $request->validate([
                        'copyright_title' => 'required',
                        'fb' => 'required',
                        'twitter' => 'required',
                        'linkedin' => 'required',
                        'youtube' => 'required',
                    ]);
                    $footer -> copyright_title = $request['copyright_title'];
                    $footer -> fb = $request['fb'];
                    $footer -> twitter = $request['twitter'];
                    $footer -> linkedin = $request['linkedin'];
                    $footer -> youtube = $request['youtube'];
                    break;
            }

            $footer->save();
            if($footer){
                $success = true;
                $message = "Successfully updated";
            }
        }
        $quick_links = Common::where('type', 'footer_quick_links') -> select('id', 'content1', 'content2') ->get();
        return response()->json(['success' => $success, 'message' => $message, 'section' => $request['section'], 'quick_links' => $quick_links]);
    }
}
