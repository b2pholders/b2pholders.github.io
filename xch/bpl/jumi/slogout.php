<?php

namespace BPL\Jumi\Slogout;

require_once 'bpl/mods/helpers.php';

use Joomla\CMS\Uri\Uri;

use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\session_set;
use function BPL\Mods\Helpers\application;

session_set('admintype', '');

application()->redirect(Uri::root(true) . '/' . sef(43));