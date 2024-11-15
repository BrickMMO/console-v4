<?php

security_check();
admin_check();

if(
    !isset($_GET['key']) || 
    !is_numeric($_GET['key']) || 
    !tag_fetch($_GET['key']))
{
    message_set('Track Error', 'There was an error with the provided track.');
    header_redirect('/trackview/tracks');
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    // Basic serverside validation
    if (!validate_blank($_POST['name']))
    {

        message_set('Track Error', 'There was an error with the provided track.', 'red');
        header_redirect('/admin/media/tags');
    }
    
    $query = 'UPDATE tracks SET
        name = "'.addslashes($_POST['name']).'",
        updated_at = NOW()
        WHERE id = '.$_GET['key'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    message_set('Track Success', 'Your track has been edited.');
    header_redirect('/trackview/tracks');
    
}

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

        <div class="w3-cell w3-border w3-<?php echo square_colour($squares[$row][$col]['id'], array('track_id'=> $_GET['key']))?>" 
            style="width: <?=$width?>%; height: 35px; cursor: pointer;"
            data-id="<?=$squares[$row][$col]['id']?>"
            data-type="<?=$squares[$row][$col]['type']?>"
            data-track-id="<?=$squares[$row][$col]['track_id'] == $_GET['key']?>"
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
    let track_id = target.dataset.track_id;
    let key = <?=$_GET['key']?>;

    console.log(track_id);

    if(type == "ground")
    {

        if(track_id == key)
        {
            target.classList.remove("w3-dark-grey");
            target.classList.add("w3-brown");

            target.dataset.track_id = 0;
        }
        else
        {
            target.classList.remove("w3-brown");
            target.classList.remove("w3-grey");
            target.classList.add("w3-dark-grey");

            target.dataset.track_id = key;
        }        
        
        fetch('/ajax/square/track',{
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({id: id, track_id: target.dataset.track_id})
        });
    }
}

</script>
    

<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
