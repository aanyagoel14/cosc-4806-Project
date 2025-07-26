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
        $movie_title = trim($_GET['movie']);
        $movie = $api->search_movie($movie_title);

        $_SESSION['current_movie'] = [
            'title' => $movie->Title,
            'imdb_id' => $movie->imdbID
        ];

        $_SESSION['current_movie']['plot'] = $movie->Plot ?? '';
        $_SESSION['current_movie']['year'] = $movie->Year ?? '';
    
        $this->view('movie/results', [
            'movie' => $movie, 
            'searchTerm' => $movie_title
        ]);
    }
    
    public function review($rating = '') {
        if (!is_numeric($rating) || $rating < 1 || $rating > 5 || 
            !isset($_SESSION['current_movie'])) {
            header('Location: /movie');
            exit;
        }

        $review = $this->model('Review');
        $result = $review->saveRating(
            $_SESSION['current_movie']['imdb_id'],
            $_SESSION['current_movie']['title'],
            $rating,
            $_SESSION['user_id'] ?? null
        );

        $_SESSION['rating_result'] = $result ? 'success' : 'failed';

        header('Location: /movie/search?movie=' . urlencode($_SESSION['current_movie']['title']));
        exit;
    }
    public function generateReview() {
        if (!isset($_SESSION['current_movie'])) {
            header('Location: /movie');
            exit;
        }

        $gemini = $this->model('Gemini');
        $review = $gemini->generateReview(
            $_SESSION['current_movie']['title'],
            $_SESSION['current_movie']['year'],
            $_SESSION['current_movie']['plot']
        );

        $_SESSION['ai_review'] = $review;
        header('Location: /movie/search?movie=' . urlencode($_SESSION['current_movie']['title']));
        exit;
    }
    }
    ?>