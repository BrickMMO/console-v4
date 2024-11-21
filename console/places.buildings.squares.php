<?php

security_check();
admin_check();

define('APP_NAME', 'Places');

define('PAGE_TITLE','Edit Building');
define('PAGE_SELECTED_SECTION', 'geography');
define('PAGE_SELECTED_SUB_PAGE', '/places/buildings');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

$building = building_fetch($_GET['key']);
$squares = squares_fetch_all($_city['id']);
$width = round(100/$_city['width'],2);

?>

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/places.png"
        height="50"
        style="vertical-align: top"
    />
    Places
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    <a href="/places/dashboard">Places</a> / 
    <a href="/places/buildings">Buildings</a> / 
    Building Squares
</p>

<hr />

<h2>Building Squares: <?=$building['name']?></h2>

<?php for($row = 0; $row < $_city['height']; $row ++): ?>

<div class="w3-cell-row">

    <?php for($col = 0; $col < $_city['width']; $col ++): ?>

        <div class="w3-cell w3-border w3-<?=square_colour($squares[$row][$col]['id'], array('building_id'=> $_GET['key']))?>" 
            style="width: <?=$width?>%; height: 35px; cursor: pointer;"
            data-id="<?=$squares[$row][$col]['id']?>"
            data-type="<?=$squares[$row][$col]['type']?>"
            data-building="<?=$squares[$row][$col]['building_id'] && $_GET['key'] == $squares[$row][$col]['building_id'] ? 'true' : 'false'?>"
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
    let building = target.dataset.building;
    let key = <?=$_GET['key']?>;

    if(type == "ground")
    {

        if(building == "true")
        {
            target.classList.remove("w3-red");
            target.classList.add("w3-brown");
            target.dataset.building = "false";
            building = "false";
        }
        else
        {
            target.classList.remove("w3-brown");
            target.classList.add("w3-red");
            target.dataset.building = "true";
            building = "true";
        }        
        
        fetch('/ajax/square/building',{
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({id: id, building_id: key, building: building})
        });
    }
}

</script>
    

<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');