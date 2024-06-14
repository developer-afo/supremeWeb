<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


use Illuminate\Support\Facades\Storage;

use App\Models\Property;
use App\Models\Message;
use App\Models\Contact;


class UserController extends Controller
{
    
    public function getUserProfile(Request $request)
    {
     return response()->json(['status'=>'success','msg'=>'User Details Successfully Fetched','data' => Auth::user()],200);
    }
    
    public function getAllUsers()
    {
        $all_users = User::paginate(10);
        
        return response()->json(['status' => 'success', 'msg' => 'All users fetched successfully', 'data' => $all_users], 200);
    }
    

}
