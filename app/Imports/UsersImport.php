<?php

namespace App\Imports;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithCustomCsvSettings, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        //Convertir texto a fecha
        $fecha_nac = Carbon::createFromFormat('d/m/Y',$row['fecha_de_nacimiento']);
        $fecha_ing = Carbon::createFromFormat('d/m/Y',$row['fecha_de_ingreso']);

        //Definir valor pr defeto
        $value = '0'; 
        if($row['ventas_2019'] !== '' || $row['ventas_2019'] !== null){
            $value_str = substr($row['ventas_2019'],1,strlen($row['ventas_2019'])); // obtener el valor como cadena sin simbolo pesos
            $value = str_replace('.', '', $value_str); // Obtener el valor como cadena numerica
        }
        $data = [
            'nombres'=>$row['nombres'],
            'apellido_1'=>$row['apellido_1'],
            'apellido_2'=>$row['apellido_2'],
            'cedula'=>$row['cedula'],
            'fecha_nacimiento'=>$fecha_nac,//$row['fecha_de_nacimiento'],
            'genero'=>$row['genero'],
            'fecha_ingreso'=>$fecha_ing,//$row['fecha_de_ingreso'],
            'numero_empleado'=>$row['numero_de_empleado'],
            'cargo'=>$row['cargo'],
            'jefe'=>$row['jefe'],
            'zona'=>$row['zona'],
            'municipio'=>$row['municipio'],
            'departamento'=>$row['departamento'],
            'ventas'=>floatval($value), 
            'email'=>$row['email'],
            'imagen'=>$row['imagen'],
            'password'=>Hash::make($row['contrasena']),
            'celular'=>$row['celular'],

        ];

        return new User($data);
    }

    public function getCsvSettings(): array
    {
        return [
            // 'input_encoding' => 'ISO-8859-1',
            'input_encoding' => 'UTF-8',
            'delimiter' => ",",
        ];
    }
}
