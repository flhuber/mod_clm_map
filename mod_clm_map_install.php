<?php
// No direct access to this file

use function PHPSTORM_META\type;

defined('_JEXEC') or die;

/**
 * Installer file of clm_map module
 */
class mod_clm_mapInstallerScript
{
	/**
	 * Method to install the extension
	 * $parent is the class calling this method
	 *
	 * @return void
	 */
	function install($parent) 
	{
        echo JText::_('MOD_CLM_MAP_INSTALL');
	}

	/**
	 * Method to uninstall the extension
	 * $parent is the class calling this method
	 *
	 * @return void
	 */
	function uninstall($parent) 
	{
		echo JText::_('MOD_CLM_MAP_DEINSTALL');
	}

	/**
	 * Method to update the extension
	 * $parent is the class calling this method
	 *
	 * @return void
	 */
	function update($parent) 
	{
//		echo JText::_('MOD_CLM_MAP_UPDATE') . $parent->get('manifest')->version;
		echo JText::_('MOD_CLM_MAP_UPDATE') . $parent->getManifest()->version;
	}

	/**
	 * Method to run before an install/update/uninstall method
	 * $parent is the class calling this method
	 * $type is the type of change (install, update or discover_install)
	 *
	 * @return void
	 */
	function preflight($type, $parent) 
	{
		//empty
	}

	/**
	 * Method to run after an install/update/uninstall method
	 * $parent is the class calling this method
	 * $type is the type of change (install, update or discover_install)
	 *
	 * @return void
	 */
	function postflight($type, $parent) 
	{
        //empty
	}
}