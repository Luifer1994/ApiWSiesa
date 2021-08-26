<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use nusoap_client;

class BodegasController extends Controller
{
    public  function Existence(Request $request) {
        //return $request->id_cia;
        $cliente = new nusoap_client("http://131.0.171.99/WSUNOEE/wsunoee.asmx?wsdl", true);

        
        $xml = "<Consulta>" .
            "<NombreConexion>unoee_invercomer</NombreConexion>" .
            "<IdCia>1</IdCia>" .
            "<IdProveedor>MT</IdProveedor>" .
            "<IdConsulta>EXISTENCIA_BODEGA</IdConsulta>" .
            "<Usuario>osalcedo</Usuario>" .
            "<Clave>Auror@02</Clave>" .
            "<Parametros>" .
            "<id_bodega>10101</id_bodega>" .
            "<id_cia>1</id_cia>" .
            "</Parametros>" .
            "</Consulta>";

        $params = ['pvstrxmlParametros' => $xml];

        //var_dump($this->cliente);

        $result = $cliente->call('EjecutarConsultaXML', $params);

        return $result["EjecutarConsultaXMLResult"]["diffgram"]["NewDataSet"]["Resultado"];


    }
}
