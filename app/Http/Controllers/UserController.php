<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
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
            Excel::import(new UsersImport, $file);
        } catch (\Exception $ex) {
            $msg = $ex->getMessage();
            $status = 500;

        }
        return response()->json(['message' => $msg], $status);
    }

    
    /**
     * Consulta los datos de los empleados y subalternos
     * @param Request $request 
     */
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

}
