<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .search-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.18);
            margin-top: 5rem;
        }

        .search-btn {
            background: #ff6b6b;
            border: none;
            transition: all 0.3s ease;
            padding: 10px 25px;
        }

        .search-btn:hover {
            background: #ff5252;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.4);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            box-shadow: 0 0 0 0.25rem rgba(255, 107, 107, 0.25);
            border-color: rgba(255, 107, 107, 0.5);
        }

        .movie-title {
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
            margin-bottom: 1.5rem;
        }

        .movie-result {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            padding: 20px;
            margin-top: 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .movie-result:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        ::placeholder {
            color: rgba(255, 255, 255, 0.6) !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="search-container animate__animated animate__fadeIn">
                    <h1 class="text-center movie-title animate__animated animate__fadeInDown">
                        <i class="fas fa-film"></i> Movie Explorer
                    </h1>

                    <form method="get" action="/movie/search" class="animate__animated animate__fadeIn animate__delay-1s">
                        <div class="input-group mb-3">
                            <input 
                                type="text" 
                                name="movie" 
                                class="form-control" 
                                value="<?= htmlspecialchars($searchTerm ?? '') ?>" 
                                placeholder="Enter movie title..."
                                aria-label="Movie title"
                                required
                            >
                            <button class="btn search-btn" type="submit">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </form>

                    <div class="text-center animate__animated animate__fadeIn animate__delay-2s">
                        <small class="text-white-50">Try: The Dark Knight, Inception, Parasite</small>
                    </div>
                </div>

                <?php if (isset($movie)): ?>
                <div class="movie-result animate__animated animate__fadeInUp">
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>