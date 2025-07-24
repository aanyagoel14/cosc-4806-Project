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
