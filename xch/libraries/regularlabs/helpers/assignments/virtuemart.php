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

class RLAssignmentsVirtueMart extends RLAssignment
{
    public function init()
    {
        $virtuemart_product_id  = JFactory::getApplication()->input->get('virtuemart_product_id', [], 'array');
        $virtuemart_category_id = JFactory::getApplication()->input->get('virtuemart_category_id', [], 'array');

        $this->request->item_id     = $virtuemart_product_id[0] ?? null;
        $this->request->category_id = $virtuemart_category_id[0] ?? null;
        $this->request->id          = ($this->request->item_id) ? $this->request->item_id : $this->request->category_id;
    }

    public function passCategories()
    {
        if ($this->request->option != 'com_virtuemart')
        {
            return $this->pass(false);
        }

        // Because VM sucks, we have to get the view again
        $this->request->view = JFactory::getApplication()->input->getString('view');

        $pass = (($this->params->inc_categories && in_array($this->request->view, ['categories', 'category']))
            || ($this->params->inc_items && $this->request->view == 'productdetails')
        );

        if ( ! $pass)
        {
            return $this->pass(false);
        }

        $cats = [];

        if ($this->request->view == 'productdetails' && $this->request->item_id)
        {
            $query = $this->db->getQuery(true)
                ->select('x.virtuemart_category_id')
                ->from('#__virtuemart_product_categories AS x')
                ->where('x.virtuemart_product_id = ' . (int) $this->request->item_id);
            $this->db->setQuery($query);
            $cats = $this->db->loadColumn();
        }
        elseif ($this->request->category_id)
        {
            $cats = $this->request->category_id;

            if ( ! is_numeric($cats))
            {
                $query = $this->db->getQuery(true)
                    ->select('config')
                    ->from('#__virtuemart_configs')
                    ->where('virtuemart_config_id = 1');
                $this->db->setQuery($query);
                $config = $this->db->loadResult();
                $lang   = substr($config, strpos($config, 'vmlang='));
                $lang   = substr($lang, 0, strpos($lang, '|'));

                if (preg_match('#"([^"]*_[^"]*)"#', $lang, $lang))
                {
                    $lang = $lang[1];
                }
                else
                {
                    $lang = 'en_gb';
                }

                $query = $this->db->getQuery(true)
                    ->select('l.virtuemart_category_id')
                    ->from('#__virtuemart_categories_' . $lang . ' AS l')
                    ->where('l.slug = ' . $this->db->quote($cats));
                $this->db->setQuery($query);
                $cats = $this->db->loadResult();
            }
        }

        $cats = $this->makeArray($cats);

        $pass = $this->passSimple($cats, 'include');

        if ($pass && $this->params->inc_children == 2)
        {
            return $this->pass(false);
        }

        if ( ! $pass && $this->params->inc_children)
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
        // Because VM sucks, we have to get the view again
        $this->request->view = JFactory::getApplication()->input->getString('view');

        return $this->passByPageTypes('com_virtuemart', $this->selection, $this->assignment, true);
    }

    public function passProducts()
    {
        // Because VM sucks, we have to get the view again
        $this->request->view = JFactory::getApplication()->input->getString('view');

        if ( ! $this->request->id || $this->request->option != 'com_virtuemart' || $this->request->view != 'productdetails')
        {
            return $this->pass(false);
        }

        return $this->passSimple($this->request->id);
    }

    private function getCatParentIds($id = 0)
    {
        return $this->getParentIds($id, 'virtuemart_category_categories', 'category_parent_id', 'category_child_id');
    }
}
