<?php

ini_set('memory_limit', '2G');
session_start();

$credentials = getUriOrEnvValue('MONGO_CRED', false);
$hostPort = getUriOrEnvValue('MONGO_HOST_PORT', 'mongo:27017');
$collection = getUriOrEnvValue('MONGO_COLLECTION', 'results');
$dictColl = getUriOrEnvValue('MONGO_DICT_COLLECTION', 'dict');
$options = getUriOrEnvValue('MONGO_OPTIONS', false);

$mongoUri = sprintf(
    'mongodb://%s%s?%s',
    $credentials ? $credentials . '@' : '',
    $hostPort,
    $options
);

return [
    'save.handler'      => 'file',
    'db.host'           => $mongoUri,
    'db.db'             => 'xhprof',
    'db.collection'     => $collection,
    'db.dictionary'     => $dictColl,
    'db.options'        => [],
    'templates.path'    => dirname(__DIR__) . '/src/templates',
    'date.format'       => 'M jS H:i:s',
    'detail.count'      => 6,
    'page.limit'        => 25,
];

function getUriOrEnvValue($name, $default = null)
{
    if (isset($_GET[$name])) {
        $value = $_GET[$name];
    } elseif (isset($_SESSION[$name])) {
        $value = $_SESSION[$name];
    } else {
        $value = getenv($name);
        if ($value === false) {
            $value = $default;
        }
    }

    $_SESSION[$name] = $value;

    return $value;
}
