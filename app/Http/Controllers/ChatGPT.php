<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Throwable;

class ChatGPT extends Controller
{
    /**
     * @param Request $request
     * @return string
     */
    public function __invoke(Request $request)
    {

        try {
            $title = "Migliori siti di " .$request->post('content');
            $slug = Str::slug("Migliori siti di " .$request->post('content'));
            $message = "Crea una metadescription ottimizzata SEO, di 160 caratteri, su una selezione dei migliori siti che parlano di: ";

            if (null !== $request->post('description') && $request->post('description') == 'full' ) {
                $message = "Crea una description ottimizzata SEO, di 160 caratteri, su una selezione dei migliori siti che parlano di: ";
            }
            /** @var array $response */
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . env('CHAT_GPT_KEY')
            ])->post('https://api.openai.com/v1/chat/completions', [
                "model" => $request->post('model'),
                "messages" => [
                    [
                        "role" => "user",
                        "content" => $message .$request->post('content')
                    ]
                ],
                "temperature" => 0,
                "max_tokens" => 2048
            ])->body();            
            //$response['choices'][0]['message']['content'];
            //$data->choices[0]->message->content;
            $data = json_decode($response);
            $data->title = $title;
            $data->slug = $slug;
            return $data;
            
        } catch (Throwable $e) {
            return "Error: $response";
        }
    }
}