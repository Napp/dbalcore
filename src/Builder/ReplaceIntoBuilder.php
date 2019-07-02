<?php

namespace Napp\Core\Dbal\Builder;

use Illuminate\Database\Grammar;
use Illuminate\Database\Query\Builder;

/**
 * Class ReplaceIntoBuilder.
 */
class ReplaceIntoBuilder
{
    /**
     * @return \Closure
     */
    public function replace()
    {
        return function (array $values) {

            /* @var Builder $this  */

            if (empty($values)) {
                return true;
            }

            // Since every insert gets treated like a batch insert, we will make sure the
            // bindings are structured in a way that is convenient for building these
            // inserts statements by verifying the elements are actually an array.
            if (!\is_array(reset($values))) {
                $values = [$values];
            }

            // Since every insert gets treated like a batch insert, we will make sure the
            // bindings are structured in a way that is convenient for building these
            // inserts statements by verifying the elements are actually an array.
            else {
                foreach ($values as $key => $value) {
                    ksort($value);
                    $values[$key] = $value;
                }
            }
            // We'll treat every insert like a batch insert so we can easily insert each
            // of the records into the database consistently. This will make it much
            // easier on the grammars to just handle one type of record insertion.
            $bindings = [];

            foreach ($values as $record) {
                foreach ($record as $value) {
                    $bindings[] = $value;
                }
            }

            $sql = $this->compileReplace($values);

            // Once we have compiled the insert statement's SQL we can execute it on the
            // connection and return a result as a boolean success indicator as that
            // is the same type of result returned by the raw connection instance.
            $bindings = $this->cleanBindings($bindings);

            return $this->connection->insert($sql, $bindings);
        };
    }

    /**
     * @param Builder $query
     * @param Grammar $grammar
     * @param array   $values
     *
     * @return string
     */
    public static function compileReplace()
    {
        return function (array $values) {
            $grammar = $this->getGrammar();
            // Essentially we will force every insert to be treated as a batch insert which
            // simply makes creating the SQL easier for us since we can utilize the same
            // basic routine regardless of an amount of records given to us to insert.
            $table = $grammar->wrapTable($this->from);

            if (!\is_array(reset($values))) {
                $values = [$values];
            }

            $columns = $grammar->columnize(array_keys(reset($values)));

            // We need to build a list of parameter place-holders of values that are bound
            // to the query. Each insert should have the exact same amount of parameter
            // bindings so we will loop through the record and parameterize them all.
            $parameters = [];

            foreach ($values as $record) {
                $parameters[] = '('.$grammar->parameterize($record).')';
            }

            $parameters = implode(', ', $parameters);

            return "replace into {$table} ({$columns}) values {$parameters}";
        };
    }
}
