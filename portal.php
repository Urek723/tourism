<?php
$covers = $_settings->info('cover') ? json_decode($_settings->info('cover'), true) : [];
?>
<style>
	/* Masthead settings */
	header.masthead {
		position: relative;
		width: 100%;
		height: 90vh;

		overflow: hidden;
		display: flex;
		justify-content: center;
		align-items: center;
		margin-top: 90px;

	}


	#tourismCarousel {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;

		object-fit: cover;

	}

	/* Styling for content inside the masthead */
	header.masthead .container {
		position: relative;
		z-index: 10;

		background: rgba(0, 0, 0, 0.5);

		padding: 2rem;
		border-radius: 10px;
	}

	.masthead-heading {
		font-size: 3rem;
		font-weight: 700;
		margin-bottom: 2rem;
		color: white;
	}

	.masthead-subheading {
		font-size: 1.5rem;
		color: #f8f9fa;
	}

	/* Styling for the custom navigation (bottom) */
	.carousel-control-bottom {
		position: absolute;
		bottom: 20px;
		width: 100%;
		text-align: center;
	}

	.carousel-control-bottom a {
		color: white;
		font-size: 1.25rem;
		background-color: rgba(0, 0, 0, 0.6);
		padding: 1rem 2rem;
		border-radius: 30px;
		text-decoration: none;
	}

	.carousel-control-bottom a:hover {
		background-color: rgba(0, 0, 0, 0.8);
	}

	#home {
		padding-top: 117px;
	}
</style>

<!-- Masthead -->
<header class="masthead">

	<div id="tourismCarousel" class="carousel slide carousel-fade" data-ride="carousel" data-interval="3000" data-wrap="true">

		<ol class="carousel-indicators">
			<?php
			if (is_array($covers) && !empty($covers)) :
				foreach ($covers as $key => $cover) :
			?>
					<li data-target="#tourismCarousel" data-slide-to="<?php echo $key ?>" <?php echo ($key == 0) ? 'class="active"' : '' ?>></li>
			<?php
				endforeach;
			endif;
			?>
		</ol>
		<div class="carousel-inner">
			<?php
			if (is_array($covers) && !empty($covers)) :
				foreach ($covers as $key => $cover) :
			?>
					<div class="carousel-item <?php echo ($key == 0) ? 'active' : '' ?>">
						<img src="<?php echo validate_image($cover) ?>" class="d-block w-100" alt="Tourism Spot" style="height: 100%; object-fit: cover;">
					</div>
				<?php
				endforeach;
			else :

				$single_cover = $_settings->info('cover');
				if ($single_cover) :
				?>
					<div class="carousel-item active">
						<img src="<?php echo validate_image($single_cover) ?>" class="d-block w-100" alt="Tourism Spot" style="height: 100%; object-fit: cover;">
					</div>
			<?php
				endif;
			endif;
			?>
		</div>
	</div>

	<!-- Centered Content -->
	<div class="container text-center">
		<div class="masthead-subheading">Welcome to Our Tourism Portal</div>
		<div class="masthead-heading text-uppercase">Discover Attractions & Local Insights</div>
		<a class="btn btn-primary btn-xl text-uppercase" href="#home">View Tourist Spots</a>
	</div>


	<div class="carousel-control-bottom">
		<a href="#tourismCarousel" role="button" data-slide="next">Explore More</a>
	</div>
</header>



