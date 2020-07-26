<?php

/**
 * Author: Amirul Momenin
 * Desc:Send Model
 */
class Send_model extends CI_Model
{

    protected $send = 'send';

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Get send by id
     *
     * @param $id -
     *            primary key to get record
     *            
     */
    function get_send($id)
    {
        $result = $this->db->get_where('send', array(
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
     * Get all send
     */
    function get_all_send()
    {
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('send')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Get limit send
     *
     * @param $limit -
     *            limit of query , $start - start of db table index to get query
     *            
     */
    function get_limit_send($limit, $start)
    {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('send')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Count send rows
     */
    function get_count_send()
    {
        $result = $this->db->from("send")->count_all_results();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * function to add new send
     *
     * @param $params -
     *            data set to add record
     *            
     */
    function add_send($params)
    {
        $this->db->insert('send', $params);
        $id = $this->db->insert_id();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $id;
    }

    /**
     * function to update send
     *
     * @param $id -
     *            primary key to update record,$params - data set to add record
     *            
     */
    function update_send($id, $params)
    {
        $this->db->where('id', $id);
        $status = $this->db->update('send', $params);
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $status;
    }

    /**
     * function to delete send
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function delete_send($id)
    {
        $status = $this->db->delete('send', array(
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
