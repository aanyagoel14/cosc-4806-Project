<!DOCTYPE html>
<html>
<head>
    <title>Movie Search</title>
    <style>
        .movie-result {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Movie Search</h1>

    <!-- Search Form -->
    <form method="get" action="/movie">
        <input type="text" name="movie" value="<?= htmlspecialchars($searchTerm ?? '') ?>" placeholder="Enter movie title">
        <button type="submit">Search</button>
    </form>

    <!-- Results Section -->
    <?php if (isset($movie)): ?>
        <div class="movie-result">
            <?php if ($movie && !isset($movie->Error)): ?>
                <h2><?= htmlspecialchars($movie->Title ?? '') ?> (<?= htmlspecialchars($movie->Year ?? '') ?>)</h2>
                <p><strong>Plot:</strong> <?= htmlspecialchars($movie->Plot ?? '') ?></p>
                <p><strong>Director:</strong> <?= htmlspecialchars($movie->Director ?? '') ?></p>
                <p><strong>Actors:</strong> <?= htmlspecialchars($movie->Actors ?? '') ?></p>
                <p><strong>IMDB Rating:</strong> <?= htmlspecialchars($movie->imdbRating ?? '') ?></p>
            <?php else: ?>
                <p>No movie found for "<?= htmlspecialchars($searchTerm) ?>".</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</body>
</html>