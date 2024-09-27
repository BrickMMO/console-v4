<?php
if (isset($_GET['city_id'])) {
    $query = 'SELECT * FROM panels where city_id = ' . $_GET['city_id'];

    $result = mysqli_query($connect, $query);

    $panelArray = array();

    if ($result) {

        header("Content-type: JSON");
        $i = 0;

        while ($panel = mysqli_fetch_assoc($result)) {
            $panelArray[$i]['id'] = $panel['id'];
            $panelArray[$i]['port_id'] = $panel['port_id'];
            $panelArray[$i]['cartridge'] = $panel['cartridge'];
            $panelArray[$i]['city_id'] = $panel['city_id'];
            $panelArray[$i]['value'] = $panel['value'];
            $i++;
        }

        $data = array(
            'message' => 'Panel data retrieved successfully.',
            'error' => false,
            'panel' => $panelArray,
        );
    } else {
        $data = array(
            'message' => 'Error retrieving panel detail.',
            'error' => true,
            'panel' => null,
        );
    }
}
