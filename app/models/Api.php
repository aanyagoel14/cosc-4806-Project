<?php 
class Api { 
    public function search_movie($title) { 
        $api_key = $_ENV['omdb_key'] ?? getenv('omdb_key') ?? '';

        if (empty($api_key)) {
            return (object)['Response' => 'False', 'Error' => 'API key not configured'];
        }

        $query_url = "http://www.omdbapi.com/?apikey=".$api_key."&t=".urlencode($title);
        $json = file_get_contents($query_url); 

        if ($json === false) {
            return (object)['Response' => 'False', 'Error' => 'Failed to fetch data'];
        }

        return json_decode($json); 
    } 
}