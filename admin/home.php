
<?php
// Ensure database connection is available
if (!isset($conn)) {
    require_once('../config.php');
}
?>
<style>
    /* Modernized styles for the dashboard */
    body {
        font-family: 'Inter', sans-serif;
        background: #1a1a2e;
        color: #e0e0e0;
    }
    .container {
        padding: 20px;
    }
    .analytics-card {
        background: #2a2a4e;
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }
    .analytics-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
    }
    .analytics-card .card-body {
        padding: 20px;
    }
    .analytics-card .card-title {
        color: #00d4ff;
        font-weight: 600;
        font-size: 1.25rem;
        margin-bottom: 15px;
    }
    .analytics-card .card-text {
        color: #ffffff;
        font-weight: 700;
        font-size: 2.5rem;
        margin: 0;
    }
    .analytics-card i {
        color: #28a745;
        font-size: 2rem;
        margin-bottom: 10px;
    }
    /* Popular destinations list */
    .list-group-item {
        background: transparent;
        border: none;
        padding: 12px 15px;
        color: #e0e0e0;
        font-size: 1rem;
        display: flex;
        align-items: center;
        transition: background 0.2s ease;
    }
    .list-group-item:hover {
        background: #3a3a6e;
        border-radius: 8px;
    }
    .list-group-item i {
        color: #ff6f61;
        margin-right: 10px;
    }
    .list-group-item .rating {
        color: #ff6f61;
        font-size: 0.85rem;
        margin-left: auto;
    }
    /* Chart container */
    #analyticsChart {
        max-height: 200px;
        width: 100%;
    }
    /* Header styling */
    h1.text-center {
        color: #00d4ff;
        font-weight: 700;
        font-size: 2rem;
        margin-bottom: 20px;
    }
    hr {
        border: 2px solid #ff6f61;
        width: 100px;
        margin: 0 auto 30px;
        opacity: 0.7;
    }
    /* Animation for cards */
    .analytics-card {
        animation: fadeIn 0.5s ease-in;
    }
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .analytics-card .card-text {
            font-size: 2rem;
        }
        .analytics-card .card-title {
            font-size: 1.1rem;
        }
        h1.text-center {
            font-size: 1.5rem;
        }
    }
</style>

<h1 class="text-center mb-4">Welcome to <?php echo $_settings->info('name') ?></h1>
<hr>
<div class="container">
    <div class="row">
        <!-- Destination Inquiries -->
        <div class="col-md-4 mb-4">
            <div class="card analytics-card">
                <div class="card-body text-center">
                    <i class="fas fa-envelope"></i>
                    <h5 class="card-title">Destination Inquiries</h5>
                    <?php
                    $total_inquiries = $conn->query("SELECT COUNT(id) as total FROM `inquiry`")->fetch_assoc()['total'];
                    ?>
                    <p class="card-text"><?php echo $total_inquiries; ?></p>
                </div>
            </div>
        </div>

        <!-- Registered Visitors -->
        <div class="col-md-4 mb-4">
            <div class="card analytics-card">
                <div class="card-body text-center">
                    <i class="fas fa-users"></i>
                    <h5 class="card-title">Registered Visitors</h5>
                    <?php
                    $total_users = $conn->query("SELECT COUNT(id) as total FROM `users`")->fetch_assoc()['total'];
                    ?>
                    <p class="card-text"><?php echo $total_users; ?></p>
                </div>
            </div>
        </div>

        <!-- Pie Chart for Inquiries and Visitors -->
        <div class="col-md-4 mb-4">
            <div class="card analytics-card">
                <div class="card-body">
                    <h5 class="card-title text-center">Visitor Engagement</h5>
                    <?php if ($total_inquiries == 0 && $total_users == 0) : ?>
                        <p class="text-center text-muted">No data available for the chart.</p>
                    <?php else : ?>
                        <canvas id="analyticsChart"></canvas>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Popular Destinations with Average Rating -->
        <div class="col-md-12 mb-4">
            <div class="card analytics-card">
                <div class="card-body">
                    <h5 class="card-title"><i class=" me-2"></i>Popular Destinations</h5>
                    <?php
                    $popular_destinations = $conn->query("SELECT p.id, p.title, AVG(r.rate) as avg_rating, COUNT(r.id) as review_count
                                                          FROM `packages` p 
                                                          LEFT JOIN `rate_review` r ON p.id = r.package_id
                                                          GROUP BY p.id, p.title 
                                                          HAVING COUNT(r.id) > 0
                                                          ORDER BY AVG(r.rate) DESC, COUNT(r.id) DESC 
                                                          LIMIT 3");
                    ?>
                    <ul class="list-group list-group-flush">
                        <?php while ($row = $popular_destinations->fetch_assoc()) : ?>
                            <li class="list-group-item">
                                <i class="fas fa-star"></i>
                                <?php echo $row['title']; ?>
                                <span class="rating">
                                    <?php echo $row['avg_rating'] ? number_format($row['avg_rating'], 1) . '/5 (' . $row['review_count'] . ')' : 'N/A'; ?>
                                </span>
                            </li>
                        <?php endwhile; ?>
                        <?php if ($popular_destinations->num_rows == 0) : ?>
                            <li class="list-group-item text-muted">No rated destinations available.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Chart.js Pie Chart
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('analyticsChart')?.getContext('2d');
        if (ctx) {
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Inquiries', 'Registered Visitors'],
                    datasets: [{
                        data: [<?php echo $total_inquiries; ?>, <?php echo $total_users; ?>],
                        backgroundColor: ['#ff6f61', '#28a745'],
                        borderColor: '#2a2a4e',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#e0e0e0',
                                font: {
                                    size: 12,
                                    family: 'Inter, sans-serif'
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: '#2a2a4e',
                            titleColor: '#e0e0e0',
                            bodyColor: '#e0e0e0',
                            borderColor: '#00d4ff',
                            borderWidth: 1
                        }
                    }
                }
            });
        }
    });
</script>
