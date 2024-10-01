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
    //Color Maps
    const tab20 = [[0.1216, 0.4667, 0.7059], [0.6824, 0.7804, 0.9098], [1.0, 0.498, 0.0549], [1.0, 0.7333, 0.4706], [0.1725, 0.6275, 0.1725], [0.5961, 0.8745, 0.5412], [0.8392, 0.1529, 0.1569], [1.0, 0.5961, 0.5882], [0.5804, 0.4039, 0.7412], [0.7725, 0.6902, 0.8353], [0.549, 0.3373, 0.2941], [0.7686, 0.6118, 0.5804], [0.8902, 0.4667, 0.7608], [0.9686, 0.7137, 0.8235], [0.498, 0.498, 0.498], [0.7804, 0.7804, 0.7804], [0.7373, 0.7412, 0.1333], [0.8588, 0.8588, 0.5529], [0.0902, 0.7451, 0.8118], [0.6196, 0.8549, 0.898]];

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

    public static function getTeamList($selectedID, $params){

        //Obtain database connection
        $db = JFactory::getDbo();
        $selectedIDString = implode(',', $selectedID);
        // Query to get the selected teams
        $query = "SELECT id, sid, zps, name, lokal_coord, liga, tln_nr
                    FROM #__clm_mannschaften 
                    WHERE liga IN ($selectedIDString)"; 
        $db->setQuery($query);
        $teamList = $db->loadObjectList();

        $teamList = self::convertArray($teamList);

        // Do Grouping
        self::doLeagueGrouping($selectedID, $teamList, $params);
        return $teamList;
    }

    private static function doLeagueGrouping($leagueID, $list, $params){

        if($params->get('grouping_liga', 0)==1) //Grouping by League
        {
            $colorArray = self::getColorArray(count($leagueID));
            $groupingArray = array_combine($leagueID, $colorArray);

            foreach ($list as $entry){
                $entry->color = $groupingArray[$entry->liga];
            }
        }
        else //No Grouping
        {
            foreach ($list as $entry){
                $entry->color = '#2880ca';
            }
        }
    }
/**
 * Converts an array of club objects, extracting and assigning coordinates to each club.
 * Clubs with null coordinates are filtered out.
 *
 * @param array $queriedEntries The array of club objects to convert.
 * @return array The converted array of club objects.
 */
private static function convertArray($queriedEntries)
{
    // Extract coordinates
    foreach ($queriedEntries as $club) {
        $coord_text = $club->lokal_coord;
        $coordinates = self::extractCoordinatesFromText($coord_text);
        $club->lokal_coord_lat = $coordinates[0];
        $club->lokal_coord_long = $coordinates[1];
    }

    // Delete clubs where coordinates are NULL
    $queriedEntries = array_filter($queriedEntries, function ($club) {
        return $club->lokal_coord_lat !== null || $club->lokal_coord_long !== null;
    });

    return $queriedEntries;
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

private static function getHeader($id){

    $js = "var map".$id." = new L.map('map".$id."');\n";
    //Set Layer
    $js .= "var tileLayer".$id." = new L.TileLayer('https://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png',{
        attribution: '<a href=\"https://www.openstreetmap.org/copyright\" target=\"_blank\">© OpenStreetMap contributors</a>',
        noWrap: false});\n";
    // Add Control Scale to Map
    $js .= "L.control.scale({metric:true,imperial:false}).addTo(map".$id.");\n";

    // Set Map View 
    $js .= "map".$id.".addLayer(tileLayer".$id.");\n";

    // Add cluster
    $js .= "var markers = L.markerClusterGroup({maxClusterRadius:1, showCoverageOnHover:false});\n";
    //Create empty array for coordinates 
    $js .= "var coordinateArray = [];\n";
    return $js;
}

private static function getValueFromArray($array, $fraction){
    // Ensure the input is between 0 and 1
    if ($fraction < 0 || $fraction > 1) {
        return null; // Handle invalid input
    }

    // Calculate the index (0 to count($array) - 1)
    $index = round($fraction * (count($array) - 1));

    // Return the value at the calculated index
    return $array[$index];
}

