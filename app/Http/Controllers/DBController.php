<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

//we need the facade
use Illuminate\Support\Facades\DB;

class DBController extends Controller
{


    public function logout()
    {
        Session::flush();
        return redirect('/');
    }

    public function register_submit(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $name = $request->input('name');


        DB::table('users')->insert([
            'email' => $email,
            'password' => $password,
            'name' => $name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('login')->with('success', "account created. login to proceed");




    }

    public function login_submit(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');


        $user = DB::table('users')->where('email', $email)->where('password', $password)->first(['email', 'password', 'userid', 'name']);


        // $users = DB::table('users')->get(['email', 'password', 'userid', 'name']);

        //this is not the best approach
        // foreach ($users as $user) {
        //     if ($user->email == $email && $user->password == $password) {
        //         //match. store the userid in session 
        //         session(['userid' => $user->userid, 'email' => $user->email, 'name' => $user->name]);
        //         return view('index');
        //     }
        // }

        if ($user) {
            //match. store the userid in session 
            session(['userid' => $user->userid, 'email' => $user->email, 'name' => $user->name]);
            return redirect('index');
        } else {
            //invalid email and passworld
            return redirect()->route('login')->with('error', 'invalid email or password or No account found');
        }



    }

    public function history()
    {
        $userId = 1;
        $routes = DB::table('locations')
            ->where('userid', $userId)
            ->orderBy('group')
            ->get()
            ->groupBy('group');

        return view('history', ['routes' => $routes]);
    }

    public function save_location(Request $request)
    {
        //extract the coordinate variable from the request.
        $coordinates = $request->input('coordinates');
        $profile = $request->input('profile');
        //get the last number in the group column. 
        $lastnumber_group = DB::table('locations')->max('group');

        //then iterate
        // Store the coordinate pairs in the database
        foreach ($coordinates as $coordinate) {
            DB::table('locations')->insert([
                'userid' => 1,
                'group' => ($lastnumber_group + 1),
                'profile' => $profile,
                'latitude' => $coordinate['lat'],
                'longitude' => $coordinate['lng'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['message' => 'Route saved successfully!'], 200);

    }
}
