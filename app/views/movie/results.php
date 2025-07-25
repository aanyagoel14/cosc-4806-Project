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

        .rating-container {
            margin: 20px 0;
            padding: 15px;
            background-color: #fff9e6;
            border-radius: 8px;
        }

        .rating-title {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .popcorn-rating {
            font-size: 24px;
            letter-spacing: 5px;
            margin: 10px 0;
        }

        .popcorn-full {
            color: #ffc107;
            text-shadow: 0 0 3px rgba(255, 193, 7, 0.5);
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

        .rate-movie {
            margin-top: 20px;
            padding: 15px;
            background-color: #f5f5f5;
            border-radius: 8px;
        }

        .rate-title {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .popcorn-btn {
            font-size: 24px;
            cursor: pointer;
            margin: 0 5px;
            transition: all 0.2s;
            background: none;
            border: none;
        }

        .popcorn-btn:hover {
            transform: scale(1.3);
        }

        .rating-stats {
            margin-top: 10px;
            font-style: italic;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>Movie Search</h1>

    <p><a href="/movie">← New Search</a></p>

    <?php if (isset($movie)): ?>
        <?php if (!isset($movie->Error)): ?>
            <div class="movie-result">
                <h2><?= htmlspecialchars($movie->Title ?? '') ?> (<?= htmlspecialchars($movie->Year ?? '') ?>)</h2>
                <p><strong>Plot:</strong> <?= htmlspecialchars($movie->Plot ?? '') ?></p>
                <p><strong>Director:</strong> <?= htmlspecialchars($movie->Director ?? '') ?></p>
                <p><strong>Actors:</strong> <?= htmlspecialchars($movie->Actors ?? '') ?></p>
                <p><strong>IMDB Rating:</strong> <?= htmlspecialchars($movie->imdbRating ?? '') ?></p>

                <!-- Popcorn Rating Section -->
                <div class="rating-container">
                    <div class="rating-title">Community Rating:</div>
                    <div class="popcorn-rating">
                        <?php
                        // Calculate average rating (replace with your actual data)
                        $avg_rating = 3.8; // Example value - get from your database
                        $full_popcorns = floor($avg_rating);
                        $has_half = ($avg_rating - $full_popcorns) >= 0.5;
                        $empty_popcorns = 5 - ceil($avg_rating);

                        // Full popcorns
                        for ($i = 0; $i < $full_popcorns; $i++) {
                            echo '<span class="popcorn-full">🍿</span>';
                        }

                        // Half popcorn
                        if ($has_half) {
                            echo '<span class="popcorn-half">🍿</span>';
                        }

                        // Empty popcorns
                        for ($i = 0; $i < $empty_popcorns; $i++) {
                            echo '<span class="popcorn-empty">🍿</span>';
                        }
                        ?>
                    </div>
                    <div class="rating-stats">
                        <?= number_format($avg_rating, 1) ?> out of 5 (from 42 ratings)
                        <!-- Replace 42 with actual count from your database -->
                    </div>
                </div>

                <!-- Rating Form -->
                <div class="rate-movie">
                    <div class="rate-title">Rate this movie:</div>
                    <div>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <button class="popcorn-btn" onclick="rateMovie(<?= $i ?>)">🍿</button>
                        <?php endfor; ?>
                    </div>
                    <small>Click a popcorn to rate</small>
                </div>
            </div>

            <script>
                function rateMovie(rating) {
                    if (confirm('Are you sure you want to rate this movie ' + rating + ' popcorns?')) {
                        // Send rating to server
                        window.location.href = '/movie/review/<?= $movie->imdbID ?>/' + rating;
                    }
                }
            </script>

        <?php else: ?>
            <p>Error: <?= htmlspecialchars($movie->Error) ?></p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>