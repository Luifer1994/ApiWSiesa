<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use nusoap_client;

class CentroOperacionesController extends Controller
{
    public  function List(Request $request) {

        $this->validate($request, [
            'id_cia' => 'required|numeric',
            'user' => 'required|email',
            'pass' => 'required',
        ]);
        $user = User::whereEmail($request["user"])->first();

        try {
            if ($user && Hash::check($request["pass"], $user->password)) {

                $centro_operaciones = new nusoap_client("http://131.0.171.99/WSUNOEE/wsunoee.asmx?wsdl", true);

                $xml = "<Consulta>" .
                "<NombreConexion>unoee_invercomer</NombreConexion>" .
                "<IdCia>1</IdCia>" .
                "<IdProveedor>MT</IdProveedor>" .
                "<IdConsulta>LISTAR_CENTROSOP</IdConsulta>" .
                "<Usuario>osalcedo</Usuario>" .
                "<Clave>Auror@02</Clave>" .
                "<Parametros>" .
                "<id_cia>" . $request->id_cia . "</id_cia>" .
                    "</Parametros>" .
                    "</Consulta>";

                $params = ['pvstrxmlParametros' => $xml];

                $result = $centro_operaciones->call('EjecutarConsultaXML', $params);
                //Variable para comprobar si viene vacio
                $centro_operaciones_list = json_encode($result["EjecutarConsultaXMLResult"]["diffgram"]["NewDataSet"]["Resultado"], JSON_PARTIAL_OUTPUT_ON_ERROR);


                if ($centro_operaciones_list == "") {
                    return response()->json([
                        'res' => false,
                        'message' => 'No hay centros de operaciones',
                    ], 400);
                } else {
                    return response()->json([
                        'res' => true,
                        'message' => 'Ok',
                        'data' => json_decode($centro_operaciones_list),
                    ], 200);
                }
            } else {
                return response()->json([
                    'res' => false,
                    'message' => 'Usuario o password incorrecta',
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'message' => 'Error de servidor',
            ], 500);
        }

    }
}
