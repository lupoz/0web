<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;

class ChatGPT extends Controller
{
    /**
     * @param Request $request
     * @return string
     */
    public function __invoke(Request $request): string
    {

        try {
            /** @var array $response */
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . env('CHAT_GPT_KEY')
            ])->post('https://api.openai.com/v1/chat/completions', [
                "model" => $request->post('model'),
                "messages" => [
                    [
                        "role" => "user",
                        "content" => "Crea una metadescription ottimizzata SEO, di 160 caratteri, su una selezione dei migliori siti che parlano di: " .$request->post('content')
                    ]
                ],
                "temperature" => 0,
                "max_tokens" => 2048
            ])->body();            
            return $response['choices'][0]['message']['content'];
        } catch (Throwable $e) {
            return "Error: $response";
        }
    }
}