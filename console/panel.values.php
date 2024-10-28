<?php

security_check();
admin_check();

// Check if form is submitted to update the panel values
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error = false;
    foreach ($_POST['panels'] as $panel_id => $values) {
        $new_value = $values['value'];

        // Basic server-side validation
        if (!strlen($new_value) || !update_panel_value($panel_id, $new_value, $connect)) {
            $error = true;
            break; // Exit loop on first error
        }
    }

    if ($error) {
        message_set('Panel update Error', 'There was an error saving your panel values', 'red');
    } else {
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
            <option value="NOCOLOR" <?= $current_cartridge['value'] == 'NOCOLOR' ? 'selected' : '' ?>>NOCOLOR</option>
            <option value="BLACK" <?= $current_cartridge['value'] == 'BLACK' ? 'selected' : '' ?>>BLACK</option>
            <option value="BLUE" <?= $current_cartridge['value'] == 'BLUE' ? 'selected' : '' ?>>BLUE</option>
            <option value="GREEN" <?= $current_cartridge['value'] == 'GREEN' ? 'selected' : '' ?>>GREEN</option>
            <option value="YELLOW" <?= $current_cartridge['value'] == 'YELLOW' ? 'selected' : '' ?>>YELLOW</option>
            <option value="RED" <?= $current_cartridge['value'] == 'RED' ? 'selected' : '' ?>>RED</option>
            <option value="WHITE" <?= $current_cartridge['value'] == 'WHITE' ? 'selected' : '' ?>>WHITE</option>
            <option value="BROWN" <?= $current_cartridge['value'] == 'BROWN' ? 'selected' : '' ?>>BROWN</option>
        </select>
    </p>

    <?php foreach ($cartridge_data as $cartridge => $ports): ?>
        <hr>
        <div>
            <p>Cartridge: <span class="w3-tag w3-<?= strtolower($cartridge) ?>"><?= $cartridge ?></span></p>
            <?php foreach ($ports as $port => $values): ?>
                <p style="display:flex; align-items: center">
                    <?php echo is_numeric($port) ? "Motor $port" : "Switch $port"; ?>:
                    <?php foreach ($values as $panel): ?>
                        <?php if (is_numeric($port)): ?>
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

    <button type="submit" class="w3-block w3-btn w3-orange w3-text-white w3-margin-bottom w3-margin-top w3-half">
        <i class="fa-solid fa-save fa-padding-right"></i>
        Save Panel Changes
    </button>
</form>

<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
