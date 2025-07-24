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

    <form method="get" action="/movie/search">
        <input type="text" name="movie" value="<?= htmlspecialchars($searchTerm ?? '') ?>" placeholder="Enter movie title">
        <button type="submit">Search</button>
    </form>
</body>
</html>