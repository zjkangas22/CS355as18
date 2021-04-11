<?php 
/*
	filename 	: cis355api.php
	author   	: Zachery Kangas (temolate by george corser)
	course   	: cis355 (winter2020)
	description	: demonstrate JSON API functions
				  return number of new covid19 cases
	input    	: https://api.covid19api.com/summary
	functions   : main()
	                curl_get_contents()
*/

main();

#-----------------------------------------------------------------------------
# FUNCTIONS
#-----------------------------------------------------------------------------
function main () {
	
	$apiCall = 'https://api.covid19api.com/summary';
	// line below stopped working on CSIS server
	// $json_string = file_get_contents($apiCall); 
	$json_string = curl_get_contents($apiCall);
	$obj = json_decode($json_string);
	$data = $obj->Global->TotalDeaths;

	// echo html head section
	echo '<html>';
	echo '<head>';
	echo '	<link rel="icon" href="img/cardinal_logo.png" type="image/png" />';
	echo '</head>';
	
	// open html body section
	echo '<body onload="loadDoc()">';
    echo '<a href="http://github.com/zjkangas22/CS355as18/blob/main/cis355api.php">Link to Github code.</a>';
    echo '<br>';
	
	$tableHead = '<table id="results">';
	echo $tableHead;
	echo '<tr><th>Country</th><th>Total Deaths</th></tr>';
	echo '<tr><td>0</td><td>0</td></tr>';
	echo '<tr><td id="00"></td><td id="01"></td></tr>';
	echo '<tr><td id="10"></td><td id="11"></td></tr>';
	echo '<tr><td id="20"></td><td id="21"></td></tr>';
	echo '<tr><td id="30"></td><td id="31"></td></tr>';
	echo '<tr><td id="40"></td><td id="41"></td></tr>';
	echo '<tr><td id="50"></td><td id="51"></td></tr>';
	echo '<tr><td id="60"></td><td id="61"></td></tr>';
	echo '<tr><td id="70"></td><td id="71"></td></tr>';
	echo '<tr><td id="80"></td><td id="81"></td></tr>';
	echo '<tr><td id="90"></td><td id="91"></td></tr>';
	echo '</table>';

	echo '<script>';
	echo '
		function loadDoc() {
		  var xhttp = new XMLHttpRequest();
		  xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
			  
			  var everything = JSON.parse(this.responseText);
            everything.sort((a,b) => b[7] - a[7]);
			  
			  
			  document.getElementById("00").innerHTML = everything.Countries[0].NewDeaths;
			  document.getElementById("01").innerHTML = everything.Countries[1].NewDeaths;
			  
			}
		  };
		  var api = "https://api.covid19api.com/summary";
		  xhttp.open("GET", api, true);
		  xhttp.send();
		}
	';
	echo '</script>';
	
	// close html body section
	echo '</body>';
	echo '</html>';
}


#-----------------------------------------------------------------------------
// read data from a URL into a string
function curl_get_contents($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
?>
