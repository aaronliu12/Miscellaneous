<?php

/**
* File description
*
* @author Aaron Liu <aaronliu12@gmail.com>
* @copyright 2015 Aaron Liu
*/

$context = stream_context_create(array(
	'http' => array(
		'proxy' => ''=,
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
		}
	}
	else if(isset(${$temp[0][1] . "wins"}) == false && $temp[0][8] == "Win"){
		${$temp[0][1] . "wins"} = array(array($temp[0][4], ($temp[0][3]-$temp[0][5])));
		array_push($teams_array, $temp[0][1]);
		if(isset(${$temp[0][4] . "losses"})){
			array_push(${$temp[0][4] . "losses"}, array($temp[0][1], ($temp[0][3]-$temp[0][5])));
		}
		else{
			${$temp[0][4] . "losses"} = array(array($temp[0][1], ($temp[0][3]-$temp[0][5])));
		}
	}
}

foreach ($teams_array as $key => $team) {
	if(isset(${$team . "losses"})){
		foreach (${$team . "losses"} as $loss => $betterteam) {
			if(isset(${$team . "wins"})){
				foreach (${$team . "wins"} as $win => $worseteams) {
					if(isset(${$worseteams[0]. "wins"})){
						foreach(${$worseteams[0]. "wins"} as $newteam => $teamname){
							if($betterteam[0] == $teamname[0]){
								break 2;
							}	
						}
							if(isset(${$teamname[0]. "wins"})){
/*								if(isset(${$betterteam[0]."betterthan"}) == false){
									${$betterteam[0]."betterthan"} = array();
								}
								else{
									if(in_array($teamname[0], ${$betterteam[0]."betterthan"}) == false){
										if(isset(${$betterteam[0]."losses"})){
											foreach (${$betterteam[0]."losses"} as $losses => $teamloss) {
												if($teamloss[0] == $teamname[0]){
													break 2;
												}
											}
										}	
										array_push(${$betterteam[0]."betterthan"}, $teamname[0]);	
									}		
								}*/

								foreach (${$teamname[0] . "wins"} as $key => $value) {
									if(isset(${$betterteam[0]."betterthan"}) == false){
										${$betterteam[0]."betterthan"} = array();
									}
									else{
										if(in_array($value[0], ${$betterteam[0]."betterthan"}) == false){
											if(isset(${$betterteam[0]."losses"})){
												foreach (${$betterteam[0]."losses"} as $losses => $teamloss) {
													if($teamloss[0] == $value[0]){
														break 2;
													}
												}
											}	
											array_push(${$betterteam[0]."betterthan"}, $value[0]);	
										}		
									}
						
								}
							}	

					}
				}	
			}	
		}	
	}
}

foreach ($teams_array as $key => $team) {
	if(isset(${$team . "betterthan"})){
		$betterthantotal = sizeof(${$team . "betterthan"});
		$ranking[$team] = $betterthantotal;
	}	


}
arsort($ranking);

$counting_var = 1;
foreach ($ranking as $key => $value) {
	echo $counting_var . ". ";
	echo $key . " ";
	echo $value . "<br />";

	$counting_var += 1;
}

print_r($Kansasbetterthan);
