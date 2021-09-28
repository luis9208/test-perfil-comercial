<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json(['users' => $users], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('file');
        $msg = 'Todo se cargo OK';
        $status = 201;
        try {
            //code...
            Excel::import(new UsersImport, $file);
        } catch (\Exception $ex) {
            //throw $th;
            dd($ex);

            $msg = $ex->getMessage();
            $status = 500;

        }

        return response()->json(['message' => $msg], $status);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    public function search(Request $request)
    {

        $user = User::find($request->id); //$request->user();
        $subordinates = null;
        $status = 200;
        $total_ventas = 0;
        $subordinates = User::subordinates($user->numero_empleado, $user->cargo);

        foreach ($subordinates as $subordinate) {
            if ($subordinate->ventas == 0) {
                $sub_users = User::subordinates($subordinate->numero_empleado, $subordinate->cargo);
                $total_venta_sub = 0;
                foreach ($sub_users as $sub) {
                    $total_venta_sub += $sub->ventas;
                }
                $subordinate['ventas'] = $total_venta_sub;
            }
            $total_ventas += $subordinate->ventas;
        }
        $user['ventas'] = $total_ventas;

        return response()->json(['usuario' => $user, 'subalternos' => $subordinates], $status);
    }

    public function hasBoss($id)
    {
        User::find($id)->first();
    }
}
