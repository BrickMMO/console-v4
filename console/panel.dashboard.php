<?php

security_check();
admin_check();

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
define('PAGE_SELECTED_SUB_PAGE', '/panel/dashboard');

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
    Control Panel
</p>

<hr>

<?php debug_pre($cartridge_data); ?>
<?php debug_pre($current_cartridge); ?>

<div class="w3-row">
    <div class="w3-col w3-center s12 m12 l12" style="border:9px solid black; background-color:#D9D9D9">
        <div class="w3-margin-top w3-row-padding"
            style="display: flex; align-items:flex-end; justify-content:center;">
            <div class="w3-col w3-center s2 m2 l2">
                <img src="/images/panel_<?= strtolower($power_lever['value']) ?>.png" alt="Panel Dial" width="100px">
                <span class="w3-text-black">
                    Power Lever
                </span>
            </div>
            <div class="w3-col w3-center s3 m3 l3">
                <img id="dial-B" src="/images/panel_dial.png" alt="Panel Dial" width="100px"
                    style="transform: rotate(calc(<?= $cartridge_data[$current_cartridge['value']]['b'][0]['value'] ?>* 2.7deg));">
                <div class="w3-light-grey w3-tiny w3-margin-top">
                    <div id="progress-B" class="w3-container w3-orange w3-text-white w3-center"
                        style="width:<?= $cartridge_data[$current_cartridge['value']]['b'][0]['value'] ?>%">
                        <?= $cartridge_data[$current_cartridge['value']]['b'][0]['value'] ?>%
                    </div>
                </div>
                <span class="w3-text-black">
                    Motor B
                </span>
            </div>
            <div class="w3-col w3-center s3 m3 l3">
                <img id="dial-C" src="/images/panel_dial.png" alt="Panel Dial" width="100px"
                    style="transform: rotate(calc(<?= $cartridge_data[$current_cartridge['value']]['c'][0]['value'] ?>* 2.7deg));">
                <div class="w3-light-grey w3-tiny w3-margin-top">
                    <div id="progress-C" class="w3-container w3-orange w3-text-white w3-center"
                        style="width:<?= $cartridge_data[$current_cartridge['value']]['c'][0]['value'] ?>%">
                        <?= $cartridge_data[$current_cartridge['value']]['c'][0]['value'] ?>%
                    </div>
                </div>
                <span class="w3-text-black">
                    Motor C
                </span>
            </div>
            <div class="w3-col w3-center s3 m3 l3">
                <img id="dial-D" src="/images/panel_dial.png" alt="Panel Dial" width="100px"
                    style="transform: rotate(calc(<?= $cartridge_data[$current_cartridge['value']]['d'][0]['value'] ?>* 2.7deg));">
                <div class="w3-light-grey w3-tiny w3-margin-top">
                    <div id="progress-D" class="w3-container w3-orange w3-text-white w3-center"
                        style="width:<?= $cartridge_data[$current_cartridge['value']]['d'][0]['value'] ?>%">
                        <?= $cartridge_data[$current_cartridge['value']]['d'][0]['value'] ?>%
                    </div>
                </div>
                <span class="w3-text-black">
                    Motor D
                </span>
            </div>
        </div>
        <div class="w3-row-padding w3-margin-bottom"
            style="display: flex; align-items:center; margin-top:32px">
            <div class="w3-col w3-center s3 m3 l3">
                <select id="cartridge-select"
                    class="w3-<?= strtolower($current_cartridge['value']) ?>"
                    style="border:15px solid black; width:100%; height:90px;">
                    <?php foreach ($cartridge_data as $cartridge => $data): ?>
                        <option class="w3-<?= strtolower($cartridge) ?>" value="<?= $cartridge ?>" <?= $current_cartridge['value'] == $cartridge ? 'selected' : '' ?>>
                            <?= $cartridge ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <span class="w3-text-black">
                    Cartridge
                </span>
            </div>
            <div class="w3-col w3-center s3 m3 l3">
                <div id="switch-S2"
                    class="w3-circle <?= $cartridge_data[$current_cartridge['value']]['2'][0]['value'] == "OFF" ? "w3-red" : "w3-green" ?> w3-border w3-border-black"
                    style="display: flex; align-items:center; justify-content: center; height: 80px; width: 80px; margin: auto;">
                    <div class="w3-circle w3-white w3-border w3-border-black" style="line-height: 50px;height: 50px;width: 50px;">
                        <span class="switch-text"><?= $cartridge_data[$current_cartridge['value']]['2'][0]['value'] ?></span>
                    </div>
                </div>
                <span class="w3-text-black">
                    Switch S2
                </span>
            </div>
            <div class="w3-col w3-center s3 m3 l3">
                <div id="switch-S3"
                    class="w3-circle <?= $cartridge_data[$current_cartridge['value']]['3'][0]['value'] == "OFF" ? "w3-red" : "w3-green" ?> w3-border w3-border-black"
                    style="display: flex; align-items:center; justify-content: center; height: 80px; width: 80px; margin: auto;">
                    <div class="w3-circle w3-white w3-border w3-border-black" style="line-height: 50px;height: 50px;width: 50px;">
                        <span class="switch-text"><?= $cartridge_data[$current_cartridge['value']]['3'][0]['value'] ?></span>
                    </div>
                </div>
                <span class="w3-text-black">
                    Switch S3
                </span>
            </div>
            <div class="w3-col w3-center s3 m3 l3">
                <div id="switch-S4"
                    class="w3-circle <?= $cartridge_data[$current_cartridge['value']]['4'][0]['value'] == "OFF" ? "w3-red" : "w3-green" ?> w3-border w3-border-black"
                    style="display: flex; align-items:center; justify-content: center; height: 80px; width: 80px; margin: auto;">
                    <div class="w3-circle w3-white w3-border w3-border-black" style="line-height: 50px;height: 50px;width: 50px;">
                        <span class="switch-text"><?= $cartridge_data[$current_cartridge['value']]['4'][0]['value'] ?></span>
                    </div>
                </div>
                <span class="w3-text-black">
                    Switch S4
                </span>
            </div>
        </div>
    </div>
