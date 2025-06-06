<?php
/**
 * @package         Regular Labs Library
 * @version         23.9.3039
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            https://regularlabs.com
 * @copyright       Copyright © 2023 Regular Labs All Rights Reserved
 * @license         GNU General Public License version 2 or later
 */

/* @DEPRECATED */

defined('_JEXEC') or die;

use Joomla\CMS\Factory as JFactory;

if (is_file(JPATH_LIBRARIES . '/regularlabs/autoload.php'))
{
    require_once JPATH_LIBRARIES . '/regularlabs/autoload.php';
}

require_once dirname(__FILE__, 2) . '/assignment.php';

class RLAssignmentsMijoShop extends RLAssignment
{
    public function init()
    {
        $input = JFactory::getApplication()->input;

        $category_id = $input->getCmd('path', 0);

        if (strpos($category_id, '_'))
        {
            $category_id_parts = explode('_', $category_id);
            $category_id       = end($category_id_parts);
        }

        $this->request->item_id     = $input->getInt('product_id', 0);
        $this->request->category_id = $category_id;
        $this->request->id          = ($this->request->item_id) ? $this->request->item_id : $this->request->category_id;

        $view = $input->getCmd('view', '');

        if (empty($view))
        {
            $mijoshop = JPATH_ROOT . '/components/com_mijoshop/mijoshop/mijoshop.php';

            if ( ! file_exists($mijoshop))
            {
                return;
            }

            require_once($mijoshop);

            $route = $input->getString('route', '');
            $view  = MijoShop::get('router')->getView($route);
        }

        $this->request->view = $view;
    }

    public function passCategories()
    {
        if ($this->request->option != 'com_mijoshop')
        {
            return $this->pass(false);
        }

        $pass = (
            ($this->params->inc_categories
                && ($this->request->view == 'category')
            )
            || ($this->params->inc_items && $this->request->view == 'product')
        );

        if ( ! $pass)
        {
            return $this->pass(false);
        }

        $cats = [];

        if ($this->request->category_id)
        {
            $cats = $this->request->category_id;
        }
        elseif ($this->request->item_id)
        {
            $query = $this->db->getQuery(true)
                ->select('c.category_id')
                ->from('#__mijoshop_product_to_category AS c')
                ->where('c.product_id = ' . (int) $this->request->id);
            $this->db->setQuery($query);
            $cats = $this->db->loadColumn();
        }

        $cats = $this->makeArray($cats);

        $pass = $this->passSimple($cats, 'include');

        if ($pass && $this->params->inc_children == 2)
        {
            return $this->pass(false);
        }
        elseif ( ! $pass && $this->params->inc_children)
        {
            foreach ($cats as $cat)
            {
                $cats = array_merge($cats, $this->getCatParentIds($cat));
            }
        }

        return $this->passSimple($cats);
    }

    public function passPageTypes()
    {
        return $this->passByPageTypes('com_mijoshop', $this->selection, $this->assignment, true);
    }

    public function passProducts()
    {
        if ( ! $this->request->id || $this->request->option != 'com_mijoshop' || $this->request->view != 'product')
        {
            return $this->pass(false);
        }

        return $this->passSimple($this->request->id);
    }

    private function getCatParentIds($id = 0)
    {
        return $this->getParentIds($id, 'mijoshop_category', 'parent_id', 'category_id');
    }
}
