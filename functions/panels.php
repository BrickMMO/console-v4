<?php

// Fetch panel data based on city_id
function get_panel_data_by_city($city_id, $connect)
{
    $query = "SELECT * FROM panels WHERE city_id = " . mysqli_real_escape_string($connect, $city_id);
    $result = mysqli_query($connect, $query);

    $panel_data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $panel_data[] = $row;
    }

    return $panel_data;
}

// Update panel value based on panel ID
function update_panel_value($panel_id, $new_value, $connect)
{
    $query = "UPDATE panels SET value = '" . mysqli_real_escape_string($connect, $new_value) . "' WHERE id = '" . mysqli_real_escape_string($connect, $panel_id) . "'";
    $result = mysqli_query($connect, $query);
    return $result;
}

// Group panel data by cartridge and port_id
function group_panel_data_by_cartridge($panel_data)
{
    $power_lever = [];
    $current_cartridge = [];
    $cartridge_data = [];

    foreach ($panel_data as $panel) {
        if ($panel['port_id'] == 'A') {
            $power_lever = ['id' => $panel['id'], 'value' => $panel['value']];
        }
        if ($panel['port_id'] == 'S1') {
            $current_cartridge = ['id' => $panel['id'], 'value' => $panel['value']];
        }
        if ($panel['cartridge'] != null) {
            $cartridge = $panel['cartridge'];
            $port_id = $panel['port_id'];
            $value = $panel['value'];

            if (!isset($cartridge_data[$cartridge])) {
                $cartridge_data[$cartridge] = [];
            }

            if (!isset($cartridge_data[$cartridge][$port_id])) {
                $cartridge_data[$cartridge][$port_id] = [];
            }

            $cartridge_data[$cartridge][$port_id][] = ['id' => $panel['id'], 'value' => $value];
        }
    }

    return [$power_lever, $current_cartridge, $cartridge_data];
}

// Fetch panel data based on cartridge and city_id
function get_panel_data_by_cartridge($cartridge, $city_id, $connect)
{
    $query = "SELECT * FROM panels WHERE city_id = " . mysqli_real_escape_string($connect, $city_id) . " 
              AND cartridge = '" . mysqli_real_escape_string($connect, $cartridge) . "'";
    $result = mysqli_query($connect, $query);

    $cartridge_data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $port_id = $row['port_id'];
        if (!isset($cartridge_data[$port_id])) {
            $cartridge_data[$port_id] = [];
        }
        $cartridge_data[$port_id][] = ['id' => $row['id'], 'value' => $row['value']];
    }

    return $cartridge_data;
}
