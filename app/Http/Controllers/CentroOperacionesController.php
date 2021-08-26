<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use nusoap_client;

class CentroOperacionesController extends Controller
{
    public function List(Request $request)
    {
       //return $request->id_cia;
        $cliente = new nusoap_client("http://131.0.171.99/WSUNOEE/wsunoee.asmx?wsdl", true);

                $xml = "<Consulta>" .
                            "<NombreConexion>unoee_invercomer</NombreConexion>" .
                            "<IdCia>1</IdCia>" .
                            "<IdProveedor>Mt</IdProveedor>" .
                            "<IdConsulta>listar_centrosop</IdConsulta>" .
                            "<Usuario>osalcedo</Usuario>" .
                            "<Clave>Auror@02</Clave>" .
                            "<Parametros>" .
                            "<id_cia>" . $request->id_cia . "</id_cia>" .
                            "</Parametros>" .
                        "</Consulta>";

                $params = ['pvstrxmlParametros' => $xml];

                $result = $cliente->call('EjecutarConsultaXML', $params);
                $client = $result["NewDataSet"];

                return $client;
    }
}
