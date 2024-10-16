<?php

security_check();
admin_check();

define('APP_NAME', 'Events');

define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'community');
define('PAGE_SELECTED_SUB_PAGE', '/radio/dashboard');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');
// debug_pre(generateContent(4));
// Prepare and execute the query to fetch broadcasts
$broadcasts = get_segments_data_by_schedule_5();
// debug_pre($broadcasts);
?>

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/radio.png"
        height="50"
        style="vertical-align: top" />
    Radio
</h1>

<p>
    <a href="/city/dashboard">Dashboard</a> /
    Radio
</p>

<hr>

<h2>Radio Station</h2>

<img src="https://www.lego.com/cdn/cs/set/assets/blt13be82b8c836289b/10334_alt1.png?format=webply&fit=bounds&quality=60&width=800&height=800&dpr=2" alt="Radio-Image" width="300px" style="margin-bottom: 20px;">

<br>
<div class="btn" style=" margin-left: 10px; font-size: 20px; ">
    <button class="w3-button w3-teal" id="playRadio" onclick="playRadio()">
        <i class="fas fa-play button-icon"></i>
    </button>
    <button class="w3-button w3-red" id="pauseRadio" onclick="pauseRadio()">
        <i class="fas fa-pause button-icon"></i>
    </button>
</div>

<hr>

<h2>Upcoming Broadcasts</h2>

<table class="w3-table w3-striped w3-bordered">
    <thead>
        <tr>
            <th>Time</th>
            <th>Title</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($broadcasts as $broadcast): ?>
            <tr>
                <td><?= htmlspecialchars($broadcast['time']) ?></td>
                <td><?= htmlspecialchars($broadcast['title']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a
    href="/Radio/schedule"
    class="w3-button w3-white w3-border w3-margin-top">
    <i class="fa-solid fa-pen-to-square fa-padding-right"></i> Broadcasting Schedule Edit
</a>
<hr>
<div
    class="w3-row-padding"
    style="margin-left: -16px; margin-right: -16px">
    <div class="w3-half">
        <div class="w3-card">
            <header class="w3-container w3-grey w3-padding w3-text-white">
                <i class="bm-brix"></i> Uptime Status
            </header>
            <div class="w3-container w3-padding">Uptime Status Summary</div>
            <footer class="w3-container w3-border-top w3-padding">
                <a
                    href="/uptime/radio"
                    class="w3-button w3-border w3-white">
                    <i class="fa-regular fa-file-lines fa-padding-right"></i>
                    Full Report
                </a>
            </footer>
        </div>
    </div>
    <div class="w3-half">
        <div class="w3-card">
            <header class="w3-container w3-grey w3-padding w3-text-white">
                <i class="bm-brix"></i> Stat Summary
            </header>
            <div class="w3-container w3-padding">App Statistics Summary</div>
            <footer class="w3-container w3-border-top w3-padding">
                <a
                    href="/stats/radio"
                    class="w3-button w3-border w3-white">
                    <i class="fa-regular fa-chart-bar fa-padding-right"></i> Full Report
                </a>
            </footer>
        </div>
    </div>
</div>

<script>
    // Global audio variable
    var audio = null;

    function playRadio() {
        console.log('Attempting to play radio...');
        // Check if audio is defined and not paused (i.e., it's already playing)
        if (audio && !audio.paused) {
            console.log('Audio is already playing.');
            return; // Stop here if audio is playing
        }

        // If audio hasn't been loaded yet, fetch and initialize it
        if (!audio) {
            console.log('Fetching new audio...');
            fetch('/api/radio/logs', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.blob())
            .then(blob => {
                var url = window.URL.createObjectURL(blob);
                audio = new Audio(url);
                audio.play();
                audio.onended = function() {
                    console.log('Audio finished playing.');
                    audio = null; // Reset audio after it finishes playing
                };
            })
            .catch(error => console.error('Error fetching or playing the radio:', error));
        } else {
            // Audio is loaded but was paused, so just play it
            console.log('Resuming audio...');
            audio.play();
        }
    }

    function pauseRadio() {
        if (audio && !audio.paused) {
            console.log('Pausing radio...');
            audio.pause();
        } else {
            console.log('No audio is playing to pause.');
        }
    }

    function selectCharacter(characterId) {
        console.log('Character selected:', characterId);
        document.getElementById('characterModal').style.display = 'none';
    }
</script>

<?php

include('../templates/modal_city.php');
include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
