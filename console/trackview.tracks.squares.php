<?php

security_check();
admin_check();

define('APP_NAME', 'Track View');

define('PAGE_TITLE','Edit Track');
define('PAGE_SELECTED_SECTION', 'geography');
define('PAGE_SELECTED_SUB_PAGE', '/trackview/tracks');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

$track = track_fetch($_GET['key']);
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
    <a href="/trackview/dashboard">Track View</a> / 
    <a href="/trackview/tracks">Tracks</a> / 
    Track Squares
</p>

<hr />

<h2>Track Squares: <?=$track['name']?></h2>

<?php for($row = 0; $row < $_city['height']; $row ++): ?>

<div class="w3-cell-row">

    <?php for($col = 0; $col < $_city['width']; $col ++): ?>

        <div class="w3-cell w3-border w3-<?=square_colour($squares[$row][$col]['id'], array('track_id'=> $_GET['key']))?>" 
            style="width: <?=$width?>%; height: 35px; cursor: pointer;"
            data-id="<?=$squares[$row][$col]['id']?>"
            data-type="<?=$squares[$row][$col]['type']?>"
            data-track="<?=(is_array($squares[$row][$col]['tracks']) and in_array($_GET['key'], $squares[$row][$col]['tracks'])) ? 'true' : 'false'?>"
            onclick="editSquareType(this);">
        </div>

    <?php endfor; ?>    

</div>

<?php endfor; ?>

<script>

function editSquareType(target)
{
    let id = target.dataset.id;
    let type = target.dataset.type;
    let track = target.dataset.track;
    let key = <?=$_GET['key']?>;

    if(type == "ground")
    {

        if(track == "true")
        {
            target.classList.remove("w3-red");
            target.classList.add("w3-brown");
            target.dataset.track = "false";
            track = "false";
        }
        else
        {
            target.classList.remove("w3-brown");
            target.classList.add("w3-red");
            target.dataset.track = "true";
            track = "true";
        }        
        
        fetch('/ajax/square/track',{
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({id: id, track_id: key, track: track})
        });
    }
}

</script>
    

<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
