<?php

namespace BPL\Cron\Test;

require_once '../lib/Db_Connect.php';
require_once '../mods/helpers_local.php';

echo time() % 3;
echo time() % 5;
echo time() % 7;