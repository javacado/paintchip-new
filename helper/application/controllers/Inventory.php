<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory extends CI_Controller
{
	function __construct()
	{

		parent::__construct();
		$this->base_url = "http://paintchip.local/";
		$this->local_image_path = "2020/06/";
		$this->img_dir = "wp-content/uploads/" . $this->local_image_path;
		$this->temp_img_dir = $_SERVER['DOCUMENT_ROOT'] . "/helper/uploads/";
		$this->prod_img_dir = $_SERVER['DOCUMENT_ROOT'] . "/" . $this->img_dir;
		if (is_dir("/var/www/html/paintchip")) {
			$this->base_url = "https://thepaint-chip.com/";
		}
		$this->load->library('AdvancedHtmlBase');

		$this->load->helper('cookie');
		$this->load->helper('file');
		parse_str($_SERVER['QUERY_STRING'], $this->get);
	}

	function index()
	{
	}
	function parseData($test = 0)
	{
		$nothave = array();
		$csv = $_SERVER['DOCUMENT_ROOT'] . "/dta/thedata.txt";
		$handle = fopen($csv, "r");
		$octr = 0;
		$ct = 0;
		$prods = array();
		$firstignores = array(" ", "Vend", "Prod");


		$q = "select post_id, meta_value from wp_postmeta where meta_key='_sku'";
		$rq = $this->db->query($q);
		$r = $rq->result();
		$rq->free_result();

		$skus = array();
		foreach ($r as $row) {
			$skus[$row->meta_value] = $row->post_id;
		}
		//die("<h3>Output</h3><pre>".print_r($rq,1)."</pre>");

		while (($row = fgetcsv($handle, 10000, ",")) != FALSE) //get row vales
		{
			$first = false;




			$parts = preg_split('/  +/', $row[0]);
			//echo ("<h3>".count($parts)."</h3><pre>" . print_r($parts, 1) . "</pre>");
			$numparts = count($parts);
			$first = $second = false;
			if ($numparts == 8 || $numparts == 9) {
				$prod = array();
				$first = true;

				$test = trim($parts[0]);
				if ($test != "SS" && $test != "MA") {
					//echo "<P>cont...$test</P>";
					continue;
				}
			} else if ($numparts == 12 || $numparts == 13) {
				$second = true;
				if (!isset($prod['title'])) {
					//echo "<P>continueing $octr</P>";
					continue;
				}
			} else {
				continue;
			}

			//if ($octr > 80) break;
			$id = $sku = $title = $price = '';
			if ($first) {
				$prod['supplier'] = $parts[0] == "SS" ? "SLS" : "MAC";
				$testit = trim($parts[0]);
				if ($testit != "SS" && $testit != "MA") {
					echo ("<h3>OutputNOT</h3><pre>" . print_r($parts, 1) . "</pre>");
				}
				$prod['title'] = ucwords(strtolower($parts[2]));
				$prod['carries'] = intval($parts[5]) != 0;
				//	echo("<h3>Output</h3><pre>".print_r($parts,1)."</pre>");
				if ($prod['title'] == '0' || $prod['title'] == '1') {
					$t = explode(" ", $parts[1]);
					unset($t[0]);
					$t = implode(" ", $t);
					$t = ucwords(strtolower($t));
					$prod['title'] = $t;
				}

				if ($prod['title'] == '0' || $prod['title'] == '1') {
					//die("<h3>Output</h3><pre>" . print_r($parts, 1) . "</pre>");

				}
			} else if ($second) {
				$die = 0;
				//die("<h3>Output</h3><pre>".print_r($parts,1)."</pre>");

				$prod['sku'] = $parts[2];
				preg_match_all('!\d+\.*\d*!', $parts[5], $matches);
				$prod['price'] = $matches[0][0]; //preg_replace("/[^A-Za-z ]/", '', $parts[5]);
				$carries = $prod['carries']; //intval($parts[8]) != 0;
				//echo("<h3>Output</h3><pre>".print_r($parts,1)."</pre>");

				$prod['qoh'] = $parts[9];


				/* 
				

				if ($subarr[10] == "disc") {
					echo "<P>SKIPPING";
					$ct = 0;
					continue;
				}
 */
				/* $prod['sku'] = $subarr[1];
				$prod['upc'] = $subarr[2];
				$prod['qoh'] = $subarr[9]; */
				if (!$carries) {
					continue;
				}
				if (!isset($skus[$prod['sku']])) {
					$nothave[] = $prod;
					continue;
				}
				@$prod['post_id'] = $skus[$prod['sku']];
				$prods[] = $prod;
			}


			if ($ct == 1) {
				//echo "\n" . $this->db->insert_string("jt_mac_data", $prod) . ";";
				//$prods[] = $prod;
			}
			$ct = $ct == 0 ? 1 : 0;
			$octr++;

			//print_r($row); //rows in array

			//here you can manipulate the values by accessing the array

		}
		if ($test == 1) die("<h3>Output</h3><pre>" . print_r($prods, 1) . "</pre>");


		$q = "update jt_inv_holder set complete =1 where id>0";
		$this->db->query($q);
		$i = array('date_created' => date("Y-m-d H:i:s"), 'data' => json_encode($prods));
		$this->db->insert('jt_inv_holder', $i);
		echo json_encode(array('status' => 'ok', 'message' => count($prods) . " products uploaded"));

		//echo "<h3>".count($nothave)." Missing Items</h3>";
		//foreach($nothave as $n) {
		//	echo "<br> ". $n['supplier'] . " - " . $n['title']. " SKU: ".$n['sku']." / $" . $n['price'] . " (q: ".$n['qoh'].")";
		//}
	}




	function sku_not_in()
	{

		$q = "SELECT * FROM `wp_postmeta`  where meta_key='_sku' and meta_value!=''";
		$rq = $this->db->query($q);
		$psku = $rq->row();
		$rq->free_result();
		$dbskus = array();
		foreach ($psku as $p) {
			$dbskus[] = $p->meta_value;
		}


		$q = "select * from jt_inv_holder where complete = 0 order by date_created desc";
		$rq = $this->db->query($q);
		if ($rq->num_rows() == 0) {
			die(json_encode(array('error' => 'no data found')));
		}
		$r = $rq->row();
		$curexec = json_decode($r->exec);
		$incoming=array();
		foreach ($curexec as $p){
			$incoming[]=$curexec->sku;

		}

		die("dbskus:".count($dbskus). " /// " . " incoming:".count($incoming));
	}




	function checkInventory()
	{


		$show_missing = true;


		$q = "select * from jt_inv_holder where complete = 0 order by date_created desc";
		$rq = $this->db->query($q);
		if ($rq->num_rows() == 0) {
			die(json_encode(array('error' => 'no data found')));
		}
		$r = $rq->row();
		$curexec = json_decode($r->exec);
		if (!$r->exec) {
			$curexec = array();
		}

		$curerrors = json_decode($r->errors);
		if (!$r->errors) {
			$curerrors = array();
		}

		$invID = $r->id;
		$last_num = $r->last_num;
		$rq->free_result();
		$data = json_decode($r->data);
		$errors = array();
		$exec = array();
		$len = 5500;

		if (count($data) <= $last_num) {
			$u = array('ready' => 1);
			$this->db->update('jt_inv_holder', $u, array("id" => $invID));
			die(json_encode(array('status' => 'complete')));
		}

		$newdata = array_slice($data, $last_num, $len);
		//echo ("<h3>Output</h3><pre>" . print_r($newdata, 1) . "</pre>");

		$postids = array();
		foreach ($newdata as $d) {
			if (!$d->post_id || $d->post_id == '') {
				$errors[] = 'Sku: ' . $d->sku . ' was not in the database';
				continue;
			}
			$postids[] = $d->post_id;
		}

		//die("<h3>Output</h3><pre> post ids ".print_r(count($postids),1)."</pre>");

		if (count($postids) > 0) {
			$postids = implode(",", $postids);

			// get all inventory quantity and price in memory...

			$q = "select post_id, meta_value from wp_postmeta where meta_key='_stock' and post_id in ($postids)";
			$rq = $this->db->query($q);
			$r = $rq->result();
			$rq->free_result();
			$curstock = array();
			foreach ($r as $row) {
				$curstock[$row->post_id] = $row->meta_value;
			}



			$q = "select ID, post_title from wp_posts where ID in ($postids)";
			$rq = $this->db->query($q);
			$r = $rq->result();
			$rq->free_result();
			$titles = array();
			foreach ($r as $row) {
				$titles[$row->ID] = $row->post_title;
			}




			foreach ($newdata as $d) {
				$curq = 0;
				if (isset($curstock[$d->post_id])) {
					$curq = $curstock[$d->post_id];
				}
				if ($curq != $d->qoh) {
					//$curq = 0;


					$d->curq = $curq;
					$d->title = $titles[$d->post_id];
					$exec[] = $d;
				} else {
					$errors[] = 'The item: ' . $d->sku . ' did not change currently set to ' . $curq;
					continue;
				}
			}
		}

		$curerrors = array_merge($curerrors, $errors);
		$curexec = array_merge($curexec, $exec);
		if ($show_missing) {

			foreach ($curerrors as $n) {
				echo "<br> " . $n->supplier . " - " . $n->title . " SKU: " . $n->sku . " / $" . $n->price . " (q: " . $n->qoh . ")";
			}


			//die('doneeee');
			//die("<h3>Output</h3><pre>".print_r(,1)."</pre>");

		}
		//die("<h3>Output</h3><pre>Exec:".print_r(count($curexec),1)."  /// Ertrros:  ".print_r(count($curerrors),1)." </pre>");
		$u = array('last_num' => ($last_num + $len), 'errors' => json_encode($curerrors), 'exec' => json_encode($curexec));

		$this->db->update('jt_inv_holder', $u, array("id" => $invID));
	}


	// UPDATE `jt_inv_holder` SET `exec` = '', `errors` = '', `last_num` = '0' WHERE `jt_inv_holder`.`id` = 1;





	function getUpdateData()
	{
		$q = "select * from jt_inv_holder where complete = 0 order by date_created desc limit 1";
		$rq = $this->db->query($q);
		if ($rq->num_rows() == 0) {
			die(json_encode(array('error' => 'no data found')));
		}
		$r = $rq->row();
		die(json_encode(array('id' => $r->id, 'exec' => $r->exec)));
	}

	function runUpdateData($id)
	{
		die('running');
	}










	function getOrderLogData($post_id)
	{

		$q = "select p.*, l.* from wp_posts p left join wp_order_log l on l.post_id=p.ID  where   ID=$post_id";
		$rq = $this->db->query($q);
		$r = $rq->result();
		$rq->free_result();
		$log = array();
		foreach ($r as $row) {
			$row->prod_data = json_decode($row->prod_data, true);

			$q = "select * from wp_postmeta where post_id={$row->ID}";
			$rq = $this->db->query($q);
			$meta = $rq->result();
			$rq->free_result();
			$m = new stdClass();
			foreach ($meta as $v) {
				$m->{$v->meta_key} = $v->meta_value;
			}
			$row->meta = $m;

			// get products ordered
			$q = "select * from wp_woocommerce_order_items where order_item_type='line_item' and  order_id={$row->ID}";
			$rq = $this->db->query($q);
			$products = $rq->result();
			$prod = array();
			foreach ($products as $pp) {

				$q = "select * from wp_woocommerce_order_itemmeta where order_item_id={$pp->order_item_id} and meta_key='_product_id'";
				$rq = $this->db->query($q);
				$pid = $rq->row();
				$rq->free_result();

				$pp->product_id = $pid->meta_value;


				$q = "SELECT * FROM `wp_postmeta`  where meta_key='_sku' and post_id={$pp->product_id}";
				$rq = $this->db->query($q);
				$psku = $rq->row();
				$rq->free_result();
				$pp->sku = $psku->meta_value;




				$prod[] = $pp;
			}

			$row->products = $prod;
		}

		if ($row) {
			$this->load->view('inside-order-log', array('row' => $row));
		} else {
			echo "";
		}
	}



	

	function index2($completed = 0)
	{
		$waiting = 0;
		if ($completed == 'waiting') {
			$waiting = 1;
		}

		$status = $completed == 0 ? "wc-processing" : "wc-completed";
		$q = "select p.*, l.* from wp_posts p left join wp_order_log l on l.post_id=p.ID  where   post_type='shop_order' and post_status='$status'";
		$rq = $this->db->query($q);
		$r = $rq->result();
		$rq->free_result();
		$log = array();
		foreach ($r as $row) {
			$row->prod_data = json_decode($row->prod_data, true);

			$q = "select * from wp_postmeta where post_id={$row->ID}";
			$rq = $this->db->query($q);
			$meta = $rq->result();
			$rq->free_result();
			$m = new stdClass();
			foreach ($meta as $v) {
				$m->{$v->meta_key} = $v->meta_value;
			}
			$row->meta = $m;

			// get products ordered
			$q = "select * from wp_woocommerce_order_items where order_item_type='line_item' and  order_id={$row->ID}";
			$rq = $this->db->query($q);
			$products = $rq->result();
			$prod = array();
			foreach ($products as $pp) {

				$q = "select * from wp_woocommerce_order_itemmeta where order_item_id={$pp->order_item_id} and meta_key='_product_id'";
				$rq = $this->db->query($q);
				$pid = $rq->row();
				$rq->free_result();

				$pp->product_id = $pid->meta_value;


				$q = "SELECT * FROM `wp_postmeta`  where meta_key='_sku' and post_id={$pp->product_id}";
				//echo "\n\n<!-- $q -->";
				$rq = $this->db->query($q);
				$psku = $rq->row();
				$rq->free_result();
				$pp->sku = $psku->meta_value;




				$prod[] = $pp;
			}

			$row->products = $prod;

			$log[] = $row;
		}
		$this->load->view('order-log', array('log' => $log, 'completed' => $completed));
	}

	function saveLogData()
	{
		$p = $_POST['prod_data'];
		$pd = array();
		foreach ($p as $pp) {
			$pd[$pp['prod_id']] = array('in_store' => $pp['in_store']);
		}
		$prod_data = json_encode($pd);
		$in = array(
			'post_id' => $_POST['post_id'],
			'employee' => $_POST['employee'],
			'picked_up' => $_POST['picked_up'],
			'notes' => $_POST['notes'],
			'prod_data' => $prod_data,
		);
		// test for it
		$q = "select * from wp_order_log where post_id=" . $_POST['post_id'];
		$rq = $this->db->query($q);
		$exists = $rq->result();
		$rq->free_result();
		if ($exists && count($exists) > 0) {
			$exists = $exists[0];
			$log_id = $exists->log_id;
			$this->db->update('wp_order_log', $in, array('log_id' => $log_id));
		} else {
			$this->db->insert('wp_order_log', $in);
		}
	}
}
