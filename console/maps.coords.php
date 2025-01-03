<?php

security_check();
admin_check();

define('APP_NAME', 'Maps');

define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'geography');
define('PAGE_SELECTED_SUB_PAGE', '/maps/quick');

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
    Simulate Coords
</p>
<hr>

<?php for($row = 0; $row < $_city['height']; $row ++): ?>

<div class="w3-cell-row">

    <?php for($col = 0; $col < $_city['width']; $col ++): ?>

        <div class="w3-cell w3-border w3-<?=square_colour($squares[$row][$col]['id'], array('coords' => true))?>" 
            style="width: <?=$width?>%; height: 35px; cursor: pointer"
            data-id="<?=$squares[$row][$col]['id']?>"
            data-type="<?=$squares[$row][$col]['type']?>"
            data-coord="<?=(count($squares[$row][$col]['coords'])) ? 'true' : 'false'?>"
            onclick="editSquareCoord(this);">
        </div>

    <?php endfor; ?>    

</div>

<?php endfor; ?>

<script>

function editSquareCoord(target)
{
    let id = target.dataset.id;
    let type = target.dataset.type;
    let coord = target.dataset.coord;

    if(type == "ground")
    {

        if(coord == "true")
        {
            target.classList.remove("w3-red");
            target.classList.add("w3-brown");
            target.dataset.coord = "false";
            coord = "false";
        }
        else
        {
            target.classList.remove("w3-brown");
            target.classList.add("w3-red");
            target.dataset.coord = "true";
            coord = "true";
        }        
        
        fetch('/ajax/square/coord',{
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({id: id, coord: coord})
        });
    }
}

</script>
    

<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
