<?php
/**
 * Club Map for Chess League Manager
 * 
 * @package    Joomla.Tutorials
 * @subpackage Modules
 * @license    GNU/GPL, see LICENSE.php
 * @link       GIT LINK
 * mod_clm_map is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// No direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';

// Include scripts and set style 
$document = JFactory::getDocument();
//$document->addScript(JURI::root(true) . '/modules/mod_clm_map/lib/js-colormaps.js');
$document->addScript(JURI::root(true) . '/modules/mod_clm_map/lib/svg-marker.js');
$document->addScript('https://unpkg.com/leaflet@1.9.4/dist/leaflet.js');
$document->addStyleSheet('https://unpkg.com/leaflet@1.9.4/dist/leaflet.css');
$document->addStyleSheet('https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css');
$document->addStyleSheet('https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css');
$document->addScript('https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js');

$document->addStyleDeclaration( modCLMMapHelper::style($params, $module->id) );

/**
 * This code retrieves the season ID and fetches the club list based on the season ID.
 * It then checks if the club list is null or not. If it is null, it displays an error message.
 * If the club list is not null, it calls the makeMap function to generate the JavaScript code for the map.
 * Finally, it includes the layout file for the mod_clm_map module.
 */

// Get mode
$moduleMode = $params->get('module_mode');
if ($moduleMode == '0') // Show teams of leagues
{
    //Plausability check
    $selectedEntries = $params->get('liga');
    if ($selectedEntries == null) {
        $js = "console.log('CLM Map: No leagues selected!');";
    }
    else{
        $queriedEntries = modCLMMapHelper::getTeamList($selectedEntries, $params);
        if ($queriedEntries == null) {
            $js = "console.log('CLM Map: Could not retrieve teams with set coordinates!');";
        } else {
            $js = modCLMMapHelper::makeLeagueMap($params, $queriedEntries, $module->id);
        }
    }

}
else //Show clubs
{
    $queriedEntries = modCLMMapHelper::getClubList($params);
    if ($queriedEntries == null) {
        $js = "console.log('CLM Map: Could not retrieve clubs with set coordinates!');";
    } else {
        $js = modCLMMapHelper::makeClubMap($params, $queriedEntries, $module->id);
    }
}

// Darstellen
require JModuleHelper::getLayoutPath('mod_clm_map');