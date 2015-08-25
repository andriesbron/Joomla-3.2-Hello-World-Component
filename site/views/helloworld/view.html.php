<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * HTML View class for the HelloWorld Component
 *
 * @since  0.0.1
 */
class HelloWorldViewHelloWorld extends JViewLegacy
{
	/**
	 * Display the Hello World view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	function display($tpl = null)
	{
		// Assign data to the view
		$this->item = $this->get('Item');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');

			return false;
		}

		$params = JFactory::getApplication()->getParams();

		JPluginHelper::importPlugin('content');
		$dispatcher = JEventDispatcher::getInstance();
		$this->displayEvent = new stdClass();

		$dispatcher->trigger('onContentPrepare', array ('com_helloworld.helloworld', &$this->item, &$params, 0));

		$results = $dispatcher->trigger('onContentBeforeDisplay', array(
				'com_helloworld.helloworld',
				&$this->item,
				&$params,
				0
		));
		$this->displayEvent->beforeDisplayContent = trim(implode("\n", $results));

		$results = $dispatcher->trigger('onContentAfterDisplay', array(
				'com_helloworld.helloworld',
				&$this->item,
				&$params,
				0
		));
		$this->displayEvent->afterDisplayContent = trim(implode("\n", $results));

		// Display the view
		parent::display($tpl);
	}
}
