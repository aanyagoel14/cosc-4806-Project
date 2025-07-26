<?php
class Gemini {
    private $apiKey;

    public function __construct() {
        $key = $_ENV['GEMINI'] ?? getenv('GEMINI') ?? die('Missing API key');
        $this->apiKey = $key;
    }

    public function generateReview($movieTitle, $movieYear, $plot) {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$this->apiKey}";

        $prompt = "Give me a review for {$movieTitle} ({$movieYear}) from someone that has an average of 4 out of 5.\n\n";

        $data = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'topP' => 1,
                'topK' => 40,
                'maxOutputTokens' => 300
            ],
            'safetySettings' => [
                [
                    'category' => 'HARM_CATEGORY_HATE_SPEECH',
                    'threshold' => 'BLOCK_ONLY_HIGH'
                ],
                [
                    'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
                    'threshold' => 'BLOCK_ONLY_HIGH'
                ],
                [
                    'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
                    'threshold' => 'BLOCK_ONLY_HIGH'
                ]
            ]
        ];

        $options = [
            'http' => [
                'header' => "Content-type: application/json\r\n",
                'method' => 'POST',
                'content' => json_encode($data),
                'ignore_errors' => true
            ]
        ];

        try {
            $context = stream_context_create($options);
            $response = file_get_contents($url, false, $context);

            if ($response === false) {
                error_log("Gemini API Error: " . print_r(error_get_last(), true));
                return "Could not connect to review service. Please try later.";
            }

            $result = json_decode($response, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return "Invalid response from review service.";
            }

            if (isset($result['error'])) {
                error_log("Gemini API Error: " . print_r($result['error'], true));
                return "Review service temporarily unavailable.";
            }

            if (!isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                return "Failed to generate review. Please try again.";
            }

            return $result['candidates'][0]['content']['parts'][0]['text'];

        } catch (Exception $e) {
            error_log("Gemini Exception: " . $e->getMessage());
            return "Review service temporarily unavailable.";
        }
    }
}
?>