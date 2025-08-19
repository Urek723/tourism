<?php
function getCategories($conn) {
    $categories = [];
    $category_names = [];
    $category_query = "SELECT id, name FROM categories ORDER BY name ASC";
    $category_result = $conn->query($category_query);
    if ($category_result) {
        while ($row = $category_result->fetch_assoc()) {
            $categories[] = (string)$row['id'];
            $category_names[$row['id']] = $row['name'];
        }
    }
    return ['categories' => $categories, 'names' => $category_names];
}

function checkCategoryMatch($conn, $category_filter) {
    if (empty($category_filter)) {
        return true;
    }
    $conditions = [];
    foreach ($category_filter as $cat_id) {
        $safe_cat_id = $conn->real_escape_string($cat_id);
        $conditions[] = "JSON_CONTAINS(category, '\"$safe_cat_id\"')";
    }
    $check_query = "SELECT COUNT(*) as count FROM packages WHERE status = 1 AND (" . implode(" OR ", $conditions) . ")";
    $check_result = $conn->query($check_query);
    error_log("Category Match Check Query: $check_query");
    return $check_result && $check_result->fetch_assoc()['count'] > 0;
}

function getCategorySql($conn, $category_filter) {
    if (empty($category_filter)) {
        return "";
    }
    $conditions = [];
    foreach ($category_filter as $cat_id) {
        $safe_cat_id = $conn->real_escape_string($cat_id);
        $conditions[] = "JSON_CONTAINS(category, '\"$safe_cat_id\"')";
    }
    $category_sql = " AND (" . implode(" OR ", $conditions) . ")";
    error_log("Category SQL: $category_sql");
    return $category_sql;
}

function getTotalPackages($conn, $search_query, $category_sql) {
    $count_query = "SELECT COUNT(*) as total FROM packages WHERE status = 1";
    if (!empty($search_query)) {
        $count_query .= " AND title LIKE '%" . $conn->real_escape_string($search_query) . "%'";
    }
    $count_query .= $category_sql;
    error_log("Count Query: $count_query");
    $total_result = $conn->query($count_query);
    return $total_result ? $total_result->fetch_assoc()['total'] : 0;
}

function getPackages($conn, $sort_type, $search_query, $category_sql, $offset, $items_per_page, $user_preference) {
    $packages = [];
    
    switch ($sort_type) {
        case 'rating':
            $query = "
                SELECT p.*, IFNULL(AVG(r.rate), 0) AS avg_rating
                FROM packages p
                LEFT JOIN rate_review r ON p.id = r.package_id
                WHERE p.status = 1
            ";
            if (!empty($search_query)) {
                $query .= " AND p.title LIKE '%" . $conn->real_escape_string($search_query) . "%'";
            }
            $query .= $category_sql;
            $query .= "
                GROUP BY p.id
                ORDER BY avg_rating DESC
                LIMIT $offset, $items_per_page
            ";
            break;
        case 'free':
            $query = "SELECT * FROM packages WHERE status = 1 AND LOWER(cost) LIKE '%free entry%'";
            if (!empty($search_query)) {
                $query .= " AND title LIKE '%" . $conn->real_escape_string($search_query) . "%'";
            }
            $query .= $category_sql;
            $query .= " ORDER BY title ASC LIMIT $offset, $items_per_page";
            break;
        case 'popularity':
            $query = "
                SELECT p.*, COUNT(r.id) AS review_count
                FROM packages p
                LEFT JOIN rate_review r ON p.id = r.package_id
                WHERE p.status = 1
            ";
            if (!empty($search_query)) {
                $query .= " AND p.title LIKE '%" . $conn->real_escape_string($search_query) . "%'";
            }
            $query .= $category_sql;
            $query .= "
                GROUP BY p.id
                ORDER BY review_count DESC
                LIMIT $offset, $items_per_page
            ";
            break;
        default:
            if (!empty($user_preference)) {
                $preference_array = json_decode($user_preference, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($preference_array)) {
                    $category_ids = $preference_array;
                } else {
                    $preferences = array_map('trim', explode(',', $user_preference));
                    $pref_names = implode("','", array_map(array($conn, 'real_escape_string'), $preferences));
                    $category_query = "SELECT id FROM categories WHERE name IN ('$pref_names')";
                    $category_result = $conn->query($category_query);
                    $category_ids = [];
                    if ($category_result) {
                        while ($row = $category_result->fetch_assoc()) {
                            $category_ids[] = $row['id'];
                        }
                    }
                }

                $displayed_ids = [];
                $base_query = "SELECT * FROM packages WHERE status = 1";
                if (!empty($search_query)) {
                    $base_query .= " AND title LIKE '%" . $conn->real_escape_string($search_query) . "%'";
                }
                $base_query .= $category_sql;

                if (!empty($category_ids)) {
                    $conditions = [];
                    foreach ($category_ids as $cat_id) {
                        $safe_cat_id = $conn->real_escape_string($cat_id);
                        $conditions[] = "JSON_CONTAINS(category, '\"$safe_cat_id\"')";
                    }
                    $preferred_query = $base_query . " AND (" . implode(" OR ", $conditions) . ")";
                    $preferred_query .= " LIMIT $offset, $items_per_page";
                    error_log("Preferred Query: $preferred_query");

                    $result = $conn->query($preferred_query);
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $packages[] = $row;
                            $displayed_ids[] = $row['id'];
                        }
                    }

                    if (count($packages) < $items_per_page) {
                        $remaining = $items_per_page - count($packages);
                        $exclude_ids = !empty($displayed_ids) ? implode(",", array_map('intval', $displayed_ids)) : "0";
                        $fallback_query = $base_query . " AND id NOT IN ($exclude_ids)";
                        $fallback_query .= " ORDER BY RAND() LIMIT $remaining";
                        error_log("Fallback Query: $fallback_query");

                        $result = $conn->query($fallback_query);
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $packages[] = $row;
                            }
                        }
                    }
                } else {
                    $query = $base_query . " ORDER BY RAND() LIMIT $offset, $items_per_page";
                    error_log("Random Query: $query");
                    $result = $conn->query($query);
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $packages[] = $row;
                        }
                    }
                }
                return $packages;
            } else {
                $query = "SELECT * FROM packages WHERE status = 1";
                if (!empty($search_query)) {
                    $query .= " AND title LIKE '%" . $conn->real_escape_string($search_query) . "%'";
                }
                $query .= $category_sql;
                $query .= " ORDER BY RAND() LIMIT $offset, $items_per_page";
                error_log("No Preference Query: $query");
            }
            break;
    }

    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $packages[] = $row;
        }
    }
    return $packages;
}

function getPackageCover($base_app, $package_id) {
    $cover = '';
    if (is_dir($base_app . 'uploads/package_' . $package_id)) {
        $img = scandir($base_app . 'uploads/package_' . $package_id);
        $k = array_search('.', $img);
        if ($k !== false) unset($img[$k]);
        $k = array_search('..', $img);
        if ($k !== false) unset($img[$k]);
        $cover = isset($img[2]) ? 'uploads/package_' . $package_id . '/' . $img[2] : "";
    }
    return $cover;
}

function getPackageRating($conn, $package_id) {
    $review = $conn->query("SELECT * FROM `rate_review` WHERE package_id='$package_id'");
    $review_count = $review->num_rows;
    $rate = 0;
    while ($r = $review->fetch_assoc()) {
        $rate += $r['rate'];
    }
    if ($rate > 0 && $review_count > 0) {
        $rate = number_format($rate / $review_count, 0, "");
    }
    return ['count' => $review_count, 'rate' => $rate];
}
?>