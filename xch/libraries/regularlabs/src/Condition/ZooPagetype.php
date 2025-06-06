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

namespace RegularLabs\Library\Condition;

defined('_JEXEC') or die;

/**
 * Class ZooPagetype
 *
 * @package RegularLabs\Library\Condition
 */
class ZooPagetype extends Zoo
{
    public function pass()
    {
        return $this->passByPageType('com_zoo', $this->selection, $this->include_type);
    }
}
