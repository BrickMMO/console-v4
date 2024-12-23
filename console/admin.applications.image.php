<?php

use \WideImage\WideImage;

security_check();

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    
    // Basic serverside validation
    if (
        !validate_image($_FILES['image']))
    {
        message_set('Image Upload Error', 'There was an error with your uploaded image.', 'red');
        header_redirect('/admin/applications/dashboard');
    }

    $image = Wideimage::load($_FILES['image']['tmp_name']);
    $image = $image->resize(400, 400, 'inside');
    $image = $image->crop('center', 'center', 400, 400);
    $image = 'data:image/png;base64, '.base64_encode($image->asString('png'));

    $query = 'UPDATE applications SET
        image = "'.addslashes($image).'"
        WHERE id = '.$_GET['key'].' 
        LIMIT 1';
    mysqli_query($connect, $query);

    message_set('Image Upload Success', 'Your image has been updated.');
    header_redirect('/admin/applications/dashboard');
    
}

define('APP_NAME', 'Setting');
define('PAGE_TITLE', 'Edit Application');
define('PAGE_SELECTED_SECTION', 'admin-settings');
define('PAGE_SELECTED_SUB_PAGE', '/admin/applications/dashboard');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

$application = application_fetch($_GET['key']);

?>

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/bricksum.png"
        height="50"
        style="vertical-align: top"
    />
    Applications
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    <a href="/admin/applications/dashboard">Applications</a> / 
    Edit Application
</p>

<hr />

<h2>Edit Application: <?=$application['name']?></h2>

<?php if($application['image']): ?>
    <img src="<?=$application['image']?>" class="w3-padding w3-border w3-margin-bottom" width="400">
<?php endif; ?>

<p>The application image must be a jpg, png, or gif. Images will be resized and cropped to 400 x 400.</p>

<form
    enctype="multipart/form-data"
    method="post"
    novalidate
    id="main-form"
>

    <input  
        name="image" 
        class="w3-input w3-border" 
        type="file" 
        id="image" 
        autocomplete="off"
    />

    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top">
        <i class="fa-solid fa-pen fa-padding-right"></i>
        Update Image
    </button>
</form>
    
<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
