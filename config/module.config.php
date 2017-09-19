<?php
/**
 * Module related configuration. Might be some db settings, URLs, users, .. 
 * everything that is relevant for the module.
 * 
 * for the current example we define only the path to the data file.
 */
return array(
    'users' => array(
        'file' => __DIR__.'/../data/AuthList.txt',
    ),
);