</div>

<hr>

<a
    href="/panel/values"
    class="w3-button w3-white w3-border"
>
    <i class="fa-solid fa-download"></i> Modify Values
</a>

<script>
    // Assuming $cartridge_data is available globally through PHP
    const cartridgeData = <?= json_encode($cartridge_data) ?>;

    document.getElementById('cartridge-select').addEventListener('change', function() {
        const selectedCartridge = this.value;

        // Update the class of the select element based on the current cartridge
        const selectElement = document.getElementById('cartridge-select');
        const colorClasses = ['w3-gray', 'w3-black', 'w3-blue', 'w3-green', 'w3-yellow', 'w3-red', 'w3-white', 'w3-brown'];

        // Remove existing color classes
        colorClasses.forEach(cls => selectElement.classList.remove(cls));

        // Add the new class based on the selected cartridge
        selectElement.classList.add(`w3-${selectedCartridge.toLowerCase()}`);

        if (cartridgeData[selectedCartridge]) {

            // Update the dial values
            const portBValue = cartridgeData[selectedCartridge]['b'][0]['value'];
            const portCValue = cartridgeData[selectedCartridge]['c'][0]['value'];
            const portDValue = cartridgeData[selectedCartridge]['g'][0]['value'];

            // Update dials based on new selected values
            document.getElementById('dial-B').style.transform = `rotate(calc(${portBValue} * 2.7deg))`;
            document.getElementById('dial-C').style.transform = `rotate(calc(${portCValue} * 2.7deg))`;
            document.getElementById('dial-D').style.transform = `rotate(calc(${portDValue} * 2.7deg))`;

            // Update progress bars based on new selected values
            document.getElementById('progress-B').style.width = `${portBValue}%`;
            document.getElementById('progress-B').innerText = `${portBValue}%`;

            document.getElementById('progress-C').style.width = `${portCValue}%`;
            document.getElementById('progress-C').innerText = `${portCValue}%`;

            document.getElementById('progress-D').style.width = `${portDValue}%`;
            document.getElementById('progress-D').innerText = `${portDValue}%`;

            // Handle switches (S2, S3, S4)
            const switchS2Value = cartridgeData[selectedCartridge]['2'][0]['value'];
            const switchS3Value = cartridgeData[selectedCartridge]['3'][0]['value'];
            const switchS4Value = cartridgeData[selectedCartridge]['4'][0]['value'];

            // Update Switch S2
            const switchS2Element = document.querySelector('#switch-S2');
            switchS2Element.classList.toggle('w3-green', switchS2Value === 'ON');
            switchS2Element.classList.toggle('w3-red', switchS2Value === 'OFF');
            switchS2Element.querySelector('.switch-text').innerText = switchS2Value;

            // Update Switch S3
            const switchS3Element = document.querySelector('#switch-S3');
            switchS3Element.classList.toggle('w3-green', switchS3Value === 'ON');
            switchS3Element.classList.toggle('w3-red', switchS3Value === 'OFF');
            switchS3Element.querySelector('.switch-text').innerText = switchS3Value;

            // Update Switch S4
            const switchS4Element = document.querySelector('#switch-S4');
            switchS4Element.classList.toggle('w3-green', switchS4Value === 'ON');
            switchS4Element.classList.toggle('w3-red', switchS4Value === 'OFF');
            switchS4Element.querySelector('.switch-text').innerText = switchS4Value;
        }
    });
</script>
<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
