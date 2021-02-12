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


		$ok = get_cookie("is_admin") == 1;
		if ($_POST) {
			if (isset($_POST['pphrase']) && $_POST['pphrase'] == 'stasia') {
				set_cookie("is_admin", "1", 99999999);
				$ok = 1;
			} else {
				die("Incorrect. Click the back button and try again");
			}
		}

		$data = array("ok" => $ok);



		$q = "select * from jt_inv_holder where complete = 0 order by date_created desc";
		$rq = $this->db->query($q);
		$r = $rq->result();
		$rq->free_result();
		$data['data'] = $r;
		$this->load->view('inventory-index', $data);
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
			if (strpos($row[0], 'VA10105') !== false) {
				//die("<h3>Output</h3><pre>".print_r($parts,1)."</pre>");

			}

			//echo ("<h3>".count($parts)."</h3><pre>" . print_r($parts, 1) . "</pre>");
			$numparts = count($parts);
			$first = $second = false;
			if ($numparts == 8 || $numparts == 9) {
				$prod = array();
				$first = true;

				$test = trim($parts[0]);
				if ($test != "SS" && $test != "MA") {
					// echo "<P>cont FROM...   $test</P>";
					continue;
				}
			} else if ($numparts == 11 || $numparts == 12 || $numparts == 13) {
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
				$carries = $prod['carries']; //


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
				if (!$carries && intval($prod['qoh']) == 0) {
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



		$q = "select * from jt_inv_holder where complete = 0 order by date_created desc";
		$rq = $this->db->query($q);
		if ($rq->num_rows() == 0) {
			die(json_encode(array('error' => 'no data found')));
		}
		$r = $rq->row();
		$curexec = json_decode($r->exec);
		$incoming = array();
		foreach ($curexec as $p) {
			$incoming[] = $p->sku;
		}

		$not_here = array();

		$q = "SELECT * FROM `wp_postmeta`  where meta_key='_sku' and meta_value!=''";
		$rq = $this->db->query($q);
		$psku = $rq->result();
		$rq->free_result();
		$dbskus = array();
		foreach ($psku as $p) {
			$dbskus[] = $p->meta_value;
			if (!in_array($p->meta_value, $incoming)) {
				$not_here[] = $p->meta_value;
			}
		}



		echo ("dbskus:" . count($dbskus) . " /// " . " incoming:" . count($incoming) . " /// " . " not_here:" . count($not_here));
		die("<h3>Output</h3><pre>" . implode($not_here, ",") . "</pre>");
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
		$curprice = array();
		$exec = array();
		$len = 8500;

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

			$q = "select post_id, meta_key, meta_value from wp_postmeta where (meta_key='_stock' or meta_key='_price' ) and post_id in ($postids)";
			$rq = $this->db->query($q);
			$r = $rq->result();
			$rq->free_result();
			$curstock = array();
			foreach ($r as $row) {
				if ($row->meta_key == '_price') {
					if (isset($curprice[$row->post_id])) {
						die('<p>price already set for ' . $row->post_id);
					}
					$curprice[$row->post_id] = $row->meta_value;
				} else {
					if (isset($curstock[$row->post_id])) {
						die('<p>stock already set for ' . $row->post_id);
					}
					$curstock[$row->post_id] = $row->meta_value;
				}
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
				$curp = 0;

				if (isset($curprice[$d->post_id])) {
					$curp = $curprice[$d->post_id];
				}
				if (!$curp) {
					die('<p>no price for ' . $curp);
				}

				$d->curp = $curp;
				$d->curq = $curq;
				$d->title = $titles[$d->post_id];
				$exec[] = $d;

				if ($curp != $d->price) {
					$diff = (floatval($d->price) - floatval($curp));
					if (abs($diff) > 5) {
						$diff = "<b style='color:#c00'>" . $diff . "</b>";
					}
					echo '<p>The item: ' . $d->sku . ' real price: $' . $d->price . ' // existing price: $' . $curp  . '  (' . $diff . ')';
					//continue;
				}


				if ($curq != $d->qoh) {
					//$curq = 0;
				} else {
					$errors[] = 'The item: ' . $d->sku . ' did not change currently set to ' . $curq;
					//continue;
				}
			}
		}

		$curerrors = array_merge($curerrors, $errors);
		$curexec = array_merge($curexec, $exec);
		if ($show_missing) {

			foreach ($curerrors as $n) {
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

	function initInv($go = 0)
	{
		// get post ids
		$q = "SELECT * FROM `wp_postmeta`  where meta_key='_sku' and meta_value!=''";
		$rq = $this->db->query($q);
		$psku = $rq->result();
		$rq->free_result();
		$postids = array();
		foreach ($psku as $p) {
			$postids[] = $p->post_id;
		}
echo "<p>".count($postids)." products to update</p>";
		$postids  = implode(",", $postids);



		$q = "update wp_postmeta set meta_value='yes' where meta_key='_manage_stock' and post_id in (" . $postids . ')';
		if (!$go) {
			echo "<P>$q</P>";
		} else {
			$uuup = $this->db->query($q);
			if (!$uuup) {
				die("<h3>Output</h3><pre>" . print_r($this->db->error(), 1) . "</pre>");
			}
		}



		$q = "update wp_postmeta set meta_value='0' where meta_key='_stock' and post_id in (" . $postids . ')';
		if (!$go) {
			echo "<P>$q</P>";
		} else {
			$uuup = $this->db->query($q);
			if (!$uuup) {
				die("<h3>Output</h3><pre>" . print_r($this->db->error(), 1) . "</pre>");
			}
		}


		$q = "update wp_postmeta set meta_value='notify' where meta_key='_backorders' and post_id in (" . $postids . ')';
		if (!$go) {
			echo "<P>$q</P>";
		} else {
			$uuup = $this->db->query($q);
			if (!$uuup) {
				die("<h3>Output</h3><pre>" . print_r($this->db->error(), 1) . "</pre>");
			}
		}
	}











	function applyInventory($id, $go = 0)
	{
		// first set manage stock and stock #'s 0 and backorders to 'notify' 
		$q = "SELECT * FROM `jt_inv_holder`  where id=$id";
		$rq = $this->db->query($q);
		$r = $rq->row();
		$rq->free_result();
		$exec = json_decode($r->exec);
		foreach ($exec as $row) {
			$up = array("meta_value" => $row->price);
			$uuup = $this->db->update_string("wp_postmeta", $up, array("meta_key" => "_price", "post_id" => $row->post_id));
			if (!$go) {
				echo ("<P>" . $uuup);
			} else {
				$this->db->query($uuup);
			}




			$up = array("meta_value" => $row->qoh);
			$uuup = $this->db->update_string("wp_postmeta", $up, array("meta_key" => "_stock", "post_id" => $row->post_id));
			if (!$go) {
				echo ("<P>" . $uuup);
			} else {
				$this->db->query($uuup);
			}



		}


		if ($go) {
			$da = date("Y-m-d H:i:s");
			$q = "update jt_inv_holder set complete=1, date_approved='$da' where id=$id";
		$this->db->query($q);
		
		}
	}

	function rununknowns($start)
	{
		$unknowns = $this->getit();
		
		$sku = $unknowns[$start];
		$start++;



		$url = "https://www.macphersonart.com/cgi-bin/maclive/wam_tmpl/catalog_browse.p?site=MAC&layout=Responsive&page=catalog_browse&searchText=" . $sku;
		$res = array();
		$options = array(
			CURLOPT_RETURNTRANSFER => true, // return web page
			CURLOPT_HEADER => false, // do not return headers
			CURLOPT_FOLLOWLOCATION => true, // follow redirects
			CURLOPT_USERAGENT => "spider", // who am i
			CURLOPT_AUTOREFERER => true, // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 120, // timeout on connect
			CURLOPT_TIMEOUT => 120, // timeout on response
			CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
		);
		$ch = curl_init($url);
		curl_setopt_array($ch, $options);
		$content = curl_exec($ch);
		$err = curl_errno($ch);
		$errmsg = curl_error($ch);
		$header = curl_getinfo($ch);
		curl_close($ch);

		$machad = true;
		$res['content'] = $content;
		$res['content'] = strip_tags($content, "<body>");
		$res['url'] = $header['url'];

		$newurl = str_replace('document.location.replace("', "", $res['content']);
		$newurl = str_replace('");', "", $newurl);

		if (!$newurl || strpos($newurl, "Catalog Browse | MacPherson's") != FALSE) {
			$item['data'] = "NO URL";
			//$this->db->update("jt_mac_data", $item, array("id" => $row->id));
			$machad = false ;
$avail = false;
//die("<h3>Output</h3><pre>" . print_r("no url", 1) . "</pre>");

		} else {
		$html = file_get_html($newurl);

$h1s = $html->find('h1');
$avail = true;
foreach ($h1s as $h1) {
	if (strtolower(trim($h1->innerText)) == 'product not found') {
		$avail = false ;
	}
}

	}
 		

		if ($start > count($unknowns)) {
			$a = 'done';
		} else {
			$a = $start+1;
		}


		echo json_encode(array('avail' => $avail, 'machad' => $machad,  'sku' => $sku,  'url' => $url, 'next' => $a));
	}




function getit() {
	return array(
		"RC8693356",
"DC110310",
"DC110302",
"DC110322",
"BS523008",
"CHKSTARTG",
"BS523716",
"SA1815007",
"SA1815010",
"RYRCADSTH18",
"RS255510001",
"RS255500010",
"RS255500006",
"RS255500004",
"RS255500002",
"RS255500001",
"RS255410001",
"RS255400009",
"RS255400007",
"RS255400006",
"RS255400005",
"RS255400004",
"RS255400003",
"RS255400002",
"RS255400001",
"RS255310002",
"RS255300008",
"LC245B",
"JR210531",
"RS255160012",
"RS255160006",
"RS255146002",
"RS255145002",
"RS255145006",
"RS255144001",
"RS255144002",
"RS255144004",
"RS255144006",
"RS255144008",
"RS255142001",
"RS255142002",
"RS255142006",
"RS255142008",
"RS255142010",
"RS255141006",
"RS255141008",
"RS255141010",
"RS255141001",
"RS255141004",
"PB6500SFB4",
"RYZ73WO34",
"RYZ73WO12",
"RYZ73TW14",
"RYZ73TW12",
"RYZ73SP200",
"RYZ73SP100",
"RYZ73FW14",
"RYZ73FW12",
"RS255100050",
"RS255085001",
"RS255085003",
"RS255085004",
"RS255085006",
"RS255085010",
"RS255085099",
"RS255081090",
"RS255081095",
"RS255081097",
"RS255075025",
"RS255075037",
"RS255075050",
"RS255075075",
"RS255068004",
"RS255068006",
"RS255068008",
"RS255068010",
"RS255067002",
"RS255067004",
"RS255067006",
"RS255067008",
"RS255067010",
"RS255067012",
"RS255062004",
"RS255062006",
"RS255062008",
"RS255062010",
"RS255060010",
"RS255060006",
"RS255060008",
"RS255060012",
"RS255060014",
"RS255060016",
"RS255060099",
"RS255055050",
"RS255051001",
"RS255051002",
"RS255051090",
"RS255051098",
"RS255050001",
"RS255050003",
"RS255047002",
"RS255047004",
"PB3950FG037",
"PB3950AS012",
"PB3750TS100",
"PB3750MSP100",
"PB3750MSP200",
"PB3750SP50",
"PB3750SL100",
"PB3750SL180",
"PB3750SC100",
"PB3750SC20",
"PB3750RB12",
"PB3750MR200",
"PB3750MM200",
"PB3750G025",
"PB3750FW050",
"PB3750FG037",
"PB3750FG075",
"BS053515",
"RYZ83WRLG",
"RYZ83PO12",
"RYZ83MB34",
"RYZ83MB12",
"RS255053050",
"RS255052100",
"RS255030001",
"TF6016",
"AMFTHIN780808W",
"AMFTHIN781114B",
"AMFTHIN781620B",
"AMFTHIN781620M",
"AMFTHIN781620W",
"AMFTHIN151114M",
"HU0010305",
"LQ5321",
"GD31955",
"RYRSETKCAP",
"LQ101036",
"BS542390",
"GD35605",
"GD35506",
"DS284040003",
"RYRSETOIL7000",
"RC8591008",
"RC8591006",
"DS284075001",
"DS284055013",
"DS284055002",
"SG221195",
"GD14032",
"GD15742",
"MTEX0140016M",
"MTEX0140020M",
"MTEX0140060M",
"MTEX0140099M",
"MTEX0140100M",
"MTEX0140105M",
"MTEX0140106M",
"MTEX0140108M",
"MTEX0140110M",
"MTEX0140113M",
"MTEX0140115M",
"MTEX0140116M",
"MTEX0140129M",
"MTEX0140144M",
"MTEX0140147M",
"MTEX0140149M",
"MTEX0140151M",
"MTEX0140152M",
"MTEX0140156M",
"MTEX0140160M",
"MTEX0140167M",
"MTEX0140170M",
"MTEX0140172M",
"MTEX0140174M",
"MTEX0140177M",
"MTEX0140178M",
"MTEX0140183M",
"MTEX0140186M",
"MTEX0140189M",
"MTEX0140195M",
"MTEX0140200M",
"MTEX0140600M",
"MTEX0140602M",
"MTEX0144010M",
"MTEX0147047M",
"MTEX0148023M",
"MTEX0149010M",
"MTEX0149011M",
"MTEX0149310M",
"MTEX0140605M",
"MTEX0145005M",
"MTEX0140103M",
"MTEX0140118M",
"MTEX0140201M",
"MTEX0140604M",
"MTEX0141013M",
"MTEX0142004M",
"DEDS183",
"DEDPM1730",
"DEDPM1630",
"DEDPM1530",
"DEDPM1330",
"DEDPM1230",
"DEDPM1030",
"DEDPM0930",
"DEDPM0830",
"DEDPM0730",
"DEDPM0530",
"DEDPM0430",
"DEDPM0130",
"DEDA047",
"KR3940",
"PCCS11203",
"AO76379X",
"AO76362B",
"AO76361A",
"TE1145TT",
"TE1152TT",
"TE1134TT",
"TE1127TT",
"TE1165TT",
"TE1124TT",
"TE1138TT",
"TE1163TT",
"TE1144TT",
"TE1111TT",
"TE1140TT",
"TE1110TT",
"TE1147TT",
"TE1149TT",
"SG665617",
"DS284600004",
"DS284600006",
"DS284600009",
"DS284600019",
"DS284600021",
"DS284600025",
"DS284600028",
"DS284600034",
"DS284600039",
"DS284600041",
"DS284600043",
"DS284600045",
"DS284600046",
"DS284600049",
"DS284600051",
"DS284600058",
"DS284600060",
"DS284600064",
"DS284600065",
"DS284600066",
"DS284600068",
"DS284600077",
"DS284600078",
"DS284600080",
"DS284600091",
"DS284600092",
"DS284600152",
"DS284600156",
"DS284600163",
"DS284600167",
"DS284600175",
"DS284600185",
"DS284600190",
"DS284600193",
"DS284600194",
"DS284600197",
"DS284600198",
"DS284600203",
"DS284600206",
"DS284600222",
"DS284600225",
"DS284600238",
"DS284600096",
"DS284600097",
"DS284600101",
"DS284600103",
"DS284600105",
"DS284600108",
"DS284600109",
"DS284600112",
"DS284600114",
"DS284600086",
"DS284600061",
"DS284600023",
"DS284600188",
"DS284600082",
"DS284600088",
"DS284600090",
"JAJAC9937",
"TR945TBLK",
"JAACC8000",
"RYLP7",
"RYLP6",
"RYLP5",
"RYLP4",
"RYLP3",
"RYLP2",
"RYLP15",
"RYLP14",
"RYLP13",
"GRPKS6A",
"TR2427TSKES",
"MLBWM10152",
"AB9001AB",
"AB83805",
"AB6880AB",
"AB6815AG",
"AB6811AG",
"JR400239",
"JR400208",
"LC4142602499",
"LC4142602484",
"GP5630ABP",
"GP5576BBP",
"ML0729712",
"ML0728312",
"ML0722412",
"RYRSETKCSS",
"RYRD832",
"SKXLP16",
"SKXEP25",
"SKXEP12",
"RYRSETKCOPS",
"CD7400312",
"RT95863115",
"RT95862055",
"RT95864095",
"RT95862275",
"RT95866755",
"RT95862025",
"RT95865365",
"RT95862365",
"RT95865355",
"RT95867177",
"RT95861005",
"RT95862355",
"RT95867005",
"RT95865705",
"RT95866545",
"RT95865085",
"RT95862015",
"RT95862439",
"RT95863349",
"RT95863475",
"RT95862345",
"RT95866145",
"RT95862005",
"RT95863185",
"RT95868035",
"RT95864035",
"RT95861205",
"QT105007",
"RYRD831",
"ML0742312",
"BS510816",
"MS52650",
"MLCMM403",
"PLPG527BP",
"PLPG525BP",
"PLPG523BP",
"ML185032920",
"ML185029920",
"ML185012920",
"RYRD837",
"GPS6491CBP",
"CN100511215",
"SM59417",
"DA481550406",
"DA481550508",
"DA481550811",
"DA481551114",
"DA481500406",
"DA481500508",
"DA481150508",
"DA481151114",
"DA481150811",
"DA481100508",
"DA481100811",
"CPCVB8511G2",
"CPCVB68P2",
"CPCVB46P2",
"CMSB8X11RDBL",
"CMSB4X6FLSQ",
"CMSB4X6FLBL",
"CN100510823",
"NBSB100C2",
"CN100510894",
"CN31074S047",
"CN200041406",
"CN200041397",
"CN200041377",
"CN200041378",
"CN200041384",
"CN200041386",
"CN200041387",
"CN200041391",
"CN200041399",
"CN31074S026",
"CN31074S027",
"CN31074S028",
"CN31074S029",
"CN31074S030",
"CN31074S031",
"CN31074S032",
"CN31074S033",
"CN31074S034",
"CN31074S035",
"CN31074S036",
"CN31074S037",
"CN31074S038",
"CN31074S039",
"CN31074S043",
"CN31074S044",
"CN31074S045",
"CN31074S046",
"CN31074S048",
"CN31074S049",
"CN31074S050",
"CN200041380",
"CN200041396",
"CN200041408",
"CN200041411",
"CN200041414",
"SM41218",
"SM412118",
"DR8008157BY",
"DR8008155BY",
"DR8008151BY",
"DR80081514BY",
"DR80081510BY",
"DR80081511BY",
"DR80081516BY",
"DR80081520BY",
"DA160029028",
"DA160029701",
"TB56619",
"SKXBR12SA",
"PLGFKP3BPA",
"PLFP10BP6A",
"SKXSDKBR49",
"UC125CGLD",
"SA1815005",
"PLK98BP4M",
"PLBG202BPA",
"SKXSDK0849",
"SKXSDK0549",
"SKXSDK0519",
"SKXSDK0119",
"SKXSDK00519",
"PLTRJ50BPA",
"PLST150A",
"PLSD98PABPA",
"FC567100",
"SKXSDK0524",
"SKXSDK0521",
"SKXSDK0149",
"SKXSDK0249",
"SKXSDK0349",
"SKXSDK249",
"SKXSDK349",
"FC567499",
"UC240SCPR",
"UC240SGLD",
"UC240SSLV",
"UC250SCPR",
"UC250SSLV",
"UC350SCPR",
"UC350SGLD",
"UC350SSLV",
"MW711000",
"MW703102",
"SA1905069",
"ML80159",
"ML0615350Y",
"UC4300S1",
"SP008022",
"SP008020",
"SP045061",
"SP004517",
"DL800010402",
"YPADH0901",
"WFPIC8",
"WFPIC6",
"WFPIC4",
"WFPIC3",
"WFLD1",
"WFHT325",
"WFHT324",
"WFHT319",
"WFHT265",
"WFHT17",
"DO0486480194",
"DO0486480011",
"DO0486273350",
"LI3283335",
"WN3254895",
"GP116VPSK",
"RS255300007",
"ME1135",
"PB3950AS037",
"PB3750DF025",
"RYRSETART3103",
"LQ1049432",
"WN2136744",
"MTEX0149312M",
"MTEX0149311M",
"MTEX0148317M",
"MTEX0147040M",
"DEDHS7",
"DEDA378",
"DEDA377",
"DEDA376",
"DEDA375",
"DEDA374",
"DEDGM02",
"DEDGM01",
"DEDGM03",
"DETG0136",
"MG11205",
"SG176314",
"SG176320",
"SG176342",
"SG176350",
"SG176385",
"SG176388",
"SG176396",
"RYRSETART2610",
"IAIA129",
"IAIA12890",
"HX346011ZC",
"MS94872124",
"JR40022012",
"JR400219",
"JR400204",
"KF912YE",
"RYRSETART2503",
"RYRSETART2601",
"RYRSETART3402",
"ML4719116",
"PLZE21BPK6",
"SKXS12949",
"PLP209G",
"GP4440",
"GL881824",
"PLGFLFRHBP",
"PLSES15NA",
"SKXSDK00549",
"SKXSDK01117",
"SKXSDK149",
"MW693013",
"MW127214",
"SP4526",
"SP4524",
"JAVPI2347",
"PTUPCA160MWHT",
"TE3501XT",
"DO0486201805",
"DT00310",
"DC119284",
"SL10310",
"SYSS1",
"SYS3MP05001",
"SYS3MP00001",
"SYS2",
"RT95862009",
"RT95862019",
"RT95862029",
"DA157700012",
"FC129997",
"FC112996",
"FC129298",
"ML4700116",
"ML4706116",
"ML4717112",
"KR1374",
"GR546",
"BL10006",
"BL10506",
"ZGRB60AT902",
"ZGRB60AT901",
"ZGRB60AT900",
"ZGRB60AT803",
"ZGRB60AT400",
"ZGRB60AT303",
"ZGRB60AT302",
"ZGRB60AT260",
"ZGRB60AT230",
"ZGRB60AT222",
"ZGRB60AT220",
"ZGRB60AT200",
"ZGRB6000AT99",
"ZGRB6000AT98",
"ZGRB6000AT97",
"ZGRB6000AT96",
"ZGRB6000AT95",
"ZGRB6000AT94",
"ZGRB6000AT93",
"ZGRB6000AT92",
"ZGRB6000AT91",
"ZGRB6000AT90",
"ZGRB6000AT84",
"ZGRB6000AT83",
"ZGRB6000AT82",
"ZGRB6000AT81",
"ZGRB6000AT80",
"ZGRB6000AT75",
"ZGRB6000AT72",
"ZGRB6000AT71",
"ZGRB6000AT69",
"ZGRB6000AT68",
"ZGRB6000AT67",
"ZGRB6000AT66",
"ZGRB6000AT65",
"ZGRB6000AT64",
"ZGRB6000AT63",
"ZGRB6000AT62",
"ZGRB6000AT61",
"ZGRB6000AT60",
"ZGRB6000AT53",
"ZGRB6000AT52",
"ZGRB6000AT51",
"ZGRB6000AT50",
"ZGRB6000AT49",
"ZGRB6000AT48",
"ZGRB6000AT47",
"ZGRB6000AT46",
"ZGRB6000AT44",
"ZGRB6000AT43",
"ZGRB6000AT42",
"ZGRB6000AT41",
"ZGRB6000AT40",
"ZGRB6000AT38",
"ZGRB6000AT37",
"ZGRB6000AT36",
"ZGRB6000AT35",
"ZGRB6000AT34",
"ZGRB6000AT33",
"ZGRB6000AT32",
"ZGRB6000AT31",
"ZGRB6000AT30",
"ZGRB6000AT29",
"ZGRB6000AT28",
"ZGRB6000AT27",
"ZGRB6000AT26",
"ZGRB6000AT24",
"ZGRB6000AT23",
"ZGRB6000AT22",
"ZGRB6000AT21",
"ZGRB6000AT20",
"ZGRB6000AT10",
"ZGRB6000AT04",
"ZGRB6000AT03",
"ZGRB6000AT02",
"ZGRB6000AT01",
"ZGRB60006VA",
"ZGRB60004VD",
"ZGRB60004VC",
"ZGRB60004VB",
"ZGRB60004VA",
"ZGRB600012VA",
"ZGMS-3400301",
"ZGMS-3400092",
"ZGMS-3400080",
"ZGMS-3400070",
"ZGMS-3400060",
"ZGMS-3400052",
"ZGMS-3400047",
"ZGMS-3400044",
"ZGMS-3400035",
"ZGMS-3400031",
"ZGMS-3400030",
"ZGMS-3400026",
"ZGMS-3400024",
"ZGMS-3400021",
"ZGMS-3400010",
"ZGMC2036V",
"ZGMC2024V",
"ZGMC2018V",
"ZGDO150-60S",
"ZB30",
"YOGX1017",
"WP410111",
"WP410052",
"WP409686",
"WP408994",
"WP408989",
"WP407946",
"WP407942",
"WN6201045",
"UX248385000",
"UX248369000",
"UC222S-GGLD",
"SKXSDK08-36",
"SKXSDK08-29",
"SKXSDK08-19",
"SKXSDK05-36",
"SKXSDK05-32",
"SKXSDK05-29",
"SKXSDK05-243",
"SKXSDK05-230",
"SKXSDK05-138",
"SKXSDK05-12",
"SKXSDK05-05",
"SKXSDK05-03",
"SKXSDK03-36",
"SKXSDK03-29",
"SKXSDK03-19",
"SKXSDK02-36",
"SKXSDK02-29",
"SKXSDK01-36",
"SKXSDK01-29",
"SKXSDK01-24",
"SKXSDK01-21",
"SKXSDK01-12",
"SKXSDK01-05",
"SKXSDK005-36",
"SKXSDK005-29",
"SKXSDK005-24",
"SKXSDK005-21",
"SKXSDK005-12",
"SKXSDK005-05",
"ZNNP102",
"SA37222",
"SA37218",
"RYRSET-2506",
"RYPAL18",
"ROIMA46",
"RLRL03010112",
"RLRL02020112",
"RLRL02020103",
"RLRL01020103",
"PX707695000",
"PX364232000",
"PX364224000",
"PX364216000",
"PX364190000",
"PX364182000",
"PX364174000",
"PX364166000",
"PX148932000",
"PX148924000",
"PX148916000",
"PX148890000",
"PX148882000",
"PX148874000",
"PX148858000",
"PX148841000",
"PX148833000",
"PX148825000",
"PX148817000",
"PX148809000",
"PX148791000",
"PX146696000",
"PX146688000",
"PX146670000",
"PX146662000",
"PX146654000",
"PX146647000",
"PX146639000",
"PX146621000",
"PX146613000",
"PX146605000",
"PX113670000",
"PX113662000",
"PX113654000",
"PX113647000",
"PX113639000",
"PX113621000",
"PX113613000",
"PX113605000",
"PX107615000",
"PX107599000",
"PX107581000",
"PX107573000",
"PX107565000",
"PX107557000",
"PX107540000",
"PX107532000",
"PX107524000",
"PX107516000",
"PX107508000",
"PP91690",
"PP91630",
"PLFRPBP2A",
"PLFRHMMBP",
"PLBG208-MP",
"PLBG208-ME",
"PLBG208-MD",
"PLBG208-MB",
"OY132-103",
"OO50130",
"NLZ8106",
"MZMOO-200",
"MXGLDCAP-25",
"MXGLDCAP-24",
"MXGLDCAP-23",
"MXGLDCAP-22",
"MXGLDCAP-21",
"MVSF31270",
"MVPM06317",
"MVE5510200",
"MVE230516",
"MVCT20219",
"MVBM2",
"MUMC1235US",
"MUMC0462ASC",
"MUMC0402ASC",
"MP2P-100RD",
"MM30001",
"MDMWCP12J",
"MDMMAMG10",
"MDMAW405",
"MDEGSMP5",
"MDEGSMP4",
"MDEGSMP2",
"MDEGSMP1",
"MDEGSBOOK01",
"MDECRZOO",
"LOM1041-7",
"LOM1041-5",
"LOM1041-23",
"LOM1041-17",
"LOM1041-15",
"LI741-1015BF",
"LCWC384-225",
"LCWC382-225",
"LCEM210-5",
"LCEM210-225",
"LCEM207-225",
"KP836552",
"KP835524",
"KOFA8911HB12",
"KOFA89118B12",
"KOFA89116B12",
"KOFA89114B12",
"KOFA89112B12",
"KIN3205",
"KIN3202",
"KIN2102",
"KIN2100",
"IARB-9-12",
"IAMDP-59GYBU",
"IAMDP-47GYBU",
"HY33759",
"HQHCMWNA",
"GXKATP559",
"GP4401-24A",
"FT4425",
"FOCS19",
"EL950-086",
"DZ06121-5T27",
"DZ06121-5020",
"DR800815-22B",
"DR800815-21B",
"DR800815-19B",
"DR800815-18B",
"DR800815-17B",
"DR800815-9B",
"DPDS135-64",
"DPDS134-64",
"DPDGG18-30",
"DPDGG15-30",
"DPDGG14-30",
"DPDGG11-30",
"DPDGG10-30",
"DPDGG08-30",
"DPDGG07-30",
"DPDGG06-30",
"DPDGG05-30",
"DPDGG04-30",
"DPDGG02-30",
"DPDGG01-30",
"DO44483-X",
"DO43037-5",
"DO43037-5",
"DO43006-5",
"DO49313X",
"DO42066-3",
"DO41833-2",
"DO25157-8",
"DK281261",
"DJ284600223",
"DJ284600220",
"DJ284600219",
"DJ284600216",
"DJ284600215",
"DJ284600214",
"DJ284600213",
"DJ284600212",
"DJ284600209",
"DJ284600208",
"DJ284600207",
"DJ284600205",
"DJ284600204",
"DJ284600199",
"DJ284600196",
"DJ284600195",
"DJ284600192",
"DJ284600191",
"DJ284600189",
"DJ284600187",
"DJ284600186",
"DJ284600183",
"DJ284600180",
"DJ284600179",
"DJ284600174",
"DJ284600173",
"DJ284600170",
"DJ284600169",
"DJ284600162",
"DJ284600161",
"DJ284600154",
"DJ284600151",
"DJ284600148",
"DJ284600147",
"DJ284600134",
"DJ284600133",
"DJ284600132",
"DJ284600130",
"DJ284600129",
"DJ284600127",
"DJ284600126",
"DJ284600124",
"DJ284600123",
"DJ284600115",
"DJ284600111",
"DJ284600110",
"DJ284600098",
"DJ284600084",
"DJ284600076",
"DJ284600075",
"DJ284600074",
"DJ284600072",
"DJ284600071",
"DJ284600070",
"DJ284600067",
"DJ284600063",
"DJ284600062",
"DJ284600050",
"DJ284600048",
"DJ284600047",
"DJ284600044",
"DJ284600040",
"DJ284600038",
"DJ284600033",
"DJ284600029",
"DJ284600027",
"DJ284600026",
"DJ284600024",
"DJ284600020",
"DJ284600008",
"DJ284600005",
"DJ284600003",
"CSWSUC2",
"CSWRMAPSF2",
"CSWRCHI",
"CSWRCELEST",
"CSWRAPCW",
"CSWRAPBAR",
"CSWPLU",
"CSWBTRCHT",
"CN100510397",
"CK1165",
"CK1121",
"CC9959-4",
"CB12-00020C",
"BFR400-140",
"BB750006207",
"AE100101",
"AC2133-1",
"AAM-SETPRM",
"AAM-SETPOR",
"AAM-SETPAS",
"AAM-SETGRY",
"AAM-SET12PC",
"AAAS0003",
"AAAS0002",
"AA75114",
"AA71140",
"AA7002",
"AA27073",
"AA18607",
"AA18447",
"AA17952",
"AA17923",
"AA17710",
"AA17591",
"AA15620",
"AA15601",
"AA13306",
"AA12300",
"AA10131",
"BA350-6",
"PAVLSET",
"CE5236",
"CE5237",
"SP1059",
"DA123900024",
"DA123900012",
"SP1050",
"SP1051",
"SP1052",
"SP1053",
"SP1054",
"SP1055",
"SP1056",
"SP1058",
"SP1060",
"SP1061",
"SP1062",
"SP1063",
"SP1064",
"SP1065",
"SP1066",
"SP1067",
"SP1068",
"SP1069",
"SP1070",
"SP1071",
"SP1073",
"LCWC379-225",
"ELE-3066",
"KR3801",
"KR3802",
"KR3803",
"KR3804",
"KR3805",
"KR3806",
"KR3807",
"KR3808",
"KR3809",
"KR3810",
"KR3812",
"KR3813",
"KR3814",
"KR3815",
"EL2022911",
"EL2022923",
"PCCS17292",
"PCCS17293",
"PCCS17294",
"KR3819",
"KR1323",
"HY33751",
"HY33754",
"HY33755",
"SA1924009",
"SA1924010",
"SA1924061",
"SA1924258",
"SA1924008",
"SA1924064",
"BB750016505",
"BB750016510",
"BB750016470",
"BB752006240",
"BB750096740",
"WAR6701",
"WAR6707",
"FR19821311",
"FR19821312",
"FR19821313",
"FR19821314",
"FR19821315",
"FR19821316",
"FR19821317",
"FR19821318",
"FR14821051",
"FR14821052",
"FR14821053",
"FR14821054",
"FR14821055",
"FR14821056",
"FR14821057",
"FR14821058",
"FR19148053",
"FR19148054",
"FR65600086",
"FR65600087",
"FR65600088",
"FR65600089",
"FR65600090",
"FR19007311",
"FR19007312",
"FR19007313",
"FR19007314",
"FR19007315",
"FR19007316",
"FR19007317",
"FR19007318",
"FR19097311",
"FR19097312",
"FR19097313",
"FR19097314",
"FR19097315",
"FR65600083",
"FR21297057",
"FR21297058",
"FR21297311",
"FR21297312",
"FR21297313",
"FR21297314",
"FR21297315",
"FR21297316",
"FR21297317",
"FR21297318",
"ly11110101",
"WN0308103",
"LI4734070"
	);
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