private static function getColorArray($count){    
    $colorArray = array();
    for ($i = 1; $i <= $count; $i++){
        $colorArray[$i] = self::getValueFromArray(self::tab20, $i/$count);
    }

    //Convert to full RGB
    $colorArray = array_map(fn($color) => array_map(fn($c) => round($c * 255), $color), $colorArray);
    //Convert to hex
    $colorArray = array_map(fn($rgb) => sprintf("#%02x%02x%02x", ...$rgb), $colorArray);

    return $colorArray;
    }
/**
 * Creates a map with markers for clthe teams.
 *
 * @param int $seasonID - The ID of the season.
 * @param array $queriedEntries - The list of clubs.
 * @param int $id - The ID of the map.
 * @return string - The JavaScript code for creating the map.
 */
public static function makeLeagueMap($params, $queriedEntries, $id){
    $localURL = JUri::base();

    $js = self::getHeader($id);

    // Add Markers for Clubs
    foreach ($queriedEntries as $entry){


        // First set the marker
        $js .= "var marker$entry->id = L.marker([$entry->lokal_coord_lat,$entry->lokal_coord_long],{icon: colorMarker('$entry->color'),}).addTo(map$id);\n";
        
        // Second set the Popup content
        // $js = "var colorLink = 'color:black';\n";
        $js .= "var popup$entry->id = \"<h6 style='color:black'><a href='{$localURL}index.php?option=com_clm&view=mannschaft&saison=$entry->sid&liga=$entry->liga&tlnr=$entry->tln_nr&Itemid=101'>$entry->name</a></h6>\"\n";
        
        // Set the Popup
        $js .= "marker$entry->id.bindPopup(popup$entry->id);\n";    

        //For centering and zooming add coordinates to array
        $js .= "coordinateArray.push([$entry->lokal_coord_lat,$entry->lokal_coord_long]);\n";

        // Add marker to cluster
        $js .= "markers.addLayer(marker$entry->id);\n";
    }

    // Add cluster to map
    $js .= "map".$id.".addLayer(markers);\n";
    // Set zoom and fit map to markers 
    $js .= "map".$id.".fitBounds(L.latLngBounds(coordinateArray));\n";

    // Create Legend
    $js .= "var legend = L.control({position: 'bottomright'});\n";

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

/**
 * Creates a map with markers for club teams.
 *
 * @param int $seasonID - The ID of the season.
 * @param array $queriedEntries - The list of clubs.
 * @param int $id - The ID of the map.
 * @return string - The JavaScript code for creating the map.
 */
public static function makeClubMap($params, $queriedEntries, $id){
    $localURL = JUri::base();

    $js = self::getHeader($id);

    // Add Markers for Clubs
    foreach ($queriedEntries as $entry){


        // First set the marker
        $js .= "var marker$entry->id = L.marker([$entry->lokal_coord_lat,$entry->lokal_coord_long],{icon: colorMarker('$entry->color'),}).addTo(map$id);\n";
        
        // Second set the Popup content
        // $js = "var colorLink = 'color:black';\n";
        $js .= "var popup$entry->id = \"<h6 style='color:black'><a href='{$localURL}index.php?option=com_clm&view=verein&saison=$entry->sid&zps=$entry->zps'>$entry->name</a></h6>\"\n";
        
        // Set the Popup
        $js .= "marker$entry->id.bindPopup(popup$entry->id);\n";    

        //For centering and zooming add coordinates to array
        $js .= "coordinateArray.push([$entry->lokal_coord_lat,$entry->lokal_coord_long]);\n";

        // Add marker to cluster
        $js .= "markers.addLayer(marker$entry->id);\n";
    }

    // Add cluster to map
    $js .= "map".$id.".addLayer(markers);\n";
    // Set zoom and fit map to markers 
    $js .= "map".$id.".fitBounds(L.latLngBounds(coordinateArray));\n";

    // Create Legend
    $js .= "var legend = L.control({position: 'bottomright'});\n";

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

