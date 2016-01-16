<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Script file of mod_doyandexmetrika
 */
class mod_doyandexmetrikaInstallerScript
{

	protected function _getId($parent)
	{
		$db = $parent->getParent()->getDbo();

		$query = $db->getQuery(true);
			$query->select($query->qn('id'))->from($query->qn('#__modules'));
			$query->where($query->qn('module') . ' = "mod_doyandexmetrika"');
			$db->setQuery($query);

			try
			{
						$id = (int) $db->loadResult();
			}
			catch (JException $e)
			{
						$id = 0;
			}

			return $id;
	}

	/**
	 * method to install the module
	 *
	 * @return void
	 */
	function install($parent)
	{
		// $parent is the class calling this method
	}

	/**
	 * method to uninstall the module
	 *
	 * @return void
	 */
	function uninstall($parent)
	{
		// $parent is the class calling this method
	}

	/**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent)
	{
		// $parent is the class calling this method
	}

	/**
	 * method to run before an install/update/uninstall method
	 *
	 * @return void
	 */
	function preflight($type, $parent)
	{
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)

		$jversion = new JVersion();

    // Manifest file minimum Joomla version
    $this->minimum_joomla_release = $parent->get( "manifest" )->attributes()->version;

    // abort if the current Joomla release is older
    if( version_compare( $this->minimum_joomla_release, $jversion->getShortVersion() ) > 0 ) {

	    // Installing component manifest file version
	    $this->release = $parent->get( "manifest" )->version;

	    // Show the essential information at the install/update back-end
	    echo '<p>Installing component manifest file version = ' . $this->release;
	    echo '<br />Installing component manifest file minimum Joomla version = ' . $this->minimum_joomla_release;
	    echo '<br />Current Joomla version = ' . $jversion->getShortVersion();

      Jerror::raiseWarning( null, JText::_('MOD_DOYANDEXMETRIKA_REQNEWER_MSG').$this->minimum_joomla_release );
      $parent->getParent()->abort( JText::_('MOD_DOYANDEXMETRIKA_REQNEWER_MSG').$this->minimum_joomla_release );

      return false;
    }

		// Массив несовместимых с веткой 2.x.x версий
		$oldVers = array( '1.0.1','1.1.0','1.1.1','1.1.2' );

		// Поиск версии установленной в настоящее время
		$extension = JTable::getInstance('extension');
		$eid = $extension->find(array('element' =>'mod_doyandexmetrika'));
		$extension->load($eid);

		$data = json_decode($extension->manifest_cache, true);

		if (in_array($data['version'], $oldVers)) {
			// Предупреждение об удалении версии 1.x.x и отмена установки
			$parent->getParent()->abort(JText::_('MOD_DOYANDEXMETRIKA_UNINSTALL_MSG'));
			return false;
		}
	}
	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	function postflight($type, $parent)
	{
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)

		if (strtolower($type) == 'install') {
			// Новая установка. Переход к настройкам модуля
			$rUrl = 'index.php?option=com_modules&view=module&layout=edit&id=' . $this->_getId($parent);
			$parent->getParent()->setRedirectURL($rUrl);
		}
	}
}