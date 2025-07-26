<?php

class Review {
    protected $db;

    public function __construct() {
        $this->db = db_connect(); 
    }

    public function saveRating($imdb_id, $movie_title, $rating, $user_id = null) {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare(
                "INSERT INTO movie_ratings 
                (imdb_id, movie_title, rating, user_id, ip_address) 
                VALUES (?, ?, ?, ?, ?)"
            );

            $ip = $_SERVER['REMOTE_ADDR'];
            $result = $stmt->execute([$imdb_id, $movie_title, $rating, $user_id, $ip]);

            $this->db->commit();
            return $result;

        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Rating save failed: " . $e->getMessage());
            return false;
        }
    }

    public function getAverageRating($imdb_id) {
        $statement = $this->db->prepare(
            "SELECT AVG(rating) as avg_rating 
            FROM movie_ratings 
            WHERE imdb_id = ?"
        );
        $statement->execute([$imdb_id]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return isset($result['avg_rating']) ? round((float)$result['avg_rating'], 1) : 0;
    }

    public function getRatingCount($imdb_id) {
        $statement = $this->db->prepare(
            "SELECT COUNT(*) as total 
            FROM movie_ratings 
            WHERE imdb_id = ?"
        );
        $statement->execute([$imdb_id]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['total'] : 0;
    }

    public function getUserRating($imdb_id, $user_id) {
        $statement = $this->db->prepare(
            "SELECT rating 
            FROM movie_ratings 
            WHERE imdb_id = ? AND user_id = ?
            ORDER BY created_at DESC
            LIMIT 1"
        );
        $statement->execute([$imdb_id, $user_id]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['rating'] : null;
    }

    public static function logRatingActivity($imdb_id, $action) {
        $db = db_connect();
        $statement = $db->prepare(
            "INSERT INTO rating_activity 
            (imdb_id, action, ip_address, created_at) 
            VALUES (?, ?, ?, NOW())"
        );
        $statement->execute([
            $imdb_id, 
            $action, 
            $_SERVER['REMOTE_ADDR']
        ]);
    }
}