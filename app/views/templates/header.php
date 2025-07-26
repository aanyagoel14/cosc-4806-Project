<?php
if (!isset($_SESSION['auth'])) {
    header('Location: /login');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Explorer</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary: #0d253f;
            --secondary: #01b4e4;
            --tertiary: #90cea1;
            --dark: #032541;
            --light: #f8f9fa;
        }
        
        body {
            background-color: var(--light);
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 60px;
        }
        
        .navbar {
            background-color: var(--primary) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--tertiary) !important;
            font-size: 1.8rem;
            letter-spacing: 1px;
        }
        
        .nav-link {
            color: white !important;
            font-weight: 500;
            margin: 0 0.5rem;
            transition: all 0.3s;
        }
        
        .nav-link:hover {
            color: var(--secondary) !important;
            transform: translateY(-2px);
        }
        
        .movie-poster {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            transition: transform 0.3s;
        }
        
        .movie-poster:hover {
            transform: scale(1.03);
        }
        
        .movie-title {
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .movie-year {
            color: var(--secondary);
            font-weight: 500;
        }
        
        .movie-section {
            margin-bottom: 2rem;
        }
        
        .movie-section-title {
            color: var(--dark);
            border-bottom: 2px solid var(--tertiary);
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .rating-stars {
            color: var(--secondary);
            font-size: 1.2rem;
        }
        
        .btn-explore {
            background-color: var(--secondary);
            color: white;
            font-weight: 600;
            padding: 0.5rem 2rem;
            border: none;
            transition: all 0.3s;
        }
        
        .btn-explore:hover {
            background-color: var(--tertiary);
            transform: translateY(-2px);
        }
        
        .user-greeting {
            background: linear-gradient(to right, var(--primary), var(--dark));
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="bi bi-camera-reels"></i> Movie Explorer
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/"><i class="bi bi-house"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/movie"><i class="bi bi-search"></i> Movie Search</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ratings"><i class="bi bi-star"></i> My Ratings</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <span class="text-white me-3"><i class="bi bi-person-circle"></i> <?= htmlspecialchars($_SESSION['username']) ?></span>
                    <a href="/logout" class="btn btn-sm btn-outline-light"><i class="bi bi-box-arrow-right"></i> Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mt-4">
        <?php if (isset($movie)): // Movie details page ?>
            <div class="row">
                <div class="col-md-4">
                    <img src="<?= $movie->Poster ?>" class="movie-poster img-fluid mb-4" alt="<?= $movie->Title ?>">
                </div>
                <div class="col-md-8">
                    <h1 class="movie-title"><?= $movie->Title ?> <span class="movie-year">(<?= $movie->Year ?>)</span></h1>
                    
                    <div class="rating-stars mb-3">
                        <i class="bi bi-star-fill"></i> <?= $movie->imdbRating ?>/10 (IMDb)
                    </div>
                    
                    <div class="movie-section">
                        <h3 class="movie-section-title">Plot</h3>
                        <p><?= $movie->Plot ?></p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="movie-section">
                                <h3 class="movie-section-title">Director</h3>
                                <p><?= $movie->Director ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="movie-section">
                                <h3 class="movie-section-title">Actors</h3>
                                <p><?= $movie->Actors ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <button class="btn btn-explore mt-3">
                        <i class="bi bi-pencil"></i> Rate This Movie
                    </button>
                </div>
            </div>
        
        <?php else: // Default home page content ?>
        <?php endif; ?>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>