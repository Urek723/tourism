<?php

$query = "SELECT * FROM emergency_contacts WHERE status = 1 ORDER BY name ASC";
$result = $conn->query($query);

$emergency_contacts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $emergency_contacts[] = $row;
    }
}

$conn->close();
?>

<section class="page-section" id="emergency_contacts">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">Emergency Contacts</h2>
            <h3 class="section-subheading text-muted">Important contacts for your safety and convenience</h3>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title m-0">Emergency Contact Numbers</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <?php foreach ($emergency_contacts as $contact) : ?>
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1"><?php echo $contact['name']; ?></h5>
                                    </div>
                                    <p class="mb-1">
                                        <strong>Phone:</strong> <?php echo $contact['phone_number']; ?><br>
                                        <?php if (!empty($contact['address'])) : ?>
                                            <strong>Address:</strong> <?php echo $contact['address']; ?><br>
                                        <?php endif; ?>
                                        <?php if (!empty($contact['description'])) : ?>
                                            <strong>Info:</strong> <?php echo $contact['description']; ?>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title m-0">Emergency Locations Map</h5>
                    </div>
                    <div class="card-body">
                        <div id="map" style="height: 500px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    var contactLocations = <?php echo json_encode($emergency_contacts); ?>;

    function initMap() {
        // Center on Tupi if no contacts or first contact has no coordinates
        var centerLat = 6.3333;
        var centerLng = 124.9500;

        if (contactLocations.length > 0 && contactLocations[0].lat && contactLocations[0].lng) {
            centerLat = parseFloat(contactLocations[0].lat);
            centerLng = parseFloat(contactLocations[0].lng);
        }

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: {
                lat: centerLat,
                lng: centerLng
            }
        });

        // Add markers for each contact
        contactLocations.forEach(function(contact) {
            if (contact.lat && contact.lng) {
                var marker = new google.maps.Marker({
                    position: {
                        lat: parseFloat(contact.lat),
                        lng: parseFloat(contact.lng)
                    },
                    map: map,
                    title: contact.name
                });

                var infoContent = '<div>' +
                    '<h5>' + contact.name + '</h5>' +
                    '<p><strong>Phone:</strong> ' + contact.phone_number + '</p>';

                if (contact.address) {
                    infoContent += '<p><strong>Address:</strong> ' + contact.address + '</p>';
                }

                if (contact.description) {
                    infoContent += '<p><strong>Info:</strong> ' + contact.description + '</p>';
                }

                infoContent += '</div>';

                var infowindow = new google.maps.InfoWindow({
                    content: infoContent
                });

                marker.addListener('click', function() {
                    infowindow.open(map, marker);
                });
            }
        });
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAOVYRIgupAurZup5y1PRh8Ismb1A3lLao&q=&callback=initMap">
</script>