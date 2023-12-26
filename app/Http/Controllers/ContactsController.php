<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacts;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessage;
use App\Mail\ContactReply;

class ContactsController extends Controller
{
    function SendMessage(Request $req)
    {
        $m = new Contacts();
    
        if ($req->filled("FullName")) {
            $m->FullName = $req->FullName;
        }
    
        if ($req->filled("Phone")) {
            $m->Phone = $req->Phone;
        }
    
        if ($req->filled("Email")) {
            $m->Email = $req->Email;
        }
    
        if ($req->filled("Subject")) {
            $m->Subject = $req->Subject;
        }
    
        if ($req->filled("Message")) {
            $m->Message = $req->Message;
        }
    
        $saver = $m->save();
        if ($saver) {
            // Send email if the request is successful
            try {
                Mail::to('admin@hydottech.com')->send(new ContactMessage($m));
                return response()->json(["Request" => "Success"], 200);
            } catch (\Exception $e) {
              
                return response()->json(["Request" => "Success"], 200);
            }
            
    
           
        } else {
            return response()->json(["Request" => "Failed"], 500);
        }
    }

    function GetAllMessages(){
        $messages = Contacts::orderBy('created_at', 'desc')->get();
        return $messages;
    }


    function ReplyMessage(Request $req, $Id){
        $m = Contacts::find($Id);
    
        if ($m == null){
            return response()->json(["Request" => "Failed"], 500); 
        }
    
        $m->Reply = $req->Reply;
        $saver = $m->save();
    
        if ($saver) {
            // Send email if the request is successful
            try {
                // Assuming ContactMessage accepts the reply message as a parameter
                Mail::to($m->Email)->send(new ContactReply($req->Reply));
    
                return response()->json(["Request" => "Success"], 200);
            } catch (\Exception $e) {
                // Log any exception but still return a success response (since the saving was successful)
                \Log::error('Email sending failed: ' . $e->getMessage());
                return response()->json(["Request" => "Success"], 200);
            }
        } else {
            return response()->json(["Request" => "Failed"], 500);
        }
    }

    function Deleter($Id){
        $m = Contacts::find($Id);
    
        if ($m == null){
            return response()->json(["Request" => "Failed"], 500); 
        }

        $deleter= $m->delete();
        if($deleter){
            return response()->json(["Request" => "Deleted"], 200);
        }
        else{
            return response()->json(["Request" => "Failed"], 500);
        }
    }

}
