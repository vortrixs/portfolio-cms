<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Search
 *
 * @author hans2770
 */

namespace Framework\Models;

use Framework\Core\DB;

class SearchEngine {

    private $_db;

    public function __construct(DB $db) {
        $this->_db = $db;
    }

    public function search($select = array(), $table, $keywords, $columns = array(), $where = array(), $options = null) {

        $keywords_filtered = $this->filter($keywords);

        foreach ($columns as $column) {
            foreach ($keywords_filtered as $keyword) {
                $sql .= "{$column} LIKE ? OR ";
            }
        }
        $search = trim($sql, "OR ");

        $this->action('SELECT ' . implode($select, ', '), $table, $where, $options, $search, $columns, $keywords_filtered);
    }

    private function filter($keywords) {
        $keywords_filtered = array();
        $filter_common_words = array("is","in", "it", "a", "the", "of", "or", "I", "you", "he", "me", "us", "they", "she", "to", "but", "that", "this", "those", "then");
        foreach (explode(" ", $keywords) as $key) {
            if (!in_array($key, $filter_common_words)) {
                $keywords_filtered[] = $key;
            }
        }
        return $keywords_filtered;
    }

    private function action($action, $table, $where = array(), $options = array(), $search, $columns, $keywords_filtered) {
        $sql = "{$action} FROM {$table}";

        if (!empty($where)) {
            $sql .= " WHERE ";
            foreach ($where as $clause) {
                if (count($clause) === 3) {
                    $operators = array('=', '>', '<', ' >=', '<=');

                    if (isset($clause)) {
                        $field = $clause[0];
                        $operator = $clause[1];
                        $value[] = $clause[2];
                        $bindValue = '?';
                    }

                    if (in_array($operator, $operators)) {
                        $sql .= "{$field} {$operator} {$bindValue}";
                        $sql .= " AND ";
                    }
                }
            }
            $sql = rtrim($sql, " AND ");
        }
        if (isset($search)) {
            $operator = (!empty($where) ? " AND" : " WHERE");
            $sql .= "{$operator} {$search}";
            foreach ($keywords_filtered as $word) {
                $searchParams[] = "%" . $word . "%";
            }
        }
        if (!empty($options)) {
            foreach ($options as $optionKey => $optionValue) {
                $sql .= " {$optionKey} {$optionValue}";
            }
        }

        if (!$this->_db->query($sql, $value, $searchParams, count($columns))->error()) {
            return $this;
        }
        return false;
    }

    public function results() {
        return $this->_db->results();
    }

}
