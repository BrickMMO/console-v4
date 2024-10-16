<?php

security_check();
admin_check();

// Fetch segments for the dropdown
$segmentsStmt = "SELECT id, name FROM Segments ORDER BY name ASC";
$result = mysqli_query($connect, $segmentsStmt);
$segments = [];
while ($row = mysqli_fetch_assoc($result)) {
    $segments[] = $row;
}
// debug_pre($segments);


// Add, Edit, Delete the broadcast
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $segment_id = $_POST['segment_id'];
    $content = generateContent($segment_id);

    $timeInput = $_POST['hour'] . ':' . $_POST['minute'] . ' ' . $_POST['ampm'];
    $broadcast_time = date("Y-m-d H:i:s", strtotime($timeInput));

    // Insert into Schedule
    $scheduleQuery = "INSERT INTO Schedules (time, segment_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($connect, $scheduleQuery);
    mysqli_stmt_bind_param($stmt, 'si', $broadcast_time, $segment_id);
    mysqli_stmt_execute($stmt);

    // Insert into BroadcastLogs
    $logsQuery = "INSERT INTO Broadcast_logs (content, broadcast_time, segment_id) VALUES (?, ?, ?)";
    $logStmt = mysqli_prepare($connect, $logsQuery);
    mysqli_stmt_bind_param($logStmt, 'sss', $content, $broadcast_time, $segment_id);
    mysqli_stmt_execute($logStmt);
    header_redirect('/radio/schedule');
    exit();
} elseif (isset($_POST['edit'])) {
    debug_pre($_POST);
    $id = $_POST['id'];
    $timeInput = $_POST['hour'] . ':' . $_POST['minute'] . ' ' . $_POST['ampm'];
    $time = date("Y-m-d H:i:s", strtotime($timeInput));
    $segment_name = $_POST['title'];
    $segment_id = $_POST['segment_id'];

    // Update Schedule
    $updateScheduleQuery = "UPDATE Schedules SET time = ?, segment_id = ? WHERE id = ?";
    $updateStmt = mysqli_prepare($connect, $updateScheduleQuery);
    mysqli_stmt_bind_param($updateStmt, 'sii', $time, $segment_id, $id);
    mysqli_stmt_execute($updateStmt);

    // Update BroadcastLogs content that should change
    $updateLogsQuery = "UPDATE Broadcast_logs SET broadcast_time = ? WHERE segment_id = ?";
    $updateLogsStmt = mysqli_prepare($connect, $updateLogsQuery);
    mysqli_stmt_bind_param($updateLogsStmt, 'si', $time, $segment_id);
    mysqli_stmt_execute($updateLogsStmt);
    header_redirect('/radio/schedule');
    exit();
} elseif (isset($_POST['delete'])) {
    $id = $_POST['id'];

    
    // Delete from BroadcastLogs on the schedule
    $deleteLogsQuery = "DELETE FROM Broadcast_logs WHERE segment_id = (SELECT segment_id FROM Schedules WHERE id = ?)";
    $deleteLogsStmt = mysqli_prepare($connect, $deleteLogsQuery);
    mysqli_stmt_bind_param($deleteLogsStmt, 'i', $id);
    mysqli_stmt_execute($deleteLogsStmt);
    
    // Delete from Schedule
    $deleteScheduleQuery = "DELETE FROM Schedules WHERE id = ?";
    $deleteStmt = mysqli_prepare($connect, $deleteScheduleQuery);
    mysqli_stmt_bind_param($deleteStmt, 'i', $id);
    mysqli_stmt_execute($deleteStmt);
    header_redirect('/radio/schedule');
    exit();
}

define('APP_NAME', 'Events');
define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'community');
define('PAGE_SELECTED_SUB_PAGE', '/radio/schedule');

require_once('../templates/html_header.php');
require_once('../templates/nav_header.php');
require_once('../templates/nav_slideout.php');
require_once('../templates/nav_sidebar.php');
require_once('../templates/main_header.php');
require_once('../templates/message.php');


// Fetching broadcast schedule from database
$schedule = get_broadcast_list();
// debug_pre($schedule);

?>

<h1 class="w3-margin-top w3-margin-bottom">
    <img src="https://cdn.brickmmo.com/icons@1.0.0/radio.png" alt="Radio Broadcast Icon" height="50" style="vertical-align: top" /> Radio Broadcast
</h1>
<p><a href="/city/dashboard">Dashboard</a> / <a href="/radio/dashboard">Radio</a> / Schedule</p>
<hr>

