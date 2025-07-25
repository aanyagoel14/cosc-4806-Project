<?php

class Movie extends Controller{
    public function index(){
        $this->view('movie/index');
    }

    public function search() {
        if (!isset($_GET['movie']) || empty(trim($_GET['movie']))) {
            header('Location: /movie');
            exit;
    }
        $api = $this->model('Api');
        $movie_title = $_GET['movie'];
        $movie = $api->search_movie($movie_title);

        $this->view('movie/results', ['movie' => $movie, 'searchTerm' => $movie_title]);
    }}

    public function review(){
        $this->view('movie/review');
        $review->saveRating(
                $imdb_id,
                $_SESSION['current_movie_title'], // Set this when showing movie
                $rating,
                $_SESSION['user_id'] ?? null // If you have auth
            );

            header('Location: /movie/search?movie=' . urlencode($_SESSION['current_movie_title']));
            exit;
        }
        
    }