<!-- Services-->
<section class="page-section bg-dark" id="home">
	<div class="container">
		<h2 class="text-center">Featured Tourist Spots</h2>
		<div class="d-flex w-100 justify-content-center">
			<hr class="border-warning" style="border:3px solid" width="30%">
		</div>
		<div class="row">

			<?php
			$user_preference = isset($_SESSION['userdata']['preference']) ? $_SESSION['userdata']['preference'] : '';
			$max_display = 6;
			$displayed_ids = [];
			$packages = [];

			if (!empty($user_preference)) {

				$preference_array = json_decode($user_preference, true);

				if (json_last_error() === JSON_ERROR_NONE && is_array($preference_array)) {

					$pref_ids = $preference_array;
				} else {
					// If it's a comma-separated string of category names, convert to IDs
					$preference_names = array_map('trim', explode(',', $user_preference));
					$escaped_names = array_map(function ($name) use ($conn) {
						return "'" . $conn->real_escape_string($name) . "'";
					}, $preference_names);
					$name_list = implode(',', $escaped_names);

					$cat_res = $conn->query("SELECT id FROM categories WHERE name IN ($name_list)");
					$pref_ids = [];
					if ($cat_res && $cat_res->num_rows > 0) {
						while ($row = $cat_res->fetch_assoc()) {
							$pref_ids[] = $row['id'];
						}
					}
				}

				// If we have preference IDs to match
				if (!empty($pref_ids)) {
					$conditions = [];
					foreach ($pref_ids as $cat_id) {
						$safe_cat_id = $conn->real_escape_string($cat_id);
						$conditions[] = "JSON_CONTAINS(category, '\"$safe_cat_id\"')";
					}
					$where_clause = implode(" OR ", $conditions);

					// First query: Get packages that match the preference categories
					$pref_query = "SELECT * FROM packages WHERE status = 1 AND ($where_clause) ORDER BY RAND() LIMIT $max_display";
					$result = $conn->query($pref_query);

					if ($result && $result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							$packages[] = $row;
							$displayed_ids[] = $row['id'];
						}
					}

					// Second query: Fill up with random packages if needed
					$remaining = $max_display - count($packages);
					if ($remaining > 0 && !empty($displayed_ids)) {
						$exclude = implode(',', array_map('intval', $displayed_ids));
						$fallback = $conn->query("SELECT * FROM packages WHERE status = 1 AND id NOT IN ($exclude) ORDER BY RAND() LIMIT $remaining");
						if ($fallback && $fallback->num_rows > 0) {
							while ($row = $fallback->fetch_assoc()) {
								$packages[] = $row;
							}
						}
					} elseif ($remaining > 0) {
						// No packages matched preferences, get random packages
						$fallback = $conn->query("SELECT * FROM packages WHERE status = 1 ORDER BY RAND() LIMIT $remaining");
						if ($fallback && $fallback->num_rows > 0) {
							while ($row = $fallback->fetch_assoc()) {
								$packages[] = $row;
							}
						}
					}
				} else {
					// No valid preference IDs found, show random packages
					$res = $conn->query("SELECT * FROM packages WHERE status = 1 ORDER BY RAND() LIMIT $max_display");
					if ($res && $res->num_rows > 0) {
						while ($row = $res->fetch_assoc()) {
							$packages[] = $row;
						}
					}
				}
			} else {
				// No preference? Show 6 random packages
				$res = $conn->query("SELECT * FROM packages WHERE status = 1 ORDER BY RAND() LIMIT $max_display");
				if ($res && $res->num_rows > 0) {
					while ($row = $res->fetch_assoc()) {
						$packages[] = $row;
					}
				}
			}

			// Step 4: Display Packages
			foreach ($packages as $row) :
				$cover = '';
				$package_dir = base_app . 'uploads/package_' . $row['id'];
				if (is_dir($package_dir)) {
					$imgs = array_values(array_diff(scandir($package_dir), ['.', '..']));
					if (!empty($imgs)) {
						$cover = 'uploads/package_' . $row['id'] . '/' . $imgs[0];
					}
				}

				$row['description'] = strip_tags(stripslashes(html_entity_decode($row['description'])));
				$rate = 0;
				$review = $conn->query("SELECT * FROM rate_review WHERE package_id='{$row['id']}'");
				$review_count = $review->num_rows;
				while ($r = $review->fetch_assoc()) {
					$rate += $r['rate'];
				}
				if ($rate && $review_count) {
					$rate = number_format($rate / $review_count, 0, "");
				}
			?>
				<div class="col-md-4 p-4">
					<div class="card w-100 rounded-0">
						<img class="card-img-top" src="<?php echo validate_image($cover) ?>" alt="<?php echo htmlspecialchars($row['title']) ?>" height="200rem" style="object-fit:cover">
						<div class="card-body">
							<h5 class="card-title truncate-1 w-100"><?php echo htmlspecialchars($row['title']) ?></h5><br>
							<p class="card-text truncate"><?php echo htmlspecialchars($row['description']) ?></p>
							<div class="w-100 d-flex justify-content-end">
								<?php if (isset($_SESSION['userdata'])) : ?>
									<a href="./?page=view_package&id=<?php echo md5($row['id']) ?>" class="btn btn-sm btn-flat btn-warning">View Details <i class="fa fa-arrow-right"></i></a>
								<?php else : ?>
									<a href="javascript:void(0)" class="btn btn-sm btn-flat btn-warning" onclick="uni_modal('Login','login.php','large')">View Details <i class="fa fa-arrow-right"></i></a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>


<!-- About-->
<section class="page-section" id="about">
	<div class="container">
		<div class="text-center">
			<h2 class="section-heading text-uppercase">About Us</h2>
		</div>
		<div>
			<div class="card w-100">
				<div class="card-body">
					<?php echo file_get_contents(base_app . 'about.html') ?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Contact-->
<section class="page-section" id="contact">
	<div class="container">
		<div class="text-center">
			<h2 class="section-heading text-uppercase">Contact Us</h2>
			<h3 class="section-subheading text-muted">Send us a message for inquiries.</h3>
		</div>
		<!-- * * * * * * * * * * * * * * *-->
		<!-- * * SB Forms Contact Form * *-->
		<!-- * * * * * * * * * * * * * * *-->
		<!-- This form is pre-integrated with SB Forms.-->
		<!-- To make this form functional, sign up at-->
		<!-- https://startbootstrap.com/solution/contact-forms-->
		<!-- to get an API token!-->
		<form id="contactForm">
			<div class="row align-items-stretch mb-5">
				<div class="col-md-6">
					<div class="form-group">
						<!-- Name input-->
						<input class="form-control" id="name" name="name" type="text" placeholder="Your Name *" required />
					</div>
					<div class="form-group">
						<!-- Email address input-->
						<input class="form-control" id="email" name="email" type="email" placeholder="Your Email *" data-sb-validations="required,email" />
					</div>
					<div class="form-group mb-md-0">
						<input class="form-control" id="subject" name="subject" type="subject" placeholder="Subject *" required />
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group form-group-textarea mb-md-0">
						<!-- Message input-->
						<textarea class="form-control" id="message" name="message" placeholder="Your Message *" required></textarea>
					</div>
				</div>
			</div>
			<div class="text-center"><button class="btn btn-primary btn-xl text-uppercase" id="submitButton" type="submit">Send Message</button></div>
		</form>
	</div>
</section>
<script>
	$(function() {
		$('#contactForm').submit(function(e) {
			e.preventDefault()
			$.ajax({
				url: _base_url_ + "classes/Master.php?f=save_inquiry",
				method: "POST",
				data: $(this).serialize(),
				dataType: "json",
				error: err => {
					console.log(err)
					alert_toast("an error occured", 'error')
					end_loader()
				},
				success: function(resp) {
					if (typeof resp == 'object' && resp.status == 'success') {
						alert_toast("Inquiry sent", 'success')
						$('#contactForm').get(0).reset()
					} else {
						console.log(resp)
						alert_toast("an error occured", 'error')
						end_loader()
					}
				}
			})
		})
	})
</script>