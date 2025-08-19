<?php
// Fetch policy from system_info table
$policy_qry = $conn->query("SELECT meta_value FROM system_info WHERE meta_field = 'policy'");
if ($policy_qry->num_rows > 0) {
    $policy = $policy_qry->fetch_assoc()['meta_value'];
}
?>

<div class="form-group">
    <label for="policy" class="control-label">Policy</label>
    <textarea name="policy" id="policy" cols="30" rows="2" class="form-control form no-resize summernote">
        <?php echo isset($policy) ? $policy : ''; ?>
    </textarea>
</div>

<!-- Submit Button -->
<button type="button" class="btn btn-primary" id="savePolicyBtn">Save Policy</button>



<script>
    $(document).ready(function() {
        // Initialize summernote editor
        $('.summernote').summernote({
            height: 400,
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

        // Handle button click with AJAX to submit the form
        $('#savePolicyBtn').click(function() {
            var policyData = $('#policy').val();

            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_policy",
                type: 'POST',
                data: {
                    policy: policyData
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Policy saved successfully!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Error: ' + data.error,
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred.',
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                }
            });
        });
    });
</script>