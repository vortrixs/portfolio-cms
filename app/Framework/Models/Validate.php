<?php

namespace Framework\Models;

class Validate {

    private $_passed = false,
            $_errors = array(),
            $_db;

    public function __construct(\Framework\Core\DB $db) {
        $this->_db = $db;
    }

    public function check($source, $items = array()) {
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {

                $value = trim($source[$item]);
                $item = escape($item);

                if ($rule === 'required' && empty($value)) {
                    $this->addError("<p class='error'><span>{$item}</span> is required.&nbsp;</p>");
                } else if (!empty($value)) {
                    switch ($rule) {
                        case 'str_min':
                            if (strlen($value) < $rule_value) {
                                $this->addError("<p class='error'><span>{$item}</span> needs to be atleast {$rule_value} characters.</p>");
                            }
                            break;
                        case 'str_max':
                            if (strlen($value) > $rule_value) {
                                $this->addError("<p class='error'><span>{$item}</span> must not be heigher than {$rule_value} characters.</p>");
                            }
                            break;
                        case 'matches':
                            if ($value != $source[$rule_value]) {
                                $this->addError("<p class='error'><span>{$rule_value}</span> needs to match {$item}.</p>");
                            }
                            break;
                        case 'unique':
                            $check = $this->_db->get(array($item), $rule_value, array(array($item, '=', $value)));
                            if ($check->count()) {
                                $this->addError("<p class='error'><span>{$item}</span> already exists.</p>");
                            }
                            break;
                        case 'valid_email':
                            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                $this->addError("<p class='error'>This {$item} is invalid.</p>");
                            }
                            break;
                        case 'valid_date':
                            $date = $value;

                            $date = explode('-', $date);

                            $date = checkdate($date[1], $date[2], $date[0]);

                            if (!$date) {
                                $this->addError("<p class='error'>This date is invalid.</p>");
                            }
                            break;
                        case 'num_min':
                            if (!($value >= $rule_value)) {
                                $this->addError("<p class='error'><span>{$item}</span> needs to be more than {$rule_value}.</p>");
                            }
                            break;
                        case 'num_max':
                            if (!($value <= $rule_value)) {
                                $this->addError("<p class='error'><span>{$item}</span> needs to be less than {$rule_value}.</p>");
                            }
                            break;
                        case 'is_numeric':
                            if (!is_numeric($value)) {
                                $this->addError("<p class='error'><span>{$item}</span> must be a number.</p>");
                            }
                            break;
                        case 'is_integer':
                            if (!filter_var($value, FILTER_VALIDATE_INT)) {
                                $this->addError("<p class='error'><span>{$item}</span> must be an integer.</p>");
                            }
                            break;
                        case 'is_decimal':
                            if (!strpos($value, '.')) {
                                $this->addError("<p class='error'><span>{$item}</span> must be a decimal number.</p>");
                            }
                            break;
                    }
                }
            }
        }

        $this->_passed = (empty($this->_errors)) ? true : false;

        return $this;
    }

    public function checkImage($source, $item, $options = array()) {
        foreach ($options as $option => $rules) {
            foreach ($rules as $rule => $rule_value) {

                $value = trim($source[$item][$option]);
                $option = escape($option);

                if (!empty($value)) {
                    switch ($rule) {
                        case 'extensions':
                            $extension = end(explode(".", $value));
                            if (!in_array($extension, $rule_value)) {
                                $this->addError("<p class='error'>{$extension} extension not allowed. Please use " . implode(', ', $rule_value) . ".</p>");
                            }
                            break;
                    }
                }
            }
        }

        $this->_passed = (empty($this->_errors)) ? true : false;

        return $this;
    }

    private function addError($errors) {
        $this->_errors[] = $errors;
    }

    public function errors() {
        return $this->_errors;
    }

    public function passed() {
        return $this->_passed;
    }

}
