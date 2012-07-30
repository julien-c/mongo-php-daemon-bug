#!/usr/bin/php
<?php
require_once 'config.php';


// The daemon needs to know from which file it was executed.
ParallelTasks::setFilename(__FILE__);

// The run() method will start the daemon loop. 
ParallelTasks::getInstance()->run();