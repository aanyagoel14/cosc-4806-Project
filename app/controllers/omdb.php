<?php

class Omdb extends Controller {
  
    public function index(){
      $query_url = "http://www.omdbapi.com/?apikey=".$_ENV['omdb_key']."&t=the+matrix&y=1999";
      $json = file_get_contents($query_url);
      $phpObj = json_decode($json);
      $movie = array ($phpObj);

      echo "<pre>";
      print_r($movie);
      die;
        
    }
  
