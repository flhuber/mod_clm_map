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
$document->addStyleSheet(JURI::root(true) . '/modules/mod_clm_map/leaflet/leaflet.css');
$document->addScript(JURI::root(true) . '/modules/mod_clm_map/leaflet/leaflet.js');
$document->addStyleDeclaration( modCLMMapHelper::style($params, $module->id) );

/**
 * This code retrieves the season ID and fetches the club list based on the season ID.
 * It then checks if the club list is null or not. If it is null, it displays an error message.
 * If the club list is not null, it calls the makeMap function to generate the JavaScript code for the map.
 * Finally, it includes the layout file for the mod_clm_map module.
 */

// Get Season ID
$seasonID = modCLMMapHelper::getSeasonID();

if (is_null($seasonID) == false) {
    // Fetch Club Names
    $clubList = modCLMMapHelper::getClubList($seasonID);

    // Map settings
    if ($clubList == null) {
        $js = "console.log('CLM Map: Could not retrieve clubs with set coordinates!');";
    } else {
        $js = modCLMMapHelper::makeMap($params, $seasonID, $clubList, $module->id);
    }
} else {
    $js = "console.log('CLM Map: Could not retrieve a published and active season!');</script>";
}

// Darstellen
require JModuleHelper::getLayoutPath('mod_clm_map');