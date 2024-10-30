<?php
class Lava_Ajax_Search_Keyword {
    public $table;

    public function __construct() {
        $this->table = $GLOBALS['wpdb']->prefix . Lava_Ajax_Search::STACK_TABLE;
    }

    public function getOption($key='') {
        return lava_ajaxSearch()->admin->get_settings($key);
    }

    public function add_keyword($keyword='') {
        global $wpdb;
        $keywordRow = $this->keyword_exists($keyword);
        if(empty($keywordRow)) {
            $wpdb->insert(
                $this->table, Array(
                    'keyword' => $keyword,
                    'count' => '1',
                    'date' => date('Y-m-d H:i:s', strtotime('now')),
                )
            );
        }else{
            $wpdb->update(
                $this->table, Array(
                    'count' => intVal($keywordRow->count) + 1,
                    'date' => date('Y-m-d H:i:s', strtotime('now')),
                ),  Array(
                    'ID' => $keywordRow->ID,
                )
            );
        }
    }

    public function keyword_exists($keyword='') {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM " . $this->table . " WHERE keyword=%s ORDER BY ID DESC limit 1", $keyword
        ));
    }

    public function get_keywords($args=Array()) {
        global $wpdb;

        $args = wp_parse_args($args, Array(
            'count' => 10,
            'orderby' => 'count',
            'order' => 'DESC',
            'type' => 'auto',
            'field' => 'all',
        ));

        if('manual' == $args['type']) {
            return $this->getOption('suggestion_keywords');
        }

        $query = "SELECT * FROM". ' ' . $this->table . ' ' . "ORDER BY" . ' ' . $args['orderby'] . ' ' .  $args['order'];
        if(-1 < intVal($args['count'])) {
            $query .= ' LIMIT ' . $args['count'];
        }

        $results = $wpdb->get_results($query);

        if('all' != $args['field']) {
            $results = wp_list_pluck($results, $args['field']);
        }
        return $results;
    }

    public function getSuggestionType() {
        return $this->getOption('suggestion_orderby');
    }
}
