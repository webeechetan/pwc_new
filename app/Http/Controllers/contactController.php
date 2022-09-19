<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class contactController extends Controller
{
    function index(Request $request){
        $requestType= $request->query('request');
        if( $requestType === 'table') {
            $contact = Contact::all();
            return response()->json($contact);
        } else if( $requestType === 'message') {
            $success = false;
            $message = "Something went wrong!";
            $id = $request->query('id');
            $contact = Contact::findOrFail($id);
            if($contact) $success = true;
            return response()->json([
                "success"=> $success,
                "message"=> $message,
                "data"=> $contact
            ]);
        }else return view("admin.contact.index");
    }

    function update(Request $request){
        $success = false;
        $message = "Something went wrong";

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'message' => 'required'
        ]);

        $contact = Contact::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'message' => $request['message']
        ]);
        if($contact) {
            $success = true;
            $message = "Thank you for connecting with us!";
        }
        return response()->json([
            'success' => $success, 
            'message' => $message,
        ]);
    }

    function delete(Request $request) {
        $success = false;
        $message = "Something went wrong";

        $contact = Contact::findOrFail(request() -> id);
        if($contact)
        {
            $contact -> delete();
            $success = true;
            $message = "Successfully deleted";
        }
        return response()->json(['success' => $success, 'message' => $message]);
    }
}
