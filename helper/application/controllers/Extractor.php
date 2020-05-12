<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Extractor extends CI_Controller {
	function __construct() {

		parent::__construct();
		$this->base_url = "http://paintchip.local/";
		$this->local_image_path = "2020/05/";
		$this->img_dir = "wp-content/uploads/" . $this->local_image_path;
		$this->temp_img_dir = $_SERVER['DOCUMENT_ROOT'] . "/helper/uploads/";
		$this->prod_img_dir = $_SERVER['DOCUMENT_ROOT'] . "/" . $this->img_dir;
		if (is_dir("/var/www/html/paintchip")) {
			$this->base_url = "https://thepaint-chip.com/";

		}
		$this->load->library('AdvancedHtmlBase');

		$this->load->helper('cookie');
		$this->load->helper('file');

		$str = "a:1:{i:26;a:2:{i:0;i:313;i:1;i:581;}}";
/*		die("<h3>Output</h3><pre>" . print_r(unserialize($str), 1) . "</pre>");
 */
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 *      http://example.com/index.php/welcome
	 *  - or -
	 *      http://example.com/index.php/welcome/index
	 *  - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function index() {

		/*$a = "SYS302164S,SYS30216S7,1BS6621,SYS302164S,SYS30216S7,WN3222991,reg45,GP1K1T,GP1O,DE0700836,WFWM2,WFWM4,RC8212142,SO221175,SO221194,SO221195,Fixed,S0665417,RYLP13P,RYLP14P,RYLP15P,RYLP2P,RYLP3P,RYLP4P,RYLP6P,RYLP7P,RYLP8P,S0667012,Location,SM10S902,SM10S903,SM10S901,SM10S904,SM10S905,SM10S907,SM10S908,SM10S909,TE1110,TEi11i,TE1114,TE1124,TE1127,TE1134,TE1145,TE1I46TT,SS021654TE1147,SS021656TE1149,TE1ISITT,TE1167,SS026395LQ5004,SS026476,SM105146,SM105147,SM105148,SM105149,WFCH1,WN2301931,AP70877,Y04103,disc,LQ1045720,SA20072,BSS23008,Y04303,Y04304,WN3240956,Y04251,VA1O1O1,Y04301,W2000,1B56633,1B56574,Y06MMK,VA1O111,1B56526,1B56568,1B56637,1B56620,1B56502,M16044,M16066,ABAT60T,CN95863115,WN32092,M16304,M16046,SA227S,M16088,M16302,M16033,M16202,M16099,M16049,WN32093,M16303,OD14032,3M859NG,ADDE,FC167399,FC167100,FC167199,FC167499,CN741127,CN741157,OD14502,L15501505,JA1A127,Fised,SM400011,SM40009,SA35595,SA37219,SA37221,SA37222,SA35569,SA37218,SA35577,SA37220,Note,BRONZE,Supp1ier2,SM105l20,A1ternate1D,QCom,GX1AB1624,B8S88166,SA32989,SA32084,SA32082,Location,SA32982,SA32984,SA32986,Y06H,WFK16,ELE315,LQ1045151,Fixed,L027010,CN95866165,CN95862055,CN95864095,CN95862275,CN95866755,CN95862025,CN100516063,CN100516039,CN95865355,CN95867177,CN95861005,CN95862355,CN95867005,CN95865705,CN95866545,CN95865085,CN95862015,CN95862439,CN95863349,3M859,Y04403,AV1OO,NBL1OOOC2,L1L5331015,WN34202,reg3,A076630K,1B56613,1B56516,1B56528,1B56636,1B56600,BS080303,D00486273350,0D14072,0D31955,0D30175,0D10202,0D35705,0D13302,0D40122,0D40202,0D12752,0D11502,0D13802,0D11472,0D12552,0D12202,0D3030S,0D12502,0D35507,0D3013S,0D13052,0D35505,0D30205,0D11402,0D11702,0D15542,0D13402,0D11302,0D402S2,0D11002,0D13502,0D13702,0D12602,0D10402,0D13902,0D3S60S,0D10702,0D12402,0D12772,0D15102,L15330030,Y04311,Y04310,Y04320,AB8512MB,PMJR400208,CN95863475,CN95866145,CN95867185,CN95862005,CN100516043,CN95868035,CN95863398,CN95864035,CN95861205,CN95862435,AB8627AB,M14022,M14306,M14066,Location,M14046,M14026,M14055,M14302,M14304,M16306,BS080202,WN7006210,L14020050,L1870887,L1870888,L19871001,Y04422,Y04306,WN2120100,WFHT26,WFHT268,WFHT264,Y04307,GP14BJ,3M771075,AB681,AB681,AB689,AE150,AP1795,AP1795,AP1795,AP1795,AZL5B,BF9001,BS0803,Location,CB120,CB120,CC048,CC049,CC055,CD666,CD740,CHFA3,CMFT1,CMFTl,CMSB4,CNOOO,CN200,CN200,CN200,CN200,CN200,CN200,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA2S5,DA255,DA255,DA255,DA255,Fixed,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA2SS,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA255,DA25S,DA25S,DA255,DA481,Loudon,DA481,DA481,DA481,DA481,DA481,DA481,DA481,DASOO,DASO,DA502,DA503,DA504,DA505,DAS06,Y04312,CLAY,1LLUSTRATION,A1ternate1D,S833215,A1ternate1D,QCom,DA4811008ll,Supp1ier2,CC049,CC049,QCom,A1ternate1D,CM1B24,CN00041382,CN200041394,CPCVB34G,CPCVB34P,CPCVB46G,CPCVB46P,CPCVB68G,CPCVB68P,CPCVB8511G,A1ternate1D,QCom,DAl60,A1ternate1D,QCom,A1ternate1D,DA255,DA255,DA48ll508ll,DEDASll,DEDA53I,DEDA548,DEDA549,DADAG78,DE0700456,DE0700835,DE0700837,DE0700838,DE0700927,DE34213,DE34214,DE39009,DEDAl 11,DEDAl 12,DEDAl3l,DEDAl66,DEDAI 70,DEDAI 72,DEDAl73,DEDAI 74,DEDAI 79,DEDAl80,DEDAl90,DEDA19l,Location,DEDA26l,DEDA306,DEDA0l0,DEDA0l1,SSDEDAO36 DEDA036,SSDEDA04 DEDA04,SSDEDA042 DEDA042,SSDEDA047 DEDA047,SSDEDA048 DEDA048,SSDEDAO52 DEDA052,SSDEDAO55 DEDA055,SSDEDA061 DEDA061,SSDEDA063 DEDA063,SSDEDA064 DEDA064,SSDEDA065 DEDA065,SSDEDA067 DEDA067,SSDEDA068 DEDA068,SSDEDAO71 DEDA071,SSDEDAO72 DEDA072,DEDGPM0l,DEDGPMl0,DEDGPMl l,DEDASll,DEDA53I,DEDA548,DEDA549,DADAG78,DE0700456,DE0700835,DE0700837,DE0700838,DE0700927,DE34213,DE34214,DE39009,DEDAl 11,DEDAl 12,DEDAl3l,DEDAl66,DEDAI 70,DEDAI 72,DEDAl73,DEDAI 74,DEDAI 79,DEDAl80,DEDAl90,DEDA19l,Location,DEDA26l,DEDA306,DEDA0l0,DEDA0l1,DEDASll,DEDASll,DEDA53I,DEDA548,DEDA549,DADAG78,DE0700456,DE0700835,DE0700837,DE0700838,DE0700927,DE34213,DE34214,DE39009,DEDAl 11,DEDAl 12,DEDAl3l,DEDAl66,DEDAI 70,DEDAI 72,DEDAl73,DEDAI 74,DEDAI 79,DEDAl80,DEDAl90,DEDA19l,Location,DEDA26l,DEDA306,DEDA0l0,DEDA0l1,SSDEDAO36 DEDA036,SSDEDA04 DEDA04,SSDEDA042 DEDA042,SSDEDA047 DEDA047,SSDEDA048 DEDA048,SSDEDAO52 DEDA052,SSDEDAO55 DEDA055,SSDEDA061 DEDA061,SSDEDA063 DEDA063,SSDEDA064 DEDA064,SSDEDA065 DEDA065,SSDEDA067 DEDA067,SSDEDA068 DEDA068,SSDEDAO71 DEDA071,SSDEDAO72 DEDA072,DEDGPM0l,DEDGPMl0,DEDGPMl l,DEDAl11,DEDAl12,DEDAI70,DEDAI72,DEDAI74,DEDAI79,SSDEDAO36DEDA036,SSDEDA04DEDA04,SSDEDA042DEDA042,SSDEDA047DEDA047,SSDEDA048DEDA048,SSDEDAO52DEDA052,SSDEDAO55DEDA055,SSDEDA061DEDA061,SSDEDA063DEDA063,SSDEDA064DEDA064,SSDEDA065DEDA065,SSDEDA067DEDA067,SSDEDA068DEDA068,SSDEDAO71DEDA071,SSDEDAO72DEDA072,DEDGPMll,reg2,D00486480011,D00486480127,D00486480194,D00486480208,D00486498638,D00486797953,D00486798291,D00486798313,DEDPM04,DEDPM05,DEDPM07,DEDPM08,DEDPM09,DEDPM12,DEDPM15,DEDPM16,DEDMP17,DEDPM18,DR800815168,DR800815208,OS284600023,Y04501,Y04505,Y04504,SM10Sl50,SP941Sl,OS284600188,VA40506,VA40508,VA40501,YOFU2R,WN6656568,SAl4425,HU0010999,LQ102050,LQ1046ll5,Y04305,DS28460006I,D8284600088,D8284600089,D8284600090,D,Fixe,DUSClIS,E,FC167299,FLFPC0117,SSGB1050GB1050,SSGB1060GB1060,GBI125,OB1150,GBll65,OB1190,OB1200,OB1215,SSG81220081220,0B131S,0B1330,0B1350,GBl410,SSGB14900B1490,SSGB15300B1530,SSGB15350B1535,GBJ620,GBl700,GBl710,OB1720,OB1730,OB1740,GBl780,OB1810,OB1830,SSGB1850081850,OB1875,OB1880,OB2360,OB6810,OB7020,OB7260,OB7300,SSGB7590,SSGB7595,SSGB7610,SSGB7620,SSGB7661,SSGB7678,SSG87679,SSGB7685,OB7710,OB7810,OBF1810,OD10082,GDJ0512,SSGD10902OD10902,SSGD11102OD11102,SSGD11202OD11202,OD11442,GDl4012,OD14482,GDl4602,SSGD157320D15732,SSGD15742GD15742,SSGD15762GD15762,SSGD157720D15772,SSGD353710D35371,SSGD400520D40052,SSGD400620D40062,SSGD401020D40102,SSGD401520D40152,SSGD403020D40302,SSGD852110D85211,SSGD852210D85221,SSGD852310D85231,SSGD852340D85234,SSGD852410D85241,SSGD852440D85244,SSGD852610D85261,SSGD852710D85271,OD85291,OD85301,OD85304,OD85321,OD85324,OD85341,OD85351,OD85361,OD85371,OD85374,OD85381,OD85391,OD85401,OD85404,OD85411,OD85431,OD85434,OD85461,OD85464,OD85471,OD85481,D00486480682,D00486480771,0S284600093,D8284600094,D8284600095,D82846,DS28460042,DT160,FCll4000,FLFAP01311,GBl030,GB107,GB108,SOB1210,0B152,GB168,SO87220,SO87240,G8749,GB750,OB753,G8754,OB755,GB756,GB758,0B7590,OB7595,OB7610,OB7661,OB7678,OB7679,OB7685,GB770,GB772,OD853,OD854,SSGD85644GD85644,OD85661,OD85701,GL664068,GL8800888,GL880618,GP440,GP570PC,GP699B6,S05,HB1570001,HB1570020,HB1570037,HB1570042,HB1570045,HB1570057,HB1570063,HB1570067,HB1570072,HB1570079,HB1570080,HB1570085,HB1570093,HB1570096,SSHB1570099HB1570099,SSHB1570100,SSHB1570121HB1570121,SSHB1570127,SSHB1570128HB1570128,SSHB1570129HB1570129,SSHB1570141HB1570141,IANVL219BK,JAVP12303,REG6,SSJR400157JR400157,SSJR400159,JR40020112,JR40020312,JR40020412,JR496003,JR496004,JR496006,JR710108,JR710228,JR710243,SPECIA,LC414260992,LD283005,SSLQ101076,SSLQ1041017,SSLQ1045890,SSLQ1045892,SSLQ1045893,SSLQ1045894,SSLQ126804,SSLQ3699313,SSLQ3699328,MGII038,MGII040,MGII050,MGII060,MGII080,MGLLL40,MGLLL56,MGLLL60,NG36174,ML400035317,MP2P20CR,MA94872124,MTEX0140L03M,MTEX014010JM,MTEX0140LL8M,MTEX014020IM,MTEX014601M,MTEX0L40604M,MTEX0L41013M,MTEX0L42004M,MTEX014001M,MU66PRO2005,RYZ73TCL4,RYZ73WL,RYZ73WOI,RYZ73WOL2,RYZ83AL4,RYZ83O12,RYZ83GL4,RYZ83LL,RYZ83WL,SA1735795,SAI773L03,SAL7731S6,SA1773L57,SA177316L,SAL773162,SA177316S,SAI773175,SAL773196,SAL773197,SAI773202,SA177322L,SAL77323S,SAI773237,SAI773257,SAL773261,SAL773264,SAL773267,SAL773276,SAL773278,SAL773279,SAI773280,SAL773283,SAI773295,SAI785393,SAI785394,SAI785396,SA1785400,SA1785421,SA1801039B,SA1815006,SAL815007,SA1815008,SA1815009,SAL815010,SA1815012,SAL863389,SA1863413,SA1863414,SA1927296,SA3003S,SA3005L,SA36713,SA371L4,GD856,QUT1ROJOURNALU,L35529,HB157,R210531,JR4960,SPEC1A,L13283,L13283009,LP197,LQ104,LQ101024,ML185,RYZ8314,RYZ83P034,RYZ83P01,RYZ83RP,SA1815011,A1863389,SA1898305,D00486201805,CN7022050,LQ103200,A041821C,BSS23016,SSS96892,SS600970M16402,PP54501,BSS74401,CN95865485,PP54521,LQ104616l,CADORA,Order,GP40012A,LQ1045163,LQ104084,MW70,MW71,MW83,NWOOl,NW002,NW003,P209,PB37S0,PB3950,PB39S0,PB6SOO,PKDPO,PKER2,PKMLO,PKRDP,PL509,PLBG2,PLFPl0,PLFP5,PLFRH,PLPPB,PLPPR,PLS520,PLSD9,PLST15,PLTRJ5,QT1OS,RC117,RC118,RC859,RC869,RS2550,RS25S0,RS2S50,CN31823108,LQ1046I60,ULTRAM,MW6ll000,B3750LO,B3750ML200,B3750MLBO0,B3750MM025,PB37500M025,PB37500M075,PB3750Rl,PB3750Rl0,PB3750Rl2,B3950R2,B3950R4,B3950R6,B3950R8";
			$newa = array();
			$a = explode(",", $a);
			foreach ($a as $aa) {
				$newa[] = '"' . $aa . '"';
			}

		*/

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

		$this->load->view('extractor-index', $data);
	}

	function getCSV($file) {

		ini_set("memory_limit", "500M");
		$file = $_SERVER['DOCUMENT_ROOT'] . "/helper/assets/{$file}.csv";

		$this->load->helper('file');

		$f = read_file($file);
		$f = str_replace("\r", "\n", $f);
		$lines = explode("\n", $f);
		$allitems = array();
		$noids = array();
		$replaces = array(
			'"' => '',
			"GPIKIT" => "GP1KIT",
			"SLSF" => "SLST",
			"5Y5" => "SYS",
		);
		$line_type = "";
		$itema = null;
		$lctr = 0;

		// first repair
		$nlines = array();
		$lctr = 0;
		//die("<h3>Output</h3><pre>" . print_r($lines, 1) . "</pre>");
		foreach ($lines as $line) {
			if (strpos($line, "$") === 0) {
				$nlines[$lctr - 1] .= "," . $line;
			} else {
				$nlines[] = $line;

				$lctr++;
			}
		}

		$lines = $nlines;

		foreach ($lines as $line) {

			foreach ($replaces as $find => $replace) {
				$line = str_replace($find, $replace, $line);
			}

			$line = preg_replace('/  +/', ',', $line);
			$strline = $line;

			$line = explode(",", $line);

			$line = array_values(array_filter($line));
			// $val = $this->decipher($item)

			$idd = false;
			if (!$line || count($line) == 0) {
				continue;
			}

			$firstline = $this->isFirstLine($line);

			if ($firstline) {
				$line_type = 'first';
				$dta = $this->getTitleAndCategory($line);

				//echo "\n - got title " . print_r($dta, 1);
				//die("<h3>Output</h3><pre>" . print_r($strline, 1) . "</pre>");
				$itema = array(
					"id" => "",
					"title" => $dta['title'],
					"price" => '0.00',
					"supplier" => "SS",
					"stock" => "0",
					"category" => $dta['cat'],

				);

				if (!$strline) {
					$strline = "";
				}

				$itema['odata'] = "LINE 1: " . json_encode($line);
				$itema['odata1'] = json_encode($line);

				if ($dta['title'] == '' && $dta['cat'] == '') {
					//echo ("<h3>Processing</h3><pre>" . print_r($line, 1) . print_r($dta, 1) . "</pre>");
					$noids[] = $itema;

					continue;
				}

			} else {
				$line_type = 'second';

				if (!$itema) {
					//echo "\n - NO arr started for second line ";
					$searchlines[] = $line;
					//echo "\n adding to search...  " . print_r($line, 1);

					continue;
				} else {

					//die("<h3>Outsssssput</h3><pre>" . print_r($line, 1) . print_r($itema, 1) . "</pre>");
				}

				$dta = $this->getIDAndPrice($line);
				//echo "\n dta " . print_r($dta, 1);

				$itema['theprice'] = $dta['theprice'];
				$itema['price'] = $dta['price'];
				$itema['id'] = $dta['id'];
				$itema['odata'] .= " // LINE 2: " . json_encode($line);
				$itema['odata2'] = json_encode($line);

				if ($dta['id']) {
					$allitems[] = $itema;
					//echo "\n ---- WRITTEN " . print_r($itema, 1);

				} else {
					//echo "\n ---- NOT " . print_r($itema, 1);

					$noids[] = $itema;
					//$searchlines[] = $line;
				}
				$itema = null;

			}
			$lctr++;
		}
		//die("<h3>Output</h3><pre>" . print_r($searchlines, 1) . "</pre>");
		/*foreach ($searchlines as $line) {
			$dta = $this->getIDAndPrice($line);
			//	echo ("<h3>Output</h3><pre>" . print_r($line, 1) . print_r($dta, 1) . "</pre>");
			$dta['odata'] = json_encode($line);

			$other[] = $dta;
		}*/
		$new_noids = array();
		foreach ($noids as $line) {
			//echo ("<h3>IN </h3><pre>" . print_r($line['odata1'], 1) . print_r($line['odata2'], 1) . "</pre>");
			if (isset($line['odata1'])) {
				$dta = $this->getIDAndPrice(json_decode($line['odata1']), 1);
				//echo ("<h3>-- Output 1</h3><pre>" . print_r($dta, 1) . "</pre>");
			}
			if ($dta['id'] == '' && isset($line['odata2'])) {
				$dta = $this->getIDAndPrice(json_decode($line['odata2']), 1);
				//	echo ("<h3>-- Output 2</h3><pre>" . print_r($dta, 1) . "</pre>");
			}

			if ($dta['id']) {
				$allitems[] = $dta;
			} else {
				$new_noids[] = $line;
			}

		}

		//die("<h3>Output</h3><pre>" . print_r($searchlines, 1) . "</pre>");
		$out = array("not" => $new_noids, "found" => $allitems);
		//	die("<h3>Output</h3><pre>" . print_r($out, 1) . "</pre>");
		echo json_encode($out);
		//echo ("<h3>Output- found: " . count($allitems) . " / not found: " . count($noids) . "</h3><pre>" . print_r($allitems, 1) . "</pre>");

	}

	function removeItem($sku) {
		$q = 'delete from jt_supplier_data where sku="' . $sku . '" and data=""';
		//die("<h3>Output</h3><pre>" . print_r($q, 1) . "</pre>");
		$this->db->query($q);
		echo "OK";
	}

	function isFirstLine($line = array()) {

		if (strtolower(trim($line[0])) == 'ss') {
			return true;
		}
		$test = preg_replace('/[0-9]+/', '', implode("", $line));
		if (strpos($test, "$") !== false) {
			return false;
		}

		$test = str_replace("Yes", "", $test);
		$test = str_replace("EA", "", $test);
		$test = str_replace("cleared", "", $test);

		if (strlen($test) > 8) {
			return true;
		}
		//	echo "\n Not first line  " . print_r($line, 1);
		return false;
	}
	function str_replace_first($from, $to, $content) {
		$from = '/' . preg_quote($from, '/') . '/';

		return preg_replace($from, $to, $content, 1);
	}
	function getIDAndPrice($lineitem = array(), $secondtimearound = false) {
		$id = "";
		$price = array();
		if (!$lineitem || !is_array($lineitem)) {
			return array("price" => 0, "theprice" => 0, "id" => "");

		}
		if (count($lineitem) > 2) {

			$lineitem[1] = str_replace(" ", "", $lineitem[1]);
			$lineitem[1] = str_replace("l", "1", $lineitem[1]);
			$lineitem[1] = preg_replace("/[^A-Za-z0-9 ]/", '', $lineitem[1]);
			if ($lineitem[1] . substr(0, 2) == '18') {
				$lineitem[1] = "TB" . $lineitem[1] . substr(2);
			}
		}
		$ctr = 0;
		foreach ($lineitem as $l) {
			$el = $this->decipher($l);
			//$num = preg_replace('/\d/', '', $el);

			$num = filter_var($el, FILTER_SANITIZE_NUMBER_INT);

			$str = preg_replace('/[0-9]+/', '', $el);
			$l = trim($l);
			$isID = (
				strpos($l, "Supplier") === false && // not a price
				strpos($l, " ") === false && // not a price
				strpos($l, "$") === false && // not a price
				$str != '' && // string part not empty
				strlen($str) > 0 && // string part longer than 1 letter
				strlen($el) > 3 && // original length > 4
				//(intval($num) > 0 || strpos($l, "I") !== false || strpos($l, "I") !== false) &&
				substr($el, 0, 2) != "00" &&
				intval(substr($el, 0, 2)) == 0// first 2 characters are not numbers
			);

			if (!$isID) {
				$isID = strpos($l, "3M") === 0;
			}

			if ($isID && $secondtimearound) {
				$isID = strpos($l, "SS") !== 0;
			}

			if ($isID && !$id) {

				$id = preg_replace("/[^A-Za-z0-9 ]/", '', $el);
				$id = $this->str_replace_first("I", "1", $id);

				//echo "<p>\n SET $id -- $l -- $el =  $word -- first: " . $firstchar;

//                echo "\npassing on $el";

				//continue;
			} else {
				if (strpos($el, "$") !== false) {
					$price[] = $el;
				} else {
					//echo "<p>passing on $el";
				}

			}

			$ctr++;

		}

		$theprice = 0.0;
		if ($price && is_array($price)) {
			//echo ("<h3>Output</h3><pre>" . print_r($price, 1) . "</pre>");
			foreach ($price as $p) {
				$p = preg_replace("/!\d!/", '', $p);
				$p = str_replace("$", "", $p);
				$p = floatval($p);
				//die("<h3>Output</h3><pre>" . print_r($p, 1) . "</pre>");
				$theprice = max($p, $theprice);
			}

			$theprice = number_format($theprice, 2);

		}

		return array("price" => $price, "theprice" => $theprice, "id" => $id);
	}

	function getTitleAndCategory($lineitem = array()) {
		//echo ("<h3>Outp33333ut</h3><pre>" . print_r($lineitem, 1) . "</pre>");
		$title = "";
		$cat = "";
		$trigger = 0;
		if (!$lineitem || !is_array($lineitem)) {
			return array("cat" => "", "title" => "");
		}

		foreach ($lineitem as $l) {
			$el = $this->decipher($l);
			$word = preg_replace('/\d/', '', $el);
			if ($l == "SM4001") {
				$trigger = 1;
			}

			if (strlen($word) > 4) {
				if ($title == '') {
					$title = ucwords(strtolower($el));
				} else if ($cat == '') {
					$cat = ucwords(strtolower($word));
				}

			}

		}
		$arr = array("cat" => $cat, "title" => $title);

		return $arr;
	}

	function decipher($str) {

		$str = preg_replace("/[^A-Za-z0-9 .$,]/", '', $str);
		$str = str_ireplace("�", "", $str);
		$str = str_ireplace("....", "", $str);
		$str = str_ireplace("b    ", "", $str);
		$str = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $str);
		$str = trim($str);
		if (trim($str) == "") {
			return false;
		}

		$ignores = array("Prop65");

		if ($this->strposa($str, $ignores) !== false) {
			return false;
		}
		return $str;

	}

	function strposa($haystack, $needles = array(), $offset = 0) {
		$chr = array();
		foreach ($needles as $needle) {
			$res = strpos($haystack, $needle, $offset);
			if ($res !== false) {
				$chr[$needle] = $res;
			}

		}
		if (empty($chr)) {
			return false;
		}

		return min($chr);
	}

	function getHTMLDataFrom($supplier, $id) {
		if ($supplier == "SS") {
			$url = "https://www.slsarts.com/viewitem.asp?slssku=${id}";
			$imgbase = "https://www.slsarts.com/";
		} else {
			die("<h3>Output</h3><pre>" . print_r("NO SUPPLIER", 1) . "</pre>");
		}

		$html = file_get_html($url);
		$test = $html->find('table', 0);
		if (!$test) {
			return null;
		}

		return $html;

	}

	function getfix() {

		$q = "select * from jt_supplier_data where data=''";
		$r = $this->db->query($q);
		$re = $r->result();
		$r->free_result();

		$out = array();
		foreach ($re as $row) {
			$row->tmp_data = json_decode($row->tmp_data);
			$out[] = $row;
		}

		die(json_encode($out));
	}

	function deletextra($sku) {
		$this->db->query('delete from jt_supplier_data where sku="' . $sku . '" and data=""');
		die("<h3>Output</h3><pre>" . print_r("ok", 1) . "</pre>");
	}

	function getSupplierData($supplier, $id) {
		//phpinfo();

		$tries = 1;

		$q = "select * from jt_supplier_data where sku='$id' order by data desc";
		$result = $this->db->query($q)->result();
		$exists = count($result) > 0;

		if ($exists) {
			$out = array();
			$out['id'] = $id;
			$out['exists'] = 1;
			if ($result[0]->data != '') {
				$out['origid'] = $this->input->post('origid');
			}

			if ($this->input->post('oneoff') == 1) {
				$this->db->query('delete from jt_supplier_data where sku="' . $this->input->post('origid') . '" and data=""');
			}

			die(json_encode($out));
		}

		$html = $this->getHTMLDataFrom($supplier, $id);

		if (!$html) {

			$out = array();
			$out['id'] = $id;
			$out['nodata'] = 1;

			if ($this->input->post('oneoff') == 1) {
				$this->db->query('delete from jt_supplier_data where sku="' . $this->input->post('origid') . '" and data=""');
			}

			/*$in = array(
					"sku" => $id,
					"data" => "",
					"created" => date("Y-m-d H:i:s"),
					"supplier" => $supplier,
				);

			*/
			die(json_encode($out));
		}

		//$this->db->query("delete from jt_supplier_data where sku='$id'");

		if ($supplier == "SS") {
			$url = "https://www.slsarts.com/viewitem.asp?slssku=${id}";
			$imgbase = "https://www.slsarts.com/";
		}
		/*die("<h3>Output</h3><pre>" . print_r($html, 1) . "</pre>");
		$html = file_get_html($url);*/

		$out = array();
		$out['id'] = $id;
		$t = $html->find('h3', 0);
		if ($t) {
			$t = $t->innertext;
		} else {
			$t = $html->find('td.gridbtns', 0);
			if (!$t) {
				$t = "";
			} else {
				$t = $t->innertext;
				$t = explode("<br>", $t);
				$t = ucwords($t[count($t) - 1]);
			}
		}
		$out['title'] = preg_replace('/[\x00-\x1F\x7F]/u', '', $t);

		$desc = $html->find('td.gridleft', 0)->innertext;
		$desc = str_replace("\r", "", $desc);
		$desc = str_replace("\n", "", $desc);
		$desc = preg_replace('#<h3>(.*?)</h3>#', '', $desc, 1);
		$desc = preg_replace('/(<font[^>]*>)|(<\/font>)/', '', $desc);
		$out['description'] = $desc;

		$img = $html->find('.gridcenter img')->src;
		@$imge = $html->find('.gridcenter img')->onerror;
		if ($imge && strpos($imge, "rimgsku(this") !== false) {
			//holy crap we gotta deal with this shit
			$imge = str_replace("rimgsku(this,'", "", $imge);
			$imge = str_replace("');", "", $imge);

			$imge = str_replace("rimgsku(this,'", "", $imge);
			$imge = str_replace("');", "", $imge);

			$img = "/images/" . $imge;
			$img = str_replace("/images/images/", "/images/", $img);
		}

		$img = str_replace("\\", "/", $img);
		$img = str_replace("./", "", $img);
		//$img = str_replace("/images/", "", $img);
		$img = str_replace("Regular Images", "Large Images", $img);

		$oimg = $img;
		if (strpos($oimg, "/") === 0) {
			$oimg = substr($img, 1);
		}

		$oimg = str_replace(" ", "", strtolower($oimg));
		$oimg = str_replace("/", "-", strtolower($oimg));
		$oimg = str_replace("productimages-", "", $oimg);
		$oimg = str_replace("largeimages-", "", $oimg);

		$img = $imgbase . $img;

		// test and save image

		$hasimg = $this->getImage($img, $oimg);

		if (!$hasimg) {
			$oimg = "";
		}

		$out['img'] = $oimg;
		$out['orig_img'] = $img;
		$out['linedata'] = $this->input->post('linedata');

		$d = $this->input->post('data_batch');
		if (!$d) {
			$d = 'retry';
		}

		$out = json_encode($out);
		$in = array(
			"sku" => $id,
			"data" => $out,
			"data_batch" => $d,
			"created" => date("Y-m-d H:i:s"),
			"supplier" => $supplier,
		);
		if ($this->input->post('title')) {
			$in['title'] = $this->input->post('title');
		}
		if ($this->input->post('price')) {
			$in['price'] = str_replace("$", "", $this->input->post('price'));
			$in['category'] = $this->input->post('category');
			$in['approved'] = 1;

		}

		if ($this->db->insert("jt_supplier_data", $in)) {
			if ($this->input->post('oneoff') == 1) {
				$this->db->query('delete from jt_supplier_data where sku="' . $this->input->post('origid') . '" and data=""');
			}
		}

		die($out);

	}

	function getMyCategoryFromLinkData($ldata) {

		$cats = $this->getLiveCats();
		$catref = array();
		foreach ($cats as $cat) {
			$catref[strtolower($cat->name)] = $cat->term_id;
		}

		$cat = $ldata->struc;
		foreach ($cats as $thecat) {
			if (strtolower($thecat->name) == strtolower($cat[1])) {
				return array("mycat" => $thecat->name, "mycatid" => $thecat->term_id);

			}
		}
		return array();

	}
	function returnItemsFromLinkData($ldata, $catdata) {
		$mycat = $catdata['mycat'];
		$mycatid = $catdata['mycatid'];
		$ic = 0;
		$upp = array();
		$upps = array();
		foreach ($ldata->data as $item) {
			$ic++;

			if ($ic == 1) {
				$sku = $item;
			}

			if ($ic == 2) {
				$upp['title'] = $item;
			}

			if ($ic == 3) {
				$upp['upc'] = $item;
			}

			if ($ic % 7 == 0) {

				$upp['price'] = str_replace("$", "", $item);
				$upp['category'] = $mycat;
				$upp['cat_id'] = $mycatid;
				$upp['sku'] = $sku;
				$upps[] = $upp;
				/*$this->db->update('jt_supplier_data', $upp, array("sku" => $sku));
					echo ("<h3>updated</h3><pre>" . print_r($this->db->affected_rows(), 1) . "</pre>");
*/
				$upp = array();
				$sku = '';
				$ic = 0;
			}

		}
		return $upps;

	}

	function fixupcs() {
		$q = "select * from jt_supplier_data where data='' and upc!='' limit 1 ";

		$r = $this->db->query($q)->result();
		if (count($r) == 0) {
			die(json_encode(array("complete" => 1)));
		}
		foreach ($r as $row) {
			$q = "select * from linkys where data like '%" . $row->upc . "%'";
			$rr = $this->db->query($q)->result();

			if (count($rr) > 0) {
				$lrow = $rr[0];
				$ldata = json_decode($lrow->data);

				//get category
				$category = $this->getMyCategoryFromLinkData($ldata);
				$objects = $this->returnItemsFromLinkData($ldata, $category);

				foreach ($objects as $item) {

					$qq = "select * from jt_supplier_data where sku='{$item['sku']}'";
					$rrr = $this->db->query($qq)->result();
					if (count($rrr) > 0) {
						echo "<P>SKU Exists " . $item['sku'];
						echo ("<h3>Output</h3><pre>" . print_r($rrr, 1) . "</pre>");
						continue;
					}
					echo ("<h3>Output</h3><pre>" . print_r($category, 1) . print_r($item, 1) . "</pre>");
					//$q = $this->db->

					$html = $this->getHTMLDataFrom("SS", $item['sku']);

					if (!$html) {

						echo "<P>----NO HTML " . print_r($item, 1);
						continue;
					}

					//$this->db->query("delete from jt_supplier_data where sku='$id'");

					$imgbase = "https://www.slsarts.com/";

					$t = $html->find('h3', 0);
					if ($t) {
						$t = $t->innertext;
					} else {
						$t = $html->find('td.gridbtns', 0);
						if (!$t) {
							$t = "";
						} else {
							$t = $t->innertext;
							$t = explode("<br>", $t);
							$t = ucwords($t[count($t) - 1]);
						}
					}
					//$out['title'] = preg_replace('/[\x00-\x1F\x7F]/u', '', $t);

					$desc = $html->find('td.gridleft', 0)->innertext;
					$desc = str_replace("\r", "", $desc);
					$desc = str_replace("\n", "", $desc);
					$desc = preg_replace('#<h3>(.*?)</h3>#', '', $desc, 1);
					$desc = preg_replace('/(<font[^>]*>)|(<\/font>)/', '', $desc);
					$item['description'] = $desc;

					$img = $html->find('.gridcenter img')->src;
					@$imge = $html->find('.gridcenter img')->onerror;
					if ($imge && strpos($imge, "rimgsku(this") !== false) {
						//holy crap we gotta deal with this shit
						$imge = str_replace("rimgsku(this,'", "", $imge);
						$imge = str_replace("');", "", $imge);

						$imge = str_replace("rimgsku(this,'", "", $imge);
						$imge = str_replace("');", "", $imge);

						$img = "/images/" . $imge;
						$img = str_replace("/images/images/", "/images/", $img);
					}

					$img = str_replace("\\", "/", $img);
					$img = str_replace("./", "", $img);
					//$img = str_replace("/images/", "", $img);
					$img = str_replace("Regular Images", "Large Images", $img);

					$oimg = $img;
					if (strpos($oimg, "/") === 0) {
						$oimg = substr($img, 1);
					}

					$oimg = str_replace(" ", "", strtolower($oimg));
					$oimg = str_replace("/", "-", strtolower($oimg));
					$oimg = str_replace("productimages-", "", $oimg);
					$oimg = str_replace("largeimages-", "", $oimg);

					$img = $imgbase . $img;

					// test and save image

					$hasimg = $this->getImage($img, $oimg);

					if (!$hasimg) {
						$oimg = "";
					}
					$item['image'] = $oimg;
					$item['orig_img'] = $img;
					$item['data'] = $row->tmp_data;

					$up = $this->db->update("jt_supplier_data", $item, array("id" => $row->id));
					if (!$up) {
						die("<h3>Output</h3><pre>" . print_r($this->db->error(), 1) . "</pre>");
					}
					//die("<h3>Output</h3><pre>" . print_r($item, 1) . print_r($row, 1) . "</pre>");

				}

			}
			//echo ("<h3>Output</h3><pre>" . print_r($rr, 1) . "</pre>");
			continue;

		}
		die(json_encode(array("done" => 1)));

		die("<h3>Output</h3><pre>" . print_r("DONE", 1) . "</pre>");
	}

	function updater() {
		$titles = array();
		$q = "select * from linkys where data!='' and mined=1 and moved=0 ";
		$rq = $this->db->query($q);
		$r = $rq->result();
		$rq->free_result();
		$a = array();

		$cats = $this->getLiveCats();
		$catref = array();
		foreach ($cats as $cat) {
			$catref[strtolower($cat->name)] = $cat->term_id;
		}

		foreach ($r as $row) {
			$data = json_decode($row->data);

			$thecat = $this->getMyCategoryFromLinkData($ldata);
			$mycat = $thecat['name'];
			$mycatid = $thecat['term_id'];

			//$mycatid = $catref[strtolower($mycat)];

			$pdata = $data->data;

			$ic = 0;
			$upp = array();
			foreach ($pdata as $item) {
				$ic++;

				if ($ic == 1) {
					$sku = $item;
				}

				if ($ic == 3) {
					$upp['upc'] = $item;
				}

				if ($ic % 7 == 0) {

					$upp['price'] = str_replace("$", "", $item);
					$upp['category'] = $mycat;
					$upp['cat_id'] = $mycatid;
					$this->db->update('jt_supplier_data', $upp, array("sku" => $sku));
					echo ("<h3>updated</h3><pre>" . print_r($this->db->affected_rows(), 1) . "</pre>");

					$upp = array();
					$sku = '';
					$ic = 0;
				}

			}

			//echo ("<h3>Output</h3><pre>" . print_r($catdata, 1) . print_r($pdata, 1) . "</pre>");
		}

		die("<h3>Output</h3><pre>" . print_r("DONE", 1) . "</pre>");

		foreach ($titles as $cat => $subcats) {
			$uid = $catref[strtolower($cat)];
			if (!$uid) {
				die("<h3>Output</h3><pre>" . print_r("NO UID", 1) . "</pre>");
			}
			$order = 0;
			$subids = array();
			foreach ($subcats as $sub) {
				$nt = strtolower($sub);
				$slug = str_replace(" ", "-", $nt);
				$nt = ucwords($nt);
				$nt = str_replace("And ", "and ", $nt);
				$in = array("name" => $nt, "slug" => $slug);
				$this->db->insert("wp_terms", $in);
				$term_id = $this->db->insert_id();
				$subids[] = $term_id;

				$in = array("term_id" => $term_id, "meta_key" => "order", "meta_value" => $order);
				$this->db->insert("wp_termmeta", $in);

				$in = array("term_id" => $term_id, "meta_key" => "display_type", "meta_value" => "products");
				$this->db->insert("wp_termmeta", $in);

				$in = array("term_id" => $term_id, "meta_key" => "thumbnail_id", "meta_value" => "0");
				$this->db->insert("wp_termmeta", $in);

				$in = array("term_id" => $term_id, "taxonomy" => "product_cat", "parent" => $uid);
				$this->db->insert("wp_term_taxonomy", $in);
				$order++;
			}

			$a[$uid] = $subids;

		}

		$a = serialize($a);
		$in = array("option_value" => $a);
		$this->db->update("wp_options", $in, array("option_id" => 104590));

		die("<h3>Output</h3><pre>" . print_r($titles, 1) . "</pre>");
	}

	function updatercats() {
		$titles = array();
		$q = "select * from linkys where data!='' and mined=1 and moved=0 ";
		$rq = $this->db->query($q);
		$r = $rq->result();
		$rq->free_result();
		$a = array();

		foreach ($r as $row) {
			$data = json_decode($row->data);
			$cat = $data->struc;

			if (!array_key_exists($cat[0], $titles)) {
				$titles[$cat[0]] = array($cat[1]);
			} else {
				if (!in_array($cat[1], $titles[$cat[0]])) {
					$titles[$cat[0]][] = $cat[1];
				}
			}

			continue;
			$pdata = $data->data;

			echo ("<h3>Output</h3><pre>" . print_r($catdata, 1) . print_r($pdata, 1) . "</pre>");
		}

		$cats = $this->getLiveCats();
		$catref = array();
		foreach ($cats as $cat) {
			$catref[strtolower($cat->name)] = $cat->term_id;
		}

		foreach ($titles as $cat => $subcats) {
			$uid = $catref[strtolower($cat)];
			if (!$uid) {
				die("<h3>Output</h3><pre>" . print_r("NO UID", 1) . "</pre>");
			}
			$order = 0;
			$subids = array();
			foreach ($subcats as $sub) {
				$nt = strtolower($sub);
				$slug = str_replace(" ", "-", $nt);
				$nt = ucwords($nt);
				$nt = str_replace("And ", "and ", $nt);

				$q = "select * from wp_terms where name='$nt'";
				$rr = $this->db->query($q)->row();
				$term_id = $rr->term_id;
				$subids[] = $term_id;

/*
$in = array("name" => $nt, "slug" => $slug);
$this->db->insert("wp_terms", $in);
$term_id = $this->db->insert_id();
$subids[] = $term_id;

$in = array("term_id" => $term_id, "meta_key" => "order", "meta_value" => $order);
$this->db->insert("wp_termmeta", $in);

$in = array("term_id" => $term_id, "meta_key" => "display_type", "meta_value" => "products");
$this->db->insert("wp_termmeta", $in);

$in = array("term_id" => $term_id, "meta_key" => "thumbnail_id", "meta_value" => "0");
$this->db->insert("wp_termmeta", $in);

$in = array("term_id" => $term_id, "taxonomy" => "product_cat", "parent" => $uid);
$this->db->insert("wp_term_taxonomy", $in);
$order++;*/
			}

			$a[$uid] = $subids;

		}

		$a = serialize($a);
		$in = array("option_value" => $a);

		$this->db->update("wp_options", $in, array('option_name' => 'product_cat_children'));

		//$this->db->update("wp_options", array("option_value" => $d), array('option_name' => 'product_cat_children'));

		die("<h3>Output</h3><pre>" . print_r($titles, 1) . "</pre>");
	}

	/*&

		$r = $this->db->query("select * from linkys where mined=0 and link!='' and  tm='' limit 30 ")->result();
			if (count($r) == 0) {
				die(json_encode(array("complete" => 1)));
			}
			foreach ($r as $el) {
				$file = $el->link;
				$file = str_replace(" ", "%20", $file);
				//$file = str_replace("fright_itemlist.asp", "defaultFrame.asp", $file);
				$u = "https://www.slsarts.com/$file";

				$html = file_get_html($u);

				// get the cat structure
				$struc = array();
				$a = $html->find("a");
				foreach ($a as $alink) {
					$struc[] = trim(str_replace("\r\n", "", $alink->innertext));
				}

				$data = array();
				$cells = $html->find('table td');
				foreach ($cells as $cell) {
					$h = trim($cell->innertext);
					$h = trim(str_replace("\r\n", "", strip_tags($h)));
					if ($h != "") {
						$data[] = $h;

						if ($h == "MSRP") {
							$data = array();
						}

					}
				}

				$up = array("data" => json_encode(array("struc" => $struc, "data" => $data)), "mined" => 1);
				$this->db->update("linkys", $up, array("id" => $el->id));

			}
			die(json_encode(array("done" => 1)));

	*/

	/*a:12:{i:0;a:17:{i:0;i:866;i:1;i:867;i:2;i:868;i:3;i:869;i:4;i:870;i:5;i:871;i:6;i:872;i:7;i:873;i:8;i:874;i:9;i:875;i:10;i:876;i:11;i:877;i:12;i:878;i:13;i:879;i:14;i:880;i:15;i:881;i:16;i:882;}i:1;a:15:{i:0;i:883;i:1;i:884;i:2;i:885;i:3;i:886;i:4;i:887;i:5;i:888;i:6;i:889;i:7;i:890;i:8;i:891;i:9;i:892;i:10;i:893;i:11;i:894;i:12;i:895;i:13;i:896;i:14;i:897;}i:2;a:29:{i:0;i:898;i:1;i:899;i:2;i:900;i:3;i:901;i:4;i:902;i:5;i:903;i:6;i:904;i:7;i:905;i:8;i:906;i:9;i:907;i:10;i:908;i:11;i:909;i:12;i:910;i:13;i:911;i:14;i:912;i:15;i:913;i:16;i:914;i:17;i:915;i:18;i:916;i:19;i:917;i:20;i:918;i:21;i:919;i:22;i:920;i:23;i:921;i:24;i:922;i:25;i:923;i:26;i:924;i:27;i:925;i:28;i:926;}i:3;a:14:{i:0;i:927;i:1;i:928;i:2;i:929;i:3;i:930;i:4;i:931;i:5;i:932;i:6;i:933;i:7;i:934;i:8;i:935;i:9;i:936;i:10;i:937;i:11;i:938;i:12;i:939;i:13;i:940;}i:4;a:39:{i:0;i:941;i:1;i:942;i:2;i:943;i:3;i:944;i:4;i:945;i:5;i:946;i:6;i:947;i:7;i:948;i:8;i:949;i:9;i:950;i:10;i:951;i:11;i:952;i:12;i:953;i:13;i:954;i:14;i:955;i:15;i:956;i:16;i:957;i:17;i:958;i:18;i:959;i:19;i:960;i:20;i:961;i:21;i:962;i:22;i:963;i:23;i:964;i:24;i:965;i:25;i:966;i:26;i:967;i:27;i:968;i:28;i:969;i:29;i:970;i:30;i:971;i:31;i:972;i:32;i:973;i:33;i:974;i:34;i:975;i:35;i:976;i:36;i:977;i:37;i:978;i:38;i:979;}i:5;a:15:{i:0;i:980;i:1;i:981;i:2;i:982;i:3;i:983;i:4;i:984;i:5;i:985;i:6;i:986;i:7;i:987;i:8;i:988;i:9;i:989;i:10;i:990;i:11;i:991;i:12;i:992;i:13;i:993;i:14;i:994;}i:6;a:26:{i:0;i:995;i:1;i:996;i:2;i:997;i:3;i:998;i:4;i:999;i:5;i:1000;i:6;i:1001;i:7;i:1002;i:8;i:1003;i:9;i:1004;i:10;i:1005;i:11;i:1006;i:12;i:1007;i:13;i:1008;i:14;i:1009;i:15;i:1010;i:16;i:1011;i:17;i:1012;i:18;i:1013;i:19;i:1014;i:20;i:1015;i:21;i:1016;i:22;i:1017;i:23;i:1018;i:24;i:1019;i:25;i:1020;}i:7;a:49:{i:0;i:1021;i:1;i:1022;i:2;i:1023;i:3;i:1024;i:4;i:1025;i:5;i:1026;i:6;i:1027;i:7;i:1028;i:8;i:1029;i:9;i:1030;i:10;i:1031;i:11;i:1032;i:12;i:1033;i:13;i:1034;i:14;i:1035;i:15;i:1036;i:16;i:1037;i:17;i:1038;i:18;i:1039;i:19;i:1040;i:20;i:1041;i:21;i:1042;i:22;i:1043;i:23;i:1044;i:24;i:1045;i:25;i:1046;i:26;i:1047;i:27;i:1048;i:28;i:1049;i:29;i:1050;i:30;i:1051;i:31;i:1052;i:32;i:1053;i:33;i:1054;i:34;i:1055;i:35;i:1056;i:36;i:1057;i:37;i:1058;i:38;i:1059;i:39;i:1060;i:40;i:1061;i:41;i:1062;i:42;i:1063;i:43;i:1064;i:44;i:1065;i:45;i:1066;i:46;i:1067;i:47;i:1068;i:48;i:1069;}i:8;a:25:{i:0;i:1070;i:1;i:1071;i:2;i:1072;i:3;i:1073;i:4;i:1074;i:5;i:1075;i:6;i:1076;i:7;i:1077;i:8;i:1078;i:9;i:1079;i:10;i:1080;i:11;i:1081;i:12;i:1082;i:13;i:1083;i:14;i:1084;i:15;i:1085;i:16;i:1086;i:17;i:1087;i:18;i:1088;i:19;i:1089;i:20;i:1090;i:21;i:1091;i:22;i:1092;i:23;i:1093;i:24;i:1094;}i:9;a:23:{i:0;i:1095;i:1;i:1096;i:2;i:1097;i:3;i:1098;i:4;i:1099;i:5;i:1100;i:6;i:1101;i:7;i:1102;i:8;i:1103;i:9;i:1104;i:10;i:1105;i:11;i:1106;i:12;i:1107;i:13;i:1108;i:14;i:1109;i:15;i:1110;i:16;i:1111;i:17;i:1112;i:18;i:1113;i:19;i:1114;i:20;i:1115;i:21;i:1116;i:22;i:1117;}i:10;a:15:{i:0;i:1118;i:1;i:1119;i:2;i:1120;i:3;i:1121;i:4;i:1122;i:5;i:1123;i:6;i:1124;i:7;i:1125;i:8;i:1126;i:9;i:1127;i:10;i:1128;i:11;i:1129;i:12;i:1130;i:13;i:1131;i:14;i:1132;}i:11;a:22:{i:0;s:4:"1134";i:1;s:4:"1135";i:2;s:4:"1136";i:3;s:4:"1137";i:4;s:4:"1138";i:5;s:4:"1139";i:6;s:4:"1140";i:7;s:4:"1141";i:8;s:4:"1142";i:9;s:4:"1143";i:10;s:4:"1144";i:11;s:4:"1145";i:12;s:4:"1146";i:13;s:4:"1147";i:14;s:4:"1148";i:15;s:4:"1149";i:16;s:4:"1150";i:17;s:4:"1151";i:18;s:4:"1152";i:19;s:4:"1153";i:20;s:4:"1154";i:21;s:4:"1155";}}
			*/

	/*function fixone() {
		$q = "select * from wp_terms where term_id>1133";
		$r = $this->db->query($q)->result();
		$s = array('1133' => array());
		foreach ($r as $row) {
			$s['1133'][] = $row->term_id;
		}
		$q = "select * from wp_options where option_name='product_cat_children'";
		$o = $this->db->query($q)->row();
		$d = unserialize($o->option_value);
		$d['1133'] = $s['1133'];
		die("<h3>Output</h3><pre>" . print_r($d, 1) . "</pre>");
		$d = serialize($d);
		$this->db->update("wp_options", array("option_value" => $d), array('option_name' => 'product_cat_children'));

	}*/

	function mine() {
		$r = $this->db->query("select * from linkys where mined=0 and link!='' and  tm='' limit 30 ")->result();
		if (count($r) == 0) {
			die(json_encode(array("complete" => 1)));
		}
		foreach ($r as $el) {
			$file = $el->link;
			$file = str_replace(" ", "%20", $file);
			//$file = str_replace("fright_itemlist.asp", "defaultFrame.asp", $file);
			$u = "https://www.slsarts.com/$file";

			$html = file_get_html($u);

			// get the cat structure
			$struc = array();
			$a = $html->find("a");
			foreach ($a as $alink) {
				$struc[] = trim(str_replace("\r\n", "", $alink->innertext));
			}

			$data = array();
			$cells = $html->find('table td');
			foreach ($cells as $cell) {
				$h = trim($cell->innertext);
				$h = trim(str_replace("\r\n", "", strip_tags($h)));
				if ($h != "") {
					$data[] = $h;

					if ($h == "MSRP") {
						$data = array();
					}

				}
			}

			$up = array("data" => json_encode(array("struc" => $struc, "data" => $data)), "mined" => 1);
			$this->db->update("linkys", $up, array("id" => $el->id));

		}
		die(json_encode(array("done" => 1)));
		// to get link...
		$r = $this->db->query("select * from linkys where mined=0 and link='' and  tm!=''")->result();
		foreach ($r as $el) {
			$file = $el->tm;
			$u = "https://www.slsarts.com/$file";
			//echo "<P>U: " . $u;
			$hstr = file_get_contents($u);
			//die("<h3>Output</h3><pre>" . print_r($html, 1) . "</pre>");
			$items = $this->getItemsFromStr($hstr);
			if (!$items || (!$items['items'] && !$items['links'])) {

				continue;
			}

			foreach ($items['items'] as $item) {
				$this->db->insert("linkys", array("tm" => $item));
			}
			foreach ($items['links'] as $item) {
				$this->db->insert("linkys", array("link" => $item));
			}

			$this->db->update("linkys", array("mined" => 1), array("id" => $el->id));
		}

		die("<h3>Output</h3><pre>" . print_r("DONE - items: " . count($items['items']) . " LInks:" . count($items['links']), 1) . "</pre>");
	}

	function grail() {

		$js = array();
		$links = array();
		$cats = $this->getLiveCats();
		foreach ($cats as $cat) {
			if ($cat->name != 'Books') {
				continue;
			}

			// navigate...
			$ucat = urlencode(strtoupper($cat->name));
			$turl = "https://www.slsarts.com/fright.asp?level1=$ucat";
			echo "<P>$turl";
			$html = file_get_html($turl);
			//die("<h3>Output</h3><pre>" . print_r($html, 1) . "</pre>");

			if (!$html) {
				echo "<P>----NO HTML";
				continue;

			}
			$hstr = $html->plaintext;

			$items = $this->getItemsFromStr($hstr);
			//die("<h3>Output</h3><pre>" . print_r($items, 1) . print_r($hstr, 1) . "</pre>");
			if (!$items || (!$items['items'] && !$items['links'])) {
				continue;
			}

			foreach ($items['items'] as $item) {
				$this->db->insert("linkys", array("tm" => $item));
			}
			foreach ($items['links'] as $item) {
				$this->db->insert("linkys", array("link" => $item));
			}

			//	$links = array_merge($links, $items['links']);

		}

		return;

		//echo ("<h3>Output</h3><pre>" . print_r($js, 1) . "</pre>");
		$njs = array();
		foreach ($js as $file) {
			$u = "https://www.slsarts.com/$file";
			//echo "<P>U: " . $u;
			$hstr = file_get_contents($u);
			//die("<h3>Output</h3><pre>" . print_r($html, 1) . "</pre>");
			$items = $this->getItemsFromStr($hstr);
			if (!$items || (!$items['items'] && !$items['links'])) {

				continue;
			}

			foreach ($items['items'] as $item) {
				if (strpos($item, "tm/tm") !== false) {
					$njs[] = $item;
				}
			}
			$links = array_merge($links, $items['links']);

		}

		$nnjs = array();

		foreach ($njs as $file) {
			$u = "https://www.slsarts.com/$file";
			//echo "<P>U: " . $u;
			$hstr = file_get_contents($u);
			//die("<h3>Output</h3><pre>" . print_r($html, 1) . "</pre>");
			$items = $this->getItemsFromStr($hstr);
			if (!$items || (!$items['items'] && !$items['links'])) {

				continue;
			}

			foreach ($items['items'] as $item) {
				if (strpos($item, "tm/tm") !== false) {
					$nnjs[] = $item;
				}
			}
			$links = array_merge($links, $items['links']);

		}

		echo ("<h3>Output</h3><pre>" . print_r($links, 1) . "</pre>");
		echo ("<h3>Output</h3><pre>" . print_r($nnjs, 1) . "</pre>");

	}

	function getItemsFromStr($hstr) {
		$sch = "var tmenuItems = [";

		$n = explode($sch, $hstr);
		if (count($n) < 2) {
			return false;
		}

		$n = $n[1];
		$n = explode("];", $n);
		$n = $n[0];
		$items = explode('",', $n);
		$ni = array();
		$links = array();
		foreach ($items as $item) {
			$item = trim(str_replace('"', "", $item));
			if (strpos($item, "level2=") !== false) {
				$links[] = $item;
				//die("<h3>Output</h3><pre>" . print_r($items, 1) . "</pre>");

			} else if (strpos($item, "tm/tm") !== false) {
				$ni[] = $item;
			}
		}
		return array("items" => $ni, "links" => $links);

	}

	function getdupes($go = 0) {
		//$this->db->query("delete from jt_supplier_data where sku='A1ternate1D' or sku='disc' or sku='Fixed' or sku='Location' or sku='Multiplier' or sku='QCom' or sku='Supp1ier2'");
		$q = "SELECT id, title,  COUNT(title) as ttl FROM jt_supplier_data where approved=1 and title !='' GROUP BY title HAVING COUNT(title) > 1";
		$r = $this->db->query($q)->result();
		foreach ($r as $row) {
			echo "<p>#" . $row->ttl . " // id: " . $row->id . ": " . $row->title;
			$ttl = addslashes($row->title);
			$q = "select * from jt_supplier_data where title='$ttl' order by price desc";
			$rr = $this->db->query($q)->result();
			$theprice = '';
			foreach ($rr as $srow) {
				echo "<P>$" . $srow->price . " s:" . $srow->sku . ": " . $srow->title;

				$html = $this->getHTMLDataFrom("SS", $srow->sku);

				if (!$html) {
					echo "<P>No HTML";
					continue;
				}

				//$this->db->query("delete from jt_supplier_data where sku='$id'");
				$supplier = "SS";
				/*if ($supplier == "SS") {
					$url = "https://www.slsarts.com/viewitem.asp?slssku=${$rr->sku}";
					$imgbase = "https://www.slsarts.com/";
				}*/
				/*die("<h3>Output</h3><pre>" . print_r($html, 1) . "</pre>");
		$html = file_get_html($url);*/

				$out = array();

				$t = $html->find('td.gridbtns', 0);
				if (!$t) {
					$t = "";
				} else {
					$t = $t->innertext;
					$t = explode("<br>", $t);
					$t = ucwords($t[count($t) - 1]);
				}

				$title = preg_replace('/[\x00-\x1F\x7F]/u', '', $t);

				$title = str_replace("CARDED", "", $title);
				$up = array("title" => $title, "ttlchecked" => 1, "approved" => 0);
				if (strpos($title, "CANVAS") !== false) {
					$up['category'] = "Canvas and Surfaces";
					echo "<P>?-- changing category...";
				}

				if (strpos($title, "CLAY") !== false) {
					$up['category'] = "Clay and Accessories";
					echo "<P>?-- changing category...";
				}

				if (($srow->price != '' && $srow->price != '0')) {
					$up['approved'] = 1;
				}
				echo "<P>new title: " . $title . " -- (OLD: " . $srow->title . ") - $" . $srow->price . " - C:" . $srow->category . " - A:" . $up['approved'];
				if ($go) {
					$this->db->update("jt_supplier_data", $up, array("id" => $srow->id));
				}

			}

			//$out[] = $in;
		}

		die("<h3>Output</h3><pre>done</pre>");

		// DA160
		// DAl60

	}

	function saveForLater() {
		//die("<h3>Output</h3><pre>" . print_r($_POST, 1) . "</pre>");
		$id = $this->input->post('id');
		$this->db->query('update jt_supplier_data set do_later=1 where id=' . $id);
		echo "OK";

	}

	function saveApprove() {
		$id = $this->input->post('id');
		$price = $this->input->post('price');
		$title = $this->input->post('title');
		$category = $this->input->post('category');
		$row = $this->db->query("select * from jt_supplier_data where id=$id")->row();
		$data = json_decode($row->data);
		$data->price = $price;
		$data->category = $category;

		$up = array(
			"title" => $title,
			"price" => $price,
			"category" => $category,
			"approved" => 1,
		);
		$this->db->update("jt_supplier_data", $up, array("id" => $id));
		die(json_encode(array(
			"ok" => 1)));
		die("<h3>Output</h3><pre>" . print_r($data, 1) . "</pre>");
	}

	function getImage($url, $img) {
		$url = trim($url);
		$url = str_replace(" ", "%20", $url);
		$img = str_replace(" ", "-", $img);
		$saveto = $_SERVER['DOCUMENT_ROOT'] . "/helper/uploads/{$img}";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
		$raw = curl_exec($ch);
		curl_close($ch);
		if ($raw !== false) {
			if (file_exists($saveto)) {
				unlink($saveto);
			}
			$fp = fopen($saveto, 'x');
			fwrite($fp, $raw);
			fclose($fp);
			return true;
		} else {
			return false;
		}
	}

	function doonce() {
		$q = "select * from jt_supplier_data where data!='' and approved=1 and (title='' or description='' or image='') order by category asc, suggestedprice desc, price asc ";
		$r = $this->db->query($q);
		$rr = $r->result();
		$r->free_result();
		$out = array();
		foreach ($rr as $row) {
			$new = array();
			$row->data = json_decode($row->data);
			if (!$row->title && $row->data->title != '') {
				$new['title'] = $row->data->title;
			}

			if (!$row->price && isset($row->data->price)) {
				$new['price'] = $row->data->price;
			}

			if (!$row->description && $row->data->description != '') {
				$new['description'] = $row->data->description;
			}

			if (!$row->image && isset($row->data->img) && $row->data->img != '') {

				// test and save image
				echo "<P>is file:" . is_file($this->temp_img_dir . $row->data->img);
				if (!is_file($this->temp_img_dir . $row->data->img)) {
					$hasimg = $this->getImage($row->data->orig_img, $row->data->img);
				}
				$new['image'] = $row->data->img;
				//$hasimg = $this->getImage($row->data->orig_img, $row->data->img);
				//die("<h3>Output</h3><pre>" . print_r($row->data->img . " -" . $row->data->orig_img, 1) . "</pre>");
			}

			/*if (!$row->category && $row->data->category != '') {
				$new['category'] = $row->data->category;
			}*/
			if (count($new) == 0) {
				continue;
			} else {
				$up = $this->db->update("jt_supplier_data", $new, array("id" => $row->id));
				if (!$up) {

					die("<h3>Output</h3><pre>" . print_r($this->db->error(), 1) . "</pre>");
				}
				echo "<hr>updated with: <br><pre>" . print_r($new, 1) . "</pre>";
			}

		}
	}

	function tryit($go = 0) {
		$t = array("Grumbacher");

		foreach ($t as $tt) {
			$r = $this->db->query("Select * from jt_supplier_data where trim(title) like'$tt%' and ttlchecked=0 limit 100")->result();
			foreach ($r as $rr) {

				$html = $this->getHTMLDataFrom("SS", $rr->sku);

				if (!$html) {
					echo "<P>No HTML";
					continue;
				}

				//$this->db->query("delete from jt_supplier_data where sku='$id'");
				$supplier = "SS";
				/*if ($supplier == "SS") {
					$url = "https://www.slsarts.com/viewitem.asp?slssku=${$rr->sku}";
					$imgbase = "https://www.slsarts.com/";
				}*/
				/*die("<h3>Output</h3><pre>" . print_r($html, 1) . "</pre>");
		$html = file_get_html($url);*/

				$out = array();

				$t = $html->find('td.gridbtns', 0);
				if (!$t) {
					$t = "";
				} else {
					$t = $t->innertext;
					$t = explode("<br>", $t);
					$t = ucwords($t[count($t) - 1]);
				}

				$title = preg_replace('/[\x00-\x1F\x7F]/u', '', $t);

				if (strpos(strtolower($title), strtolower($tt)) === FALSE) {
					$title = $tt . " " . $title;
				}
				$up = array("title" => $title, "ttlchecked" => 1, "approved" => 0);
				if (($rr->price != '' && $rr->price != '0') || $rr->approved == 1) {
					$up['approved'] = 1;
				}
				echo "<P>new title: " . $title . " C: " . $rr->category . " -- (" . $rr->title . ") $" . $rr->price . "  A:" . $up['approved'];
				if ($go) {
					$this->db->update("jt_supplier_data", $up, array("id" => $rr->id));
				}

			}

		}
	}

	function fixthecats() {
		$t = array("CHISEL");
	}

	function fixtheimages($go = 0) {
		// get array of image names

		$f = get_filenames($this->temp_img_dir);
		$wh = array();
		foreach ($f as $ff) {
			$wh[] = "'" . $ff . "'";
		}

		$q = "select * from jt_supplier_data where image!='' and image not in (" . implode($wh, ",") . ")";
		echo $q;
	}

	function titlecheck($go = 0) {

		$r = $this->db->query("Select * from jt_supplier_data where approved=0 and title!='' and ttlchecked=0 limit 200")->result();
		foreach ($r as $rr) {

			$html = $this->getHTMLDataFrom("SS", $rr->sku);

			if (!$html) {
				echo "<P>No HTML";
				continue;
			}

			//$this->db->query("delete from jt_supplier_data where sku='$id'");
			$supplier = "SS";
			/*if ($supplier == "SS") {
					$url = "https://www.slsarts.com/viewitem.asp?slssku=${$rr->sku}";
					$imgbase = "https://www.slsarts.com/";
				}*/
			/*die("<h3>Output</h3><pre>" . print_r($html, 1) . "</pre>");
		$html = file_get_html($url);*/

			$out = array();

			$t = $html->find('td.gridbtns', 0);
			if (!$t) {
				$t = "";
			} else {
				$t = $t->innertext;
				$t = explode("<br>", $t);
				$t = ucwords($t[count($t) - 1]);
			}

			$title = preg_replace('/[\x00-\x1F\x7F]/u', '', $t);

			$title = str_replace("CARDED", "", $title);
			$up = array("title" => $title, "ttlchecked" => 1, "approved" => 0);
			if (strpos($title, "CANVAS") !== false) {
				$up['category'] = "Canvas and Surfaces";
				echo "<P>?-- changing category...";
			}

			if (strpos($title, "CLAY") !== false) {
				$up['category'] = "Clay and Accessories";
				echo "<P>?-- changing category...";
			}

			if (($rr->price != '' && $rr->price != '0') || $rr->approved == 1) {
				$up['approved'] = 1;
			}
			echo "<P>new title: " . $title . "(" . $rr->title . ") - $" . $rr->price . " - C:" . $rr->category . " - A:" . $up['approved'];
			if ($go) {
				$this->db->update("jt_supplier_data", $up, array("id" => $rr->id));
			}

		}

	}

	function getGood() {
		$q = "select count(*) as ttl from jt_supplier_data where data!='' and approved != 1 ";
		$r = $this->db->query($q);
		$rr = $r->row();
		$r->free_result();
		$data['notapproved'] = $rr->ttl;

		$q = "select count(*) as ttl from jt_supplier_data where data!='' and approved = 1 ";
		$r = $this->db->query($q);
		$rr = $r->row();
		$r->free_result();
		$data['approved'] = $rr->ttl;

		$q = "select count(*) as ttl from jt_supplier_data where data!='' and approved != 1 and do_later=1";
		$r = $this->db->query($q);
		$rr = $r->row();
		$r->free_result();
		$data['do_later'] = $rr->ttl;

		$q = "select count(*) as ttl from jt_supplier_data where data!='' and category = '' ";
		$r = $this->db->query($q);
		$rr = $r->row();
		$r->free_result();
		$data['nocat'] = $rr->ttl;

		$q = "select count(*) as ttl from jt_supplier_data where data!='' and price = 0 ";
		$r = $this->db->query($q);
		$rr = $r->row();
		$r->free_result();
		$data['noprice'] = $rr->ttl;

		$q = "select * from jt_supplier_data where data!='' and approved != 1 and do_later!=1 order by sku asc, suggestedprice desc, price asc limit 100";
		$r = $this->db->query($q);
		$rr = $r->result();
		$r->free_result();
		$out = array();
		foreach ($rr as $row) {
			$row->data = json_decode($row->data);

			$theline = $row->data->linedata;
			$theline = explode("LINE 2:", $theline);
			$thefline = $theline[0];
			$thefline = str_replace("LINE 1:", "", $thefline);
			$thefline = trim(str_replace("//", "", $thefline));

			$theline = $theline[count($theline) - 1];
			$theline = json_decode($theline);
			$dta = $this->getIDAndPrice($theline);
			$row->data->price = $dta['theprice'];
			if ($thefline) {
				$thefline = json_decode($thefline);
				$dta = $this->getTitleAndCategory($thefline);
				if ($dta && is_array($dta) && isset($dta['category'])) {
					$row->data->category = $dta['category'];
				}

			}

			if (!isset($row->data->category)) {
				$row->data->category = "";
			}

			if (!isset($row->data->price)) {
				$row->data->price = "";
			}

			// test for image
			if ($row->data->img) {
				$local = $_SERVER['DOCUMENT_ROOT'] . "/helper/uploads/" . $row->data->img;
				if (!is_file($local)) {
					//	echo "NOT";
					$row->data->img = "";
				} else {
					//	echo "<P>" . $row->data->img;
				}

			}

			// guess category
			if (!$row->data->category) {
				$row->data->category = $this->guessCategory($row->data);

				/* 	$u = array(
					"title" => $row->data->title,
					"category" => $row->data->category,
					"description" => $row->data->description,
					"price" => $row->data->price,
					"image" => $row->data->img,
				);*/
				if ($row->data->category != "") {
					$u = array(
						"category" => $row->data->category,
					);

					$this->db->update("jt_supplier_data", $u, array("id" => $row->id));
				}
			}

			$out[] = $row;
		}

		$data['good'] = $out;

		die(json_encode($data));
	}

	function guessCategory($data = array()) {
		$title = strtolower($data->title);
		$painting = array(
			"acrylic",
			"liquitex",
			"brush",
			"weber",
			"canvas",
			"easel",
			"tray",
			"linseed",
			"testor",
			"linoleum",
			"plastalina",
			"gamblin",
			"emulsion",
			"gouache",
			"oil color",
			"tempera",
			"tube",
			"jacquard",
			"spray paint",
			"m. graham",
			"scribbles",
			"daniel smith",
			"mask",
			"retarder",
			"versatex",
			"gum arabic",
			"grumbacher",
			"golden",
			"varnish",
			"decoart",
			"filler",
			"gesso",

		);

		$ceramics = array(
			"sculpey",
			"carve",
			"clay",
			"ceramic",
			"pottery",
			"sculpt",
		);

		$frames = array(
			"frame",
			"stretcher",

		);

		$drawing = array(
			"prismacolor",
			"pastel",
			"artyfacts",
			"nibs",
			"pens",
			"pencils",
			"rubber cement",
			"pentel",
			"finish spray",
			"pencil",
			"crayola",
			"ink",
			"crayon",
			"wheel",
			"marker",
			"pitt",
			"graphite",
			"sharpie",
			"calligraphy",
			"squeegee",
			"artbin",
			"faber-castell",
			"koh-",
			"eraser",
			"pen fine",
			"gel pen",
			"pen set",
			"portfolio",
			"profolio",
			"palette",
			"fixative",

		);

		$paper = array(
			"sheet",
			"pads",
			"board",
			"tracing",
			"roll",
			"paper",
			"pages",
			"doodle",
			"glassine",
			"arches",
			"strathmore",
			"tru ray",

		);

		$books = array(
			"book",
			"learn to draw",
			"journal",
			"coloring",
			"drawing:",
			"moleskin",

		);

		$kids = array(
			"kids",
			"silly",
			"face paint",

		);

		$gifts = array(
			"trading cards",
			"greeting cards",

		);

		$print = array(
			"printing",
			"hinge",
			"essential tools",
			"intermediate kit",

		);

		$drafting = array(
			"x-acto",
			"drafting",
		);
		$adhesives = array(
			"spray mount",
			"adhesive",
			"glue",
			"mounting",

		);

		$crafts = array(
			"stain",
			"foamboard",
			"foamcore",
			"tape",
			"tattoo",
			"tie dye",
			"body art",
			"yarn",
			"felt",
			"balsa",
			"basswood",
			"clip",
			"metal leaf",
			"carving",
			"burnish",

		);

		$misc = array(
			"",
		);

		$cats = $this->getCats();

		foreach ($cats as $c => $n) {
			$arr = strtolower($c);
			if (!isset($$arr)) {
				continue;
			}

			foreach ($$arr as $test) {
				if ($test && strpos($title, $test) !== false) {
					return "$n";
				}

			}

		}

		return "";
	}

	function getCategories() {
		$cats = $this->getCats();
		$out = array();
		foreach ($cats as $c => $n) {
			$out[] = $n;
		}

		sort($out);
		$out[] = "Miscellaneous";
		echo json_encode($out);
	}

	function fixCats() {
		$fix = array("Kids Corner" => "Childrens Crafts",
			"Painting Supplies" => "Paints, Mediums and Finishes",
			"Paper Supplies" => "Paper and Pads",
			"Ceramics" => "Clays and Accessories",
			"Adhesives" => "Tapes and Adhesives",
			"Craft Supplies" => "Basic Craft Supplies",
		);
		foreach ($fix as $old => $new) {
			$q = "update jt_supplier_data set category='$new' where category='$old'";
			echo "<P>$q";
			$this->db->query($q);

		}
	}

	function fixCatsWithNew($go = 0) {
		$fix = array(
			"Paints, Mediums and Finishes" => array(
				"acrylic",
				"liquitex",
				"weber",
				"linseed",
				"testor",
				"linoleum",
				"plastalina",
				"gamblin",
				"emulsion",
				"gouache",
				"oil color",
				"tempera",
				"tube",
				"jacquard",
				"spray paint",
				"m. graham",
				"scribbles",
				"daniel smith",
				"mask",
				"retarder",
				"versatex",
				"gum arabic",
				"grumbacher",
				"golden",
				"varnish",
				"decoart",
				"filler",
				"gesso",
			),
			"Airbrush Supplies" => array(
				"airbrush ",

			),

			"Brushes and Brush Care" => array(
				"brush ",
				"brushes",

			),

			"Canvas and Surface" => array(
				"canvas",
				"board",
			),
			"Art Accessories" => array(
				"tray",
				"easel",
				"bin",
			),
			"Pastels" => array(
				"pastel",
			),
			"Pens and Markers" => array(
				"nibs",
				"pen ",
				"pens",
				"marker",
			),
		);
		$ids = array();
		foreach ($fix as $cat => $keywords) {
			$key = array();
			foreach ($keywords as $k) {
				$key[] = " lower(title) like  '%" . $k . "%' ";
			}

			$q = "select * from jt_supplier_data where " . implode(" OR ", $key);
			echo "<P>$q";
			$r = $this->db->query($q)->result();
			foreach ($r as $row) {
				if (in_array($row->id, $ids)) {
					continue;
				}

				$title = strip_tags($row->title);
				echo "<P> changing " . $title . " to $cat (from " . $row->category . ")";
				$q = "update jt_supplier_data set title='" . addslashes($title) . "', category='$cat' where id={$row->id}";
				echo "<P>$q";
				$ids[] = $row->id;
				if ($go) {
					$this->db->query($q);
				}

			}
		}

		/*

			"canvas",
				"easel",
				"tray",

		*/
	}

	function getLiveCats() {
		$q = "select * from wp_terms where term_id>14";
		$res = $this->db->query($q);
		$result = $res->result();
		$res->free_result();
		return $result;
	}

	function removeProducts($go = 0) {

		$q = "update jt_supplier_data set moved=0 where id>0";
		$this->db->query($q);
		$q = "select * from wp_posts where post_type='product' order by id asc";
		$r = $this->db->query($q)->result();
		echo "<P>total product posts:" . count($r);

		$q = "Select count(*) as ttl from wp_posts where post_type='attachment' and id>1014";
		$rr = $this->db->query($q)->row();
		echo "<P>total img:" . $rr->ttl;
		$postids = array();
		foreach ($r as $row) {
			echo "<p>" . $row->post_title;
			$postids[] = $row->ID;

		}

		if ($go) {

			$this->db->query("delete from wp_posts where post_type='attachment' and id>1014");
			$this->db->query("delete from wp_posts where ID in (" . implode(",", $postids) . ")");
			$this->db->query("delete from wp_term_relationships where object_id in (" . implode(",", $postids) . ")");
		} else {

			echo ("<p>delete from wp_posts where post_type='attachment' and id>1014");
			echo ("<p>delete from wp_posts where ID in (" . implode(",", $postids) . ")");
			echo ("<p>delete from wp_term_relationships where object_id in (" . implode(",", $postids) . ")");
		}

	}

	function fixlivecats() {

		$target = "Paints, Mediums and Finishes";
		$subs = array(
			"brush" => 20,
			"watercolor" => 25,
			"oil" => 22,
			"acrylic" => 41,
			"gouache" => 43,
			"tempera" => 42,
			"enamel" => 44,

		);
		$category_id = $this->db->query("select * from wp_terms where name='$target'")->row()->term_id;
//23
		$r = $this->db->query("select * from wp_posts p left join wp_term_relationships r on r.object_id=p.ID where r.term_taxonomy_id=$category_id")->result();

		foreach ($r as $row) {
			$title = strtolower($row->post_title);
			foreach ($subs as $s => $sid) {
				if (strpos($title, $s) !== false) {
					echo "<p>Move into $s: $title";
					$up = array("term_taxonomy_id" => $sid);
					$this->db->update("wp_term_relationships", $up, array("object_id" => $row->ID));
					continue 2;
				}
			}
		}
	}

	function moveProducts($go = 0) {

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);

		/*$str = 'a:5:{s:5:"width";i:225;s:6:"height";i:225;s:4:"file";s:19:"2020/03/images.jpeg";s:5:"sizes";a:0:{}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}';
		die("<h3>Output</h3><pre>" . print_r(unserialize($str), 1) . "</pre>");*/

		// $go = 0;
		$cats = $this->getLiveCats();

		foreach ($cats as $cat) {
			echo "<p>Using Cat " . print_r($cat->name, 1);

			$q = "select * from jt_supplier_data where category='{$cat->name}' and moved=0 and approved=1 order by image desc, id asc limit 500";
			echo "<P>$q";

			$rr = $this->db->query($q);
			$r = $rr->result();
			$rr->free_result();

			foreach ($r as $row) {
				//echo ("<p> going for it " . print_r($row, 1));

				$in = $this->getPostInsertA($row);
				echo "<p>" . $this->db->insert_string("wp_posts", $in);
				if ($go) {
					$done = $this->db->insert("wp_posts", $in);
					if (!$done) {
						die("<h3>Output</h3><pre>" . print_r($this->db->error(), 1) . "</pre>");
					}
					$post_id = $this->db->insert_id();
				} else {
					$post_id = "NEWPOSTID";
				}
				$row->post_id = $post_id;

				$ustr = $this->db->update_string("wp_posts", array("guid" => $this->base_url . "?post_type=product&#038;p=" . $post_id), array("id" => $post_id));

				if ($go) {
					$this->db->query($ustr);
				} else {
					echo "<P>$ustr";
				}
				$row->image_post_id = null;
				if ($row->image) {
					$in = $this->getImgInsertA($row);
					echo "<p>" . $this->db->insert_string("wp_posts", $in);
					if ($go) {
						$done = $this->db->insert("wp_posts", $in);
						if (!$done) {
							die("<h3>Output</h3><pre>" . print_r($this->db->error(), 1) . "</pre>");
						}
						$image_post_id = $this->db->insert_id();
					} else {
						$image_post_id = "NEW-IMAGE-POSTID";
					}

					echo "<P>moving " . $this->temp_img_dir . $row->image . " to " . $this->prod_img_dir . $row->image;
					if ($go) {
						copy($this->temp_img_dir . $row->image, $this->prod_img_dir . $row->image);
					}

					$row->image_post_id = $image_post_id;

					$sz = getimagesize($this->temp_img_dir . $row->image);

					$img_meta = array(

						"width" => $sz[0],
						"height" => $sz[1],
						"file" => "2020/05/" . $row->image,
						"sizes" => Array
						(
						),

						"image_meta" => Array
						(
							"aperture" => 0,
							"credit" => "",
							"camera" => "",
							"caption" => "",
							"created_timestamp" => 0,
							"copyright" => "",
							"focal_length" => 0,
							"iso" => 0,
							"shutter_speed" => 0,
							"title" => $row->title,
							"orientation" => 0,
							"keywords" => Array
							(
							),

						),
					);
					$img_meta = serialize($img_meta);
					$i = array();
					$i[] = array("post_id" => $image_post_id, "meta_key" => "_wp_attached_file", "meta_value" => $this->local_image_path . $row->image);
					$i[] = array("post_id" => $image_post_id, "meta_key" => "_wp_attachment_metadata", "meta_value" => $img_meta);

					if ($go) {
						$this->db->insert_batch("wp_postmeta", $i);
					}

					//echo "<p>post meta: " . print_r($i, 1);

				}

				$up = array("object_id" => $post_id, "term_taxonomy_id" => $cat->term_id);
				if ($go) {
					$this->db->insert("wp_term_relationships", $up);
				}

				echo "<P>wp_term_relationships: " . print_r($up, 1);

				// insert meta
				$in = $this->getPostMetaInsertA($row);

				if ($go) {
					$done = $this->db->insert_batch("wp_postmeta", $in);
					if (!$done) {
						die("<h3>Output</h3><pre>" . print_r($this->db->error(), 1) . "</pre>");
					}

					$upp = array("moved" => 1);
					$this->db->update("jt_supplier_data", $upp, array("id" => $row->id));
				} else {
					echo ("<h3>post meta</h3><pre>" . print_r($in, 1) . "</pre>");
				}

				//echo ("<h3>Output</h3><pre>" . print_r("DONE", 1) . "</pre>");

			}
		}

	}

	function fixsku() {
		$q = "select * from jt_supplier_data where moved=1;";
		$r = $this->db->query($q)->result();

		foreach ($r as $row) {
			$title = trim(strtolower(addslashes($row->title)));
			$q = "select * from wp_posts where trim(lower(post_title))='$title'";
			$t = $this->db->query($q);
			if ($t && $t->num_rows() != 1) {
				echo "<hr>$q";
				echo "<P>-- found 0 or 2+ title matches for $title --  #rows: " . $t->num_rows();
			}

		}
	}

	function getPostInsertA($row) {
		$title = $row->title;
		$title = ucwords(strtolower(trim($title)));
		$safetitle = strtolower($title);
		$safetitle = preg_replace('/[^a-z0-9]+/i', '-', $safetitle); # or...
		$safetitle = preg_replace('/[^a-z\d]+/i', '-', $safetitle);
		$safetitle = str_replace(" ", "-", $safetitle);

		//if (strtoupper($title) == $title) {
		//}
		$a = array(
			"post_author" => 1,
			"post_date" => date("Y-m-d H:i:s"),
			"post_date_gmt" => date("Y-m-d H:i:s"),
			"post_modified_gmt" => date("Y-m-d H:i:s"),
			"post_modified" => date("Y-m-d H:i:s"),
			"post_content" => $row->description,
			"post_title" => $title,
			"post_status" => "publish",
			"comment_status" => "open",
			"ping_status" => "open",
			"post_name" => $safetitle,
			"guid" => $this->base_url . "?post_type=product&#038;p=",
			"post_type" => "product",
			"menu_order" => 0,
		);

		return $a;
	}

	function getImgInsertA($row) {
		$safetitle = strtolower($row->image);
		$safetitle = explode(".", $safetitle);
		$safetitle = $safetitle[0];
		$safetitle = preg_replace('/[^a-z0-9]+ /i', '_', $safetitle); # or...
		$safetitle = preg_replace('/[^a-z\d]+ /i', '_', $safetitle);
		$safetitle = str_replace(" ", "-", $safetitle);
		$a = array(
			"post_author" => 1,
			"post_date" => date("Y-m-d H:i:s"),
			"post_date_gmt" => date("Y-m-d H:i:s"),
			"post_modified_gmt" => date("Y-m-d H:i:s"),
			"post_modified" => date("Y-m-d H:i:s"),
			"post_content" => "",
			"post_title" => $safetitle,
			"post_status" => "inherit",
			"comment_status" => "open",
			"ping_status" => "closed",
			"post_name" => $safetitle,
			"guid" => $this->base_url . $this->img_dir . $row->image,
			"post_type" => "attachment",
			"post_mime_type" => "image/jpeg",
			"menu_order" => 0,
		);

		return $a;
	}

	function getPostMetaInsertA($row) {

		$in = array();

		$in[] = array(
			"post_id" => $row->post_id,
			"meta_key" => "_regular_price",
			"meta_value" => $row->price,
		);

		$in[] = array(
			"post_id" => $row->post_id,
			"meta_key" => "_sku",
			"meta_value" => $row->sku,
		);

		$in[] = array(
			"post_id" => $row->post_id,
			"meta_key" => "_edit_last",
			"meta_value" => "1",
		);

		$in[] = array(
			"post_id" => $row->post_id,
			"meta_key" => "_edit_lock",
			"meta_value" => "",
		);

		$in[] = array(
			"post_id" => $row->post_id,
			"meta_key" => "total_sales",
			"meta_value" => "0",
		);

		$in[] = array(
			"post_id" => $row->post_id,
			"meta_key" => "_tax_status",
			"meta_value" => "taxable",
		);

		$in[] = array(
			"post_id" => $row->post_id,
			"meta_key" => "_tax_class",
			"meta_value" => "",
		);

		$in[] = array(
			"post_id" => $row->post_id,
			"meta_key" => "_manage_stock",
			"meta_value" => "no",
		);

		$in[] = array(
			"post_id" => $row->post_id,
			"meta_key" => "_backorders",
			"meta_value" => "no",
		);

		$in[] = array(
			"post_id" => $row->post_id,
			"meta_key" => "_sold_individually",
			"meta_value" => "no",
		);

		$in[] = array(
			"post_id" => $row->post_id,
			"meta_key" => "_virtual",
			"meta_value" => "no",
		);

		$in[] = array(
			"post_id" => $row->post_id,
			"meta_key" => "_downloadable",
			"meta_value" => "no",
		);

		$in[] = array(
			"post_id" => $row->post_id,
			"meta_key" => "_download_limit",
			"meta_value" => "-1",
		);

		$in[] = array(
			"post_id" => $row->post_id,
			"meta_key" => "_download_expiry",
			"meta_value" => "-1",
		);

		$in[] = array(
			"post_id" => $row->post_id,
			"meta_key" => "_stock",
			"meta_value" => "NULL",
		);

		$in[] = array(
			"post_id" => $row->post_id,
			"meta_key" => "_stock_status",
			"meta_value" => "instock",
		);

		$in[] = array(
			"post_id" => $row->post_id,
			"meta_key" => "_wc_average_rating",
			"meta_value" => "0",
		);

		$in[] = array(
			"post_id" => $row->post_id,
			"meta_key" => "_wc_review_count",
			"meta_value" => "0",
		);

		$in[] = array(
			"post_id" => $row->post_id,
			"meta_key" => "_product_version",
			"meta_value" => "4.0.1",
		);

		$in[] = array(
			"post_id" => $row->post_id,
			"meta_key" => "_price",
			"meta_value" => $row->price,
		);

		if ($row->image_post_id) {
			/*$in[] = array(
				"post_id" => $row->post_id,
				"meta_key" => "_product_image_gallery",
				"meta_value" => $row->image_post_id,
			);*/

			$in[] = array(
				"post_id" => $row->post_id,
				"meta_key" => "_thumbnail_id",
				"meta_value" => $row->image_post_id,
			);
		}

		return $in;
	}

	/*
		//// PRODUCT-IFYING

		set up categories first (wp_terms)
		see how it influenced wp_termmeta

		insert main post into wp_posts (like id:17)
		insert image into wp_posts (like id:18)
		-- move image to correct location...

		update wp_term_relationships
		with object_id = post_id, term_taxonomy_id=category_id (from terms)

		insert into post_meta

		meta_id - auto increment
		post_id - from above
		meta_key, meta_value
		-------------------------
		meta_key: _edit_last
		meta_value: 1

		meta_key: _edit_lock
		meta_value: 1585691484:1

		meta_key: _regular_price
		meta_value: 50  // $VAR

		meta_key: total_sales
		meta_value: 0

		meta_key: _tax_status
		meta_value: taxable

		meta_key: _tax_class
		meta_value:
		meta_key: _manage_stock
		meta_value: no

		meta_key: _backorders
		meta_value: no

		meta_key: _sold_individually
		meta_value: no

		meta_key: _virtual
		meta_value: no

		meta_key: _downloadable
		meta_value: no

		meta_key: _download_limit
		meta_value: -1

		meta_key: _download_expiry
		meta_value: -1

		meta_key: _stock
		meta_value: NULL

		meta_key: _stock_status
		meta_value: instock

		meta_key: _wc_average_rating
		meta_value: 0

		meta_key: _wc_review_count
		meta_value: 0

		meta_key: _product_version
		meta_value: 4.0.1

		meta_key: _price
		meta_value: 50   // $VAR

		meta_key: _product_image_gallery
		meta_value: 20,18  // $VAR

		meta_key: _thumbnail_id
		meta_value: 19  // $VAR
		-------------------------

	*/

	function getCats() {

		// with '// new' below update db on records before may 6
		$cats = array(
			"Crafts" => "Basic Craft Supplies",
			"Art Accessories" => "Art Accessories", // new
			"Airbrush Supplies" => "Airbrush Supplies", // new
			"Brushes and Brush Care" => "Brushes and Brush Care", // new
			"Canvas and Surface" => "Canvas and Surface", // new
			"Adhesives" => "Tapes and Adhesives",
			"Drafting" => "Drafting Supplies",
			"Print" => "Printmaking",
			"Gifts" => "Gifts",
			"Kids" => "Childrens Crafts",
			"Books" => "Books",
			"Bookmaking" => "Bookmaking",
			"Pastels" => "Pastels",
			"Paper" => "Paper and Pads",
			"Drawing" => "Drawing Supplies",
			"Pens and Markers" => "Pens and Markers", // new
			"Frames" => "Frames",
			"Ceramics" => "Clays and Accessories",
			"Painting" => "Paints, Mediums and Finishes");

		ksort($cats);

		return $cats;
	}

	function saveTempSupplierData() {
		$json = array(
			"id" => $this->input->post('id'),
			"title" => $this->input->post('title'),
			"category" => $this->input->post('category'),
			"price" => $this->input->post('price'),
			"linedata" => $this->input->post('linedata'),
		);
		$in = array(
			"sku" => $this->input->post('id'),
			"tmp_data" => json_encode($json),
			"data_batch" => $this->input->post('data_batch'),
			"created" => date("Y-m-d H:i:s"),
			"supplier" => $this->input->post('supplier'),
		);

		$this->db->insert("jt_supplier_data", $in);
		$out = array("status" => "ok");
		die(json_encode($out));
	}

}
