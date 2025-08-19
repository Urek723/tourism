<section class="page-section bg-light py-5">
    <style>
        .reels-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .reel-card {
            overflow: hidden;
            cursor: pointer;
        }

        .reel-wrapper {
            position: relative;
            padding-top: 177.78%;

            overflow: hidden;
        }

        .reel-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .reel-play-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #fullSizeVideo {
            max-height: 80vh;
        }

        #tourCarousel .carousel-item {
            transition: transform 0.2s ease-in-out, opacity 0.2s ease-in-out;

            background-color: black;

        }
        .nav-tabs .nav-link {
    background: #f5f5f5;
    color: #222 !important;
    border: none;
    border-bottom: 2px solid transparent;
    transition: background 0.2s, color 0.2s;
    font-weight: 500;
}

.nav-tabs .nav-link:hover,
.nav-tabs .nav-link:focus {
    background: #e9ecef;
    color: #ffc107 !important;
    border-bottom: 2px solid #ffc107;
}

.nav-tabs .nav-link.active {
    background: #ffc107;
    color: #fff !important;
    border-bottom: 2px solid #ffc107    ;
    font-weight: 600;
    z-index: 2;
}
    </style>
    <div class="container">
        <?php
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        include 'initialize.php';

        if (isset($_GET['id'])) {
            $packages = $conn->query("SELECT * FROM packages WHERE md5(id) = '{$_GET['id']}'");
            if ($packages->num_rows > 0) {
                foreach ($packages->fetch_assoc() as $k => $v) {
                    $$k = $v;
                }
            }
            $comments = $conn->query("SELECT c.*, CONCAT(u.firstname, ' ', u.lastname) as name 
            FROM comments c 
            INNER JOIN users u ON c.user_id = u.id
            WHERE c.package_id = '{$id}'
            ORDER BY c.date_created DESC");
            $review = $conn->query("SELECT r.*, CONCAT(firstname, ' ', lastname) AS name FROM rate_review r 
                            INNER JOIN users u ON r.user_id = u.id 
                            WHERE r.package_id = '{$id}' 
                            ORDER BY unix_timestamp(r.date_created) DESC");

            $review_count = $review->num_rows;
            $rate = 0;
            $feed = array();
            while ($row = $review->fetch_assoc()) {
                $rate += $row['rate'];
                if (!empty($row['review'])) {
                    $row['review'] = stripslashes(html_entity_decode($row['review']));
                    $feed[] = $row;
                }
            }

            if ($rate > 0 && $review_count > 0) {
                $rate = number_format($rate / $review_count, 0, "");
            }

            $files = array();
            if (is_dir(base_app . 'uploads/package_' . $id)) {
                $ofile = scandir(base_app . 'uploads/package_' . $id);
                foreach ($ofile as $img) {
                    if (in_array($img, array('.', '..'))) continue;
                    $files[] = validate_image('uploads/package_' . $id . '/' . $img);
                }
            }

            $video_paths = array();
            $video_dir = base_app . 'uploads/video_' . $id;
            $video_extensions = ['mp4', 'avi', 'mov', 'wmv'];

            if (is_dir($video_dir)) {
                $video_files = scandir($video_dir);
                foreach ($video_files as $video) {
                    if (in_array(pathinfo($video, PATHINFO_EXTENSION), $video_extensions)) {
                        $video_paths[] = 'uploads/video_' . $id . '/' . $video;
                    }
                }
            }
        }
        ?>



        <!-- Breadcrumb Navigation -->
        <div class="d-flex mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 m-0">
                    <li class="breadcrumb-item"><a href="index.php" class="text-warning">Home</a></li>
                    <li class="breadcrumb-item"><a href="?page=packages" class="text-warning">Attractions</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $title ?></li>
                </ol>
            </nav>
            <div class="ms-auto">
                <button class="btn btn-sm btn-outline-warning"><i class="fa fa-heart"></i> Save</button>
                <button class="btn btn-sm btn-outline-warning"><i class="fa fa-share-alt"></i> Share</button>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="card shadow-sm rounded-3 overflow-hidden border-0 mb-4">
            <div class="row g-0">

                <div class="col-12" style="height: 40%;">
                    <div id="tourCarousel" class="carousel slide  h-100" data-ride="carousel" data-interval="3000">
                        <div class="carousel-inner">
                            <?php foreach ($files as $k => $img) : ?>
                                <div class="carousel-item h-100 <?php echo $k == 0 ? 'active' : '' ?>">
                                    <img class="d-block w-100 h-100" src="<?php echo $img ?>" alt="" style="object-fit: cover; max-height: 600px;">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <a class="carousel-control-prev" href="#tourCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#tourCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>


                <div class="col-12 mt-6">
                    <div class="card-body p-4" style="background: rgba(0, 0, 0, 0.3);">
                        <div class="d-flex justify-content-between align-items-start mb-2">

                            <h2 class="card-title text-white mb-0"><?php echo $title ?></h2>
                            <div class="bg-warning text-dark rounded px-2 py-1">
                                <small><?php echo $rate ?>/5</small>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <div class="stars me-2">
                                <?php for ($i = 5; $i >= 1; $i--) : ?>
                                    <input disabled class="star star-<?php echo $i ?>" id="star-<?php echo $i ?>" type="radio" name="star" <?php echo $rate == $i ? "checked" : '' ?> />
                                    <label class="star star-<?php echo $i ?>" for="star-<?php echo $i ?>"></label>
                                <?php endfor; ?>
                            </div>

                            <span class="text-white small">(<?php echo $review_count ?> reviews)</span>
                        </div>

                        <div class="mb-3">
                            <p class="d-flex align-items-center mb-2">
                                <i class="fa fa-map-marker-alt text-warning me-2"></i>

                                <span class="text-white"><?php echo $tour_location ?></span>
                            </p>
                            <p class="d-flex align-items-center mb-2">
                                <i class="fa fa-clock text-warning me-2"></i>
                                <span class="text-white">Opening hours: <?php echo isset($opening_hours) ? htmlspecialchars($opening_hours) : 'Not specified'; ?></span>
                            </p>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <!-- Tabs Section -->
        <div class="card shadow-sm rounded-3 border-0 mb-4">
            <div class="card-header bg-white p-0 border-0">
                <ul class="nav nav-tabs" id="packageTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active px-4 py-3" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">About</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-4 py-3" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews (<?php echo count($feed) ?>)</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-4 py-3" id="comments-tab" data-bs-toggle="tab" data-bs-target="#comments" type="button" role="tab" aria-controls="comments" aria-selected="false">Comments</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-4 py-3" id="map-tab" data-bs-toggle="tab" data-bs-target="#map" type="button" role="tab" aria-controls="map" aria-selected="false">Map</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-4 py-3" id="highlights-tab" data-bs-toggle="tab" data-bs-target="#highlights" type="button" role="tab" aria-controls="highlights" aria-selected="false">Highlights</button>
                    </li>
                    <li class="nav-item" role="presentation">
        <button class="nav-link px-4 py-3" id="events-tab" data-bs-toggle="tab" data-bs-target="#events" type="button" role="tab" aria-controls="events" aria-selected="false">
            Events & Festivals
        </button>
    </li>
                </ul>
            </div>
            <div class="card-body p-4">
                <div class="tab-content" id="packageTabContent">
                    <!-- Description Tab -->
                    <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                        <div class="description">
                            <?php echo stripslashes(html_entity_decode($description)) ?>
                        </div>
                    </div>
                    <!-- Highlight Content -->
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                        </div>
                        <div class="tab-pane fade" id="highlights" role="tabpanel" aria-labelledby="highlights-tab">
                            <div class="highlights">
                                <div style="text-align: center;">
                                    <p>Here are the highlights of <strong><?php echo $title; ?></strong></p>
                                    <p>Take a quick tour through the most stunning features of <strong><?php echo $title; ?></strong>. From its scenic views to its unique attractions, this video captures the essence of what makes this place a must-visit destination.</p>
                                </div>
                                <?php if (!empty($video_paths)) : ?>
                                    <div class="row reels-container">
                                        <?php foreach ($video_paths as $index => $video_path) : ?>
                                            <div class="col-6 col-md-4 col-lg-3 mb-4">
                                                <div class="card h-100 shadow-sm rounded-lg reel-card">
                                                    <div class="position-relative reel-wrapper">
                                                        <!-- Video element with poster -->
                                                        <video class="reel-video" poster="<?php echo base_url . str_replace('.mp4', '-thumbnail.jpg', $video_path); ?>" data-fullvideo="<?php echo base_url . $video_path; ?>" controls>
                                                            <source src="<?php echo base_url . $video_path; ?>" type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                        <div class="reel-play-button">
                                                            <i class="fas fa-play"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <!-- Full-size video modal -->
                                    <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Video</h5>
                                                    <button type="button" class="btn-close close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body p-0">
                                                    <video id="fullSizeVideo" class="w-100" controls>
                                                        <source src="" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <p>No video highlights available.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!-- Events & Festivals Tab -->
    <div class="tab-pane fade" id="events" role="tabpanel" aria-labelledby="events-tab">
        <div class="events-calendar">
            <h5 class="mb-3">Upcoming Events & Festivals</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Event</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example static events, replace with dynamic PHP if needed -->
                    <tr>
                        <td>2025-09-10</td>
                        <td>Harvest Festival</td>
                        <td>Celebrate the local harvest with food, music, and cultural performances.</td>
                    </tr>
                    <tr>
                        <td>2025-10-05</td>
                        <td>River Parade</td>
                        <td>A colorful parade along the river with floats and fireworks.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>                




                    <!-- Reviews Tab -->
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <?php if (isset($_SESSION['userdata'])) : ?>
                            <div class="card mb-4 border-0 shadow-sm">
                                <div class="card-body p-3">
                                    <div class="d-flex">
                                        <img src="<?php echo validate_image('assets/img/user.jpg') ?>" class="rounded-circle me-3" width="40" height="40" alt="">
                                        <form action="classes/Master.php?f=rate_review" id="rate-review" method="POST" class="flex-grow-1">
                                            <input name="package_id" type="hidden" value="<?php echo $id ?>" />
                                            <div class="input-group mb-2">
                                                <textarea name="review" class="form-control border-0 bg-light rounded-pill py-2 px-3" placeholder="Write a review..." onclick="$('#reviewControls').collapse('show')" style="resize: none; height: 40px;"></textarea>
                                            </div>
                                            <div class="collapse" id="reviewControls">
                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                    <div class="stars stars-small">
                                                        <?php for ($i = 5; $i >= 1; $i--) : ?>
                                                            <input value="<?php echo $i ?>" class="star star-<?php echo $i ?>" id="rate-<?php echo $i ?>" type="radio" name="rate" <?php echo $i == 5 ? 'checked' : '' ?> />
                                                            <label class="star star-<?php echo $i ?>" for="rate-<?php echo $i ?>"></label>
                                                        <?php endfor; ?>
                                                    </div>
                                                    <button type="submit" class="btn btn-warning rounded-pill px-4">Post</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="card mb-4 border-0 shadow-sm">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo validate_image('assets/img/user.jpg') ?>" class="rounded-circle me-3" width="40" height="40" alt="">
                                        <div class="bg-light rounded-pill py-2 px-3 flex-grow-1">
                                            <a href="login.php" class="text-decoration-none">Log in to write a review...</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Reviews List -->
                        <?php if (count($feed) > 0) : ?>
                            <?php foreach ($feed as $r) : ?>
                                <div class="card mb-3 border-0 shadow-sm">
                                    <div class="card-body p-3">
                                        <div class="d-flex">
                                            <img src="<?php echo validate_image('assets/img/user.jpg') ?>" class="rounded-circle me-3 align-self-start" width="40" height="40" alt="">
                                            <div class="flex-grow-1">
                                                <div class="bg-light rounded p-3">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <h6 class="mb-0"><?php echo $r['name'] ?></h6>
                                                        <div class="stars stars-small">
                                                            <?php for ($i = 5; $i >= 1; $i--) : ?>
                                                                <input disabled class="star star-<?php echo $i ?>" id="star-user-<?php echo $r['id'] ?>-<?php echo $i ?>" type="radio" name="star-user-<?php echo $r['id'] ?>" <?php echo $r['rate'] == $i ? "checked" : '' ?> />
                                                                <label class="star star-<?php echo $i ?>" for="star-user-<?php echo $r['id'] ?>-<?php echo $i ?>"></label>
                                                            <?php endfor; ?>
                                                        </div>
                                                    </div>
                                                    <div class="review-content">
                                                        <?php echo $r['review'] ?>
                                                    </div>
                                                </div>
                                                <div class="text-muted small mt-1 ms-2">
                                                    <?php echo date("M d, Y", strtotime($r['date_created'])) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="text-center py-5">
                                <img src="assets/img/review-empty.svg" alt="No Reviews" style="max-width: 200px; margin-bottom: 20px;">
                                <h5>No reviews yet</h5>
                                <p class="text-muted">Be the first to review this attraction!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- Comments Tab -->
                    <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments-tab">
                        <?php if (isset($_SESSION['userdata'])) : ?>
                            <div class="card mb-4 border-0 shadow-sm">
                                <div class="card-body p-3">
                                    <div class="d-flex">
                                        <img src="<?php echo validate_image('assets/img/user.jpg') ?>" class="rounded-circle me-3" width="40" height="40" alt="">
                                        <form action="classes/Master.php?f=save_comment" id="comment-form" method="POST" class="flex-grow-1">
                                            <input name="package_id" type="hidden" value="<?php echo $id ?>" />
                                            <div class="input-group mb-2">
                                                <textarea name="comment" class="form-control border-0 bg-light rounded-pill py-2 px-3" placeholder="Write a comment..." onclick="$('#commentControls').collapse('show')" style="resize: none; height: 40px;"></textarea>
                                            </div>
                                            <div class="collapse" id="commentControls">
                                                <div class="d-flex justify-content-end align-items-center mt-2">
                                                    <button type="submit" class="btn btn-warning rounded-pill px-4">Post Comment</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="card mb-4 border-0 shadow-sm">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo validate_image('assets/img/user.jpg') ?>" class="rounded-circle me-3" width="40" height="40" alt="">
                                        <div class="bg-light rounded-pill py-2 px-3 flex-grow-1">
                                            <a href="login.php" class="text-decoration-none">Log in to leave a comment...</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Comments List -->
                        <?php
                        $comment_count = $comments->num_rows;
                        if ($comment_count > 0) :
                            $comment_list = array();
                            while ($row = $comments->fetch_assoc()) {
                                $row['comment'] = stripslashes(html_entity_decode($row['comment']));
                                $comment_list[] = $row;
                            }
                            foreach ($comment_list as $c) :
                        ?>
                                <div class="card mb-3 border-0 shadow-sm">
                                    <div class="card-body p-3">
                                        <div class="d-flex">
                                            <img src="<?php echo validate_image('assets/img/user.jpg') ?>" class="rounded-circle me-3 align-self-start" width="40" height="40" alt="">
                                            <div class="flex-grow-1">
                                                <div class="bg-light rounded p-3">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <h6 class="mb-0"><?php echo $c['name'] ?></h6>
                                                    </div>
                                                    <div class="comment-content">
                                                        <?php echo $c['comment'] ?>
                                                    </div>
                                                </div>
                                                <div class="text-muted small mt-1 ms-2">
                                                    <?php echo date("M d, Y h:i A", strtotime($c['date_created'])) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="text-center py-5">
                                <img src="assets/img/comment-empty.svg" alt="No Comments" style="max-width: 200px; margin-bottom: 20px;">
                                <h5>No comments yet</h5>
                                <p class="text-muted">Be the first to comment on this attraction!</p>
                            </div>
                        <?php endif; ?>
                    </div>


                    <!-- Map Tab -->
                    <div class="tab-pane fade" id="map" role="tabpanel" aria-labelledby="map-tab">
                        <div class="map-container" style="height: 400px; overflow: hidden; position: relative;">
                            <iframe width="100%" height="400" style="border:0; display: block;" loading="lazy" allowfullscreen src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAOVYRIgupAurZup5y1PRh8Ismb1A3lLao&q=<?php echo urlencode($tour_location) ?>"></iframe>
                            <div class="position-absolute bottom-0 end-0 p-3">
                                <button class="btn btn-light shadow-sm" id="resetMap">
                                    <i class="fa fa-location-arrow"></i> Reset Map
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nearby Attractions Section -->
    <div class="mb-4" style="padding-left: 4.5rem; padding-right: 4.5rem;">
        <div class="card shadow-sm border-0 rounded-3 px-5">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Explore Nearby</h4>
                    <a href="?page=packages" class="text-decoration-none text-warning">View all</a>
                </div>

                <div class="row">
                    <?php
                    $nearby = $conn->query("SELECT * FROM packages WHERE status = 1 AND id != '{$id}' ORDER BY RAND() LIMIT 4");
                    while ($row = $nearby->fetch_assoc()) :
                        $cover = '';
                        if (is_dir(base_app . 'uploads/package_' . $row['id'])) {
                            $img = scandir(base_app . 'uploads/package_' . $row['id']);
                            $k = array_search('.', $img);
                            if ($k !== false) unset($img[$k]);
                            $k = array_search('..', $img);
                            if ($k !== false) unset($img[$k]);
                            $cover = isset($img[2]) ? 'uploads/package_' . $row['id'] . '/' . $img[2] : "";
                        }
                    ?>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="card h-100 shadow-sm border-0 rounded-3">
                                <img src="<?php echo validate_image($cover) ?>" class="card-img-top" alt="<?php echo $row['title'] ?>" style="height: 160px; object-fit: cover;">
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title"><?php echo $row['title'] ?></h6>
                                    <p class="card-text small text-muted flex-grow-1">
                                        <?php echo substr(strip_tags(html_entity_decode($row['description'])), 0, 60) . '...'; ?>
                                    </p>
                                    <a href="./?page=view_package&id=<?php echo md5($row['id']) ?>" class="stretched-link"></a>
                                </div>
                            </div>
                        </div>

                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<!-- JavaScript for AJAX Review Submission -->
<script>
    $(document).ready(function() {
        $('#comment-form').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var submitBtn = form.find('button[type="submit"]');
            var originalBtnText = submitBtn.html();
            submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Posting...');
            submitBtn.prop('disabled', true);
            $.ajax({
                url: 'classes/Master.php?f=save_comment',
                method: 'POST',
                data: form.serialize(),
                dataType: 'json',
                success: function(resp) {
                    submitBtn.html(originalBtnText);
                    submitBtn.prop('disabled', false);
                    if (resp.status === 'success') {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Comment posted successfully',
                            showConfirmButton: false,
                            timer: 500,
                            timerProgressBar: true
                        });
                        window.location.hash = '#comments';
                        location.reload();


                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Error: ' + (resp.error || 'Unknown error'),
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    submitBtn.html(originalBtnText);
                    submitBtn.prop('disabled', false);
                    console.error("AJAX Error:", xhr.responseText);
                    try {
                        var response = JSON.parse(xhr.responseText);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Error: ' + (response.error || error),
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        });
                    } catch (e) {
                        Swal.fire({
                            title: 'Server Error!',
                            text: 'Server error: ' + error,
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        });
                    }
                }
            });

        });
    });
    $(document).ready(function() {
        var tabEl = document.querySelectorAll('button[data-bs-toggle="tab"]');
        tabEl.forEach(function(tab) {
            tab.addEventListener('click', function(event) {
                event.preventDefault();
                var targetTab = document.querySelector(this.getAttribute('data-bs-target'));
                var activeTab = document.querySelector('.tab-pane.active');
                document.querySelectorAll('.tab-pane').forEach(function(tabPane) {
                    tabPane.classList.remove('show', 'active');
                });
                document.querySelectorAll('button[data-bs-toggle="tab"]').forEach(function(button) {
                    button.classList.remove('active');
                });
                this.classList.add('active');
                targetTab.classList.add('show', 'active');
            });
        });

        $('#rate-review').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var submitBtn = form.find('button[type="submit"]');
            var originalBtnText = submitBtn.html();
            submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Posting...');
            submitBtn.prop('disabled', true);
            $.ajax({
                url: 'classes/Master.php?f=rate_review',
                method: 'POST',
                data: form.serialize(),
                dataType: 'json',
                success: function(resp) {
                    submitBtn.html(originalBtnText);
                    submitBtn.prop('disabled', false);
                    if (resp.status === 'success') {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Review posted successfully',
                            showConfirmButton: false,
                            timer: 500,
                            timerProgressBar: true,
                            didClose: () => {
                                window.location.hash = '#reviews';
                                location.reload();
                            }
                        });
                    }

                },
                error: function(xhr, status, error) {
                    submitBtn.html(originalBtnText);
                    submitBtn.prop('disabled', false);
                    console.error("AJAX Error:", status, error);
                    Swal.fire({
                        title: 'Oops!',
                        text: 'An error occurred. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        $('#resetMap').click(function() {
            var iframe = $('#map iframe')[0];
            if (iframe) {
                iframe.src = iframe.src;
            }
            window.location.hash = '#map';
            location.reload();
        });

        var hash = window.location.hash;
        if (hash) {
            var activeTab = $('button[data-bs-target="' + hash + '"]');
            if (activeTab.length) {
                activeTab.trigger('click');
            }
        }

        function createReviewHTML(review) {
            var ratingStars = '';
            for (var i = 5; i >= 1; i--) {
                ratingStars += '<input disabled class="star star-' + i + '" id="star-user-' + review.id + '-' + i + '" ' +
                    'type="radio" name="star-user-' + review.id + '" ' +
                    (review.rate == i ? 'checked' : '') + ' />' +
                    '<label class="star star-' + i + '" for="star-user-' + review.id + '-' + i + '"></label>';
            }
            return '<div class="card mb-3 border-0 shadow-sm">' +
                '    <div class="card-body p-3">' +
                '        <div class="d-flex">' +
                '            <img src="assets/img/user.jpg" class="rounded-circle me-3 align-self-start" width="40" height="40" alt="">' +
                '            <div class="flex-grow-1">' +
                '                <div class="bg-light rounded p-3">' +
                '                    <div class="d-flex justify-content-between align-items-center mb-2">' +
                '                        <h6 class="mb-0">' + review.name + '</h6>' +
                '                        <div class="stars stars-small">' +
                ratingStars +
                '                        </div>' +
                '                    </div>' +
                '                    <div class="review-content">' +
                review.review +
                '                    </div>' +
                '                </div>' +
                '                <div class="text-muted small mt-1 ms-2">' +
                formatDate(new Date()) +
                '                </div>' +
                '            </div>' +
                '        </div>' +
                '    </div>' +
                '</div>';
        }

        function formatDate(date) {
            const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            return months[date.getMonth()] + " " + date.getDate() + ", " + date.getFullYear();
        }

        $('.reel-video').each(function() {
            var video = this;
            video.currentTime = 0.1;
            video.addEventListener('loadedmetadata', function() {
                video.pause();
            }, {
                once: true
            });
        });

        $('.reel-wrapper').on('mouseenter', function() {
            var video = $(this).find('video')[0];
            if (video) {
                video.currentTime = 1;
                video.play();
            }
        }).on('mouseleave', function() {
            var video = $(this).find('video')[0];
            if (video) {
                video.pause();
                video.currentTime = 1;
            }
        });

        $('.reel-card').on('click', function() {
            const video = $(this).find('.reel-video')[0];
            const videoSrc = $(video).attr('data-fullvideo');
            const currentTime = video.currentTime;
            const fullSizeVideo = $('#fullSizeVideo')[0];
            $(fullSizeVideo).find('source').attr('src', videoSrc);
            fullSizeVideo.load();
            var videoModal = new bootstrap.Modal(document.getElementById('videoModal'));
            $('#videoModal').off('shown.bs.modal').on('shown.bs.modal', function() {
                fullSizeVideo.currentTime = currentTime;
                fullSizeVideo.play();
            });
            videoModal.show();
        });

        $('#videoModal').on('hidden.bs.modal', function() {
            $('#fullSizeVideo')[0].pause();
        });
    });
</script>