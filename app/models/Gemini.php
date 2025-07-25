<?php
class Gemini {
    public function generateReview($movieTitle, $movieYear, $plot) {
        $apiKey = $_ENV['gemini_key']; // Your secret key

        $prompt = "Write a 100-word professional movie review for $movieTitle ($movieYear). Focus on: 
        - Cinematography
        - Acting performances  
        - Overall impression
        - Who would enjoy it

        Plot summary: $plot";

        $data = [
            'contents' => [
                'parts' => [['text' => $prompt]]
            ]
        ];

        $response = file_get_contents(
            "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=$apiKey",
            false,
            stream_context_create([
                'http' => [
                    'method' => 'POST',
                    'header' => 'Content-Type: application/json',
                    'content' => json_encode($data)
                ]
            ])
        );

        $result = json_decode($response, true);
        return $result['candidates'][0]['content']['parts'][0]['text'] ?? "Review unavailable";
    }
}