<?php

namespace Easi\DB2\Database\Connectors;

/**
 * Class ODBCZOSConnector
 *
 * @package Easi\DB2\Database\Connectors
 */
class ODBCZOSConnector extends ODBCConnector
{
    protected function getDsnParts() : array{
        return [
            'odbc:DRIVER=%s',
            'DATABASE=%s',
            'HOSTNAME=%s',
            'PORT=%s',
            'PROTOCOL=TCPIP',
            'UID=%s',
            'PWD=%s'
        ];
    }

    protected function getDsnConfig($config) : array{
        return [
            $config['driverName'],
            $config['database'],
            $config['host'],
            $config['port'],
            $config['username'],
            $config['password']
        ];
    }
}
