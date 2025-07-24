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
            </div>
        <?php else: ?>
            <p>Error: <?= htmlspecialchars($movie->Error) ?></p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
