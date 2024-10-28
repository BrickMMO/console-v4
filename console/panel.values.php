<?php

security_check();
admin_check();

// Check if form is submitted to update the panel values
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{

    $error = false;

    foreach ($_POST['panels'] as $panel_id => $values) 
    {
        $new_value = $values['value'];

        // Basic server-side validation
        if (!strlen($new_value) || !panels_update_value($panel_id, $new_value)) 
        {
            $error = true;
            break;
        }
    }

    if ($error) 
    {
        message_set('Panel update Error', 'There was an error saving your panel values', 'red');
    } 
    else 
    {
        message_set('Update Success', 'Panel values updated successfully!', 'green', true);
    }

    header_redirect('/panel/values');
    exit();
}

// Fetch panel data for the current city
$panel_data = panels_data_by_city($_city['id']);

if(!count($panel_data))
{
    message_set('Panel Error', 'This city does not yet have a panel initiated.', 'red');
    header_redirect('/panel/new');
}


define('APP_NAME', 'Panels');

define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'control');
define('PAGE_SELECTED_SUB_PAGE', '/panel/values');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

// Group panel data by cartridge and port using the function
list($power_lever, $current_cartridge, $cartridge_data) = panels_group_data_by_cartridge($panel_data);

?>

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/control-panel.png"
        height="50"
        style="vertical-align: top" />
    Control Panel
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> /
    <a href="/panel/dashboard">Control Panel</a> /
    Modify Values
</p>

<hr>

<h2>Modify Panel Values</h2>

<form method="post" action="">
    <p style="display:flex; align-items: center">
        Power Lever:
        <select name="panels[<?= $power_lever['id'] ?>][value]"
            class="w3-input w3-border w3-margin-left w3-quarter">
            <option value="ON" <?= $power_lever['value'] == 'ON' ? 'selected' : '' ?>>ON</option>
            <option value="OFF" <?= $power_lever['value'] == 'OFF' ? 'selected' : '' ?>>OFF</option>
        </select>
    </p>
    <p style="display:flex; align-items: center">
        Current Cartridge:
        <select name="panels[<?= $current_cartridge['id'] ?>][value]" class="w3-input w3-margin-left w3-border w3-quarter">
            <!-- <option value="nocolour" <?= $current_cartridge['value'] == 'nocolour' ? 'selected' : '' ?>>nocolour</option> -->
            <!-- <option value="black" <?= $current_cartridge['value'] == 'black' ? 'selected' : '' ?>>black</option> -->
            <option value="blue" <?= $current_cartridge['value'] == 'blue' ? 'selected' : '' ?>>blue</option>
            <!-- <option value="green" <?= $current_cartridge['value'] == 'green' ? 'selected' : '' ?>>green</option> -->
            <option value="yellow" <?= $current_cartridge['value'] == 'yellow' ? 'selected' : '' ?>>yellow</option>
            <option value="red" <?= $current_cartridge['value'] == 'red' ? 'selected' : '' ?>>red</option>
            <!-- <option value="white" <?= $current_cartridge['value'] == 'white' ? 'selected' : '' ?>>white</option> -->
            <option value="brown" <?= $current_cartridge['value'] == 'briwn' ? 'selected' : '' ?>>brown</option>
        </select>
    </p>

    <?php foreach ($cartridge_data as $cartridge => $ports): ?>
        <hr>
        <div>
            <p>Cartridge: <span class="w3-tag w3-<?= strtolower($cartridge) ?>"><?= $cartridge ?></span></p>
            <?php foreach ($ports as $port => $values): ?>
                <p style="display:flex; align-items: center">
                    <?php echo !is_numeric($port) ? "Motor $port" : "Switch $port"; ?>:
                    <?php foreach ($values as $panel): ?>
                        <?php if (!is_numeric($port)): ?>
                            <input type="number"
                                name="panels[<?= $panel['id'] ?>][value]"
                                value="<?= $panel['value'] ?>"
                                min="0" max="100"
                                class="w3-input w3-border w3-margin-left w3-quarter" />
                        <?php else: ?>
                            <select name="panels[<?= $panel['id'] ?>][value]"
                                class="w3-input w3-border w3-margin-left w3-quarter">
                                <option value="ON" <?= $panel['value'] == 'ON' ? 'selected' : '' ?>>ON</option>
                                <option value="OFF" <?= $panel['value'] == 'OFF' ? 'selected' : '' ?>>OFF</option>
                            </select>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </p>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>


    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top">
        <i class="fa-solid fa-pen fa-padding-right"></i>
        Save
    </button>

</form>

<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
