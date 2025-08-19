<?php
// Fetch policy from system_info table
$policy_qry = $conn->query("SELECT meta_value FROM system_info WHERE meta_field = 'policy'");
if ($policy_qry->num_rows > 0) {
    $policy = $policy_qry->fetch_assoc()['meta_value'];
}
?>
<section class="page-section" id="policy">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">Tourist Guidelines & Safety Policy</h2>
            <h3 class="section-subheading text-muted">Essential Information for Your Safe and Enjoyable Visit</h3>
        </div>
        <div class="card w-100 shadow">
            <div class="card-body">
                <?php echo stripslashes(html_entity_decode($policy)) ?>
            </div>
        </div>
    </div>
</section>
<!-- Footer -->
<footer class="bg-dark text-center text-white py-4">
    <div class="container">
        <p class="m-0">&copy; <?php echo date('Y'); ?> Tupi Tourist Information Hub. All Rights Reserved.</p>
        <a href="./?page=policy" class="text-warning">Tourist Guidelines & Safety Policy</a>
    </div>
</footer>