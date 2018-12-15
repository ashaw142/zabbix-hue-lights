#!/usr/bin/php -q
<?php

/**
* Zabbix Low Level Discovery Script for Philips Hue Bulbs
* @author Andrew Shaw - a@ashaw.uk
* @date 2018-12-15
**/

// Check if the user has actually asked us to do anything
if ($argv[1] == '') {echo usage();}

/**
* Tell users how to run the script if they did not supply arguments
**/
function usage() {
	echo "Usage: ./zabbix-hue-bulbs.php [<discover>|<reachable> <bulbId>]\n";
	die("No arguments supplied.\n");
}

// Load in some configuration data
require_once('hue-credentials.conf.php');

// Set Hue Hub API location as is required for all interactions with the Hue Hub
$strBaseUrl = "http://$strHueHost/api/$strHueUser/";

/**
* Philips Hue Bulbs Discovery Function
**/
function discoverBulbs($strBaseUrl) {
	// call the API for list of lights
	$objHueLightsList = json_decode(file_get_contents($strBaseUrl."lights"));
	// how many lights were listed?
	$intCountOfLights = count((array) $objHueLightsList);
	//Initialise a data object
	$arrDiscoveredBulbs = array();
	// iterate through and format for Zabbix LLD
	for ($i = 1; $i <= $intCountOfLights; $i++) {
		$arrDiscoveredBulbs['data'][] = array(
			'{#BULBID}' => $i,
			'{#BULBNAME}' => $objHueLightsList->{$i}->name,
		);
	}
	// Return the discovered bulbs in JSON for Zabbix
	return json_encode($arrDiscoveredBulbs);
}

/**
* Philips Hue Bulb Reachability Query
**/
function isReachable($strBaseUrl, $intBulbId) {
	// Get bulb JSON
	$objBulbState = json_decode(file_get_contents($strBaseUrl."lights/".$intBulbId));
	// Check the reachable field
	$bolReachable = $objBulbState->state->reachable;
	// report in Zabbix friendly format
	if ($bolReachable == true) {
		return 1;
	} else {
		return 0;
	}
}

// take in args and act.
if ($argv[1] == "discover") {
	echo discoverBulbs($strBaseUrl);
}
else if ($argv[1] == 'reachable') {
	$intBulbId = $argv[2];
	echo isReachable($strBaseUrl, $intBulbId);
}