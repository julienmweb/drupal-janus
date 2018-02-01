<?php

namespace Janus;

require_once __DIR__ . '/../vendor/autoload.php';

///// csv path /////
\define('NODES_CSV_FILES', __DIR__ . '/Data/nodes-example.csv');
\define('USERS_CSV_FILES', __DIR__ . '/Data/users-example.csv');
\define('NODES_ATTACHED_FILES_FOLDER', __DIR__ . '/Data/AttachedFiles');

///// Includes your script Files /////
include_once __DIR__ . '/Scripts/nodes.php';
include_once __DIR__ . '/Scripts/users.php';
include_once __DIR__ . '/Scripts/associateExample1.php';
include_once __DIR__ . '/Scripts/associateExample2.php';
