<section class="page-section bg-dark" id="home">
    <div class="container py-5">
        <?php
   
        require_once 'fetch_packages.php'; 

        if (!isset($_SESSION['userdata']) && !isset($_SESSION['user_id'])) {
            echo "<script>location.replace('./?page=login');</script>";
            exit;
        }

        $items_per_page = 6;
        $current_page = isset($_GET['p']) ? max(1, intval($_GET['p'])) : 1;
        $offset = ($current_page - 1) * $items_per_page;
        $search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
        $category_filter = isset($_GET['categories']) && !empty($_GET['categories']) ? array_filter(explode(',', $_GET['categories']), 'is_numeric') : [];

     
        $category_data = getCategories($conn);
        $valid_category_ids = $category_data['categories'];
        $category_names = $category_data['names'];
        $category_filter = array_intersect($category_filter, $valid_category_ids);

       
        $category_match_check = checkCategoryMatch($conn, $category_filter);

        // Get category SQL condition
        $category_sql = getCategorySql($conn, $category_filter);

        // Get total number of packages for pagination
        $total_items = getTotalPackages($conn, $search_query, $category_sql);
        $total_pages = ceil($total_items / $items_per_page);

        // Get sort type
        $sort_type = isset($_GET['sort']) ? $_GET['sort'] : 'recommended';
        $user_preference = isset($_SESSION['userdata']['preference']) ? $_SESSION['userdata']['preference'] : '';

        // Fetch packages
        $packages = getPackages($conn, $sort_type, $search_query, $category_sql, $offset, $items_per_page, $user_preference);
        ?>
        <h2 class="text-center text-white mb-4">Featured Destinations</h2>
        <div class="d-flex w-100 justify-content-center mb-4">
            <hr class="border-light" style="border:2px solid" width="10%">
        </div>

        <!-- Sort/Filter and Search Section -->
        <div class="sort-filter-container mb-4 text-center bg-white p-3 rounded shadow-sm">
            <div class="d-flex justify-content-center flex-wrap align-items-center">
                <!-- Search Bar -->
                <div class="input-group w-25 mb-2 mx-2 me-auto">
                    <input type="text" class="form-control" id="search-input" placeholder="Search destinations..." value="<?php echo htmlspecialchars($search_query); ?>">
                    <button class="btn btn-warning" type="button" onclick="searchPackages()">Search</button>
                </div>
                <!-- Sort Buttons -->
                <button class="btn btn-outline-dark m-1 sort-filter-btn <?php echo !isset($_GET['sort']) || $_GET['sort'] == 'recommended' ? 'active' : '' ?>" onclick="sortPackages('recommended')">Recommended</button>
                <button class="btn btn-outline-dark m-1 sort-filter-btn <?php echo isset($_GET['sort']) && $_GET['sort'] == 'rating' ? 'active' : '' ?>" onclick="sortPackages('rating')">Traveler Rating</button>
                <button class="btn btn-outline-dark m-1 sort-filter-btn <?php echo isset($_GET['sort']) && $_GET['sort'] == 'popularity' ? 'active' : '' ?>" onclick="sortPackages('popularity')">Popularity</button>
                <button class="btn btn-outline-dark m-1 sort-filter-btn <?php echo isset($_GET['sort']) && $_GET['sort'] == 'free' ? 'active' : '' ?>" onclick="sortPackages('free')">Free Entry</button>
            </div>

            <!-- Category Filters -->
            <div class="d-flex justify-content-right flex-wrap mt-3">
                <?php
                if (!empty($category_names)) {
                    foreach ($category_names as $cat_id => $cat_name) {
                        $cat_name = htmlspecialchars($cat_name);
                        $checked = in_array((string)$cat_id, $category_filter) ? 'checked' : '';
                        echo "<label class='mx-2'>";
                        echo "<input type='checkbox' class='category-filter' value='$cat_id' $checked> $cat_name";
                        echo "</label>";
                    }
                } else {
                    echo "<p class='text-muted'>No categories available. Please add categories in the admin panel.</p>";
                }
                ?>
                <button class="btn btn-sm btn-secondary ms-3" onclick="applyCategoryFilter()">Apply Filter</button>
            </div>
        </div>

        <script>
            function sortPackages(type) {
                const search = document.getElementById('search-input').value;
                const selectedCategories = Array.from(document.querySelectorAll('.category-filter:checked')).map(cb => cb.value);
                const categoryParam = selectedCategories.join(',');
                const isCurrentlyActive = <?php echo isset($_GET['sort']) ? "'" . $_GET['sort'] . "'" : "'recommended'" ?> === type;

                let url;
                if (isCurrentlyActive) {
                    url = `./?page=packages&search=${encodeURIComponent(search)}&p=1`;
                    if (selectedCategories.length > 0) {
                        url += `&categories=${encodeURIComponent(categoryParam)}`;
                    }
                } else {
                    url = `./?page=packages&sort=${type}&search=${encodeURIComponent(search)}&p=1`;
                    if (selectedCategories.length > 0) {
                        url += `&categories=${encodeURIComponent(categoryParam)}`;
                    }
                }
                window.location.href = url;
            }

            function searchPackages() {
                const search = document.getElementById('search-input').value;
                const sort = '<?php echo isset($_GET['sort']) ? $_GET['sort'] : 'recommended'; ?>';
                const selectedCategories = Array.from(document.querySelectorAll('.category-filter:checked')).map(cb => cb.value);

                let url = `./?page=packages&p=1`;

                if (sort !== 'recommended') {
                    url += `&sort=${sort}`;
                }

                if (search) {
                    url += `&search=${encodeURIComponent(search)}`;
                }

                if (selectedCategories.length > 0) {
                    url += `&categories=${encodeURIComponent(selectedCategories.join(','))}`;
                }

                window.location.href = url;
            }

            function applyCategoryFilter() {
                const selectedCategories = Array.from(document.querySelectorAll('.category-filter:checked')).map(cb => cb.value);
                const search = document.getElementById('search-input').value;
                const sort = '<?php echo isset($_GET['sort']) ? $_GET['sort'] : 'recommended'; ?>';

                let url = `./?page=packages&p=1`;

                if (sort !== 'recommended') {
                    url += `&sort=${sort}`;
                }

                if (search) {
                    url += `&search=${encodeURIComponent(search)}`;
                }

                if (selectedCategories.length > 0) {
                    url += `&categories=${encodeURIComponent(selectedCategories.join(','))}`;
                }

                window.location.href = url;
            }

            document.getElementById('search-input').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    searchPackages();
                }
            });
        </script>

        <div class="row">
            <?php
            if (empty($packages)) {
                $message = "No destinations found.";
                if (!empty($category_filter)) {
                    $category_labels = array_map(function ($id) use ($category_names) {
                        return isset($category_names[$id]) ? $category_names[$id] : "ID $id";
                    }, $category_filter);
                    $message .= " The selected categories (" . implode(", ", $category_labels) . ") do not match any packages.";
                    if (!$category_match_check) {
                        $message .= " No packages in the database have these category IDs in their category field.";
                    }
                }
                if (!empty($search_query)) {
                    $message .= " Try adjusting your search term or filters.";
                }
                $message .= " Check the admin panel to ensure packages are assigned to the selected categories.";
                echo '<p class="text-center text-white">' . $message . '</p>';
            }

            foreach ($packages as $row) :
                $cover = getPackageCover(base_app, $row['id']);
                $row['description'] = strip_tags(stripslashes(html_entity_decode($row['description'])));
                $rating = getPackageRating($conn, $row['id']);
                $review_count = $rating['count'];
                $rate = $rating['rate'];
            ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm rounded-lg package-item">
                        <div class="position-relative">
                            <img class="card-img-top" src="<?php echo validate_image($cover) ?>" alt="<?php echo $row['title'] ?>" height="200rem" style="object-fit:cover">
                            <?php if ($review_count > 0) : ?>
                                <div class="position-absolute top-0 end-0 bg-warning text-dark px-2 py-1 m-2 rounded">
                                    <small><i class="fa fa-star"></i> <?php echo $rate ?>/5</small>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-dark fw-bold"><?php echo $row['title'] ?></h5>
                            <p class="card-text text-muted small"><?php echo substr($row['description'], 0, 100) . '...'; ?></p>
                        </div>
                        <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                            <div class="me-5 fw-bold <?php echo isset($row['cost']) && strtolower(trim($row['cost'])) == 'free entry' ? 'text-success' : 'text-warning'; ?>">
                                <?php if (isset($row['cost']) && strtolower(trim($row['cost'])) == 'free entry') : ?>
                                    <span><?php echo ucfirst($row['cost']); ?></span>
                                <?php else : ?>
                                    <span><?php echo htmlspecialchars($row['cost']); ?></span>
                                <?php endif; ?>
                            </div>
                            <a href="./?page=view_package&id=<?php echo md5($row['id']) ?>" class="btn btn-sm btn-warning">View Details <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php if ($current_page > 1) : ?>
                        <li class="page-item">
                            <a class="page-link" href="./?page=packages<?php echo isset($_GET['sort']) ? '&sort=' . $sort_type : ''; ?><?php echo !empty($search_query) ? '&search=' . urlencode($search_query) : ''; ?><?php echo !empty($category_filter) ? '&categories=' . urlencode(implode(',', $category_filter)) : ''; ?>&p=<?php echo $current_page - 1 ?>" aria-label="Previous">
                                <span aria-hidden="true">«</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php
                    $show_pages = 5;
                    $start_page = max(1, $current_page - floor($show_pages / 2));
                    $end_page = min($total_pages, $start_page + $show_pages - 1);

                    if ($end_page - $start_page + 1 < $show_pages) {
                        $start_page = max(1, $end_page - $show_pages + 1);
                    }

                    for ($i = $start_page; $i <= $end_page; $i++) :
                    ?>
                        <li class="page-item <?php echo $i == $current_page ? 'active' : '' ?>">
                            <a class="page-link" href="./?page=packages<?php echo isset($_GET['sort']) ? '&sort=' . $sort_type : ''; ?><?php echo !empty($search_query) ? '&search=' . urlencode($search_query) : ''; ?><?php echo !empty($category_filter) ? '&categories=' . urlencode(implode(',', $category_filter)) : ''; ?>&p=<?php echo $i ?>"><?php echo $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages) : ?>
                        <li class="page-item">
                            <a class="page-link" href="./?page=packages<?php echo isset($_GET['sort']) ? '&sort=' . $sort_type : ''; ?><?php echo !empty($search_query) ? '&search=' . urlencode($search_query) : ''; ?><?php echo !empty($category_filter) ? '&categories=' . urlencode(implode(',', $category_filter)) : ''; ?>&p=<?php echo $current_page + 1 ?>" aria-label="Next">
                                <span aria-hidden="true">»</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</section>