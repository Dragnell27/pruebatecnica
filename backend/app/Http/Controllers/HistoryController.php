<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Param;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HistoryController extends Controller
{
    public function storage(Request $request)
    {
        try {
            // Se validan los datos del request
            $validatedData = $request->validate([
                'city' => 'required|numeric',
                'budget' => 'required|numeric',
            ]);

            // Crea el nuevo registro en la base de datos
            $history = History::create([
                'param_city' => $validatedData['city'],
                'budget' => $validatedData['budget'],
            ]);

            // Retorna respuesta exitosa
            return response()->json([
                'success' => true,
                'message' => 'History saved successfully',
                'data'    => $history,
            ], 200);
        } catch (\Exception $e) {
            // Retorna respuesta de error en caso de excepción
            return response()->json([
                'success' => false,
                'message' => 'Failed to save history: ' . $e->getMessage(),
                'data'    => null,
            ], 500);
        }
    }

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
        try {
            $city = Param::where('id', $request->city)->first();
            $country = Param::where('id',$request->country)->first();
            $coinSymbol = Param::where('param_type_id', 3)->where('param_id',$request->country)->first();
            $arrayCoinSymbol = explode(',',$coinSymbol->name);
            $coin = $arrayCoinSymbol[0];
            $symbol = $arrayCoinSymbol[1];
            $coinName = $arrayCoinSymbol[2];


            // dd($city->name . $coin . $symbol);


            $responseCoin = Http::get('https://v6.exchangerate-api.com/v6/9ab10f61335934c83a941b45/latest/COP');
            $responseClimate = Http::get('https://api.openweathermap.org/data/2.5/weather?q='.$city->name.'&APPID=ccf0fc35228f8ff018716c7e55fb5814&units=metric');

            // Verifica si la respuesta fue exitosa
            if ($responseCoin->successful() && $responseClimate->successful()) {
                // Obtener la respuesta en formato JSON
                $dataCoin = $responseCoin->json();
                $dataClimate = $responseClimate->json();

                // dd($dataClimate['weather'][0]['icon']);

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

                History::create([
                    'param_city' => $request->city,
                    'budget' => $request->budget,
                    'symbol' => $symbol,
                    'coin' => $coin,
                    'climate' => $dataClimate['main']['temp'],
                    'exchangeRate' => $dataCoin['conversion_rates'][$coin],
                    'budget' => $request->budget,
                ]);

                // dd($data);
                // Devuelve la respuesta
                return response()->json([
                    'success' => true,
                    'message' => 'Se calculó la info',
                    'data'    => $data,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No se pudo obtener la información',
                    'error'   => $responseCoin->status() .' | '. $responseClimate->status(),
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save history: ' . $e->getMessage(),
                'data'    => null,
            ], 500);
        }
    }
}
