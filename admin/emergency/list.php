<?php

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `emergency_contacts` where id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    }
}
?>
<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo isset($id) ? "Update " : "Create New " ?> Emergency Contact</h3>
    </div>
    <div class="card-body">
        <form action="" id="emergency-contact-form">
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
            <div class="form-group">
                <label for="name" class="control-label">Contact Name</label>
                <input name="name" id="name" type="text" class="form-control" value="<?php echo isset($name) ? $name : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="phone_number" class="control-label">Phone Number</label>
                <input name="phone_number" id="phone_number" type="text" class="form-control" value="<?php echo isset($phone_number) ? $phone_number : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="address" class="control-label">Address</label>
                <textarea name="address" id="address" rows="3" class="form-control"><?php echo isset($address) ? $address : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="description" class="control-label">Description</label>
                <textarea name="description" id="description" rows="3" class="form-control"><?php echo isset($description) ? $description : ''; ?></textarea>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lat" class="control-label">Latitude</label>
                        <input name="lat" id="lat" type="text" class="form-control" value="<?php echo isset($lat) ? $lat : ''; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lng" class="control-label">Longitude</label>
                        <input name="lng" id="lng" type="text" class="form-control" value="<?php echo isset($lng) ? $lng : ''; ?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="map" class="control-label">Select Location on Map</label>
                <div id="map" style="height: 400px; width: 100%;"></div>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <button class="btn btn-primary" form="emergency-contact-form" id="submit-btn">Save</button>
        <a class="btn btn-default" href="./?page=emergency">Cancel</a>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Initialize map
        var map, marker;
        var defaultLat = <?php echo isset($lat) ? $lat : 6.3333 ?>;
        var defaultLng = <?php echo isset($lng) ? $lng : 124.9500 ?>;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: defaultLat,
                    lng: defaultLng
                },
                zoom: 13
            });

            marker = new google.maps.Marker({
                position: {
                    lat: defaultLat,
                    lng: defaultLng
                },
                map: map,
                draggable: true
            });

            google.maps.event.addListener(marker, 'dragend', function() {
                var position = marker.getPosition();
                $('#lat').val(position.lat());
                $('#lng').val(position.lng());
            });

            google.maps.event.addListener(map, 'click', function(event) {
                marker.setPosition(event.latLng);
                $('#lat').val(event.latLng.lat());
                $('#lng').val(event.latLng.lng());
            });
        }

        // Load Google Maps API
        $.getScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyAOVYRIgupAurZup5y1PRh8Ismb1A3lLao&q=&callback=initMap');
        window.initMap = initMap;



        $('#emergency-contact-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this);
            $('.err-msg').remove();

            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_emergency_contact",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                success: function(resp) {
                    if (resp.status == 'success') {

                        window.location.href = "./?page=emergency/list";
                    } else {
                        alert("An error occurred: " + resp.msg);
                    }
                }
            });
        });
    });
</script>