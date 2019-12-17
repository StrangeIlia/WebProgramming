<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=mysql;dbname=server',
    'username' => 'ilya',
    'password' => 'secret',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 60,
    'schemaCache' => 'cache',
];
