<?php
/**
 * Created by PhpStorm.
 * User: DominicKirby
 * Date: 10/8/2017
 * Time: 20:48
 *
 * Autoloading file for system class
 *
 * Copyright 2017 - Dominic Kirby (domkirby.com)

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
 */


function system_autoload($class) {
    $namespaceParts = explode('\\', $class);
    if(in_array("PassPush", $namespaceParts)) {
        $className = array_pop($namespaceParts);

        array_shift($namespaceParts);
        require_once __DIR__ . '/' . 'PassPush' . "/{$className}.php";
    }
}

spl_autoload_register('system_autoload');
?>