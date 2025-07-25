class Review {
    protected $db;

    public function __construct() {
        $this->db = new Database(); // Your DB connection class
    }

    public function saveRating($imdb_id, $movie_title, $rating, $user_id = null) {
        $ip = $_SERVER['REMOTE_ADDR'];
        $query = "INSERT INTO movie_ratings 
                  (imdb_id, movie_title, rating, user_id, ip_address) 
                  VALUES (?, ?, ?, ?, ?)";

        $this->db->query($query);
        $this->db->bind($imdb_id, $movie_title, $rating, $user_id, $ip);
        return $this->db->execute();
    }

    public function getAverageRating($imdb_id) {
        $query = "SELECT AVG(rating) as avg_rating 
                  FROM movie_ratings 
                  WHERE imdb_id = ?";
        $this->db->query($query);
        $this->db->bind($imdb_id);
        return $this->db->single()->avg_rating;
    }
}