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

$set_options = set_options2($db);

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



// POST REQUEST
    if(is_post_request()) {
    $basin_selected = $_POST['basin'] ?? '';
    $cwms_ts_id_selected = $_POST['cwms_ts_id'] ?? '';
    $cwms_ts_id_2_selected = $_POST['cwms_ts_id_2'] ?? '';
    $cwms_ts_id_3_selected = $_POST['cwms_ts_id_3'] ?? '';
    $cwms_ts_id_4_selected = $_POST['cwms_ts_id_4'] ?? '';
    $cwms_ts_id_5_selected = $_POST['cwms_ts_id_5'] ?? '';
    $cwms_ts_id_6_selected = $_POST['cwms_ts_id_6'] ?? '';
    $cwms_ts_id_7_selected = $_POST['cwms_ts_id_7'] ?? '';
    $start_date_time_selected = $_POST['start_date_time'] ?? '';
    $end_date_time_selected = $_POST['end_date_time'] ?? '';
    redirect_to(url_for('plot_macro.php?basin='.$basin_selected. '&cwms_ts_id='.$cwms_ts_id_selected.'&cwms_ts_id_2='.$cwms_ts_id_2_selected.'&cwms_ts_id_3='.$cwms_ts_id_3_selected.'&cwms_ts_id_4='.$cwms_ts_id_4_selected.'&cwms_ts_id_5='.$cwms_ts_id_5_selected.'&cwms_ts_id_6='.$cwms_ts_id_6_selected.'&cwms_ts_id_7='.$cwms_ts_id_7_selected.'&start_day='.$start_date_time_selected.'&end_day='.$end_date_time_selected.''));
    }
?>


<div id="formData" style="width: 100%; height: 300px; border: 1px solid #ccc; margin-top: 30px;">
    <label for="selectBasinBox">Select a Basin:</label>
    <select id="selectBasinBox" name="basin" onchange="populateSecondDropdown()">
        <!-- Options will be populated dynamically using JavaScript -->
    </select>
    <br>
    <br>

    <label for="selectTimeSeriesBox">Default Time Series:</label>
    <select id="selectTimeSeriesBox" name="cwmsTsId">
        <!-- Options will be populated dynamically using JavaScript -->
    </select>
    <br>
    <br>

    <!-- You can use JavaScript to get the selected value -->
    <button onclick="getSelectedValues()">Submit Basin</button>
</div>


