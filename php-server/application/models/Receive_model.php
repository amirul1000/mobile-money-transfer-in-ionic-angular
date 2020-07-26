<?php

/**
 * Author: Amirul Momenin
 * Desc:Receive Model
 */
class Receive_model extends CI_Model
{

    protected $receive = 'receive';

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Get receive by id
     *
     * @param $id -
     *            primary key to get record
     *            
     */
    function get_receive($id)
    {
        $result = $this->db->get_where('receive', array(
            'id' => $id
        ))->row_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Get all receive
     */
    function get_all_receive()
    {
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('receive')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Get limit receive
     *
     * @param $limit -
     *            limit of query , $start - start of db table index to get query
     *            
     */
    function get_limit_receive($limit, $start)
    {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('receive')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Count receive rows
     */
    function get_count_receive()
    {
        $result = $this->db->from("receive")->count_all_results();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * function to add new receive
     *
     * @param $params -
     *            data set to add record
     *            
     */
    function add_receive($params)
    {
        $this->db->insert('receive', $params);
        $id = $this->db->insert_id();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $id;
    }

    /**
     * function to update receive
     *
     * @param $id -
     *            primary key to update record,$params - data set to add record
     *            
     */
    function update_receive($id, $params)
    {
        $this->db->where('id', $id);
        $status = $this->db->update('receive', $params);
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $status;
    }

    /**
     * function to delete receive
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function delete_receive($id)
    {
        $status = $this->db->delete('receive', array(
            'id' => $id
        ));
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $status;
    }
}
