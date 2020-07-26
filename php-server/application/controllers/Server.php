<?php
defined('BASEPATH') or exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");
/*header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
*/
/**
 * Author: Amirul Momenin
 * Desc:Server REST API
 */
class Server extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->helper(array(
            'cookie',
            'url'
        ));
        $this->load->database();
    }

    function serve()
    {
        $method = strtolower($this->input->server('REQUEST_METHOD'));
        switch ($method) {
            case "get":
                $this->get();
                break;
            case "post":
                $this->post();
                break;
            case "delete":
                $this->delete();
                break;
            case "put":
                $this->get();
                break;
        }
    }

    function get()
    {
        $cmd = $this->input->get('cmd');
        switch ($cmd) {
            case "login":
                // grab user input
                $email = $this->security->xss_clean($this->input->get('email'));
                $password = $this->security->xss_clean($this->input->get('password'));

                // Prep the query
                $this->db->where('email', $email);
                $this->db->where('password', $password);

                // Run the query
                $result = $this->db->get('users')->result_array();
                // Let's check if there are any results
                if (count($result) == 1) {
                    // If there is a user, then create session data
                    $data = array(
                        'id' => $result[0]['id'],
                        'email' => $result[0]['email'],
                        'first_name' => $result[0]['first_name'],
						'last_name' => $result[0]['last_name'],
                        'user_type' => $result[0]['user_type'],
                        'file_picture' => $result[0]['file_picture'],
                        'validated' => true
                    );
                    $this->session->set_userdata($data);

                    $arr[0]['status'] = 'success';
                    $arr[0]['user'] = $data;
                    echo json_encode($arr);
                    exit();
                }
                // If the previous process did not validate
                // then return false.
                $data = array(
                    'id' => '',
                    'email' => '',
                    'first_name' => '',
                    'last_name' => '',
                    'file_picture' => '',
                    'validated' => false
                );
                $arr[0]['status'] = 'fail';
                $arr[0]['user'] = $data;
                echo json_encode($arr);
                exit();
                break;
		  case "sendmoney":
                $agent_users_id = $this->input->get('agent_users_id');
                $phone_no = $this->input->get('phone_no');
                $amount = $this->input->get('amount') - 100;

                $this->load->model('Send_model');
                $params = array(
                    'agent_users_id' => $agent_users_id,
                    'subject' => 'send',
                    'note' => 'send',
                    'phone_no' => $phone_no,
                    'amount' => $amount,
                    'status' => 'pending',
                    'created_at' => date("Y-m-d"),
                    'updated_at' => ''
                );
                $send_id = $this->Send_model->add_send($params);
                // Transaction
                $this->load->model('Transactions_model');
                $params = array(
                    'users_id' => $agent_users_id,
                    'subject' => 'trnsaction of ' . $send_id,
                    'note' => 'trnsaction of ' . $send_id,
                    'debit' => $amount,
                    'credit' => 0,
                    'created_at' => date("Y-m-d"),
                    'updated_at' => ''
                );
                $this->Transactions_model->add_transactions($params);

                // Fee
                $this->load->model('Transactions_model');
                $params = array(
                    'users_id' => $agent_users_id,
                    'subject' => 'fee',
                    'note' => 'fee',
                    'debit' => 100,
                    'credit' => 0,
                    'created_at' => date("Y-m-d"),
                    'updated_at' => ''
                );
                $this->Transactions_model->add_transactions($params);

                $arr[0]['id'] = $send_id;
                $arr[0]['status'] = "success";
                echo json_encode($arr);

                break;
				//get all received money
			case "getallreceivedmoney":
					$agent_users_id = $this->input->get('agent_users_id');
					$this->load->database();
					$this->db->where('agent_users_id', $agent_users_id);
					$receive = $this->db->get('receive')->result_array();
					echo json_encode($receive);		
								
			   break; 	
			   //pay to end user
            case "releasemoney":
                $id = $this->input->get('id');
				$agent_users_id = $this->input->get('agent_users_id');
				$amount = $this->input->get('amount');
              
                $this->load->model('Receive_model');
                $params = array(
                    'agent_users_id' => $agent_users_id,
                    'subject' => 'deliver',
                    'note' => 'deliver',
                    'status' => 'completed',
                    'updated_at' =>  date("Y-m-d")
                );
                $receive_id = $this->Receive_model->update_receive($id,$params);
                // Transaction
                $this->load->model('Transactions_model');
                $params = array(
                    'users_id' => $agent_users_id,
                    'subject' => 'deliver of ' . $receive_id,
                    'note' => 'deliver of ' . $receive_id,
                    'debit' => 0,
                    'credit' => $amount,
                    'created_at' => date("Y-m-d"),
                    'updated_at' => ''
                );
                $this->Transactions_model->add_transactions($params);
				//update send
				//get send id
				$datareceive = $this->Receive_model->get_receive($id);
				$send_id = $datareceive['send_id'];
				$this->load->model('Send_model');
                $params = array(
                    'status' => 'completed',
                    'updated_at' =>  date("Y-m-d")
                );
                $send_id = $this->Send_model->update_send($send_id,$params);
				
                $arr[0]['id'] = $receive_id;
                $arr[0]['status'] = "success";
                echo json_encode($arr);

                break;
		   case "get_all_transactions":		        
				$agent_users_id = $this->input->get('agent_users_id');
				$this->load->database();
				$this->db->where('users_id', $agent_users_id);
				$transactions = $this->db->get('transactions')->result_array();
				echo json_encode($transactions);	
		        break;		
		   case "get_total_transactions":		        
				$agent_users_id = $this->input->get('agent_users_id');
			    $this->db->where("transactions.users_id",$agent_users_id);
				$this->db->select('sum(credit-debit) as total');
				$this->db->from('transactions');
				$res = $this->db->get()->result_array();

				$total = $res[0]['total'];
				
				$arr[0]['total'] = $total;
                $arr[0]['status'] = "success";
                echo json_encode($arr);
				break;	
		   case "get_total_send":		         
				$agent_users_id = $this->input->get('agent_users_id');
			    $this->db->where("send.agent_users_id",$agent_users_id);
				$this->db->select_sum('amount');
				$this->db->from('send');
				$res = $this->db->get()->result_array();
				$send_total = $res[0]['amount'];
				
				$arr[0]['send_total'] = $send_total;
                $arr[0]['status'] = "success";
                echo json_encode($arr);
				break;
	        case "get_total_receive":			    
				$agent_users_id = $this->input->get('agent_users_id');
			    $this->db->where("receive.agent_users_id",$agent_users_id);
				$this->db->select_sum('amount');
				$this->db->from('receive');
				$res = $this->db->get()->result_array();
				$receive_total = $res[0]['amount'];
				
				$arr[0]['receive_total'] = $receive_total;
                $arr[0]['status'] = "success";
                echo json_encode($arr);				
		        break;		
				
        }
    }

    function post()
    {
        switch ($cmd) {
            							
        }
    }

    function delete()
    {}

    function put()
    {}
}
?>