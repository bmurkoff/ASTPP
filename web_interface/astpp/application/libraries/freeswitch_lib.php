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

if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class freeswitch_lib{
	
	function event_socket_create($host='127.0.0.1', $port='8021', $password='ClueCon') {
	    $fp = @fsockopen($host, $port, $errno, $errdesc);
// 	    or die("Connection to $host failed");
// 	    socket_set_blocking($fp,false);
	    
	    if ($fp) {
		socket_set_blocking($fp,false);
		while (!feof($fp)) {
		    $buffer = fgets($fp, 1024);
		    usleep(100); //allow time for reponse
		    if (trim($buffer) == "Content-Type: auth/request") {
		      fputs($fp, "auth $password\n\n");
		      break;
		    }
		}
		return $fp;
	    }
	    else {
		return false;
	    }           
	}

	function event_socket_request($fp, $cmd) {
	    if ($fp) {    
		fputs($fp, $cmd."\n\n");    
		usleep(100); //allow time for reponse
		
		$response = "";
		$i = 0;
		$contentlength = 0;
		while (!feof($fp)) {
		    $buffer = fgets($fp, 4096);
		    if ($contentlength > 0) {
		      $response .= $buffer;
		    }
		    
		    if ($contentlength == 0) { //if contentlenght is already don't process again
			if (strlen(trim($buffer)) > 0) { //run only if buffer has content
			    $temparray = explode(":", trim($buffer));
			    if ($temparray[0] == "Content-Length") {
			      $contentlength = trim($temparray[1]);
			    }
			}
		    }
		    
		    usleep(100); //allow time for reponse
		    
		    //optional because of script timeout //don't let while loop become endless
		    if ($i > 10000) { break; } 
		    
		    if ($contentlength > 0) { //is contentlength set
			//stop reading if all content has been read.
			if (strlen($response) >= $contentlength) {  
			  break;
			}
		    }
		    $i++;
		}
				
		return $response;
	    }
	    else {
// 	      echo "no handle";
	    }
	}
}
?>
