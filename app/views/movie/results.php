<!DOCTYPE html>
<html>
<head>
    <title>Movie Search Results</title>
    <style>
        .movie-result {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .rating-message {
            padding: 10px;
            margin: 10px 0;
            background: #dff0d8;
            border: 1px solid #d6e9c6;
            border-radius: 4px;
            color: #3c763d;
        }

        .rating-container, .rate-movie {
            margin: 20px 0;
            padding: 15px;
            background-color: #fff9e6;
            border-radius: 8px;
        }

        .rating-title, .rate-title {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .popcorn-rating, .rating-buttons {
            font-size: 24px;
            letter-spacing: 5px;
            margin: 10px 0;
        }

        .popcorn-full, .popcorn-btn {
            color: #ffc107;
            text-shadow: 0 0 3px rgba(255, 193, 7, 0.5);
            cursor: pointer;
            margin: 0 5px;
            transition: all 0.2s;
            background: none;
            border: none;
            text-decoration: none;
            display: inline-block;
        }

        .popcorn-half {
            position: relative;
            display: inline-block;
            color: #ffc107;
        }

        .popcorn-half::after {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, transparent 0%, #fff9e6 100%);
        }

        .popcorn-empty {
            color: #ddd;
        }

        .popcorn-btn:hover, .user-rated {
            transform: scale(1.3);
            filter: drop-shadow(0 0 5px gold);
        }

        .rating-stats {
            margin-top: 10px;
            font-style: italic;
            color: #666;
        }

        .ai-review {
            margin-top: 20px;
            padding: 15px;
            background-color: #f0f8ff;
            border-radius: 8px;
        }

        .ai-review button {
            padding: 8px 16px;
            background: #4285f4;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .ai-review button:hover {
            background: #3367d6;
        }

        .review-content {
            margin-top: 10px;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <h1>Movie Search</h1>
    <p><a href="/movie">← New Search</a></p>

    <?php if (isset($movie)): ?>
        <?php if (!isset($movie->Error)): ?>
            <?php
            // Get real rating data
            $review = $this->model('Review');
            $avg_rating = $review->getAverageRating($movie->imdbID);
            $rating_count = $review->getRatingCount($movie->imdbID);
            $user_rating = isset($_SESSION['user_id']) ? 
                $review->getUserRating($movie->imdbID, $_SESSION['user_id']) : null;

            // Show rating result message if exists
            if (isset($_SESSION['rating_result'])) {
                $message = ($_SESSION['rating_result'] === 'success') ? 
                    'Thank you for your rating!' : 'Failed to save rating';
                echo "<div class='rating-message'>$message</div>";
                unset($_SESSION['rating_result']);
            }
            ?>

            <div class="movie-result">
                <h2><?= htmlspecialchars($movie->Title ?? '') ?> (<?= htmlspecialchars($movie->Year ?? '') ?>)</h2>
                <p><strong>Plot:</strong> <?= htmlspecialchars($movie->Plot ?? '') ?></p>
                <p><strong>Director:</strong> <?= htmlspecialchars($movie->Director ?? '') ?></p>
                <p><strong>Actors:</strong> <?= htmlspecialchars($movie->Actors ?? '') ?></p>
                <p><strong>IMDB Rating:</strong> <?= htmlspecialchars($movie->imdbRating ?? '') ?></p>

                <!-- Community Rating Section -->
                <div class="rating-container">
                    <div class="rating-title">Community Rating:</div>
                    <div class="popcorn-rating">
                        <?php
                        $full = floor($avg_rating);
                        $has_half = (($avg_rating - $full) >= 0.5);
                        $empty = 5 - ceil($avg_rating);
                        
                        // Full popcorns
                        for ($i = 0; $i < $full; $i++) {
                            echo '<span class="popcorn-full">🍿</span>';
                        }
                        
                        // Half popcorn
                        if ($has_half) {
                            echo '<span class="popcorn-half">🍿</span>';
                        }
                        
                        // Empty popcorns
                        for ($i = 0; $i < $empty; $i++) {
                            echo '<span class="popcorn-empty">🍿</span>';
                        }
                        ?>
                    </div>
                    <div class="rating-stats">
                        <?= number_format($avg_rating, 1) ?> out of 5 (from <?= $rating_count ?> ratings)
                        <?php if ($user_rating): ?>
                            - Your rating: <?= $user_rating ?>/5
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Rating Form -->
                <div class="rate-movie">
                    <div class="rate-title">Rate this movie:</div>
                    <div class="rating-buttons">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <a href="/movie/review/<?= $i ?>" 
                               class="popcorn-btn <?= ($user_rating == $i) ? 'user-rated' : '' ?>"
                               title="Rate <?= $i ?>">
                               🍿
                            </a>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>

           <!-- AI Review Section -->
           <!-- NEW: AI Review Section -->
           <div class="ai-review">
               <h3>AI-Generated Review</h3>
               <?php if (isset($_SESSION['ai_review'])): ?>
                   <div class="review-content">
                       <?= nl2br(htmlspecialchars($_SESSION['ai_review'])) ?>
                   </div>
                   <?php unset($_SESSION['ai_review']); ?>
               <?php else: ?>
                   <form action="/movie/generateReview" method="post">
                       <button type="submit">Generate AI Review</button>
                   </form>
               <?php endif; ?>
           </div>
           </div>

           <?php else: ?>
           <p>Error: <?= htmlspecialchars($movie->Error) ?></p>
           <?php endif; ?>
           <?php endif; ?>
           </body>
           </html>
