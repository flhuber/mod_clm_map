<?php
/**
 * @ Chess League Manager (CLM) Modul Club Map 
 * @Copyright (C) 2011-2024 CLM Team.  All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.chessleaguemanager.de
*/
// no direct access
defined('_JEXEC') or die('Restricted access');

class ModCLMMapHelper
{
     /**
     * Determines the active season ID.
     *     * 
     * @access public
     * @return int The ID of the active season.
     */    
    public static function getSeasonID(){
        $db = JFactory::getDbo(); // Get DB Connection
        // Query to select the ID of the active season
        $db->setQuery("SELECT id FROM #__clm_saison WHERE published = 1 AND archiv = 0 ORDER BY name DESC LIMIT 1 ");
        $season = $db->loadObject()->id; // Return only one season in case we have more than one active season
        // Do not check for NULL, this is done once outside
        return $season;
    }

    /**
     * Generates CSS styles for the map based on module parameters.
     * This function creates a CSS string that defines the height of the map and resets the style of links
     * in the map's attribution control to inherit from the page's styles.
     * 
     * @param   array  $params An object containing the module parameters.
     * @param   int    $id     The module ID used to uniquely identify the map element.
     * @access public
     * @return string A string containing CSS styles for the map.
     */    
    public static function style($params, $id){
        $style = '#map'.$id.'{'
                .'    height:'.$params->get('height', 200).'px;'
                .'}'
                .'.leaflet-control-attribution a{' // reset link style
                .'    color: inherit !important;'
                .'    font-weight: normal !important;'
                .'}';
        return $style;
    }


    /**
     * Fetches a list of clubs from the database for a given season.
     * This function queries the database for clubs that are published in the specified season
     * and returns a list of these clubs, including their ID, name, and location coordinates.
     * 
     * @param   int   $seasonID The ID of the active season for which to retrieve club information.
     * @access public
     * @return array An array of objects, each representing a club with its details.
     */    
    public static function getClubList($seasonID){
         //Obtain database connection
         $db = JFactory::getDbo();
         // Query to get a list of clubs for the specified season
         $query = "SELECT zps, name, lokal_coord "
         . " FROM #__clm_vereine "
         . " WHERE sid = $seasonID AND published = 1";
         $db->setQuery($query);
         $clubList = $db->loadObjectList();

         $clubList = self::convertArray($clubList);

        return $clubList;
    }
/**
 * Converts an array of club objects, extracting and assigning coordinates to each club.
 * Clubs with null coordinates are filtered out.
 *
 * @param array $clubList The array of club objects to convert.
 * @return array The converted array of club objects.
 */
private static function convertArray($clubList)
{
    // Extract coordinates
    foreach ($clubList as $club) {
        $coord_text = $club->lokal_coord;
        $coordinates = self::extractCoordinatesFromText($coord_text);
        $club->lokal_coord_lat = $coordinates[0];
        $club->lokal_coord_long = $coordinates[1];
    }

    // Delete clubs where coordinates are NULL
    $clubList = array_filter($clubList, function ($club) {
        return $club->lokal_coord_lat !== null || $club->lokal_coord_long !== null;
    });

    return $clubList;
}

/**
 * Extracts coordinates from a given text.
 *
 * @param string|null $coord_text The text containing the coordinates.
 * @return array An array containing the latitude and longitude extracted from the text.
 */
private static function extractCoordinatesFromText($coord_text){
    if (!is_null($coord_text)) {
        preg_match('/POINT\(([-\d\.]+) ([-\d\.]+)\)/', $coord_text, $matches);
        if ($matches) {
            $lat = $matches[1];
            $long = $matches[2];
        } else {
            $lat = null;
            $long = null;
        }
    } else {
        $lat = null;
        $long = null;
    }
    return array($lat, $long);
}
/**
 * Creates a map with markers for clubs.
 *
 * @param int $seasonID - The ID of the season.
 * @param array $clubList - The list of clubs.
 * @param int $id - The ID of the map.
 * @return string - The JavaScript code for creating the map.
 */
public static function makeMap($params, $seasonID, $clubList, $id){
    $localURL = JUri::base();
    // Create map
    $js = "var map".$id." = new L.map('map".$id."');\n";
    //Set Layer
    $js .= "var tileLayer".$id." = new L.TileLayer('https://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png',{
        attribution: '<a href=\"https://www.openstreetmap.org/copyright\" target=\"_blank\">© OpenStreetMap contributors</a>',
        noWrap: false});\n";
   
    // Add Control Scale to Map
    $js .= "L.control.scale({metric:true,imperial:false}).addTo(map".$id.");\n";

    // Set Map View 
    //$js .= "map".$id.".setView(coordinate".$id.", 9).addLayer(tileLayer".$id.");\n"; //9 is Zoom
    $js .= "map".$id.".addLayer(tileLayer".$id.");\n";

    //Create empty array for coordinates 
    $js .= "var coordinateArray = [];\n";
    // Add Markers for Clubs
    foreach ($clubList as $club){
        // First set the marker
        $js .= "var marker$club->zps = L.marker([$club->lokal_coord_lat,$club->lokal_coord_long]).addTo(map$id);\n";
        
        // Second set the Popup content
        // $js = "var colorLink = 'color:black';\n";
        $js .= "var popup$club->zps = \"<h6 style='color:black'><a href='{$localURL}index.php?option=com_clm&view=verein&saison=$seasonID&zps=$club->zps'>$club->name</a></h6>\"\n";
        
        // Set the Popup
        $js .= "marker$club->zps.bindPopup(popup$club->zps);\n";    

        //For centering and zooming add coordinates to array
        $js .= "coordinateArray.push([$club->lokal_coord_lat,$club->lokal_coord_long]);\n";
    }
    // Set zoom and fit map to markers 
    $js .= "map".$id.".fitBounds(L.latLngBounds(coordinateArray));\n";

    //Apply module settings for scrolling and dragging
    if($params->get('scrollWheelZoom', 0) == 1){
        $js .= "map".$id.".scrollWheelZoom.enable();\n";
    } else {
        $js .= "map".$id.".scrollWheelZoom.disable();\n";
    }
    if($params->get('dragging', 0) == 1){
        $js .= "map".$id.".dragging.enable();\n";
    } else {
        $js .= "map".$id.".dragging.disable();\n";
    }
    // Return the JavaScript code
    return $js;
}
}