<script>
    const basins = ["Mississippi", "Illinois", "Missouri", "Meramec", "Tributaries", "Mark Twain DO", "Mark Twain", "Wappapello", "Shelbyville", "Carlyle", "Rend", "Kaskaskia Nav", "Water Quality"];

    const cwms_ts_id_selection = {
        "Mississippi": ["St Louis-Mississippi.Stage.Inst.30Minutes.0.lrgsShef-rev"],
        "Illinois": ["Meredosia-Illinois.Stage.Inst.30Minutes.0.lrgsShef-rev"],
        "Missouri": ["St Charles-Missouri.Stage.Inst.30Minutes.0.lrgsShef-rev"],
        "Meramec": ["Eureka-Meramec.Flow.Inst.30Minutes.0.RatingUSGS"],
        "Tributaries": ["Troy-Cuivre.Flow.Inst.15Minutes.0.RatingUSGS"],
        "Mark%20Twain DO": ["Mark Twain Lk TW-Salt.Conc-DO.Inst.15Minutes.0.lrgsShef-raw"],
        "Mark%20Twain": ["Mark Twain Lk-Salt.Stage.Inst.30Minutes.0.29"],
        "Wappapello": ["Wappapello Lk-St_Francis.Stage.Inst.30Minutes.0.29"],
        "Shelbyville": ["Lk Shelbyville-Kaskaskia.Stage.Inst.30Minutes.0.29"],
        "Carlyle": ["Carlyle Lk-Kaskaskia.Stage.Inst.30Minutes.0.29"],
        "Rend": ["Rend Lk-Big Muddy.Stage.Inst.30Minutes.0.29"],
        "Kaskaskia%20Nav": ["Venedy Station-Kaskaskia.Flow.Inst.15Minutes.0.RatingUSGS"],
        "Water%20Quality": ["Mark Twain Lk TW-Salt.Conc-DO.Inst.15Minutes.0.lrgsShef-raw"],
        // Add cwms_ts_id_selection for other basins as needed
    };

    function populateDropdown(selectBasinBox, options) {
        selectBasinBox.innerHTML = '';
        options.forEach(option => {
            // Ensure option is a string before calling trim
            const optionString = String(option);

            const trimmedOption = optionString.trim();

            const optionElem = document.createElement('option');
            optionElem.value = trimmedOption.replace(/ /g, '%20');
            optionElem.text = trimmedOption;
            selectBasinBox.appendChild(optionElem);
        });
    }

    function populateSecondDropdown() {
        const selectBasinBox = document.getElementById('selectBasinBox');
        const selectedBasin = selectBasinBox.value.trim().replace(/ /g, '%20');

        const selectTimeSeriesBox = document.getElementById('selectTimeSeriesBox');

        console.log('Selected Basin:', selectedBasin);

        // Clear existing options in the second dropdown
        selectTimeSeriesBox.innerHTML = '';

        // Convert all keys in cwms_ts_id_selection to lowercase
        const cwms_ts_id_formatted = Object.fromEntries(
            Object.entries(cwms_ts_id_selection).map(([key, value]) => [key, value])
        );

        // Log the entire cwms_ts_id_selection object for inspection
        console.log('cwms_ts_id_selection:', cwms_ts_id_formatted);

        // Populate options for the selected basin from the cwms_ts_id_selection object
        const measurementOptions = cwms_ts_id_formatted[selectedBasin] || [];
        console.log('cwms_ts_id Options:', measurementOptions);

        populateDropdown(selectTimeSeriesBox, measurementOptions);
    }


    document.addEventListener('DOMContentLoaded', function () {
        const selectBasinBox = document.getElementById('selectBasinBox');
        const selectTimeSeriesBox = document.getElementById('selectTimeSeriesBox');
        const selectBox3 = document.getElementById('selectBox3');
        const selectBox4 = document.getElementById('selectBox4');

        // Populate basins dropdown
        populateDropdown(selectBasinBox, basins);

        // Set a default basin selection for testing
        selectBasinBox.value = "Mississippi";

        // Populate the cwms_ts_id dropdown based on the default selected basin
        populateSecondDropdown();

        // Populate the time range dropdown
        populateThirdDropdown();

        // Populate the time range dropdown
        populateForthDropdown();

        // Set up event listener for basin dropdown change
        selectBasinBox.addEventListener('change', function () {
            populateSecondDropdown();
            populateThirdDropdown(); // Add this line to update the time range dropdown
            populateForthDropdown(); // Add this line to updattimeRange2e the time range dropdown
        });

        // Trigger the population of the second and third dropdowns on page load
        selectBasinBox.dispatchEvent(new Event('change'));
    });

    function getSelectedValues() {
        const selectBasinBox = document.getElementById('selectBasinBox');
        const selectedBasin = selectBasinBox.value;

        const selectTimeSeriesBox = document.getElementById('selectTimeSeriesBox');
        const selectedMeasurement = selectTimeSeriesBox.value;

        //alert('Selected Basin: ' + selectedBasin + '\nSelected cwms_ts_id: ' + selectedMeasurement + '\nSelected Time Range: ' + selectedTimeRange + '\nSelected Time Range: ' + selectedTimeRange2);

        // Construct the URL based on selected variables
        const redirectURL = `https://wm.mvs.ds.usace.army.mil/web_apps/plot_macro/public/plot_macro2.php?basin=${selectedBasin}&cwms_ts_id=${selectedMeasurement}&start_day=4&end_day=0`;

        // Redirect to the new URL
        window.location.href = redirectURL;
    }
</script>
