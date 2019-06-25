<?php

/**
 * Description of mcrud
 * class ini digunakan untuk melakukan manipulasi  data sederhana
 */
class M_helper extends CI_Model

{
    function __construct()
    {
        parent::__construct();

        $this->db = $this->load->database('default', TRUE); 
        $this->db->_escape_char = ' ';

        $this->db_corecrm = $this->load->database('corecrm', TRUE);
        $this->db_corecrm->_escape_char = ' ';

        $this->db_ccpbb = $this->load->database('ccpbb', TRUE);
        $this->db_ccpbb->_escape_char = ' ';

        $this->db_tosdb = $this->load->database('tosdb', TRUE);
        $this->db_tosdb->_escape_char = ' ';

    }

    public function getList($tables, $limit, $page, $by, $sort)
    {
        $this->db->order_by($by, $sort);
        $this->db->limit($limit, $page);
        return $this->db->get($tables);
    }

    // menampilkan semua data dari sebuah tabel.
    public function getAll($tables)
    {
        return $this->db->get($tables);
    }

    public function getComboNew($table, $field, $pk, $order_by, $order_type)
    {
        $this->db->select($field);
        $this->db->distinct();
        $this->db->select($pk);

        if ($order_by != null && $order_type != null) {
            $this->db->order_by($order_by, $order_type);
        }

        return $this->db->get($table);
    }

    public function getComboByIDNew($table, $field, $pk, $where, $order_by, $order_type)
    {
        $this->db->select($field);
        $this->db->distinct();
        $this->db->select($pk);
        $this->db->where($where);
        if ($order_by != null && $order_type != null) {
            $this->db->order_by($order_by, $order_type);
        }

        return $this->db->get($table);
    }


    public function getCombo($table, $field, $pk)
    {
        $this->db_corecrm->select($field);
        $this->db_corecrm->distinct();
        $this->db_corecrm->select($pk);

        return $this->db_corecrm->get($table);
    }

    public function getComboByID($table, $field, $pk, $where)
    {
        $this->db_corecrm->select($field);
        $this->db_corecrm->distinct();
        $this->db_corecrm->select($pk);
        $this->db_corecrm->where($where);
        $this->db_corecrm->order_by($field, 'asc');

        return $this->db_corecrm->get($table);
    }

     public function getCombo2($table, $field, $pk)
    {
        $this->db->select($field);
        $this->db->distinct();
        $this->db->select($pk);

        return $this->db->get($table);
    }

    public function getComboByID2($table, $field, $pk, $where)
    {
        $this->db->select($field);
        $this->db->distinct();
        $this->db->select($pk);
        $this->db->where($where);
        $this->db->order_by($field, 'asc');

        return $this->db->get($table);
    }

    // menghitun jumlah record dari sebuah tabel.
    public function countAll($tables)
    {
        return $this->db->count_all_results($tables);
    }

    // menghitun jumlah record dari sebuah query.
    public function countQuery($query)
    {
        return $this->db->query($query)->num_rows();
    }

    // menampilkan satu record brdasarkan parameter.
    public function kondisi($tables, $where)
    {
        $this->db->where($where);
        return $this->db->get($tables);
    }

    //menampilkan satu record brdasarkan parameter.
    public function getByID($tables, $pk, $id)
    {
        $this->db->where($pk, $id);
        return $this->db->get($tables);
    }

    public function query($query)
    {
        return $this->db->query($query);
    }

    // memasukan data ke database.
    public function insert($tables, $data)
    {
        $this->db->insert($tables, $data);
    }

    // update data kedalalam sebuah tabel
    public function update($tables, $data, $pk, $id)
    {
        $this->db->where($pk, $id);
        $this->db->update($tables, $data);
    }

    // menghapus data dari sebuah tabel
    public function delete($tables, $pk, $id)
    {
        $this->db->where($pk, $id);
        $this->db->delete($tables);
    }

    public function exec_cursor($pck_name, $in, $conn_db)
    {
        $db_conn = "";
        switch ($conn_db) {
            case 'corecrm':
                $db_conn = $this->db_corecrm;
                break;
            case 'ccpbb':
                $db_conn = $this->db_ccpbb;
                break;
            case 'tosdb':
                $db_conn = $this->db_tosdb;
                break;
            case 'default':
                $db_conn = $this->db;
                break;
            default:
                $db_conn = $this->db;
        }

        if ($in) {
            $param = "";
            foreach ($in as $row => $value) {
                $param .= ":" . $row . ",";
            }

            $sql =
                "  DECLARE " .
                "  BEGIN " .
                " $pck_name( $param :cursor); END;";

            $params = array();
            foreach ($in as $arr => $arrval) {
                $params[] = array('name' => ":" . $arr, 'value' => $arrval);
            }

            // Bind the output parameter
            $stmt = oci_parse($db_conn->conn_id, $sql);
            foreach ($params as $p) {
                // Bind Input (Param name , value , length -1 or max)
                oci_bind_by_name($stmt, $p['name'], $p['value'], -1);
            }

            $cursor = oci_new_cursor($db_conn->conn_id);
            oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
            oci_execute($stmt, OCI_DEFAULT);
            oci_execute($cursor, OCI_DEFAULT);
            oci_fetch_all($cursor, $res);
            oci_commit($db_conn->conn_id);

            return $res;

        } else {
            $msg = "Parameters input can't null";
            return $msg;
        }
    }


}