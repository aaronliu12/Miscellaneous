<?php

/**
* File description
*
* @author James Dowd <talraen@gmail.com>
* @copyright 2012 James Dowd
*/

$context = stream_context_create(array(
	'http' => array(
		'proxy' => 'tcp://proxyanbcge.nbc.com:80',
		'request_fulluri' => true,
	),
));

$fh = fopen('2015 Game Results Data.csv', 'r', null, $context);

$headers = fgetcsv($fh);
set_time_limit(10000);

$ranking = array();
$teams_array = array();

while ($line = fgetcsv($fh)) {
	$temp = array();
	array_push($temp, $line);

	if(isset(${$temp[0][1] . "wins"}) && $temp[0][8] == "Win"){
		array_push(${$temp[0][1] . "wins"}, array($temp[0][4], ($temp[0][3]-$temp[0][5])));
		if(isset(${$temp[0][4] . "losses"})){
			array_push(${$temp[0][4] . "losses"}, array($temp[0][1], ($temp[0][3]-$temp[0][5])));
		}
		else{
			${$temp[0][4] . "losses"} = array(array($temp[0][1], ($temp[0][3]-$temp[0][5])));
			array_push($teams_array, $temp[0][4]);
		}
	}
	else if(isset(${$temp[0][1] . "wins"}) == false && $temp[0][8] == "Win"){
		${$temp[0][1] . "wins"} = array(array($temp[0][4], ($temp[0][3]-$temp[0][5])));
		if(isset(${$temp[0][4] . "losses"})){
			array_push(${$temp[0][4] . "losses"}, array($temp[0][1], ($temp[0][3]-$temp[0][5])));
		}
		else{
			${$temp[0][4] . "losses"} = array(array($temp[0][1], ($temp[0][3]-$temp[0][5])));
			array_push($teams_array, $temp[0][4]);
		}
	}
}

foreach ($teams_array as $key => $team) {
	foreach (${$team . "losses"} as $loss => $betterteam) {
		foreach (${$team . "wins"} as $win => $worseteams) {
			foreach(${$worseteams[0]. "wins"} as $newteam => $teamname){
				if($betterteam[0] == $teamname[0]){
					break 2;
				}	
			}
				foreach (${$teamname[0] . "wins"} as $key => $value) {
					if(isset(${$betterteam[0]."betterthan"}) == false){
						${$betterteam[0]."betterthan"} = array();
					}
					else{
						if(in_array($value[0], ${$betterteam[0]."betterthan"}) == false){
							array_push(${$betterteam[0]."betterthan"}, $value[0]);
						}		
					}
		
				}

		}
	}
}
print_r($Michiganbetterthan);
