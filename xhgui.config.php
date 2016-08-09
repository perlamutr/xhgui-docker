<?php
/**
 * Default configuration for Xhgui
 */
return [
    'save.handler' => 'mongodb',
    'db.host' => 'mongodb://xhgui:27017',
    'db.db' => 'xhprof',
    'date.format' => 'M jS H:i:s',
    'profiler.enable' => function() {
        return getenv("APP_ENV") == "local";
    }
];
