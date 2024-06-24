<?php 
require_once('../private/initialize.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ini_set("xdebug.var_display_max_children", '-1');
ini_set("xdebug.var_display_max_data", '-1');
ini_set("xdebug.var_display_max_depth", '-1');

date_default_timezone_set('America/Chicago');
if (date_default_timezone_get()) {
    //echo 'date_default_timezone_set: ' . date_default_timezone_get() . '<br />';
}
if (ini_get('date.timezone')) {
    //echo 'date.timezone: ' . ini_get('date.timezone');
}

// GET REQUEST 
    $basin = $_GET['basin'] ?? '1';
    $cwms_ts_id = $_GET['cwms_ts_id'] ?? '1';
    $cwms_ts_id_2 = $_GET['cwms_ts_id_2'] ?? '1';
    $cwms_ts_id_3 = $_GET['cwms_ts_id_3'] ?? '1';
    $cwms_ts_id_4 = $_GET['cwms_ts_id_4'] ?? '1';
    $cwms_ts_id_5 = $_GET['cwms_ts_id_5'] ?? '1';
    $cwms_ts_id_6 = $_GET['cwms_ts_id_6'] ?? '1';
    $cwms_ts_id_7 = $_GET['cwms_ts_id_7'] ?? '1';
    $start_day = $_GET['start_day'] ?? '1';
    $end_day = $_GET['end_day'] ?? '1';
    $gage_data = $_GET['gage_data'] ?? '1';
?>


<div id="formDataChangeDate" style="width: 100%; height: 500px; border: 1px solid #ccc; margin-top: 30px;">
    <label for="selectedBasinDate">Selected Basin:</label>
    <select id="selectedBasinDate" name="basin">
        <!-- Options will be populated dynamically using JavaScript -->
    </select>
    <br>
    <br>

    <label for="selectedTimeSeries01">Default Time Series 1:</label>
    <select id="selectedTimeSeries01" name="cwms_ts_id_01">
        <!-- Options will be populated dynamically using JavaScript -->
    </select>
    <br>
    <br>

    <label for="selectedTimeSeries02">Default Time Series 2:</label>
    <select id="selectedTimeSeries02" name="cwms_ts_id_02">
        <!-- Options will be populated dynamically using JavaScript -->
    </select>
    <br>
    <br>

    <label for="selectedTimeSeries03">Default Time Series 3:</label>
    <select id="selectedTimeSeries03" name="cwms_ts_id_03">
        <!-- Options will be populated dynamically using JavaScript -->
    </select>
    <br>
    <br>

    <label for="selectedTimeSeries04">Default Time Series 4:</label>
    <select id="selectedTimeSeries04" name="cwms_ts_id_04">
        <!-- Options will be populated dynamically using JavaScript -->
    </select>
    <br>
    <br>

    <label for="selectedTimeSeries05">Default Time Series 5:</label>
    <select id="selectedTimeSeries05" name="cwms_ts_id_05">
        <!-- Options will be populated dynamically using JavaScript -->
    </select>
    <br>
    <br>

    <label for="selectedTimeSeries06">Default Time Series 6:</label>
    <select id="selectedTimeSeries06" name="cwms_ts_id_06">
        <!-- Options will be populated dynamically using JavaScript -->
    </select>
    <br>
    <br>

    <label for="selectedTimeSeries07">Default Time Series 7:</label>
    <select id="selectedTimeSeries07" name="cwms_ts_id_07">
        <!-- Options will be populated dynamically using JavaScript -->
    </select>
    <br>
    <br>

    <label for="selectStartDay">Select Start Day:</label>
    <select id="selectStartDay" name="start_day">
        <option value="0">0 day</option>
        <option value="4" selected>4 days</option> <!-- Set this option as selected -->
        <option value="7">7 days</option>
        <option value="14">14 days</option>
        <option value="30">30 days</option>
        <option value="90">90 days</option>
    </select>
    <br>
    <br>

    <label for="selectEndDay">Select End Day:</label>
    <select id="selectEndDay" name="end_day">
        <option value="0" selected>0 day</option>
        <option value="4">4 days</option>
        <option value="7">7 days</option>
        <option value="14">14 days</option>
        <option value="30">30 days</option>
        <option value="90">90 days</option>
    </select>
    <br>
    <br>

    <!-- You can use JavaScript to get the selected value -->
    <button onclick="getSelectedValues()">Submit Basin</button>
</div>

<?php
// GET TIME SERIES 1
    $table_data = get_table_data($db, $cwms_ts_id, $start_day, $end_day); // Array ( [0] => stdClass Object
    //print_r($table_data);

    $table_data_json = json_encode($table_data); // JSON string
    //print_r($table_data_json);

    $data = json_decode($table_data_json, true); // Array ( [0] => Array

    $cwms_ts_id = array_column($data, 'cwms_ts_id');
    $location_id = array_column($data, 'location_id');
    $parameter_id = array_column($data, 'parameter_id');
    $version_id = array_column($data, 'version_id');
    $date_time = array_column($data, 'date_time');
    $value = array_column($data, 'value');
    $unit = array_column($data, 'unit_id');
    $quality_code = array_column($data, 'quality_code');

    $cwms_ts_id_first_element = $cwms_ts_id[0];
    //print_r($cwms_ts_id_first_element);

    $location_id_first_element = $location_id[0];
    //print_r($location_id_first_element);

    $parameter_id_first_element = $parameter_id[0];
    //print_r($parameter_id_first_element);

    $version_id_first_element = $version_id[0];
    //print_r($version_id_first_element);

    $unit_id_first_element = $unit[0];
    //print_r($unit_id_first_element);


// GET TIME SERIES 2
    $table_data_2 = get_table_data($db, $cwms_ts_id_2, $start_day, $end_day);
    //print_r($table_data_2);

    $json_data_2 = json_encode($table_data_2); // JSON string
    //print_r($json_data_2);

    $data_2 = json_decode($json_data_2, true); // Associative array
    //print_r($data_2);

    $cwms_ts_id_2 = array_column($data_2, 'cwms_ts_id');
    $location_id_2 = array_column($data_2, 'location_id');
    $parameter_id_2 = array_column($data_2, 'parameter_id');
    $date_time_2 = array_column($data_2, 'date_time');
    $value_2 = array_column($data_2, 'value');
    $unit_2 = array_column($data_2, 'unit_id');
    $quality_code_2 = array_column($data_2, 'quality_code');

    if (array_key_exists(0, $cwms_ts_id_2)) {
        // The key 0 exists in $yourArray
        $cwms_ts_id_2_first_element = $cwms_ts_id_2[0];
        //print_r($cwms_ts_id_2_first_element);
    
        $location_id_2_first_element = $location_id_2[0];
        //print_r($location_id_2_first_element);
    } else {
        // The key 0 does not exist in $yourArray
        $cwms_ts_id_2_first_element = 1;
        $location_id_2_first_element = 1;
    }


// GET TIME SERIES 3
    $table_data_3 = get_table_data($db, $cwms_ts_id_3, $start_day, $end_day);
    //print_r($table_data_3);

    $json_data_3 = json_encode($table_data_3); // JSON string
    //print_r($json_data_3);

    $data_3 = json_decode($json_data_3, true); // Associative array
    //print_r($data_3);

    $cwms_ts_id_3 = array_column($data_3, 'cwms_ts_id');
    $location_id_3 = array_column($data_3, 'location_id');
    $parameter_id_3 = array_column($data_3, 'parameter_id');
    $date_time_3 = array_column($data_3, 'date_time');
    $value_3 = array_column($data_3, 'value');
    $unit_3 = array_column($data_3, 'unit_id');
    $quality_code_3 = array_column($data_3, 'quality_code');

    if (array_key_exists(0, $cwms_ts_id_3)) {
        // The key 0 exists in $yourArray
        $cwms_ts_id_3_first_element = $cwms_ts_id_3[0];
        //print_r($cwms_ts_id_3_first_element);
    
        $location_id_3_first_element = $location_id_3[0];
        //print_r($location_id_3_first_element);
    } else {
        // The key 0 does not exist in $yourArray
        $cwms_ts_id_3_first_element = 1;
        $location_id_3_first_element = 1;
    }

// GET TIME SERIES 4
    $table_data_4 = get_table_data($db, $cwms_ts_id_4, $start_day, $end_day);
    //print_r($table_data_4);

    $json_data_4 = json_encode($table_data_4); // JSON string
    //print_r($json_data_4);

    $data_4 = json_decode($json_data_4, true); // Associative array
    //print_r($data_4);

    $cwms_ts_id_4 = array_column($data_4, 'cwms_ts_id');
    $location_id_4 = array_column($data_4, 'location_id');
    $parameter_id_4 = array_column($data_4, 'parameter_id');
    $date_time_4 = array_column($data_4, 'date_time');
    $value_4 = array_column($data_4, 'value');
    $unit_4 = array_column($data_4, 'unit_id');
    $quality_code_4 = array_column($data_4, 'quality_code');

    if (array_key_exists(0, $cwms_ts_id_4)) {
        // The key 0 exists in $yourArray
        $cwms_ts_id_4_first_element = $cwms_ts_id_4[0];
        //print_r($cwms_ts_id_4_first_element);
    
        $location_id_4_first_element = $location_id_4[0];
        //print_r($location_id_4_first_element);
    } else {
        // The key 0 does not exist in $yourArray
        $cwms_ts_id_4_first_element = 1;
        $location_id_4_first_element = 1;
    }

// GET TIME SERIES 5
    $table_data_5 = get_table_data($db, $cwms_ts_id_5, $start_day, $end_day);
    //print_r($table_data_5);

    $json_data_5 = json_encode($table_data_5); // JSON string
    //print_r($json_data_5);

    $data_5 = json_decode($json_data_5, true); // Associative array
    //print_r($data_5);

    $cwms_ts_id_5 = array_column($data_5, 'cwms_ts_id');
    $location_id_5 = array_column($data_5, 'location_id');
    $parameter_id_5 = array_column($data_5, 'parameter_id');
    $date_time_5 = array_column($data_5, 'date_time');
    $value_5 = array_column($data_5, 'value');
    $unit_5 = array_column($data_5, 'unit_id');
    $quality_code_5 = array_column($data_5, 'quality_code');

    if (array_key_exists(0, $cwms_ts_id_5)) {
        // The key 0 exists in $yourArray
        $cwms_ts_id_5_first_element = $cwms_ts_id_5[0];
        //print_r($cwms_ts_id_5_first_element);
    
        $location_id_5_first_element = $location_id_5[0];
        //print_r($location_id_5_first_element);
    } else {
        // The key 0 does not exist in $yourArray
        $cwms_ts_id_5_first_element = 1;
        $location_id_5_first_element = 1;
    }

// GET TIME SERIES 6
    $table_data_6 = get_table_data($db, $cwms_ts_id_6, $start_day, $end_day);
    //print_r($table_data_6);

    $json_data_6 = json_encode($table_data_6); // JSON string
    //print_r($json_data_6);

    $data_6 = json_decode($json_data_6, true); // Associative array
    //print_r($data_6);

    $cwms_ts_id_6 = array_column($data_6, 'cwms_ts_id');
    $location_id_6 = array_column($data_6, 'location_id');
    $parameter_id_6 = array_column($data_6, 'parameter_id');
    $date_time_6 = array_column($data_6, 'date_time');
    $value_6 = array_column($data_6, 'value');
    $unit_6 = array_column($data_6, 'unit_id');
    $quality_code_6 = array_column($data_6, 'quality_code');

    if (array_key_exists(0, $cwms_ts_id_6)) {
        // The key 0 exists in $yourArray
        $cwms_ts_id_6_first_element = $cwms_ts_id_6[0];
        //print_r($cwms_ts_id_6_first_element);
    
        $location_id_6_first_element = $location_id_6[0];
        //print_r($location_id_6_first_element);
    } else {
        // The key 0 does not exist in $yourArray
        $cwms_ts_id_6_first_element = 1;
        $location_id_6_first_element = 1;
    }

// GET TIME SERIES 7
    $table_data_7 = get_table_data($db, $cwms_ts_id_7, $start_day, $end_day);
    //print_r($table_data_7);

    $json_data_7 = json_encode($table_data_7); // JSON string
    //print_r($json_data_7);

    $data_7 = json_decode($json_data_7, true); // Associative array
    //print_r($data_7);

    $cwms_ts_id_7 = array_column($data_7, 'cwms_ts_id');
    $location_id_7 = array_column($data_7, 'location_id');
    $parameter_id_7 = array_column($data_7, 'parameter_id');
    $date_time_7 = array_column($data_7, 'date_time');
    $value_7 = array_column($data_7, 'value');
    $unit_7 = array_column($data_7, 'unit_id');
    $quality_code_7 = array_column($data_7, 'quality_code');

    if (array_key_exists(0, $cwms_ts_id_7)) {
        // The key 0 exists in $yourArray
        $cwms_ts_id_7_first_element = $cwms_ts_id_7[0];
        //print_r($cwms_ts_id_7_first_element);
    
        $location_id_7_first_element = $location_id_7[0];
        //print_r($location_id_7_first_element);
    } else {
        // The key 0 does not exist in $yourArray
        $cwms_ts_id_7_first_element = 1;
        $location_id_7_first_element = 1;
    }
?>


<script>
    function populateDropdown(id, value) {
        console.log(id + " = ", value);
        var dropdown = document.getElementById(id);
        console.log("dropdown = ", dropdown);
        var option = document.createElement('option');
        option.value = value;
        option.text = value;
        dropdown.add(option);
    }


    var basin = <?php echo json_encode($basin); ?>;
    populateDropdown('selectedBasinDate', basin);

    var cwms_ts_id_dropdown = <?php echo json_encode($cwms_ts_id_first_element); ?>;
    console.log("cwms_ts_id_dropdown: ", cwms_ts_id_dropdown);
    populateDropdown('selectedTimeSeries01', cwms_ts_id_dropdown );

    var cwms_ts_id_2_dropdown = <?php echo json_encode($cwms_ts_id_2_first_element); ?>;
    console.log("cwms_ts_id_2_dropdown: ", cwms_ts_id_2_dropdown);
    // Assuming the ID of the dropdown is 'selectedTimeSeries02'
    var label2 = document.querySelector('label[for="selectedTimeSeries02"]');
    var dropdown2 = document.getElementById('selectedTimeSeries02');
    if (cwms_ts_id_2_dropdown === 1) {
        // Hide the dropdown
        label2.style.display = 'none';
        dropdown2.style.display = 'none';
    } else {
        // Show the dropdown
        dropdown2.style.display = 'block';
    }
    populateDropdown('selectedTimeSeries02', cwms_ts_id_2_dropdown);

    var cwms_ts_id_3_dropdown = <?php echo json_encode($cwms_ts_id_3_first_element); ?>;
    console.log("cwms_ts_id_3_dropdown: ", cwms_ts_id_3_dropdown);
    populateDropdown('selectedTimeSeries03', cwms_ts_id_3_dropdown);

    var cwms_ts_id_4_dropdown = <?php echo json_encode($cwms_ts_id_4_first_element); ?>;
    console.log("cwms_ts_id_4_dropdown: ", cwms_ts_id_4_dropdown);
    populateDropdown('selectedTimeSeries04', cwms_ts_id_4_dropdown);

    var cwms_ts_id_5_dropdown = <?php echo json_encode($cwms_ts_id_5_first_element); ?>;
    console.log("cwms_ts_id_5_dropdown: ", cwms_ts_id_5_dropdown);
    populateDropdown('selectedTimeSeries05', cwms_ts_id_5_dropdown);

    var cwms_ts_id_6_dropdown = <?php echo json_encode($cwms_ts_id_6_first_element); ?>;
    console.log("cwms_ts_id_6_dropdown: ", cwms_ts_id_6_dropdown);
    populateDropdown('selectedTimeSeries06', cwms_ts_id_6_dropdown);

    var cwms_ts_id_7_dropdown = <?php echo json_encode($cwms_ts_id_7_first_element); ?>;
    console.log("cwms_ts_id_7_dropdown: ", cwms_ts_id_7_dropdown);
    populateDropdown('selectedTimeSeries07', cwms_ts_id_7_dropdown);

    function getSelectedValues() {
        var selectedBasinDropdown = document.getElementById('selectedBasinDate').value;
        console.log("selectedBasinDropdown: ", selectedBasinDropdown);
        var selectedTimeSeries01 = document.getElementById('selectedTimeSeries01').value;
        var selectedTimeSeries02 = document.getElementById('selectedTimeSeries02').value;
        var selectedTimeSeries03 = document.getElementById('selectedTimeSeries03').value;
        var selectedTimeSeries04 = document.getElementById('selectedTimeSeries04').value;
        var selectedTimeSeries05 = document.getElementById('selectedTimeSeries05').value;
        var selectedTimeSeries06 = document.getElementById('selectedTimeSeries06').value;
        var selectedTimeSeries07 = document.getElementById('selectedTimeSeries07').value;
        // Repeat for other dropdowns as needed
        var selectStartDay = document.getElementById('selectStartDay').value || '4'; // Default to 4 if no value selected
        var selectEndDay = document.getElementById('selectEndDay').value || '0'; // Default to 0 if no value selected

        // Construct the URL with selected values
        var redirectURL = 'https://wm.mvs.ds.usace.army.mil/web_apps/plot_macro/public/plot_macro2.php?' +
                        'basin=' + encodeURIComponent(selectedBasinDropdown) +
                        '&cwms_ts_id=' + encodeURIComponent(selectedTimeSeries01) + 
                        '&cwms_ts_id_2=' + encodeURIComponent(selectedTimeSeries02) + 
                        '&start_day=' + encodeURIComponent(selectStartDay) +
                        '&end_day=' + encodeURIComponent(selectEndDay);
        // Add more parameters as needed

        // Redirect to the constructed URL
        window.location.href = redirectURL;
    }

</script>


