<?php

use \WideImage\WideImage;

security_check();
admin_check();

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    // Basic serverside validation
    if (
        !validate_blank($_POST['track_id']))
    {
        message_set('Square Error', 'There was an error with your square information.', 'red');
        header_redirect('/maps/square/'.$_GET['key']);
    }

    $query = 'UPDATE squares SET
        track_rules = "'.addslashes($_POST['track_rules']).'"
        WHERE id = '.$_GET['key'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    foreach($_FILES as $key => $value)
    {
        if(in_array($value['type'], FILE_TYPES_IMAGES))
        {
            $query = 'DELETE FROM square_images
                WHERE square_id = "'.$_GET['key'].'"
                AND direction = "'.$key.'"';
            mysqli_query($connect, $query);

            $image = Wideimage::load($_FILES[$key]['tmp_name']);
            $image = $image->resize(1920, 1080, 'outside');
            $image = $image->crop('center', 'center', 1920, 1080);
            $image = 'data:image/jpeg;base64, '.base64_encode($image->asString('jpg'));
        
            $query = 'INSERT INTO square_images (
                    square_id,
                    image,
                    direction,
                    created_at,
                    updated_at
                ) VALUES (
                    "'.$_GET['key'].'",
                    "'.addslashes($image).'",
                    "'.$key.'",
                    NOW(),
                    NOW()
                )';
            mysqli_query($connect, $query);
        }
    }   

    $query = 'DELETE FROM square_track
        WHERE square_id = "'.$_GET['key'].'"';
    mysqli_query($connect, $query);

    foreach($_POST['track_id'] as $value)
    {
        $query = 'INSERT INTO square_track (
                track_id,
                square_id
            ) VALUES (
                "'.$value.'",
                "'.$_GET['key'].'"
            )';
        mysqli_query($connect, $query);
    }

    message_set('Square Success', 'Square has been updated.');
    // header_redirect('/trackview/square/'.$_GET['key']);
    header_redirect('/trackview/dashboard');
    
}
elseif(isset($_GET['delete']))
{

    $query = 'DELETE FROM square_images 
        WHERE square_id = "'.$_GET['key'].'"
        AND direction = "'.$_GET['delete'].'"
        LIMIT 1';
    mysqli_query($connect, $query);
    
    message_set('Square Image Success', 'Square image has been updated.');
    header_redirect('/trackview/square/'.$_GET['key']);

}

define('APP_NAME', 'Maps');

define('PAGE_TITLE', 'Modify Map Squares');
define('PAGE_SELECTED_SECTION', 'geography');
define('PAGE_SELECTED_SUB_PAGE', '/maps/squares');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

$square = square_fetch($_GET['key']);

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
    Modify Track Square
</p>
<hr />
<h2>Modify Track Square</h2>

<form
    method="post"
    novalidate
    id="main-form"
    enctype="multipart/form-data"
>

    <?=form_select_table('track_id', 'tracks', 'id', 'name', array('multiple' => true, 'selected' => $square['tracks'], 'first' => true))?>
    <label for="track_id" class="w3-text-gray">
        Track <span id="track-id-error" class="w3-text-red"></span>
    </label>

    <input  
        name="track_rules" 
        class="w3-input w3-border w3-margin-top" 
        type="text" 
        id="track_rules" 
        value="<?=$square['track_rules']?>"
    />
    <label for="track_rules" class="w3-text-gray">
        Track Rules <span id="track-rules-error" class="w3-text-red"></span>
    </label>

    <?php foreach(DIRECTIONS as $direction): ?>

        <?php if(isset($square[$direction])): ?>
            <div class="w3-margin-top">
                <img src="<?=$square[$direction]?>" style="max-width:300px" />
            </div>
            <div class="w3-margin-top">
                <a href="#" onclick="return confirmModal('Are you sure you want to delete this image?', '/trackview/square/delete/<?=$direction?>/<?=$_GET['key']?>');">
                    <i class="fa-solid fa-trash-can"></i> Delete Image
                </a>
            </div>
        <?php endif; ?>

        <input  
            name="<?=$direction?>"
            class="w3-input w3-border w3-margin-top" 
            type="file" 
            id="<?=$direction?>" 
            autocomplete="off"
        />
        <label for="<?=$direction?>" class="w3-text-gray">
            <?=ucfirst($direction)?> Photo
        </label>

    <?php endforeach; ?>

    

    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top" onclick="return validateMainForm();">
        <i class="fa-solid fa-pen fa-padding-right"></i>
        Update Square
    </button>
</form>

<script>

    function validateMainForm() {
        let errors = 0;

        let type = document.getElementById("type");
        let type_error = document.getElementById("type-error");
        type_error.innerHTML = "";
        if (type.value == "") {
            type_error.innerHTML = "(type is required)";
            errors++;
        }

        if (errors) return false;
    }

</script>

    
<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
