<?php
///CORE CAFFEINE ELEMENTS DO NOT REMOVE THIS///
$dependenciesjs = $info->loadBeanDepsjs();
for($i=0;$i<count($dependenciesjs);$i++) {
    echo '<script src="site-admin/installed_beans/' . $dependenciesjs[$i]["folder"] . '/' . $dependenciesjs[$i]["file"] .'"></script>' . PHP_EOL ;
}
?>