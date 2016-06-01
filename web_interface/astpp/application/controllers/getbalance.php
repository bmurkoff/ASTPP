<?php 
###########################################################################
# ASTPP - Open Source Voip Billing
# Copyright (C) 2004, Aleph Communications
#
# Contributor(s)
# "iNextrix Technologies Pvt. Ltd - <astpp@inextrix.com>"
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details..
#
# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>
############################################################################

class Getbalance extends MX_Controller
{
	function Getbalance()
	{
		parent::__construct();
		$this->load->model('common_model');
                $this->load->library('common');
		$this->load->model('db_model');
		$this->load->model('Astpp_common');
	}
	function index($sipnumber=''){
	$opensips_flag=common_model::$global_config['system_config']['opensips'];
	$accountid_arr=0;
 	if($opensips_flag == '0'){
            $where=array('username'=>$sipnumber);
            $accountid_arr=$this->db_model->getSelect('accountid','sip_devices',$where);
        }
	else{
	      $db_config = Common_model::$global_config['system_config'];
	      $opensipdsn = "mysql://" . $db_config['opensips_dbuser'] . ":" . $db_config['opensips_dbpass'] . "@" . $db_config['opensips_dbhost'] . "/" . $db_config['opensips_dbname'] . "?char_set=utf8&dbcollat=utf8_general_ci&cache_on=true&cachedir=";
	    $this->opensips_db = $this->load->database($opensipdsn, true);
	    $this->opensips_db->where(array("username"=>$sipnumber));
	    $accountnum_arr=$this->opensips_db->get("subscriber");
            $accountnum_arr=$accountnum_arr->result_array();
	    foreach($accountnum_arr as $value_num){
	    $accountid_arr = $this->db_model->getSelect('id','accounts',array('number'=>$value_num['accountcode']));
	    }
	}
	if($accountid_arr == ''){
		echo "Please enter proper username of SIP Account";
	}
	if($accountid_arr->num_rows()==0 ){
		$where=array('number'=>$sipnumber);
		$accountid_arr=$this->db_model->getSelect('id','accounts',$where);
	}
	if($accountid_arr->num_rows()>0){
		$accountid_arr=$accountid_arr->result_array();
		if($opensips_flag == '0'){
		   foreach($accountid_arr[0] as $key=>$value){
		   }
		  if($key== 'id'){
			$accountid=$accountid_arr[0]['id'];
		  }
		  else{
			$accountid=$accountid_arr[0]['accountid'];
		 }
		}
		else{
			$accountid=$accountid_arr[0]['id'];
		}
		$to_currency = common_model::$global_config['system_config']['base_currency'];
		if($accountid > 0){
		$where=array('id'=>$accountid);
		$balance=$this->db_model->getSelect('balance,currency_id','accounts',$where);
			if($balance->num_rows() > 0){
				//get balance,currency using by user from account number.
				$balance_arr = $balance->result_array();
				$balance=$balance_arr['0']['balance'];
				$currency=$balance_arr['0']['currency_id'];
				//$data=$this->generateInvoice->calculate_currency($balance,$currency);
				//print_r($data);
				//exit;
				//Get Base Currency From System which is main currency of system.

				$base_currency_arr=$this->db_model->getSelect('value','system',array('name'=>'base_currency'));
				$base_currency_arr=$base_currency_arr->result_array();
				$base_currency=$base_currency_arr['0']['value'];
				//Get basse Currency rate from Currency Name.
				$base_currency_info=$this->db_model->getSelect('*','currency',array('currency'=>$base_currency));
				$base_currency_info=$base_currency_info->result_array();
				$base_currency_rate=$base_currency_info['0']['currencyrate'];
				$base_currency_name=$base_currency_info['0']['currency'];
				//Find Currency Rate of user Currency from its currency_id
				$where= array('id'=>$currency);
				$user_currency_info=$this->db_model->getSelect("*",'currency',$where);
				//user Currency Is deleted or Not
				if($user_currency_info->num_rows() > 0){
					$user_currency_info=$user_currency_info->result_array();
					$user_currency=$user_currency_info['0']['currencyrate'];
					$user_currency_name=$user_currency_info['0']['currency'];
				}
				else{
					$user_currency=$base_currency_rate;
					$user_currency_name=$base_currency_name;
				}
				//echo "User Currency ->".$user_currency_info['0']['currencyname']."   Rate-> ".$user_currency.'<br/>';
				//echo "Without Converted".$balance."<br>";
				// Convert Balance of user in user currency
				$convert_balance=round(($balance * $user_currency)/$base_currency_rate,2);
				$convert_balance=sprintf("%.2f", $convert_balance).' '.$user_currency_name;
				echo "Balance : ".$convert_balance;
			}
		}
		else{
			echo "0.00 ".$to_currency;
		}
	}
	else{
		echo "Please enter proper username of SIP Account";
	}
  }
}



?>
 
