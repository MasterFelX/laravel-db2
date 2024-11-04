<?php

namespace Easi\DB2\Database\Connectors;

/**
 * Class ODBCConnector
 *
 * @package Easi\DB2\Database\Connectors
 */
class ODBCConnector extends DB2Connector
{
    /**
     * Returns the parts of the DSN string.
     *
     * @return array
     */
    protected function getDsnParts() : array
    {
        return [
            'odbc:DRIVER=%s',
            'SYSTEM=%s',
            'DATABASE=%s',
            'USERID=%s',
            'PASSWORD=%s',
        ];
    }
    /**
     * Returns the DSN configuration array based on the provided config.
     *
     * @param array $config
     *
     * @return array
     */
    protected function getDsnConfig(array $config) : array
    {
        return [
            $config['driverName'],
            $config['host'],
            $config['database'],
            $config['username'],
            $config['password'],
        ];
    }
    /**
     * @param array $config
     *
     * @return string
     */
    protected function getDsn(array $config) : string
    {
        $dsnParts = $this->getDsnParts();
        $dsnConfig = $this->getDsnConfig($config);
        if (array_key_exists('odbc_keywords', $config)) {
            list($dsnParts, $dsnConfig) = $this->mergeOdbcKeywords($dsnParts, $dsnConfig, $config['odbc_keywords']);
        }
        $dsnParts[] = ''; // add a trailing semicolon to the DSN
        return sprintf(implode(';', $dsnParts), ...$dsnConfig);
    }

    /**
     * Merges ODBC keywords into DSN parts and config.
     *
     * @param array $dsnParts
     * @param array $dsnConfig
     * @param array $odbcKeywords
     *
     * @return array
     */
    protected function mergeOdbcKeywords(array $dsnParts, array $dsnConfig, array $odbcKeywords) : array
    {
        $parts = array_map(function($part) {
            return $part . '=%s';
        }, array_keys($odbcKeywords));
        $config = array_values($odbcKeywords);

        $dsnParts = array_merge($dsnParts, $parts);
        $dsnConfig = array_merge($dsnConfig, $config);

        return [$dsnParts, $dsnConfig];
    }
}