<h2>Broadcasting Schedule</h2>
<table class="w3-table w3-striped w3-bordered">
    <thead>
        <tr>
            <th>Time</th>
            <th>Title</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($schedule as $item):?>
            <tr>
                <td><?= htmlspecialchars($item['time']) ?></td>
                <td><?= htmlspecialchars($item['title']) ?></td>
                <td>
                    <button onclick="showEditForm(<?= $item['id'] ?>);" class="w3-button w3-teal"><i class="fa fa-edit"></i> Edit</button>
                    <form action="/Radio/schedule" method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                        <button type="submit" name="delete" class="w3-button w3-red"><i class="fa fa-trash-alt"></i> Delete</button>
                    </form>
                </td>
            </tr>

            <!-- Hidden Edit Form -->
            <tr id="editForm-<?= $item['id'] ?>" style="display:none;">
                <td colspan="3">
                    <form action="/Radio/schedule" method="post">
                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                        <!-- <input type="hidden" name="segment_id" value="<?= $item['segment_id'] ?>"> -->

                        <?php
                        // Convert 24-hour format to 12-hour format with AM/PM
                        $timeParts = explode(':', $item['time']);
                        $hour = (int)$timeParts[0];
                        $minute = $timeParts[1];
                        $ampm = $hour >= 12 ? 'PM' : 'AM';
                        $hour = $hour > 12 ? $hour - 12 : ($hour == 0 ? 12 : $hour);
                        ?>

                        <label for="hour-<?= $item['id'] ?>">Hour:</label>
                        <select id="hour-<?= $item['id'] ?>" name="hour" required>
                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value="<?= $i ?>" <?= $i == $hour ? 'selected' : '' ?>><?= sprintf('%02d', $i) ?></option>
                            <?php endfor; ?>
                        </select>

                        <label for="minute-<?= $item['id'] ?>">Minute:</label>
                        <select id="minute-<?= $item['id'] ?>" name="minute" required>
                            <?php for ($i = 0; $i < 60; $i += 5): ?>
                                <option value="<?= sprintf('%02d', $i) ?>" <?= $minute == sprintf('%02d', $i) ? 'selected' : '' ?>><?= sprintf('%02d', $i) ?></option>
                            <?php endfor; ?>
                        </select>

                        <label for="ampm-<?= $item['id'] ?>">AM/PM:</label>
                        <select id="ampm-<?= $item['id'] ?>" name="ampm" required>
                            <option value="AM" <?= $ampm == 'AM' ? 'selected' : '' ?>>AM</option>
                            <option value="PM" <?= $ampm == 'PM' ? 'selected' : '' ?>>PM</option>
                        </select>

                        <label for="segment-<?= $item['id'] ?>">Title:</label>
                        <select id="segment-<?= $item['id'] ?>" name="segment_id">
                            <?php foreach ($segments as $segment): ?>
                                <option value="<?= $segment['id'] ?>" <?= $segment['name'] == $item['title'] ? 'selected' : '' ?>><?= $segment['name'] ?></option>
                            <?php endforeach; ?>
                        </select>

                        <button type="submit" name="edit" class="w3-button w3-green">Save Changes</button>
                        <button type="button" onclick="hideEditForm(<?= $item['id'] ?>);" class="w3-button w3-gray">Cancel</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<hr>
<a href="#" onclick="showAddBroadcastForm();" class="w3-button w3-white w3-border w3-margin-top">
    <i class="fa-solid fa-plus fa-padding-right"></i> Add Broadcast
</a>

<div id="addBroadcastForm" style="display: none;">
    <h3>Add New Broadcast</h3>
    <form action="/Radio/schedule" method="post">
        <label for="hour">Hour:</label>
        <select id="hour" name="hour" required>
            <?php for ($i = 1; $i <= 12; $i++): ?>
                <option value="<?= $i ?>"><?= sprintf('%02d', $i) ?></option>
            <?php endfor; ?>
        </select>

        <label for="minute">Minute:</label>
        <select id="minute" name="minute" required>
            <?php for ($i = 0; $i < 60; $i += 5): // You can adjust the step value 
            ?>
                <option value="<?= sprintf('%02d', $i) ?>"><?= sprintf('%02d', $i) ?></option>
            <?php endfor; ?>
        </select>

        <label for="ampm">AM/PM:</label>
        <select id="ampm" name="ampm" required>
            <option value="AM">AM</option>
            <option value="PM">PM</option>
        </select>

        <label for="segment_id">Segment:</label>
        <select id="segment_id" name="segment_id">
            <?php foreach ($segments as $segment): ?>
                <option value="<?= $segment['id'] ?>"><?= htmlspecialchars($segment['name']) ?></option>
            <?php endforeach; ?>
        </select>

        <input type="submit" name="add" value="Save Broadcast">
    </form>
</div>
<script>
    function showEditForm(id) {
        document.getElementById('editForm-' + id).style.display = 'table-row';
    }

    function hideEditForm(id) {
        document.getElementById('editForm-' + id).style.display = 'none';
    }

    function showAddBroadcastForm() {
        var form = document.getElementById('addBroadcastForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
</script>

<?php
require_once('../templates/modal_city.php');
require_once('../templates/main_footer.php');
require_once('../templates/debug.php');
require_once('../templates/html_footer.php');
?>