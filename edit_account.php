<section class="page-section">
    <div class="container">
        <div class="w-100 justify-content-between d-flex">
            <h4><b>Update Account Details</b></h4>
        </div>
        <hr class="border-warning">
        <div class="col-md-6">
            <form action="" id="update_account">
                <input type="hidden" name="id" value="<?php echo $_settings->userdata('id') ?>">

                <div class="form-group">
                    <label for="firstname" class="control-label">Firstname</label>
                    <input type="text" name="firstname" class="form-control form" value="<?php echo $_settings->userdata('firstname') ?>" required>
                </div>

                <div class="form-group">
                    <label for="lastname" class="control-label">Lastname</label>
                    <input type="text" name="lastname" class="form-control form" value="<?php echo $_settings->userdata('lastname') ?>" required>
                </div>

                <div class="form-group">
                    <label for="username" class="control-label">Username</label>
                    <input type="text" name="username" class="form-control form" value="<?php echo $_settings->userdata('username') ?>" required>
                </div>

                <div class="form-group">
    <label for="preference">Select your preferences:</label>
    <div class="btn-group" role="group" aria-label="Preferences" id="preference">
        <?php
        $user_preferences = $_settings->userdata('preference');
        $preferences_array = !empty($user_preferences) ? explode(',', $user_preferences) : []; // Convert to array if not empty
        $query = $conn->query("SELECT * FROM categories ORDER BY name ASC");
        while ($row = $query->fetch_assoc()) :
            $value = strtolower(str_replace(' ', '_', $row['name']));
            $is_checked = in_array($value, $preferences_array) ? 'checked' : ''; // Check if the preference is set
            $active_class = in_array($value, $preferences_array) ? 'active' : ''; // Add active class if preference is set
        ?>
            <input type="checkbox" class="btn-check" id="<?= $value ?>" name="preference[]" value="<?= $value ?>" autocomplete="off" <?= $is_checked ?>>
            <label class="btn btn-outline-primary <?= $active_class ?>" for="<?= $value ?>"><?= htmlspecialchars($row['name']) ?></label>
        <?php endwhile; ?>
    </div>
</div>

                <div class="form-group">
                    <label for="password" class="control-label">New Password</label>
                    <input type="password" name="password" class="form-control form" placeholder="(Enter value to change password)">
                </div>

                <div class="form-group">
                    <label for="cpassword" class="control-label">Current Password</label>
                    <input type="password" name="cpassword" class="form-control form" placeholder="(Enter value to change password)">
                </div>

                <div class="form-group d-flex justify-content-end">
                    <button class="btn btn-primary btn-flat">Update</button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
   $(function() {
    // Initialize active class for checked checkboxes
    $('#preference input[type="checkbox"]:checked').each(function() {
        $(this).next('label').addClass('active');
    });

    // Toggle active class on checkbox change
    $('#preference input[type="checkbox"]').change(function() {
        if ($(this).is(':checked')) {
            $(this).next('label').addClass('active');
        } else {
            $(this).next('label').removeClass('active');
        }
    });

    // Handle password and cpassword input validation
    $('#update_account [name="password"], #update_account [name="cpassword"]').on('input', function() {
        if ($('#update_account [name="password"]').val() != '' || $('#update_account [name="cpassword"]').val() != '') {
            $('#update_account [name="password"], #update_account [name="cpassword"]').attr('required', true);
        } else {
            $('#update_account [name="password"], #update_account [name="cpassword"]').attr('required', false);
        }
    });

    // Form submission
    $('#update_account').submit(function(e) {
        e.preventDefault();
        start_loader();
        if ($('.err-msg').length > 0) $('.err-msg').remove();
        
        // If no preferences are selected, ensure preference[] is sent as an empty array
        if ($('#preference input[type="checkbox"]:checked').length === 0) {
            $(this).append('<input type="hidden" name="preference[]" value="">');
        }

        $.ajax({
            url: _base_url_ + "classes/Master.php?f=update_account",
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",
            error: err => {
                console.log(err);
                alert_toast("an error occurred", 'error');
                end_loader();
            },
            success: function(resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    alert_toast("Account successfully updated", 'success');
                    $('#update_account [name="password"], #update_account [name="cpassword"]').attr('required', false);
                    $('#update_account [name="password"], #update_account [name="cpassword"]').val('');
                } else if (resp.status == 'failed' && !!resp.msg) {
                    var _err_el = $('<div>');
                    _err_el.addClass("alert alert-danger err-msg").text(resp.msg);
                    $('#update_account').prepend(_err_el);
                    end_loader();
                } else {
                    console.log(resp);
                    alert_toast("an error occurred", 'error');
                }
                end_loader();
            }
        });
    });
});
</script>