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
$type = $_GET['type'] ?? '1';
$basin = $_GET['basin'] ?? '1';
?>

<!-- Include Moment.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<!-- Include the Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Include the Moment.js adapter for Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@1.0.0"></script>

<!-- Include the CSS Style -->
<link href="stylesheets/style.css" rel="stylesheet" type="text/css" media="all" />

<!-- Include the JQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!--////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<?php
function get_table_data_local($db, $cwms_ts_id, $start_day, $end_day) {
	$stmnt_query = null;
	$data = [];
	
	try {		
		$sql = "select cwms_ts_id
					,cwms_util.change_timezone(tsv.date_time, 'UTC', 'CST6CDT' ) as date_time
					,cwms_util.split_text('".$cwms_ts_id."' ,1,'.') as location_id
					,cwms_util.split_text('".$cwms_ts_id."' ,2,'.') as parameter_id
					,cwms_util.split_text('".$cwms_ts_id."' ,6,'.') as version_id
					,value
					,unit_id
					,quality_code
				from cwms_v_tsv_dqu  tsv
					where 
						tsv.cwms_ts_id = '".$cwms_ts_id."'  
						and date_time  >= cast(cast(current_date as timestamp) at time zone 'UTC' as date) - interval '".$start_day."' DAY
						and date_time  <= cast(cast(current_date as timestamp) at time zone 'UTC' as date) + interval '".$end_day."' DAY
						and (tsv.unit_id = 'ppm' or tsv.unit_id = 'F' or tsv.unit_id = CASE WHEN cwms_util.split_text(tsv.cwms_ts_id,2,'.') IN ('Stage','Elev','Opening') THEN 'ft' WHEN cwms_util.split_text(tsv.cwms_ts_id,2,'.') IN ('Precip','Depth') THEN 'in' END or tsv.unit_id = 'cfs' or tsv.unit_id = 'umho/cm' or tsv.unit_id = 'volt' or tsv.unit_id = 'ac-ft')
						and tsv.office_id = 'MVS' 
						and tsv.aliased_item is null
					order by date_time desc";
		
		$stmnt_query = oci_parse($db, $sql);
		$status = oci_execute($stmnt_query);

		while (($row = oci_fetch_array($stmnt_query, OCI_ASSOC+OCI_RETURN_NULLS)) !== false) {
			
			$obj = (object) [
				"cwms_ts_id" => $row['CWMS_TS_ID'],
				"date_time" => $row['DATE_TIME'],
				"location_id" => $row['LOCATION_ID'],
				"parameter_id" => $row['PARAMETER_ID'],
				"version_id" => $row['VERSION_ID'],
				"value" => $row['VALUE'],
				"unit_id" => $row['UNIT_ID'],
				"quality_code" => $row['QUALITY_CODE']
			];
			array_push($data, $obj);
		}
	}
	catch (Exception $e) {
		$e = oci_error($db);  
		trigger_error(htmlentities($e['message']), E_USER_ERROR);

		return null;
	}
	finally {
		oci_free_statement($stmnt_query); 
	}
	return $data;
}

// Your JSON file path
if ($type == "ld") {
    $json_file_path = 'csv/ld.json';
} else {
    if ($basin == "Big Muddy") {
        $json_file_path = 'csv/big_muddy.json';
    } else if ($basin == "Cuivre") {
        $json_file_path = 'csv/cuivre.json';
    } else if ($basin == "Illinois") {
        $json_file_path = 'csv/illinois.json';
    } else if ($basin == "Kaskaskia") {
        $json_file_path = 'csv/kaskaskia.json';
    } else if ($basin == "Meramec") {
        $json_file_path = 'csv/meramec.json';
    } else if ($basin == "Mississippi") {
        $json_file_path = 'csv/mississippi.json';
    } else if ($basin == "Missouri") {
        $json_file_path = 'csv/missouri.json';
    } else if ($basin == "Ohio") {
        $json_file_path = 'csv/ohio.json';
    } else if ($basin == "Salt") {
        $json_file_path = 'csv/salt.json';
    } else if ($basin == "St Francis") {
        $json_file_path = 'csv/st_francis.json';
    } else {
        $json_file_path = 'csv/ld.json';
    }
}

// Read the JSON file and decode it
$json_data = file_get_contents($json_file_path);
$data = json_decode($json_data, true);

// Check if decoding was successful
if ($data !== null) {
    // Initialize an array to store time series data for each location
    $timeSeriesData = array();

    // Loop through the JSON data
    foreach ($data as $item) {
        $projectId = $item['project_id'];

        // Process time series data for each CWMS entry
        foreach ($item as $key => $cwmsEntry) {
            if (strpos($key, 'cwms_') === 0) {
                $locationId = $cwmsEntry['location_id'];
                $tsid = $cwmsEntry['tsid'];
                $startDay = $cwmsEntry['start_day'];
                $endDay = $cwmsEntry['end_day'];

                $tableData = get_table_data_local($db, $tsid, $startDay, $endDay);
                $timeSeriesData["$projectId - $locationId"][] = array(
                    'table_data' => $tableData
                );
            }
        }
        
    }

    // Output the processed time series data as JSON
    echo '<script>';
    echo 'var timeSeriesData = ' . json_encode($timeSeriesData) . ';';
    echo '</script>';
} else {
    echo "Error decoding the JSON file.";
}
?>

<script>
console.log("timeSeriesData: ", timeSeriesData); // Verify the data is available in the browser console

// Check if timeSeriesData is defined and not empty
if (typeof timeSeriesData !== 'undefined' && Object.keys(timeSeriesData).length > 0) {
    // Create a container for the charts
    document.write('<div style="display: flex; flex-wrap: wrap;">');

    // Track whether each project's h1 tag has been displayed
    const displayedProjects = {};

    // Create a chart for each location
    Object.keys(timeSeriesData).forEach(projectLocation => {
        const [projectId, location] = projectLocation.split(' - ');
        const locationData = timeSeriesData[projectLocation];

        // Create a container for each chart with dynamic height
        document.write('<div style="width: 50%;' +
            (!displayedProjects[projectId] ? '' : 'margin-top: 70px;') + // Add margin if h1 is displayed
            '">');

        // Check if this is the first location for the project
        if (!displayedProjects[projectId] && locationData.length > 0 && locationData[0].table_data.length > 0) {
            document.write(`<h1>${projectId}</h1>`);
            displayedProjects[projectId] = true; // Mark the project as displayed
        }

        // Create a canvas for each location
        const canvasId = `chart-${projectId}-${location}`;
        document.write(`<canvas id="${canvasId}" width="400" height="200"></canvas>`);

        // Get the context of the canvas
        const ctx = document.getElementById(canvasId).getContext('2d');

        // Create a chart for the location
        new Chart(ctx, {
            type: 'line',
            data: {
                datasets: [{
                    label: `${location}`,
                    data: locationData[0].table_data.map(entry => ({
                        x: moment(entry.date_time, "MM-DD-YYYY HH:mm").isValid() ? moment(entry.date_time, "MM-DD-YYYY HH:mm").toDate() : null,
                        y: parseFloat(entry.value)
                    })),
                    fill: false
                }]
            },
            options: {
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day'
                        }
                    },
                    y: {
                        // Configure y-axis options as needed
                    }
                }
            }
        });

        // Close the chart container div
        document.write('</div>');
    });

    // Close the overall container div
    document.write('</div>');
} else {
    console.error("timeSeriesData is not defined or empty.");
}
</script>

<!--////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<?php db_disconnect($db); ?>