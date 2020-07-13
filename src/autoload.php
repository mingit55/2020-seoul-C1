<?php
function classLoader($c){
    require SRC.DS.$c.".php";
}
spl_autoload_register("classLoader");