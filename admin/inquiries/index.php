<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Inquiries</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-stripped text-dark">
                <colgroup>
                    <col width="5%">
                    <col width="15%">
                    <col width="20%">
                    <col width="20%">
                    <col width="10%">

                    <col width="10%">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>DateTime</th>
                        <th>From</th>
                        <th>Subject</th>
                        <th>Status</th>

                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $qry = $conn->query("SELECT * FROM `inquiry` ORDER BY date(date_created) DESC ");
                    while ($row = $qry->fetch_assoc()) :
                    ?>
                        <tr>
                            <td><?php echo $i++ ?></td>
                            <td><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
                            <td><?php echo $row['email'] ?></td>
                            <td>
                                <p class="truncate-1 m-0"><?php echo $row['subject'] ?></p>
                            </td>
                            <td class="text-center status">
                                <?php if ($row['status'] == 0) : ?>
                                    <span class="badge badge-warning">Unread</span>
                                <?php else : ?>
                                    <span class="badge badge-success">Read</span>
                                <?php endif; ?>
                            </td>

                            <td align="center">
                                <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    Action
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-file text-primary"></span> View</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.delete_data').click(function() {
            _conf("Are you sure to delete this inquiry permanently?", "delete_inquiry", [$(this).attr('data-id')])
        })
        $('.view_data').click(function() {
            uni_modal("Inquiry", "inquiries/view.php?id=" + $(this).attr('data-id'))
            $(this).closest('tr').find('.status').html('<span class="badge badge-success">Read</span>')
        })
        $('.table').dataTable();
    })

    function delete_inquiry($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_inquiry",
            method: "POST",
            data: {
                id: $id
            },
            dataType: "json",
            error: err => {
                console.log(err)
                alert_toast("An error occurred.", 'error');
                end_loader();
            },
            success: function(resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    location.reload();
                } else {
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            }
        })
    }
</script>