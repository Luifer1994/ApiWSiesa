<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use nusoap_client;

class ListUserController extends Controller
{
    public function ListUserForDocument(Request $request)
    {
        $this->validate($request, [
            'document_client' => 'required|numeric',
            'user' => 'required|email',
            'pass' => 'required',
        ]);
        $user = User::whereEmail($request["user"])->first();

        try {
            if ($user && Hash::check($request["pass"], $user->password)) {

                $cliente = new nusoap_client("http://131.0.171.99/WSUNOEE/wsunoee.asmx?wsdl", true);

                $xml = "<Consulta>
                    <NombreConexion>unoee_invercomer</NombreConexion>
                    <IdCia>1</IdCia>
                    <IdProveedor>MT</IdProveedor>
                    <IdConsulta>CONSULTA_CLIENTE_DOCUMENTO</IdConsulta>
                    <Usuario>osalcedo</Usuario>
                    <Clave>Auror@02</Clave>
                    <Parametros>
                    <documento>" . $request["document_client"] . "</documento>
                    </Parametros>
                    </Consulta>";

                $params = ['pvstrxmlParametros' => $xml];


                $result = $cliente->call('EjecutarConsultaXML', $params);
                $client = $result["EjecutarConsultaXMLResult"]["diffgram"];

                if ($client == "") {
                    return response()->json([
                        'res' => false,
                        'message' => 'Cliente no existe',
                    ], 400);
                } else {
                    return response()->json([
                        'res' => true,
                        'message' => 'Ok',
                        'data' => $client["NewDataSet"]["Resultado"],
                    ], 200);
                }
            } else {
                return response()->json([
                    'res' => false,
                    'message' => 'Usuario o password incorrecta',
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'message' => 'Error de servidor',
            ], 500);
        }
    }
}