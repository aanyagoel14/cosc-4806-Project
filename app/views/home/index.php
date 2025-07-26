<?php require_once 'app/views/templates/header.php' ?>

    <div class="container mt-4">
        <!-- Welcome Section -->
        <div class="jumbotron bg-dark text-white p-5 rounded-3 shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-4">Welcome back, <?= htmlspecialchars($_SESSION['username'] ?? 'Movie Fan') ?>!</h1>
                    <p class="lead"><?= date("F jS, Y") ?></p>
                    <hr class="my-4 bg-light">
                    <p>Discover new movies and manage your ratings.</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="bi bi-camera-reels" style="font-size: 5rem; color: #f5c518;"></i>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mt-4">
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="bi bi-search text-primary" style="font-size: 2rem;"></i>
                        <h3 class="mt-3">Find Movies</h3>
                        <p>Search our movie database</p>
                        <a href="/movie" class="btn btn-outline-primary">Explore</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="bi bi-star-fill text-warning" style="font-size: 2rem;"></i>
                        <h3 class="mt-3">Your Ratings</h3>
                        <p>View and manage your ratings</p>
                        <a href="/ratings" class="btn btn-outline-warning">View</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="bi bi-film text-success" style="font-size: 2rem;"></i>
                        <h3 class="mt-3">Top Picks</h3>
                        <p>See what's trending</p>
                        <a href="/trending" class="btn btn-outline-success">Discover</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0"><i class="bi bi-clock-history"></i> Recent Activity</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                You rated "The Dark Knight" ★★★★★
                                <span class="badge bg-primary rounded-pill">2 days ago</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                You searched for "Barbie"
                                <span class="badge bg-primary rounded-pill">1 week ago</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logout Section -->
        <div class="row mt-4">
            <div class="col-lg-12 text-center">
                <a href="/logout" class="btn btn-danger">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <?php require_once 'app/views/templates/footer.php' ?>