<?php

security_check();
admin_check();

define('APP_NAME', 'Track View');

define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'geography');
define('PAGE_SELECTED_SUB_PAGE', '/trackview/dashboard');

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
        src="https://cdn.brickmmo.com/icons@1.0.0/trackview.png"
        height="50"
        style="vertical-align: top"
    />
    Track View
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    Track View
</p>
<hr>

<?php for($row = 0; $row < $_city['height']; $row ++): ?>

    <div class="w3-cell-row">

        <?php for($col = 0; $col < $_city['width']; $col ++): ?>

            <div class="w3-cell w3-border w3-<?=square_colour($squares[$row][$col]['id'], array('tracks' => true))?> w3-text-white" 
                style="width: <?=$width?>%; height: 35px; cursor: pointer; text-align: center; vertical-align: middle; font-size: 60%;"
                onclick="location.href='/trackview/square/<?=$squares[$row][$col]['id']?>';">

                <?php if(count($squares[$row][$col]['tracks']) and $squares[$row][$col]['images'] < 4): ?>
                    <i class="fa-solid fa-triangle-exclamation"></i>
                <?php endif; ?>
                <?php if(count($squares[$row][$col]['tracks']) and !$squares[$row][$col]['track_rules']): ?>
                    <i class="fa-solid fa-arrow-turn-up"></i>
                <?php endif; ?>

            </div>

        <?php endfor; ?>    

    </div>

<?php endfor; ?>

<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
