<?php

namespace App\Portal\Helpers\SQL;

/**
 * Class SQLHelper
 *
 * This class handles basic methods to help build Raw Query strings so that we are not rewriting the same bits of code
 * over and over again.
 *
 * @package App\Portal\Helpers\SQL
 */
class SQLHelper
{
    /**
     * Get Limit String
     *
     * Return a limit string for a SQL query based on passed start and length parameters
     *
     * @param int|null $start
     * @param int|null $length
     * @return string
     */
    public static function getLimitString(int $start = null, int $length = null) :string
    {
        $limit_string = '';

        if (isset($length) && $length != -1) {
            $limit_string = " LIMIT " . $start . ", " . $length;
        }

        return $limit_string;
    }

    /**
     * Get Order String
     *
     * Return an Order BY string based on passed parameters
     *
     * @param array $columns
     * @param array|null $order
     * @param string $default
     * @return string
     */
    public static function getOrderString(array $columns, array $order = null, string $default = '') :string
    {
        $order_string = '';

        if(!empty($default)) {
            $order_string = ' ORDER BY ' . $default . ' asc ';

            if (isset($order[0])) {
                $column = $columns[$order[0]['column']];
                $dir = $order[0]['dir'];
                $order_string = ' ORDER BY ' . $column . ' ' . $dir . ' ';
            }
        }

        return $order_string;
    }

    /**
     * Get Date Range String
     *
     * Return a date range string based on passed parameters
     *
     * @param string $date_column
     * @param string $start_date
     * @param string $end_date
     * @return string
     */
    public static function getDateRangeString(string $date_column = '', string $start_date = null, string $end_date = null) :string
    {
        $date_string = '';

        if(!empty($date_column)) {
            if ($start_date != null && $end_date != null) {
                $date_string = ' AND ' . $date_column . ' >= :start_date AND ' . $date_column . ' <= :end_date ';
            }
        }

        return $date_string;
    }

    /**
     * Get Client String
     *
     * Return a string to sort by client ID based on passed parameters
     *
     * @param string $client_column
     * @param int $client_id
     * @return string
     */
    public static function getClientString(string $client_column = '', int $client_id = null) :string
    {
        $client_string = '';

        if(!empty($client_column)) {
            if ($client_id !== null && $client_id != '') {
                $client_string = ' AND ' . $client_column . ' = :client_id ';
            }
        }

        return $client_string;
    }
}