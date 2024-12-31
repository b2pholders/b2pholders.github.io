<?php
/**
 * @version       $Id$
 * @package       Jumi
 * @copyright (C) 2008 - 2015 Edvard Ananyan
 * @license       GNU/GPL v3 http://www.gnu.org/licenses/gpl.html
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

use \Joomla\CMS\MVC\View\HtmlView;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Document\Document;

/**
 * HTML Contact View class for the Contact component
 *
 * @package     Joomla.Site
 * @subpackage  com_contact
 * @since       1.5
 */
/* *
if(JV == 'j2') {
    //j2 stuff here///////////////////////////////////////////////////////////////////////////////////////////////////////
    class JumiViewApplication extends JView {
        function display($tpl = null) {
            // Initialise variables.
            $fileid    = JRequest::getInt('fileid');
            $database  = JFactory::getDBO();
            $user      = JFactory::getUser();
            $document  = JFactory::getDocument();
            $mainframe = JFactory::getApplication();

            //$database->setQuery("select * from #__jumi where id = '{$fileid}' and access <= {$user->gid} and published = 1");
            $database->setQuery("select * from #__jumi where id = '{$fileid}' and published = 1");
            $appl = $database->loadObject();

            if(!is_object($appl))
                echo '<div style="color:#FF0000;background:#FFFF00;">'.JText::_("The Jumi Application is Unpublished or Removed").'</div>';

            $document->setTitle($appl->title);

            eval('?>'.$appl->custom_script);

            if(!empty($appl->path)) {
                $filepath = JPATH_BASE.DS.$appl->path;
                if(is_file($appl->path)) {
                    require($appl->path);
                }
                elseif(is_file($filepath))
                    require $filepath;
                else
                    echo '<div style="color:#FF0000;background:#FFFF00;">The file '.$filepath.' does not exists.</div>';
            }
            echo $noscript = '<noscript><strong>JavaScript is currently disabled.</strong>Please enable it for a better experience of <a href="http://2glux.com/projects/jumi">Jumi</a>.</noscript>';
            parent::display($tpl);
        }
    }
}
else {
    //j3 stuff here///////////////////////////////////////////////////////////////////////////////////////////////////////
	/* */

class JumiViewApplication extends HtmlView
{
	public function display($tpl = null)
	{
		$conf = Factory::getConfig();

		// Initialise variables.
		//$fileid    = \Joomla\CMS\Input\Input->getInt('fileid');
		$database = Factory::getDBO();
		//$user      = Factory::getUser();
		$document  = Document::getInstance();
		$mainframe = Factory::getApplication();

		$fileid = $mainframe->input->getInt('fileid');

		//$database->setQuery("select * from #__jumi where id = '{$fileid}' and access <= {$user->gid} and published = 1");
//		$database->setQuery(
//			"select * from #__jumi where id = '{$fileid}' and published = 1"
//		);

		$appl = $database->setQuery(
			'SELECT * ' .
			'FROM #__jumi ' .
			'WHERE id = ' . $database->quote($fileid) .
			' AND published = ' . $database->quote(1)
		)->loadObject();

//		$appl = $database->loadObject();

		if (!is_object($appl) || !$appl)
		{
//			echo '<div style="color:#FF0000;background:#FFFF00;">' .
//				\Joomla\CMS\Language\Text::_("The Jumi Application is Unpublished or Removed") . '</div>';

			$root = explode('\\', $conf->get('jumi_redirect_error'));
			$root = 'http://' . $_SERVER['HTTP_HOST'] . DIRECTORY_SEPARATOR . array_pop($root) . DIRECTORY_SEPARATOR;

			header('location: ' . $root);
			exit;
		}

		$document->setTitle($appl->title);

		eval('?>' . $appl->custom_script);

		if (!empty($appl->path))
		{
			$filepath = JPATH_BASE . DS . $appl->path;

			if (is_file($appl->path))
			{
				require $appl->path;
			}
			elseif (is_file($filepath))
			{
				require $filepath;
			}
			else
			{
				echo '<div style="color:#FF0000;background:#FFFF00;">The file ' . $filepath . ' does not exist.</div>';
			}
		}

		//echo $noscript = '<noscript><strong>JavaScript is currently disabled.</strong>Please enable it for a better experience of <a href="http://2glux.com/projects/jumi">Jumi</a>.</noscript>';
		parent::display($tpl);
	}
}
/* *
}
/* */