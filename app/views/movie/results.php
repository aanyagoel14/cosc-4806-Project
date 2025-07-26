<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($movie->Title ?? 'Movie Search') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary: #6c5ce7;
            --secondary: #a29bfe;
            --accent: #fd79a8;
            --dark: #2d3436;
            --light: #f5f6fa;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            color: var(--dark);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .movie-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .movie-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 6px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: all 0.3s ease;
            margin-bottom: 2rem;
        }

        .movie-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }

        .movie-poster {
            height: 100%;
            background-size: cover;
            background-position: center;
            min-height: 400px;
        }

        .movie-details {
            padding: 2rem;
        }

        .movie-title {
            font-weight: 800;
            margin-bottom: 0.5rem;
            color: var(--primary);
        }

        .movie-year {
            color: #636e72;
            font-weight: 400;
        }

        .movie-section {
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-weight: 600;
            color: var(--primary);
            border-bottom: 2px solid var(--secondary);
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
            display: inline-block;
        }

        .rating-container {
            background: rgba(108, 92, 231, 0.1);
            border-radius: 10px;
            padding: 1.5rem;
            margin: 1.5rem 0;
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

        .rating-buttons {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 10px 0;
        }

        .rating-btn {
            background: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            padding: 0;
            line-height: 1;
        }

        .rating-btn:hover {
            filter: drop-shadow(0 0 5px gold);
        }

        .user-rated {
            filter: drop-shadow(0 0 5px gold);
            transform: scale(1.1);
        }

        .ai-review-section {
            background: rgba(253, 121, 168, 0.1);
            border-radius: 10px;
            padding: 1.5rem;
            margin: 1.5rem 0;
        }

        .btn-ai {
            background: var(--accent);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-ai:hover {
            background: #3367d6;
        }

        .review-content {
            margin-top: 10px;
            line-height: 1.6;
        }

        .back-btn {
            color: white;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }

        .back-btn:hover {
            color: #fffa65;
            transform: translateX(-3px);
        }

        .alert-success {
            background: rgba(46, 213, 115, 0.2);
            border-color: rgba(46, 213, 115, 0.3);
        }

        @media (max-width: 768px) {
            .movie-poster {
                min-height: 300px;
            }

            .rating-btn {
                font-size: 1.5rem !important;
            }
        }
    </style>
</head>
<body>
    <div class="movie-header animate__animated animate__fadeIn">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="/movie" class="back-btn animate__animated animate__fadeInLeft">
                    <i class="fas fa-arrow-left"></i> New Search
                </a>
                <h1 class="animate__animated animate__fadeIn">Movie Explorer</h1>
                <div></div> 
            </div>
        </div>
    </div>

    <div class="container animate__animated animate__fadeIn animate__delay-1s">
        <?php if (isset($movie)): ?>
            <?php if (!isset($movie->Error)): ?>
                <?php
                $review = $this->model('Review');
                $avg_rating = $review->getAverageRating($movie->imdbID);
                $rating_count = $review->getRatingCount($movie->imdbID);
                $user_rating = isset($_SESSION['user_id']) ? 
                    $review->getUserRating($movie->imdbID, $_SESSION['user_id']) : null;
                ?>

                <?php if (isset($_SESSION['rating_result'])): ?>
                    <div class="alert alert-success animate__animated animate__fadeInDown">
                        <?= ($_SESSION['rating_result'] === 'success') ? 'Thank you for your rating!' : 'Failed to save rating' ?>
                    </div>
                    <?php unset($_SESSION['rating_result']); ?>
                <?php endif; ?>

                <div class="movie-card">
                    <div class="row">
                        <?php if (isset($movie->Poster) && $movie->Poster !== 'N/A'): ?>
                        <div class="col-md-4 p-0">
                            <div class="movie-poster" style="background-image: url('<?= htmlspecialchars($movie->Poster) ?>')"></div>
                        </div>
                        <?php endif; ?>
                        <div class="<?= (isset($movie->Poster) && $movie->Poster !== 'N/A' ? 'col-md-8' : 'col-12') ?>">
                            <div class="movie-details">
                                <h2 class="movie-title"><?= htmlspecialchars($movie->Title) ?></h2>
                                <p class="movie-year"><?= htmlspecialchars($movie->Year) ?></p>

                                <div class="movie-section">
                                    <h4 class="section-title">Plot</h4>
                                    <p><?= htmlspecialchars($movie->Plot) ?></p>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="movie-section">
                                            <h4 class="section-title">Director</h4>
                                            <p><?= htmlspecialchars($movie->Director) ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="movie-section">
                                            <h4 class="section-title">Actors</h4>
                                            <p><?= htmlspecialchars($movie->Actors) ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="movie-section">
                                    <h4 class="section-title">IMDB Rating</h4>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-star text-warning me-2"></i>
                                        <span><?= htmlspecialchars($movie->imdbRating) ?>/10</span>
                                    </div>
                                </div>

                                <div class="rating-container">
                                    <h4 class="section-title">Community Rating</h4>
                                    <div class="popcorn-rating">
                                        <?php
                                        $full = floor($avg_rating);
                                        $has_half = (($avg_rating - $full) >= 0.5);
                                        $empty = 5 - ceil($avg_rating);

                                        for ($i = 0; $i < $full; $i++) {
                                            echo '<span class="popcorn-full">🍿</span>';
                                        }

                                        if ($has_half) {
                                            echo '<span class="popcorn-half">🍿</span>';
                                        }

                                        for ($i = 0; $i < $empty; $i++) {
                                            echo '<span class="popcorn-empty">🍿</span>';
                                        }
                                        ?>
                                    </div>
                                    <p class="mt-2">
                                        <?= number_format($avg_rating, 1) ?> out of 5 (from <?= $rating_count ?> ratings)
                                        <?php if ($user_rating): ?>
                                            <br><span class="text-muted">Your rating: <?= $user_rating ?>/5</span>
                                        <?php endif; ?>
                                    </p>

                                    <div class="mt-3">
                                        <h4 class="section-title">Rate this movie</h4>
                                        <div class="rating-buttons">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <button type="button" 
                                                   onclick="window.location.href='/movie/review/<?= $i ?>'"
                                                   class="rating-btn <?= ($user_rating == $i) ? 'user-rated' : '' ?>"
                                                   title="Rate <?= $i ?>"
                                                   style="font-size: <?= 1 + ($i * 0.2) ?>rem">
                                                   🍿
                                                </button>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="ai-review-section">
                                    <h4 class="section-title">AI-Generated Review</h4>
                                    <?php if (isset($_SESSION['ai_review'])): ?>
                                        <div class="review-content mt-3">
                                            <?= nl2br(htmlspecialchars($_SESSION['ai_review'])) ?>
                                        </div>
                                        <?php unset($_SESSION['ai_review']); ?>
                                    <?php else: ?>
                                        <form action="/movie/generateReview" method="post">
                                            <button type="submit" class="btn-ai">
                                                <i class="fas fa-robot"></i> Generate AI Review
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-danger animate__animated animate__shakeX">
                    Error: <?= htmlspecialchars($movie->Error) ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>