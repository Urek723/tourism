<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Categories</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-flat btn-primary" id="add_new_category"><span class="fas fa-plus"></span> Add New Category</button>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-bordered table-stripped">
                <colgroup>
                    <col width="5%">
                    <col width="20%">
                    <col width="55%">
                    <col width="20%">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $qry = $conn->query("SELECT * from `categories` order by name asc");
                    while ($row = $qry->fetch_assoc()) :
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td><?php echo $row['name'] ?></td>
                            <td><?php echo $row['description'] ?></td>
                            <td align="center">
                                <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    Action
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item edit_category" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item delete_category" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Category Modal -->
<div class="modal fade" id="category_modal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">Add New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="category_form">
                <div class="modal-body">
                    <input type="hidden" name="id" value="">
                    <div class="form-group">
                        <label for="name" class="control-label">Category Name</label>
                        <input type="text" name="name" id="name" class="form-control form" required>
                    </div>
                    <div class="form-group">
                        <label for="description" class="control-label">Description</label>
                        <textarea name="description" id="description" cols="30" rows="3" class="form-control form"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('.table').dataTable();

        // Add New Category
        $('#add_new_category').click(function() {
            $('#category_form')[0].reset();
            $('#category_form input[name="id"]').val('');
            $('#categoryModalLabel').text('Add New Category');
            $('#category_modal').modal('show');
        });

        // Edit Category
        $('.edit_category').click(function() {
            var id = $(this).attr('data-id');
            start_loader();

            $.ajax({
                url: _base_url_ + "classes/Master.php?f=get_category",
                method: "POST",
                data: {
                    id: id
                },
                dataType: "json",
                error: err => {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp === 'object' && resp.status === 'success') {
                        $('#category_form input[name="id"]').val(resp.data.id);
                        $('#category_form input[name="name"]').val(resp.data.name);
                        $('#category_form textarea[name="description"]').val(resp.data.description);
                        $('#categoryModalLabel').text('Edit Category');
                        $('#category_modal').modal('show');
                    } else {
                        console.log(resp);
                        alert_toast("An error occurred", 'error');
                    }
                    end_loader();
                }
            });
        });

        // Delete Category
        $('.delete_category').click(function() {
            _conf("Are you sure to delete this category permanently?", "delete_category", [$(this).attr('data-id')]);
        });

        // Submit Form
        $('#category_form').submit(function(e) {
            e.preventDefault();
            start_loader();

            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_category",
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
                    if (resp.status === 'success') {
                        alert_toast("Category successfully saved", 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        console.log(resp);
                        alert_toast("An error occurred", 'error');
                    }
                    end_loader();
                }
            });
        });
    });

    function delete_category($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_category",
            method: "POST",
            data: {
                id: $id
            },
            dataType: "json",
            error: err => {
                console.log(err);
                alert_toast("An error occurred", 'error');
                end_loader();
            },
            success: function(resp) {
                if (resp.status === 'success') {
                    location.reload();
                } else {
                    alert_toast("An error occurred", 'error');
                }
                end_loader();
            }
        });
    }
</script>