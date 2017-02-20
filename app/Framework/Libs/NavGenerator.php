<?php

namespace Framework\Libs;

class NavGenerator {

    public $navigation;
    public $base_url = null;
    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function run(){
        if (is_array($this->data[0])) {
            $menu = $this->formatArray($this->data);
        } elseif (is_object($this->data[0])) {
            $menu = $this->formatObject($this->data);
        }
        $this->generateNav($menu);
        return $this->navigation;
    }

    private function formatArray($data, $parent_id = 0){
        $links = null;
        foreach($data as $menu_entry){
            if ($menu_entry['parent_id'] == $parent_id) {
                $array = [
                'title' => $menu_entry['title'],
                'url' => $menu_entry['url'],
                'submenu' => null,
                ];
                $array['submenu'] = $this->formatArray($data, $menu_entry['id']);
                $links[] = $array;
            }
        }
        return $links;
    }

    private function formatObject($data, $parent_id = 0){
        $links = null;
        foreach($data as $menu_entry){
            if ($menu_entry->parent_id == $parent_id) {
                $array = [
                'id' => $menu_entry->id,
                'parent_id' => $menu_entry->parent_id,
                'title' => $menu_entry->title,
                'url' => $menu_entry->url,
                'submenu' => null,
                ];
                $array['submenu'] = $this->formatObject($data, $menu_entry->id);
                $links[] = $array;
            }
        }
        return $links;
    }

    private function generateNav($menu, $is_submenu = false) {
        $list = null;
        foreach ($menu as $menu_entry) {
            foreach ($this->data as $data) {
                if ($data->parent_id == $menu_entry['id']) {
                    $has_children = true;
                    break;
                }
                $has_children = false;
            }
            if ($has_children) {
                $url = $menu_entry['url'] == '#' ? null : 'href="'.$this->base_url.'/'.$menu_entry['url'].'"';
                if ($is_submenu) {
                    $list .= '<li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle trigger" '.$url.'>' . $menu_entry['title'] . '<span class="caret"></span></a>';
                } else {
                    $list .= '<li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle" '.$url.'>' . $menu_entry['title'] . '<span class="caret"></span></a>';
                }
            } else {
                $list .= '<li><a href="' . $this->base_url . '/' . $menu_entry['url'] . '">' . $menu_entry['title'] . '</a>';
            }
            if (is_array($menu_entry['submenu'])) {
                if ($is_submenu) {
                    $list .= '<ul class="dropdown-menu sub-menu">'.$this->generateNav($menu_entry['submenu'], true).'</ul>';
                } else {
                    $list .= '<ul class="dropdown-menu">'.$this->generateNav($menu_entry['submenu'], true).'</ul>';
                }
            }
            $list .= '</li>';
        }
        return $this->navigation = $list;
    }
}