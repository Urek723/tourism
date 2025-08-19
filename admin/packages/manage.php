<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `packages` where id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    }
}
?>
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title"><?php echo isset($id) ? "Update " : "Create New " ?>Create </h3>
    </div>
    <div class="card-body">
        <form action="" id="package-form">
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">

            <!-- Title input -->
            <div class="form-group">
                <label for="title" class="control-label">Title</label>
                <textarea name="title" id="" cols="30" rows="2" class="form-control form no-resize"><?php echo isset($title) ? $title : ''; ?></textarea>
            </div>

            <!-- Tour Location input -->
            <div class="form-group">
                <label for="tour_location" class="control-label">Tour Location</label>
                <textarea name="tour_location" id="" cols="30" rows="2" class="form-control form no-resize"><?php echo isset($tour_location) ? $tour_location : ''; ?></textarea>
            </div>
            <!-- Category -->
            <div class="form-group">
                <label for="category">Select Categories:</label>
                <div role="group" aria-label="Categories">
                    <?php
                    $selected_categories = isset($category) ? json_decode($category) : array();
                    $cat_qry = $conn->query("SELECT * FROM categories ORDER BY name ASC");
                    while ($cat_row = $cat_qry->fetch_assoc()) :
                        $is_checked = in_array($cat_row['id'], $selected_categories) ? "checked" : "";
                    ?>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="category_<?php echo $cat_row['id']; ?>" name="category[]" value="<?php echo $cat_row['id']; ?>" <?php echo $is_checked; ?>>
                            <label class="custom-control-label" for="category_<?php echo $cat_row['id']; ?>">
                                <?php echo $cat_row['name']; ?>
                            </label>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>



            <!-- Cost selection -->
            <div class="form-group">
                <label for="cost" class="control-label">Cost</label>
                <select name="cost" class="form-control">
                    <option value="Free entry" <?php echo isset($cost) && $cost == 'Free entry' ? 'selected' : ''; ?>>Free entry</option>
                    <option value="Paid entry" <?php echo isset($cost) && $cost == 'Paid entry' ? 'selected' : ''; ?>>Paid entry</option>
                </select>
            </div>

            <!-- Description input -->
            <div class="form-group">
                <label for="description" class="control-label">Description</label>
                <textarea name="description" id="description" cols="30" rows="2" class="form-control form no-resize summernote"><?php echo isset($description) ? $description : ''; ?></textarea>
            </div>

            <!-- Status selection -->
            <div class="form-group">
                <label for="status" class="control-label">Status</label>
                <select name="status" id="status" class="custom-select select">
                    <option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

            <!-- Image upload -->
            <div class="form-group">
                <label for="" class="control-label">Images</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img[]" multiple accept="image/*" onchange="displayImg(this,$(this))">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>

            <!-- Display uploaded images -->
            <?php if (isset($upload_path) && is_dir(base_app . $upload_path)) : ?>
                <?php
                $file = scandir(base_app . $upload_path);
                foreach ($file as $img) :
                    if (in_array($img, array('.', '..'))) continue;
                ?>
                    <div class="d-flex w-100 align-items-center img-item">
                        <span><img src="<?php echo base_url . $upload_path . '/' . $img ?>" width="150px" height="100px" style="object-fit:cover;" class="img-thumbnail" alt=""></span>
                        <span class="ml-4"><button class="btn btn-sm btn-default text-danger rem_img" type="button" data-path="<?php echo base_app . $upload_path . '/' . $img ?>"><i class="fa fa-trash"></i></button></span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- Video upload -->
            <div class="form-group">
                <label for="upload_video" class="control-label">Upload Video</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input rounded-circle" id="upload_video" name="video" accept="video/*" onchange="displayVideo(this, $(this))">
                    <label class="custom-file-label" for="upload_video">Choose video file</label>
                </div>
            </div>

            <!-- Display uploaded video -->
            <?php
            // Ensure the $upload_path_video is correctly defined
            if (isset($upload_path_video) && is_dir(base_app . $upload_path_video)) :
                // Scan the directory for video files
                $videos = scandir(base_app . $upload_path_video);
                foreach ($videos as $video) :
                    // Skip . and .. entries
                    if (in_array($video, array('.', '..'))) continue;
            ?>
                    <div class="d-flex w-100 align-items-center video-item">
                        <video width="250" height="150" controls>
                            <source src="<?php echo base_url . $upload_path_video . '/' . $video; ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <span class="ml-4">
                            <button class="btn btn-sm btn-default text-danger rem_video" type="button" data-path="<?php echo base_app . $upload_path_video . '/' . $video; ?>">
                                <i class="fa fa-trash"></i>
                            </button>
                        </span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- End Form -->
        </form>
    </div>

    <div class="card-footer">
        <button class="btn btn-flat btn-primary" form="package-form">Save</button>
        <a class="btn btn-flat btn-default" href="?page=responses">Cancel</a>
    </div>
</div>

<script>
    function displayVideo(input, _this) {

        if (input.files && input.files.length > 0) {
            var fnames = [];

            for (var i = 0; i < input.files.length; i++) {
                fnames.push(input.files[i].name);
            }

            _this.siblings('.custom-file-label').html(fnames.join(', '));
        } else {

            _this.siblings('.custom-file-label').html('Choose video file');
        }
    }


    function displayImg(input, _this) {
        console.log(input.files)
        var fnames = []
        Object.keys(input.files).map(k => {
            fnames.push(input.files[k].name)
        })
        _this.siblings('.custom-file-label').html(fnames.join(', '))
    }


    function delete_img($path) {
        start_loader();

        $.ajax({
            url: _base_url_ + 'classes/Master.php?f=delete_p_img',
            data: {
                path: $path
            },
            method: 'POST',
            dataType: "json",
            error: err => {
                console.log(err);
                alert_toast("An error occurred while deleting the image", "error");
                end_loader();
            },
            success: function(resp) {
                $('.modal').modal('hide');
                if (typeof resp == 'object' && resp.status == 'success') {
                    $('[data-path="' + $path + '"]').closest('.img-item').hide('slow', function() {
                        $('[data-path="' + $path + '"]').closest('.img-item').remove();
                    });
                    alert_toast("Image successfully deleted", "success");
                } else {
                    console.log(resp);
                    alert_toast("An error occurred while deleting the image", "error");
                }
                end_loader();
            }
        });
    }

    function delete_video($path) {
        start_loader();
        console.log("Deleting video at path: " + $path);

        // Extract the relative path if it contains the base URL
        var relativePath = $path;
        if ($path.indexOf(_base_url_) === 0) {
            relativePath = $path.replace(_base_url_, '');
        }

        $.ajax({
            url: _base_url_ + 'classes/Master.php?f=delete_p_video',
            data: {
                path: relativePath
            },
            method: 'POST',
            dataType: "json",
            error: function(err) {
                console.log(err);
                alert_toast("An error occurred while deleting the video", "error");
                end_loader();
            },
            success: function(resp) {
                $('.modal').modal('hide');
                if (typeof resp == 'object' && resp.status == 'success') {
                    // Hide the video item and remove it
                    $('[data-path="' + $path + '"]').closest('.video-item').hide('slow', function() {
                        $('[data-path="' + $path + '"]').closest('.video-item').remove();
                    });
                    alert_toast("Video successfully deleted", "success");
                } else {
                    console.log(resp);
                    alert_toast(resp.message || "An error occurred while deleting the video", "error");
                }
                end_loader();
            }
        });
    }

    $('.rem_video').click(function() {
        _conf("Are you sure to delete this video permanently?", 'delete_video', ["'" + $(this).attr('data-path') + "'"]);
    });
    // Confirm and delete image
    $('.rem_img').click(function() {
        _conf("Are you sure to delete this image permanently?", 'delete_img', ["'" + $(this).attr('data-path') + "'"]);
    });


    $('#package-form').submit(function(e) {
        e.preventDefault();
        $('.err-msg').remove();
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=save_package",
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            dataType: 'json',
            error: err => {
                console.log(err);
                alert_toast("An error occurred", 'error');
                end_loader();
            },
            success: function(resp) {
                if (typeof resp === 'object' && resp.status === 'success') {
                    alert_toast("Location Details successfully saved.", 'success');
                    setTimeout(function() {
                        location.href = window.location.href;
                    }, 1500);
                } else {
                    alert_toast("An error occurred", 'error');
                    end_loader();
                    console.log(resp);
                }
            }

        });
    });

    $(document).ready(function() {
        $('.summernote').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ol', 'ul', 'paragraph', 'height']],
                ['table', ['table']],
                ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>