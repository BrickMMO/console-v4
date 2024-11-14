<?php

function form_select_table($name, $table, $key, $value, $data = array())
{

    global $connect;

    $query = 'SELECT '.$key.','.$value.'
        FROM '.$table.'
        ORDER BY '.$value;
    $result = mysqli_query($connect, $query);

    $html = '<select name="'.$name.'" id="'.$name.'" class="w3-input w3-border'.(isset($data['first']) ? '' : ' w3-margin-top').'">';

    if(isset($data['empty_key']) or isset($data['empty_value']) )
    {
        $html .= '<option value="'.(isset($data['empty_key']) ? $data['empty_key'] : '').'">
                '.(isset($data['empty_value']) ? $data['empty_value'] : '').'
            </option>';
    }

    while($record = mysqli_fetch_assoc($result))
    {
        $html .= '<option value="'.$record[$key].'"';
        if(isset($data['selected']) and $data['selected'] == $record[$key]) $html .= ' selected';
        $html .= '>'.$record[$value].'</option>';
    }

    $html .= '</select>';

    return $html;

}