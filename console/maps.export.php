<?php

security_check();
admin_check();

define('APP_NAME', 'Maps');

define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'geography');
define('PAGE_SELECTED_SUB_PAGE', '/maps/dashboard');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

$squares = squares_fetch_all($_city['id']);
$width = round(100/$_city['width'],2);

?>


<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/bricksum.png"
        height="50"
        style="vertical-align: top"
    />
    Maps
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    <a href="/maps/dashboard">Maps</a> / 
    Export Seeder
</p>
<hr>

<textarea name="seeder" id="seeder" class="w3-input w3-border w3-margin-bottom" rows="20"><?=city_seeder($_city['id'])?></textarea>
<button class="w3-block w3-btn w3-orange w3-text-white w3-margin-bottom w3-margin-top" onclick="copySeeder();">
    <i class="fa-solid fa-copy fa-padding-right"></i>
    Copy Seeder
</button>

<script>

    function copySeeder() {
        let seeder = document.getElementById("seeder");
        seeder.select();
        document.execCommand('copy');
        window.getSelection().removeAllRanges()
    }

</script>

<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
