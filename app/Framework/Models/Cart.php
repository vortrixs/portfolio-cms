<?php

/**
 * A class for creating a simple session-based shopping cart.
 * 
 * @author Hans Erik Jepsen <hanserikjepsen@hotmail.com>
 */

namespace Framework\Models;

use Framework\Libs\Session;

class Cart {

    private $_item;

    /**
     * Used to display the shopping cart.
     * 
     * Returns the session containing the shopping cart.
     * 
     * @return object||false Returns session or false.
     */
    public function cart_get() {
        if (Session::exists('cart')) {
            return Session::get('cart');
        }
        return false;
    }

    /**
     * Empties the shopping cart completely.
     * 
     * Deletes the session containing the shopping cart.
     * 
     * @return boolean Returns true||false.
     */
    public function cart_delete() {
        if (Session::exists('cart')) {
            Session::delete('cart');
            return true;
        }
        return false;
    }

    /**
     * Updates the shopping cart with the items passed.
     * 
     * Updates the session containing the shopping cart with the items set to the $_item property.
     * 
     * @param array $item The array of items passed.
     * @param string $check Used for the item_update() method.
     * @return boolean Returns true||false.
     */
    public function cart_update($item = array(), $check = null) {
        if (!empty($item)) {
            if ($this->set_item($item)) {
                if (!$this->item_exists()) {
                    if ($this->item_create()) {
                        return true;
                    }
                }
                if ($this->item_exists()) {
                    if ($this->item_update($check)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * Sets the $_item property.
     * 
     * Converts the array passed to an object and sets the $_item property.
     * 
     * @param array $item Array passed from cart_update().
     * @return boolean Returns true||false.
     */
    private function set_item($item = array()) {
        if (!empty($item)) {
            foreach ($item as $key => $value) {
                $is_int = (!is_int($key) ? false : true);
            }
            if (!$is_int) {
                $this->_item[] = (object) $item;
            }
            if ($is_int) {
                $this->_item = json_decode(json_encode($item));
            }
            if (!empty($this->_item)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Creates new items and adds them the the shopping cart.
     * 
     * Creates new items as objects and adds them to the shopping cart session.
     * 
     * @return boolean Returns true||false.
     */
    private function item_create() {
        if (!empty($this->_item)) {
            foreach ($this->_item as $item) {
                $_SESSION['cart'][] = (object) $item;
            }
            foreach (Session::get('cart') as $current_item) {
                foreach ($this->_item as $property_item) {
                    if ($current_item->name == $property_item->name) {
                        $current_item->price = $current_item->amount * $current_item->price;
                    }
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Redirects to the update methods.
     * 
     * Checks how the amount of items should be updated.
     * 
     * @param string $check Used for defining the update method.
     * @return boolean Returns true||false.
     */
    private function item_update($check = 'increase') {
        if (!empty($this->_item)) {
            if ($check === 'increase') {
                if ($this->item_incease_amount()) {
                    return true;
                }
            }
            if ($check === 'change') {
                if ($this->item_change_amount()) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Increases item amount.
     * 
     * Increases the item amount using the data in the session and the $_item property and adjusts the total item price. 
     * 
     * @return boolean Returns true||false.
     */
    private function item_incease_amount() {
        if (!empty($this->_item)) {
            foreach (Session::get('cart') as $current_item) {
                foreach ($this->_item as $property_item) {
                    if ($current_item->name == $property_item->name) {
                        $current_item->amount = $current_item->amount + $property_item->amount;
                        $current_item->price = $current_item->amount * $property_item->price;
                    }
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Changes total item amount.
     * 
     * Changes the total amount of an item by replacing the amount in the session with the amount in the $_item property and adjusts the total item price.
     * 
     * @return boolean Returns true||false.
     */
    private function item_change_amount() {
        if (!empty($this->_item)) {
            foreach (Session::get('cart') as $current_item) {
                foreach ($this->_item as $property_item) {
                    if ($current_item->name == $property_item->name) {
                        $current_item->amount = $property_item->amount;
                        $current_item->price = $current_item->amount * $property_item->price;
                    }
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Deletes an item from the shopping cart.
     * 
     * Deletes an item by filtering the session with the item name and unsetting the array key.
     * 
     * @param string $name Name of the item to be deleted.
     * @return boolean Returns true||false.
     */
    public function item_delete($name) {
        if (!empty($name)) {
            foreach (Session::get('cart') as $key => $item) {
                if ($item->name == $name) {
                    unset($_SESSION['cart'][$key]);
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Checks if an item already exists in the shopping cart.
     * 
     * Loops through the session and the $_item property and checks if the items already exists.
     * 
     * @return boolean Returns true||false.
     */
    private function item_exists() {
        if (!empty($this->_item) && Session::exists('cart')) {
            foreach (Session::get('cart') as $item) {
                foreach ($this->_item as $property_item) {
                    if ($item->name == $property_item->name) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

}
