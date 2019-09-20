<?php

$credentials = getUriOrEnvValue('MONGO_CRED', false);
$hostPort = getUriOrEnvValue('MONGO_HOST_PORT', 'mongo:27017');
$collection = getUriOrEnvValue('MONGO_COLLECTION', 'results');
$options = getUriOrEnvValue('MONGO_OPTIONS', false);

$mongoUri = sprintf(
    'mongodb://%s%s?%s',
    $credentials ? $credentials . '@' : '',
    $hostPort,
    $options
);

return [
    'debug'             => false,
    'mode'              => 'development',
    'save.handler'      => 'file',
    'db.host'           => $mongoUri,
    'db.db'             => 'xhprof',
    'db.collection'     => $collection,
    'db.options'        => [],
    'templates.path'    => dirname(__DIR__) . '/src/templates',
    'date.format'       => 'M jS H:i:s',
    'detail.count'      => 6,
    'page.limit'        => 25,
];

function getUriOrEnvValue($name, $default = null)
{
    $value = isset($_GET[$name]) ? $_GET[$name] : getenv($name);

    return $value ?: $default;
}
