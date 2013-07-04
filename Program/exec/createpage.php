<?php
date_default_timezone_set("PRC");
require_once('/data0/htdocs/www.qttc.net/include/public.php');
$total = $db->total();
$n = ceil($total['total']/10);
for($i=1;$i<=$n;$i++){w_list($i);}
