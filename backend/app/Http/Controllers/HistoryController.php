<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Param;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HistoryController extends Controller
{

    public function show()
    {
        try {
            // Obtiene los últimos 5 registros de la base de datos, incluyendo la información de la ciudad y país
            $histories = History::latest()->with(['city.country'])->take(5)->get();
            return response()->json([
                'success' => true,
                'message' => 'History retrieved successfully',
                'data'    => $histories,
            ], 200);
        } catch (\Exception $e) {
            // Retorna respuesta de error en caso de excepción
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve history: ' . $e->getMessage(),
                'data'    => null,
            ], 500);
        }
    }

    public function calculator(Request $request)
    {
        // Trae toda la información referente al clima y moneda de la ciudad seleccionada
        try {
            //inicializo variables con lo datos recibidos desde el frontend
            //para consultar las APIs de moneda y clima
            $city = Param::where('id', $request->city)->first();
            $country = Param::where('id',$request->country)->first();
            $coinSymbol = Param::where('param_type_id', 3)->where('param_id',$request->country)->first();
            $arrayCoinSymbol = explode(',',$coinSymbol->name);
            $coin = $arrayCoinSymbol[0];
            $symbol = $arrayCoinSymbol[1];
            $coinName = $arrayCoinSymbol[2];

            //Realizo consulta a las APIs
            $responseCoin = Http::get('https://v6.exchangerate-api.com/v6/9ab10f61335934c83a941b45/latest/COP');
            $responseClimate = Http::get('https://api.openweathermap.org/data/2.5/weather?q='.$city->name.'&APPID=ccf0fc35228f8ff018716c7e55fb5814&units=metric');

            // Verifica si ambas respuestas son exitosas
            if ($responseCoin->successful() && $responseClimate->successful()) {
                // Convierto las respuestas a json
                $dataCoin = $responseCoin->json();
                $dataClimate = $responseClimate->json();

                //formateo la información que sera enviada al frontend
                $data = [
                    'symbol' => $symbol,
                    'coin' => $coin,
                    'coinName' => $coinName,
                    'city' => $city->name,
                    'country' => $country->name,
                    'budgetFinal' => round($dataCoin['conversion_rates'][$coin] * $request->budget,3),
                    'exchangeRate' => $dataCoin['conversion_rates'][$coin],
                    'temp' => $dataClimate['main']['temp'],
                    'icon' => 'http://openweathermap.org/img/wn/' . $dataClimate['weather'][0]['icon'].'.png',
                ];

                // Creo el registro de la información consultada
                History::create([
                    'param_city' => $request->city,
                    'budget' => $request->budget,
                    'symbol' => $symbol,
                    'coin' => $coin,
                    'climate' => $dataClimate['main']['temp'],
                    'exchangeRate' => $dataCoin['conversion_rates'][$coin],
                    'budget' => $request->budget,
                ]);

                // Devuelve la respuesta
                return response()->json([
                    'success' => true,
                    'message' => 'Information consulted correctly',
                    'data'    => $data,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error consulting APIs',
                    'error'   => $responseCoin->status() .' | '. $responseClimate->status(),
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unknown error: ' . $e->getMessage(),
                'data'    => null,
            ], 500);
        }
    }
}
