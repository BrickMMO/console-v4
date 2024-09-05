<?php

security_check();
admin_check();

define('APP_NAME', 'Stores');

define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'admin-content');
define('PAGE_SELECTED_SUB_PAGE', '/stores/dashboard');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

$query = 'SELECT * 
    FROM countries 
    ORDER BY id';    
$result = mysqli_query($connect, $query);

$countries_count = mysqli_num_rows($result);

$query = 'SELECT * 
    FROM stores 
    ORDER BY id';    
$result = mysqli_query($connect, $query);

$stores_count = mysqli_num_rows($result);

$stores_last_import = setting_fetch('STORES_LAST_IMPORT');

?>

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/stores.png"
        height="50"
        style="vertical-align: top"
    />
    Stores
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    Stores
</p>

<hr>

<p>
    Number of stores imported: <span class="w3-tag w3-blue"><?=$stores_count?></span> 
</p>
<p>
    Last import: <span class="w3-tag w3-blue"><?=(new DateTime($stores_last_import))->format("D, M j g:i A")?></span>
</p>

<hr />

<h2>Store List</h2>

<?php if(!$countries_count): ?>

    <p>
        Country data has not yet been imported, initiate country import from
        <a href="http://country.io/names.json">Country.io</a>.
    </p>

<?php elseif(!$stores_count): ?>

    <p>
        Store data has not yet been imported, initiate store import from the
        <a href="https://www.lego.com/en-ca/stores">official LEGO® Store list</a>.
    </p>

<?php else: ?>

    <table class="w3-table w3-bordered w3-striped w3-margin-bottom">
        <tr>
            <th>Name</th>
            <th>URL</th>
        </tr>

        <?php while($record = mysqli_fetch_assoc($result)): ?>

            <?php $json = json_decode($record['json'], true); ?>
            
            <tr>
                <td>
                    <?=$record['name']?>
                    <small>
                        <br>
                        Country: <?=$json['country']?>
                        <br>
                        City: <?=$json['city']?>
                    </small>
                </td>
                <td>
                    <?php if($json['storeUrl'] != 'store.default.url'): ?>
                        <a href="<?=$json['storeUrl']?>" target="_blank"><?=$json['storeUrl']?></a>
                    <?php endif; ?>
                </td>
            </tr>

        <?php endwhile; ?>

    </table>

<?php endif; ?>

<a
    href="/stores/import"
    class="w3-button w3-white w3-border"
>
    <i class="fa-solid fa-download"></i> Import Stores
</a>

<a
    href="/stores/countries"
    class="w3-button w3-white w3-border"
>
    <i class="fa-solid fa-download"></i> Import Countries
</a>

<hr />

<div
    class="w3-row-padding"
    style="margin-left: -16px; margin-right: -16px"
>
    <div class="w3-half">
        <div class="w3-card">
            <header class="w3-container w3-grey w3-padding w3-text-white">
                <i class="bm-stores"></i> Uptime Status
            </header>
            <div class="w3-container w3-padding">Uptime Status Summary</div>
            <footer class="w3-container w3-border-top w3-padding">
                <a
                    href="/uptime/stores"
                    class="w3-button w3-border w3-white"
                >
                    <i class="fa-regular fa-file-lines fa-padding-right"></i>
                    Full Report
                </a>
            </footer>
        </div>
    </div>
    <div class="w3-half">
        <div class="w3-card">
            <header class="w3-container w3-grey w3-padding w3-text-white">
                <i class="bm-stores"></i> Stat Summary
            </header>
            <div class="w3-container w3-padding">App Statistics Summary</div>
            <footer class="w3-container w3-border-top w3-padding">
                <a
                    href="/stats/stores"
                    class="w3-button w3-border w3-white"
                >
                    <i class="fa-regular fa-chart-bar fa-padding-right"></i> Full Report
                </a>
            </footer>
        </div>
    </div>
</div>

<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
