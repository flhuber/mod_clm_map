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
    //Color Maps (based on matplotlib)
    const tab20 = [[0.1216, 0.4667, 0.7059], [0.6824, 0.7804, 0.9098], [1.0, 0.498, 0.0549], [1.0, 0.7333, 0.4706], [0.1725, 0.6275, 0.1725], [0.5961, 0.8745, 0.5412], [0.8392, 0.1529, 0.1569], [1.0, 0.5961, 0.5882], [0.5804, 0.4039, 0.7412], [0.7725, 0.6902, 0.8353], [0.549, 0.3373, 0.2941], [0.7686, 0.6118, 0.5804], [0.8902, 0.4667, 0.7608], [0.9686, 0.7137, 0.8235], [0.498, 0.498, 0.498], [0.7804, 0.7804, 0.7804], [0.7373, 0.7412, 0.1333], [0.8588, 0.8588, 0.5529], [0.0902, 0.7451, 0.8118], [0.6196, 0.8549, 0.898]];
    const gnuplot = [[0.0, 0.0, 0.0], [0.0626, 0.0, 0.0246], [0.0886, 0.0, 0.0493], [0.1085, 0.0, 0.0739], [0.1252, 0.0, 0.0984], [0.14, 0.0, 0.1229], [0.1534, 0.0, 0.1473], [0.1657, 0.0, 0.1716], [0.1771, 0.0, 0.1958], [0.1879, 0.0, 0.2199], [0.198, 0.0001, 0.2439], [0.2077, 0.0001, 0.2677], [0.2169, 0.0001, 0.2914], [0.2258, 0.0001, 0.3149], [0.2343, 0.0002, 0.3382], [0.2425, 0.0002, 0.3612], [0.2505, 0.0002, 0.3841], [0.2582, 0.0003, 0.4067], [0.2657, 0.0004, 0.4291], [0.273, 0.0004, 0.4512], [0.2801, 0.0005, 0.4731], [0.287, 0.0006, 0.4947], [0.2937, 0.0006, 0.5159], [0.3003, 0.0007, 0.5369], [0.3068, 0.0008, 0.5575], [0.3131, 0.0009, 0.5778], [0.3193, 0.0011, 0.5977], [0.3254, 0.0012, 0.6173], [0.3314, 0.0013, 0.6365], [0.3372, 0.0015, 0.6553], [0.343, 0.0016, 0.6737], [0.3487, 0.0018, 0.6917], [0.3542, 0.002, 0.7093], [0.3597, 0.0022, 0.7264], [0.3651, 0.0024, 0.7431], [0.3705, 0.0026, 0.7594], [0.3757, 0.0028, 0.7752], [0.3809, 0.0031, 0.7905], [0.386, 0.0033, 0.8054], [0.3911, 0.0036, 0.8197], [0.3961, 0.0039, 0.8336], [0.401, 0.0042, 0.847], [0.4058, 0.0045, 0.8598], [0.4106, 0.0048, 0.8721], [0.4154, 0.0051, 0.8839], [0.4201, 0.0055, 0.8952], [0.4247, 0.0059, 0.9059], [0.4293, 0.0063, 0.916], [0.4339, 0.0067, 0.9256], [0.4384, 0.0071, 0.9347], [0.4428, 0.0075, 0.9432], [0.4472, 0.008, 0.9511], [0.4516, 0.0085, 0.9584], [0.4559, 0.009, 0.9651], [0.4602, 0.0095, 0.9713], [0.4644, 0.01, 0.9768], [0.4686, 0.0106, 0.9818], [0.4728, 0.0112, 0.9862], [0.4769, 0.0118, 0.99], [0.481, 0.0124, 0.9932], [0.4851, 0.013, 0.9957], [0.4891, 0.0137, 0.9977], [0.4931, 0.0144, 0.9991], [0.4971, 0.0151, 0.9998], [0.501, 0.0158, 1.0], [0.5049, 0.0166, 0.9995], [0.5087, 0.0173, 0.9985], [0.5126, 0.0181, 0.9968], [0.5164, 0.019, 0.9945], [0.5202, 0.0198, 0.9916], [0.5239, 0.0207, 0.9882], [0.5277, 0.0216, 0.9841], [0.5314, 0.0225, 0.9794], [0.535, 0.0235, 0.9741], [0.5387, 0.0244, 0.9683], [0.5423, 0.0254, 0.9618], [0.5459, 0.0265, 0.9548], [0.5495, 0.0275, 0.9472], [0.5531, 0.0286, 0.939], [0.5566, 0.0297, 0.9302], [0.5601, 0.0309, 0.9209], [0.5636, 0.0321, 0.911], [0.5671, 0.0333, 0.9006], [0.5705, 0.0345, 0.8896], [0.5739, 0.0357, 0.8781], [0.5774, 0.037, 0.866], [0.5807, 0.0384, 0.8534], [0.5841, 0.0397, 0.8403], [0.5875, 0.0411, 0.8267], [0.5908, 0.0425, 0.8126], [0.5941, 0.044, 0.798], [0.5974, 0.0454, 0.7829], [0.6007, 0.047, 0.7674], [0.6039, 0.0485, 0.7513], [0.6071, 0.0501, 0.7348], [0.6104, 0.0517, 0.7179], [0.6136, 0.0534, 0.7005], [0.6168, 0.055, 0.6827], [0.6199, 0.0568, 0.6645], [0.6231, 0.0585, 0.6459], [0.6262, 0.0603, 0.6269], [0.6293, 0.0621, 0.6075], [0.6325, 0.064, 0.5878], [0.6355, 0.0659, 0.5677], [0.6386, 0.0678, 0.5472], [0.6417, 0.0698, 0.5264], [0.6447, 0.0718, 0.5053], [0.6478, 0.0739, 0.4839], [0.6508, 0.076, 0.4622], [0.6538, 0.0781, 0.4402], [0.6568, 0.0803, 0.418], [0.6598, 0.0825, 0.3955], [0.6627, 0.0847, 0.3727], [0.6657, 0.087, 0.3497], [0.6686, 0.0893, 0.3265], [0.6716, 0.0917, 0.3032], [0.6745, 0.0941, 0.2796], [0.6774, 0.0966, 0.2558], [0.6803, 0.0991, 0.2319], [0.6831, 0.1016, 0.2079], [0.686, 0.1042, 0.1837], [0.6888, 0.1068, 0.1595], [0.6917, 0.1095, 0.1351], [0.6945, 0.1122, 0.1107], [0.6973, 0.115, 0.0861], [0.7001, 0.1178, 0.0616], [0.7029, 0.1206, 0.037], [0.7057, 0.1235, 0.0123], [0.7085, 0.1265, 0.0], [0.7113, 0.1295, 0.0], [0.714, 0.1325, 0.0], [0.7167, 0.1356, 0.0], [0.7195, 0.1387, 0.0], [0.7222, 0.1419, 0.0], [0.7249, 0.1451, 0.0], [0.7276, 0.1484, 0.0], [0.7303, 0.1517, 0.0], [0.733, 0.1551, 0.0], [0.7356, 0.1585, 0.0], [0.7383, 0.162, 0.0], [0.741, 0.1655, 0.0], [0.7436, 0.1691, 0.0], [0.7462, 0.1727, 0.0], [0.7489, 0.1764, 0.0], [0.7515, 0.1801, 0.0], [0.7541, 0.1839, 0.0], [0.7567, 0.1877, 0.0], [0.7593, 0.1916, 0.0], [0.7618, 0.1955, 0.0], [0.7644, 0.1995, 0.0], [0.767, 0.2035, 0.0], [0.7695, 0.2076, 0.0], [0.7721, 0.2118, 0.0], [0.7746, 0.216, 0.0], [0.7771, 0.2203, 0.0], [0.7796, 0.2246, 0.0], [0.7822, 0.229, 0.0], [0.7847, 0.2334, 0.0], [0.7872, 0.2379, 0.0], [0.7896, 0.2424, 0.0], [0.7921, 0.247, 0.0], [0.7946, 0.2517, 0.0], [0.7971, 0.2564, 0.0], [0.7995, 0.2612, 0.0], [0.802, 0.266, 0.0], [0.8044, 0.2709, 0.0], [0.8068, 0.2759, 0.0], [0.8093, 0.2809, 0.0], [0.8117, 0.286, 0.0], [0.8141, 0.2911, 0.0], [0.8165, 0.2963, 0.0], [0.8189, 0.3016, 0.0], [0.8213, 0.3069, 0.0], [0.8237, 0.3123, 0.0], [0.826, 0.3177, 0.0], [0.8284, 0.3232, 0.0], [0.8308, 0.3288, 0.0], [0.8331, 0.3344, 0.0], [0.8355, 0.3401, 0.0], [0.8378, 0.3459, 0.0], [0.8402, 0.3517, 0.0], [0.8425, 0.3576, 0.0], [0.8448, 0.3636, 0.0], [0.8471, 0.3696, 0.0], [0.8495, 0.3757, 0.0], [0.8518, 0.3819, 0.0], [0.8541, 0.3881, 0.0], [0.8563, 0.3944, 0.0], [0.8586, 0.4007, 0.0], [0.8609, 0.4072, 0.0], [0.8632, 0.4137, 0.0], [0.8655, 0.4202, 0.0], [0.8677, 0.4269, 0.0], [0.87, 0.4336, 0.0], [0.8722, 0.4403, 0.0], [0.8745, 0.4472, 0.0], [0.8767, 0.4541, 0.0], [0.8789, 0.4611, 0.0], [0.8812, 0.4681, 0.0], [0.8834, 0.4753, 0.0], [0.8856, 0.4825, 0.0], [0.8878, 0.4897, 0.0], [0.89, 0.4971, 0.0], [0.8922, 0.5045, 0.0], [0.8944, 0.512, 0.0], [0.8966, 0.5196, 0.0], [0.8988, 0.5272, 0.0], [0.901, 0.5349, 0.0], [0.9032, 0.5427, 0.0], [0.9053, 0.5506, 0.0], [0.9075, 0.5585, 0.0], [0.9096, 0.5665, 0.0], [0.9118, 0.5746, 0.0], [0.9139, 0.5828, 0.0], [0.9161, 0.591, 0.0], [0.9182, 0.5994, 0.0], [0.9204, 0.6078, 0.0], [0.9225, 0.6163, 0.0], [0.9246, 0.6248, 0.0], [0.9267, 0.6334, 0.0], [0.9288, 0.6422, 0.0], [0.9309, 0.651, 0.0], [0.9331, 0.6598, 0.0], [0.9352, 0.6688, 0.0], [0.9372, 0.6778, 0.0], [0.9393, 0.687, 0.0], [0.9414, 0.6962, 0.0], [0.9435, 0.7054, 0.0], [0.9456, 0.7148, 0.0], [0.9476, 0.7242, 0.0], [0.9497, 0.7338, 0.0], [0.9518, 0.7434, 0.0], [0.9538, 0.7531, 0.0], [0.9559, 0.7629, 0.0], [0.9579, 0.7727, 0.0], [0.96, 0.7827, 0.0], [0.962, 0.7927, 0.0], [0.9641, 0.8028, 0.0], [0.9661, 0.813, 0.0], [0.9681, 0.8233, 0.0], [0.9701, 0.8337, 0.0], [0.9722, 0.8442, 0.0], [0.9742, 0.8547, 0.0], [0.9762, 0.8654, 0.0], [0.9782, 0.8761, 0.0], [0.9802, 0.8869, 0.0], [0.9822, 0.8978, 0.0], [0.9842, 0.9088, 0.0], [0.9862, 0.9199, 0.0], [0.9882, 0.9311, 0.0], [0.9901, 0.9423, 0.0], [0.9921, 0.9537, 0.0], [0.9941, 0.9651, 0.0], [0.9961, 0.9767, 0.0], [0.998, 0.9883, 0.0], [1.0, 1.0, 0.0]];
    
    
    /**
     * Generates CSS styles for the map based on module parameters.
     * This function creates a CSS string that defines the height of the map and resets the style of links
     * in the map's attribution control to inherit from the page's styles.
     * 
     * @param   object  $params An object containing the module parameters.
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
     * Retrieves a list of teams based on the selected IDs and parameters.
     *
     * @param array $selectedID An array of selected IDs of teams in the module settings.
     * @param object $params Module parameters.
     * @return array The list of teams.
     */
    public static function getTeamList($selectedID, $params){

        //Obtain database connection
        $db = JFactory::getDbo();
        $selectedIDString = implode(',', $selectedID);
        // Query to get the selected teams
        $query = "SELECT m.id, m.sid, m.zps, m.name, m.lokal_coord, m.liga, m.tln_nr, l.name AS liga_name
                    FROM #__clm_mannschaften m
                    JOIN #__clm_liga l ON m.liga = l.id
                    WHERE m.liga IN ($selectedIDString) AND m.sid = l.sid"; 
        $db->setQuery($query);
        $teamList = $db->loadObjectList();

        $teamList = self::convertArray($teamList);

        // Do Grouping
        self::doLeagueGrouping($selectedID, $teamList, $params);

        // Remove clubs with zero coordinates
        if($params->get('remove_coordinates', 0)==1) //Grouping by League
        {
            $teamList = self::removeZeroCoordinates($teamList);
        }
        return $teamList;
    }

    /**
     * Retrieves a list of clubs based on the given parameters.
     *
     * @param object $params Module parameters.
     * @return array|null The list of clubs or null if no selection is done in module settings.
     */
    public static function getClubList($params){

        //Mode
        $mode = $params->get('grouping_vereine', 0);
        $selectedEntries = null;
        //Obtain database connection
        $db = JFactory::getDbo();
        // Case 1: Get all clubs of current season
        if($mode==0)
        {
            $query = "SELECT id, sid, zps, name, lokal_coord
            FROM #__clm_vereine
            WHERE sid = (
                SELECT id
                FROM #__clm_saison
                WHERE published = 1 AND archiv = 0
                ORDER BY name DESC
                LIMIT 1);";
        }
        // Case 2: Get clubs of selected Bezirk or Landesverband
        elseif($mode==1||$mode==2)
        {
            if($mode==1)
            { 
               $selectedEntries = $params->get('grouping_bezirk');
            }
            else
            {
                $selectedEntries = $params->get('grouping_land');
            }
            if ($selectedEntries == null) {
                return null; //No selection done in module settings
            }
            $zpsCondition = implode(" OR ", array_map(fn($entry) => "zps LIKE '$entry%'", $selectedEntries));
            {
                $query = "SELECT id, sid, zps, name, lokal_coord
                FROM #__clm_vereine
                WHERE sid = (
                    SELECT id
                    FROM #__clm_saison
                    WHERE published = 1 AND archiv = 0
                    ORDER BY name DESC
                    LIMIT 1
                )
                AND ($zpsCondition)";
            }
        }
        $db->setQuery($query);


        // Query to get the selected teams
        $clubList = $db->loadObjectList();

        $clubList = self::convertArray($clubList);
        // Remove clubs with zero coordinates
        if($params->get('remove_coordinates', 0)==1) 
        {
            $clubList = self::removeZeroCoordinates($clubList);
        }

        // Do Grouping
        self::doClubGrouping($selectedEntries, $clubList, $params);

        return $clubList;
    }

    /**
     * Removes entries with zero coordinates from the given list.
     *
     * @param array $list The list of entries to filter.
     * @return array The filtered list with entries that have non-zero coordinates.
     */
    private static function removeZeroCoordinates($list){
        return array_filter($list, function($entry){
            return $entry->lokal_coord_lat != 0 && $entry->lokal_coord_long != 0;
        });
    }

    /**
     * Performs league grouping based on the given parameters.
     *
     * @param array $leagueID The array of league IDs.
     * @param array $list Array of teams.
     * @param object $params Module settings.
     * @return void
     */
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
     * Performs club grouping based on selected entries, club list, and modul settings.
     *
     * @param array|null $selectedEntries The selected entries for grouping.
     * @param array $list The list of clubs.
     * @param object $params Module settings.
     * @return void
     */
    private static function doClubGrouping($selectedEntries, $list, $params){

        if(is_null($selectedEntries)) //No grouping
        {
            foreach ($list as $entry){
                $entry->color = '#2880ca';
            }
        }
        else //Grouping by Bezirk or Landesverband
        {
            $colorArray = self::getColorArray(count($selectedEntries));
            $groupingArray = array_combine($selectedEntries, $colorArray);

            foreach ($list as $entry){
                if($params->get('grouping_vereine')==1)
                {$prefix = substr($entry->zps, 0, 3);}
                elseif($params->get('grouping_vereine')==2)
                {$prefix = substr($entry->zps, 0, 2);}
                else
                {$prefix = substr($entry->zps, 0, 1);}
                $entry->color = $groupingArray[$prefix];
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

/**
 * Retrieves the header JavaScript code for the map.
 *
 * @param int $id The ID of the map.
 * @return string The JavaScript code for the header.
 */
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
    $js .= "var markers = L.markerClusterGroup({maxClusterRadius:5, showCoverageOnHover:false, zoomToBoundsOnClick:true});\n";
    //Create empty array for coordinates 
    $js .= "var coordinateArray = [];\n";
    return $js;
}

/**
 * Retrieves the RGB value from a color maps with discrete steps.
 *
 * @param array $array The colormap.
 * @param float $fraction The fraction used to calculate the index.
 * @return array The RGB value at the calculated index.
 */
private static function getValueFromDiscreteArray($array, $fraction){
    // Calculate the index (0 to count($array) - 1)
    $index = round($fraction * (count($array) - 1));
    //Convert to full RGB
    $rgb = array_map(fn($c) => round($c * 255), $array[$index]);
    // Return the value at the calculated index
    return $rgb;
}

/**
 * Retrieves the interpolated RGB value from color map.
 *
 * @param array $array The colormap.
 * @param float $fraction The fraction used to calculate the interpolated RGB value.
 * @return array The interpolated RGB value.
 */
private static function getValueFromInterpolatedArray($array, $fraction){

    $lo = floor($fraction * (count($array) - 1));
    $hi = ceil($fraction * (count($array) - 1));
    $rgb = array();
    for ($i = 0; $i <= 2; $i++){
        $rgb[$i] = round((($array[$lo][$i] + $array[$hi][$i]) / 2) * 255);
    }
    return $rgb;
}

/**
 * Returns an array of colors based on the given count.
 *
 * If the num is less than or equal to 20, the function uses the tab20 color array.
 * Otherwise, it uses the gnuplot color array (which can be interpolated) for more than 20 entries.
 *
 * @param int $num The number of colors needed.
 * @return array An array of colors in hexadecimal format.
 */
private static function getColorArray($num){   
    $colorArray = array(); 
    if ($num <= 20) //Use tab20 
    {
        for ($i = 0; $i < $num; $i++){
            $colorArray[$i] = self::getValueFromDiscreteArray(self::tab20, $i/$num);
        }
    }   
    else //Use gnuplot (can be interpolated) for more than 20 entries
    {
        for ($i = 0; $i < $num; $i++){
            $colorArray[$i] = self::getValueFromInterpolatedArray(self::gnuplot, $i/$num);
        }
    }

    //Convert to hex
    $colorArray = array_map(fn($rgb) => sprintf("#%02x%02x%02x", ...$rgb), $colorArray);

    return $colorArray;
    }
/**
 * Creates a map with markers of teams for the leagues.
 *
 * @param object $params - Module settings.
 * @param array $queriedEntries - The list of clubs.
 * @param int $id - The ID of the map.
 * @return string - The JavaScript code for creating the map.
 */
public static function makeLeagueMap($params, $queriedEntries, $id){
    $localURL = JUri::base();

    $js = self::getHeader($id);

    // Add Markers for teams
    foreach ($queriedEntries as $entry){


        // First set the marker
        $js .= "var marker$entry->id = L.marker([$entry->lokal_coord_lat,$entry->lokal_coord_long],{icon: colorMarker('$entry->color'),}).addTo(map$id);\n";
        
        // Second set the Popup content
        $js .= "var popup$entry->id = \"<h6 style='color:black'><a href='{$localURL}index.php?option=com_clm&view=mannschaft&saison=$entry->sid&liga=$entry->liga&tlnr=$entry->tln_nr&Itemid=101'>$entry->name</a></h6><h7 style='color:black'><a href='{$localURL}index.php?option=com_clm&view=rangliste&saison=$entry->sid&liga=$entry->liga'>$entry->liga_name</a></h7>\"\n";
        
        // Set the Popup
        $js .= "marker$entry->id.bindPopup(popup$entry->id);\n";    

        //Allow opening on mouse over is selected
        if($params->get('popup_mode', 1) == 0){
            $js .= "marker$entry->id.on('mouseover', function (e) {this.openPopup();});\n";
            $js .= "marker$entry->id.on('mouseout', function (e) {setTimeout(() => {this.closePopup();}, 600);});\n";
        }
        //For centering and zooming add coordinates to array
        $js .= "coordinateArray.push([$entry->lokal_coord_lat,$entry->lokal_coord_long]);\n";

        // Add marker to cluster
        $js .= "markers.addLayer(marker$entry->id);\n";
    }

    // Add cluster to map
    $js .= "map".$id.".addLayer(markers);\n";
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

/**
 * Generates a JavaScript code for creating a club map.
 *
 * @param object $params Module settings.
 * @param array $queriedEntries The queried entries for adding markers and popups.
 * @param int $id The ID of the map.
 * @return string The JavaScript code for creating the club map.
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

        //Allow opening on mouse over is selected
        if($params->get('popup_mode', 1) == 0){
            $js .= "marker$entry->id.on('mouseover', function (e) {this.openPopup();});\n";
            $js .= "marker$entry->id.on('mouseout', function (e) {setTimeout(() => {this.closePopup();}, 600);});\n";
        }
        //For centering and zooming add coordinates to array
        $js .= "coordinateArray.push([$entry->lokal_coord_lat,$entry->lokal_coord_long]);\n";

        // Add marker to cluster
        $js .= "markers.addLayer(marker$entry->id);\n";
    }

    // Add cluster to map
    $js .= "map".$id.".addLayer(markers);\n";
    // Set zoom and fit map to markers 
    //Get first the padding
    $padding = "[$params->get('padding', 10), $params->get('padding', 10)]";
    $js .= "map".$id.".fitBounds(L.latLngBounds(coordinateArray, {padding: $padding}));\n";

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