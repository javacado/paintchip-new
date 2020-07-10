<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Extractor extends CI_Controller {
	function __construct() {

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

		/*$str = "a:12:{i:20;a:17:{i:0;i:866;i:1;i:867;i:2;i:868;i:3;i:869;i:4;i:870;i:5;i:871;i:6;i:872;i:7;i:873;i:8;i:874;i:9;i:875;i:10;i:876;i:11;i:877;i:12;i:878;i:13;i:879;i:14;i:880;i:15;i:881;i:16;i:882;}i:21;a:15:{i:0;i:883;i:1;i:884;i:2;i:885;i:3;i:886;i:4;i:887;i:5;i:888;i:6;i:889;i:7;i:890;i:8;i:891;i:9;i:892;i:10;i:893;i:11;i:894;i:12;i:895;i:13;i:896;i:14;i:897;}i:23;a:29:{i:0;i:898;i:1;i:899;i:2;i:900;i:3;i:901;i:4;i:902;i:5;i:903;i:6;i:904;i:7;i:905;i:8;i:906;i:9;i:907;i:10;i:908;i:11;i:909;i:12;i:910;i:13;i:911;i:14;i:912;i:15;i:913;i:16;i:914;i:17;i:915;i:18;i:916;i:19;i:917;i:20;i:918;i:21;i:919;i:22;i:920;i:23;i:921;i:24;i:922;i:25;i:923;i:26;i:924;i:27;i:925;i:28;i:926;}i:26;a:14:{i:0;i:927;i:1;i:928;i:2;i:929;i:3;i:930;i:4;i:931;i:5;i:932;i:6;i:933;i:7;i:934;i:8;i:935;i:9;i:936;i:10;i:937;i:11;i:938;i:12;i:939;i:13;i:940;}i:27;a:39:{i:0;i:941;i:1;i:942;i:2;i:943;i:3;i:944;i:4;i:945;i:5;i:946;i:6;i:947;i:7;i:948;i:8;i:949;i:9;i:950;i:10;i:951;i:11;i:952;i:12;i:953;i:13;i:954;i:14;i:955;i:15;i:956;i:16;i:957;i:17;i:958;i:18;i:959;i:19;i:960;i:20;i:961;i:21;i:962;i:22;i:963;i:23;i:964;i:24;i:965;i:25;i:966;i:26;i:967;i:27;i:968;i:28;i:969;i:29;i:970;i:30;i:971;i:31;i:972;i:32;i:973;i:33;i:974;i:34;i:975;i:35;i:976;i:36;i:977;i:37;i:978;i:38;i:979;}i:28;a:15:{i:0;i:980;i:1;i:981;i:2;i:982;i:3;i:983;i:4;i:984;i:5;i:985;i:6;i:986;i:7;i:987;i:8;i:988;i:9;i:989;i:10;i:990;i:11;i:991;i:12;i:992;i:13;i:993;i:14;i:994;}i:33;a:26:{i:0;i:995;i:1;i:996;i:2;i:997;i:3;i:998;i:4;i:999;i:5;i:1000;i:6;i:1001;i:7;i:1002;i:8;i:1003;i:9;i:1004;i:10;i:1005;i:11;i:1006;i:12;i:1007;i:13;i:1008;i:14;i:1009;i:15;i:1010;i:16;i:1011;i:17;i:1012;i:18;i:1013;i:19;i:1014;i:20;i:1015;i:21;i:1016;i:22;i:1017;i:23;i:1018;i:24;i:1019;i:25;i:1020;}i:35;a:49:{i:0;i:1021;i:1;i:1022;i:2;i:1023;i:3;i:1024;i:4;i:1025;i:5;i:1026;i:6;i:1027;i:7;i:1028;i:8;i:1029;i:9;i:1030;i:10;i:1031;i:11;i:1032;i:12;i:1033;i:13;i:1034;i:14;i:1035;i:15;i:1036;i:16;i:1037;i:17;i:1038;i:18;i:1039;i:19;i:1040;i:20;i:1041;i:21;i:1042;i:22;i:1043;i:23;i:1044;i:24;i:1045;i:25;i:1046;i:26;i:1047;i:27;i:1048;i:28;i:1049;i:29;i:1050;i:30;i:1051;i:31;i:1052;i:32;i:1053;i:33;i:1054;i:34;i:1055;i:35;i:1056;i:36;i:1057;i:37;i:1058;i:38;i:1059;i:39;i:1060;i:40;i:1061;i:41;i:1062;i:42;i:1063;i:43;i:1064;i:44;i:1065;i:45;i:1066;i:46;i:1067;i:47;i:1068;i:48;i:1069;}i:37;a:25:{i:0;i:1070;i:1;i:1071;i:2;i:1072;i:3;i:1073;i:4;i:1074;i:5;i:1075;i:6;i:1076;i:7;i:1077;i:8;i:1078;i:9;i:1079;i:10;i:1080;i:11;i:1081;i:12;i:1082;i:13;i:1083;i:14;i:1084;i:15;i:1085;i:16;i:1086;i:17;i:1087;i:18;i:1088;i:19;i:1089;i:20;i:1090;i:21;i:1091;i:22;i:1092;i:23;i:1093;i:24;i:1094;}i:38;a:23:{i:0;i:1095;i:1;i:1096;i:2;i:1097;i:3;i:1098;i:4;i:1099;i:5;i:1100;i:6;i:1101;i:7;i:1102;i:8;i:1103;i:9;i:1104;i:10;i:1105;i:11;i:1106;i:12;i:1107;i:13;i:1108;i:14;i:1109;i:15;i:1110;i:16;i:1111;i:17;i:1112;i:18;i:1113;i:19;i:1114;i:20;i:1115;i:21;i:1116;i:22;i:1117;}i:39;a:15:{i:0;i:1118;i:1;i:1119;i:2;i:1120;i:3;i:1121;i:4;i:1122;i:5;i:1123;i:6;i:1124;i:7;i:1125;i:8;i:1126;i:9;i:1127;i:10;i:1128;i:11;i:1129;i:12;i:1130;i:13;i:1131;i:14;i:1132;}i:1133;a:22:{i:0;i:1134;i:1;i:1135;i:2;i:1136;i:3;i:1137;i:4;i:1138;i:5;i:1139;i:6;i:1140;i:7;i:1141;i:8;i:1142;i:9;i:1143;i:10;i:1144;i:11;i:1145;i:12;i:1146;i:13;i:1147;i:14;i:1148;i:15;i:1149;i:16;i:1150;i:17;i:1151;i:18;i:1152;i:19;i:1153;i:20;i:1154;i:21;i:1155;}}";*/
		//die("<h3>Output</h3><pre>" . print_r(unserialize($str), 1) . "</pre>");

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

	function emails() {
		$q = "select * from wp_oses_emails order by email_created desc";
		$r = $this->db->query($q);
		$rr = $r->result();
		$r->free_result();
		$data = array("emails" => $rr);
		die("<h3>Output</h3><pre>" . print_r($data, 1) . "</pre>");
		$this->load->view('emails-viewer', $data);
	}

	function show_email($id) {
		$q = "select * from wp_oses_emails where email_id=$id";
		$r = $this->db->query($q);
		$rr = $r->row();
		$r->free_result();
		die($rr->email_message);
	}

	function getMac() {
		$csv = $_SERVER['DOCUMENT_ROOT'] . "/dta/inventory-mac.csv";
		$handle = fopen($csv, "r");
		$octr = 0;
		$ct = 0;
		$prods = array();
		while (($row = fgetcsv($handle, 10000, ",")) != FALSE) //get row vales
		{
			$first = false;

			$parts = preg_split('/  +/', $row[0]);
			//echo ("<h3>Output</h3><pre>" . print_r($parts, 1) . "</pre>");
			if ($ct == 0) {
				$prod = array();
				$first = true;
			}
			$id = $sku = $title = $price = '';
			if ($first) {
				$prod['title'] = ucwords(strtolower($parts[2]));

				if ($prod['title'] == '0' || $prod['title'] == '1') {
					$t = explode(" ", $parts[1]);
					unset($t[0]);
					$t = implode(" ", $t);
					$t = ucwords(strtolower($t));
					$prod['title'] = $t;
				}

				if ($prod['title'] == '0' || $prod['title'] == '1') {
					die("<h3>Output</h3><pre>" . print_r($parts, 1) . "</pre>");

				}
			} else {
				$die = 0;
				$subarr = array();
				foreach ($parts as $p) {
					if ($p == "019538 MVBD20071000 689076764506") {
						$die = 1;
					}
					if (strpos($p, " ") !== false) {
						$p = explode(" ", $p);
						foreach ($p as $pp) {
							$subarr[] = $pp;
						}
						//die("<h3>Output</h3><pre>" . print_r($p, 1) . "</pre>");
					} else {
						$subarr[] = $p;
					}

					//$subarr = array_merge($subarr, $p);
				}

				//if (count($subarr) != 12) {
				//	echo ("<h3>Output</h3><pre>" . print_r($subarr, 1) . "</pre>");
				//}

				if ($subarr[10] == "disc") {
					echo "<P>SKIPPING";
					$ct = 0;
					continue;
				}

				$prod['sku'] = $subarr[1];
				$prod['upc'] = $subarr[2];
				$prod['price'] = str_replace("$", "", $subarr[4]);
				$prod['supplier'] = "mac";

			}

			if ($ct == 1) {
				echo "\n" . $this->db->insert_string("jt_mac_data", $prod) . ";";
				//$prods[] = $prod;
			}
			$ct = $ct == 0 ? 1 : 0;
			$octr++;

			//print_r($row); //rows in array

			//here you can manipulate the values by accessing the array

		}

		//die("<h3>Output</h3><pre>" . print_r("TOTAL: $octr", 1) . "</pre>");

	}

	function getRelatedSLSCat($main_cat, $cat) {
		$newcat = $cat;

		return $newcat;
	}

	function getMacCats() {
		$r = $this->db->query('select * from jt_mac_data where data="DONE"')->result();

		$cats = array();
		foreach ($r as $row) {
			if (!isset($cats[$row->main_category])) {
				$cats[$row->main_category] = array();
			}

			if (!in_array($row->category, $cats[$row->main_category])) {
				$cats[$row->main_category][] = $row->category;
			}

		}

		foreach ($cats as $maincat => $subs) {
			foreach ($subs as $sub) {
				$i = array("o_cat" => $maincat, "o_subcat" => $sub);

				//$this->db->insert("jt_mac_cats", $i);
			}

		}

		/**/

		/*foreach ($r as $row) {
				if (!isset($cats[$row->main_category])) {
					$cats[$row->main_category] = array("related" => $this->getRelatedCat($row->main_category), "sub" => array());
				}

				if (!in_array($row->category, $cats[$row->main_category]["sub"])) {
					$cats[$row->main_category]['sub'][$row->category] = array("cat" => $row->category, "related" => $this->getRelatedCat($row->main_category, $row->category));
				}

			}
		*/
		return $cats;
		die("<h3>Output</h3><pre>" . print_r($cats, 1) . "</pre>");
	}

	function doMac() {

	}

	function assign() {
		$u = array("category" => $this->get['id']);
		$done = $this->db->update("jt_mac_cats", $u, array("o_subcat" => urldecode($this->get['cat'])));
		//die("<h3>Output</h3><pre>" . print_r($done, 1) . "</pre>");
		echo json_encode(array("ok" => $done));
	}
	function mackey() {
		$r = $this->db->query('select * from jt_mac_cats where category="40" order by o_cat asc')->result();

		$cats = array();
		$us = array();
		foreach ($r as $row) {
			if (in_array($row->o_cat, $us)) {
				continue;
			}

			$us[] = $row->o_cat;
		}

		foreach ($us as $item) {
			$r = $this->db->query('select * from jt_mac_cats where o_cat="' . $item . '" and  category="40" order by o_subcat asc')->result();

			foreach ($r as $row) {
				$cats[$item][] = $row->o_subcat;
				/*if (in_array($cats['p'.$row->o_subcat], $cats)) {
					continue;
				*/
			}

//			$us[] = $row->o_cat;
		}

		$data['keys'] = $cats;

		$data['cats'] = $this->getSCats();

		//die("<h3>Output</h3><pre>" . print_r($data['cats'], 1) . "</pre>");

		$this->load->view('assign-cats', $data);

	}

	function getSCats() {

		$q = "select * from wp_terms ";
		$t = $this->db->query($q)->result();
		$names = array();
		foreach ($t as $tt) {
			$names['p' . $tt->term_id] = $tt;

		}

		$q = "select * from wp_wc_category_lookup ";
		$r = $this->db->query($q)->result();
		$cats = array();
		foreach ($r as $row) {
			if (!isset($cats['p' . $row->category_tree_id])) {
				$subs = array(
					$names['p' . $row->category_id],
				);
				if ($row->category_id == $row->category_tree_id) {
					$subs = array();
				}

				$cats['p' . $row->category_tree_id] = array(
					"cat" => $names['p' . $row->category_tree_id],
					"subs" => $subs,
				);

			} else {

				$cats['p' . $row->category_tree_id]['subs'][] = $names['p' . $row->category_id];
			}
		}

		//die("<h3>Output</h3><pre>" . print_r($cats, 1) . "</pre>");
		return $cats;
	}

	function getRelatedCat($parent, $cat = "") {

		return "";

	}

	function updateimg() {

		$item = array(
			"product_post_id" => $this->input->post('product_post_id'),
			"image_post_id" => $this->input->post('image_post_id'),
			"_wp_attachment_metadata_id" => $this->input->post('_wp_attachment_metadata_id'),
		);

		$img_title = null;

		$pp = $this->db->query('select * from wp_posts where ID=' . $item['product_post_id'])->row();
		if ($pp) {
			$img_title = $pp->post_title;
		}
		$img = $this->input->post('newimg');
		$img = explode("?", $img);
		$img = $img[0];

		$iname = explode("/", $img);
		$iname = $iname[count($iname) - 1];

		if (!$img_title) {
			$img_title = $iname;
		}

		$ipostname = explode(".", $iname);
		$ext = strtolower($ipostname[count($ipostname) - 1]);
		$ipostname = $ipostname[0];

		$iloc = "2020/06/" . $iname;
		$dest = $_SERVER['DOCUMENT_ROOT'] . "/wp-content/uploads/" . $iloc;
		$this->getImage($img, $dest);

		if (!file_exists($dest)) {
			die(json_encode(array("msg" => "something went wrong... the image did not upload")));

			//$ct++;
			die("<h3>Output</h3><pre>" . print_r($content, 1) . "</pre>");
		}
		$put[] = "downloaded: $iloc";

		$gurl = "https://thepaint-chip.com/wp-content/uploads/" . $iloc;
		$mime = "";
		if ($ext == "jpg" || $ext == "jpeg") {
			$mime = "image/jpeg";
		} else if ($ext == "png") {
			$mime = "image/png";

		} else if ($ext == "gif") {
			$mime = "image/gif";

		}

		@$sz = getimagesize($dest);

		if (!$sz) {
			die(json_encode(array("msg" => "something went wrong... we can't get the image size")));

		}

		$img_meta = array(

			"width" => $sz[0],
			"height" => $sz[1],
			"file" => $iloc,
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
				"title" => $img_title,
				"orientation" => 0,
				"keywords" => Array
				(
				),

			),
		);
		$img_meta = serialize($img_meta);

		$up = array("meta_value" => $img_meta);
		$uuup = $this->db->update("wp_postmeta", $up, array("meta_id" => $item['_wp_attachment_metadata_id']));
		if (!$uuup) {
			die("<h3>Output</h3><pre>" . print_r($this->db->error(), 1) . "</pre>");
		}

		$up = array("meta_value" => $iloc);
		$uuup = $this->db->update("wp_postmeta", $up, array("meta_key" => "_wp_attached_file", "post_id" => $item['image_post_id']));
		if (!$uuup) {
			die("<h3>Output</h3><pre>" . print_r($this->db->error(), 1) . "</pre>");
		}

		$up = array("post_title" => $img_title, "post_name" => $img_title, "guid" => $gurl, "post_mime_type" => $mime);
		$uuup = $this->db->update("wp_posts", $up, array("ID" => $item['image_post_id']));

		if (!$uuup) {
			die("<h3>Output</h3><pre>" . print_r($this->db->error(), 1) . "</pre>");
		}

		echo json_encode(array("msg" => "New Photo Updated!"));

	}

	function textsearch() {
		$str = strtolower($this->input->post('str'));
		$q = "SELECT * FROM wp_posts where lower(post_title) like '{$str}%'";
#ct=1;
		$r = $this->db->query($q)->result();
		$out = array();
		$ct = 1;
		foreach ($r as $row) {

			$q = "SELECT * FROM `wp_postmeta`  where meta_key='_thumbnail_id' and post_id=" . $row->ID;
			@$t = $this->db->query($q)->row();
			@$ipost_id = $t->meta_value;
			if (!$ipost_id) {
				continue;
			}

			$r = $this->db->query("SELECT * FROM `wp_postmeta`  where meta_key='_wpm_gtin_code' and post_id=" . $row->ID);
			$pp = $r->row();

			$row->upc = $pp->meta_value;

			$q = "SELECT * FROM `wp_postmeta`  where meta_key='_wp_attached_file' and post_id=" . $ipost_id;
			$t = $this->db->query($q)->row();

			$row->img = $t->meta_value;

			$q = "SELECT * FROM `wp_postmeta`  where meta_key='_wp_attachment_metadata' and post_id=" . $ipost_id;
			$t = $this->db->query($q)->row();

			$row->_wp_attachment_metadata_id = $t->meta_id;

			$row->product_post_id = $row->ID;
			$row->image_post_id = $ipost_id;

			$out[] = $row;
			$ct++;
		}

		echo json_encode($out);
	}

	function fixd($go = 0) {
		$q = "select * from wp_posts where post_title like '%Van Gogh%'";
		$r = $this->db->query($q)->result();
		foreach ($r as $row) {
			echo "<P>" . $row->post_title;

			$q = "select * from wp_term_relationships where object_id={$row->ID} and term_taxonomy_id=1334";
			$rr = $this->db->query($q)->result();
			if (count($rr) > 0) {
				continue;
			}
			$q = "INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES ('{$row->ID}', '1334', '0');";
			if ($go) {
				$done = $this->db->query($q);
				if (!$done) {
					die("<h3>Output</h3><pre>" . print_r($this->db->error(), 1) . "</pre>");
				}
			} else {
				echo "<P>$q";
			}

		}

	}
	function findimage($upc) {

		$url = "https://api.barcodespider.com/v1/lookup?upc=" . $upc;
		$endpoint = "https://api.barcodespider.com/v1/lookup";
		$put[] = $url;

		$ch = curl_init();

		$headers = array(
			'token' => "f9ef1f0279e7b37de96b",
			'Host' => "api.barcodespider.com",
			'Accept-Encoding' => "gzip, deflate",
			'Connection' => "keep-alive",
			'cache-control' => "no-cache",
		);

		curl_setopt_array($ch, array(
			CURLOPT_URL => $endpoint . "?token=f9ef1f0279e7b37de96b&upc=" . $upc,
			CURLOPT_SSL_VERIFYHOST => 0, // do not return headers
			CURLOPT_SSL_VERIFYPEER => 0, // do not return headers
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_POSTFIELDS => "",
			CURLOPT_HTTPHEADER => $headers,
		));

		$content = curl_exec($ch);
		curl_close($ch);

		$json = json_decode($content);
		if ($json->item_response->code != 200) {

			$put[] = "Did not find page on api";
			$puts[] = $put;
			die("<h3>BAD response</h3><pre>" . print_r($json, 1) . "</pre>");
		}

		//die("<h3>Output</h3><pre>" . print_r($json, 1) . "</pre>");

		$imgs = array();
		$img = null;
		if ($json->item_attributes->image) {
			$imgs[] = $json->item_attributes->image;
		}

		if (isset($json->Stores)) {

			foreach ($json->Stores as $store) {
				if ($store->image) {
					if (strpos($store->store_name, "Amazon") !== false) {
						$img = $store->image;
					} else {
						$imgs[] = $store->image;
					}
				}
			}
		}

		if (!$img && count($imgs) > 0) {
			$img = $imgs[count($imgs) - 1];
		}

		if (!$img) {
			$put[] = "NO IMAGE at UPC";
			$puts[] = $put;

			die("<h3>NO IMAGE</h3><pre>" . print_r($content, 1) . "</pre>");
			$cont++;
		}

		die(json_encode(array('img' => $img)));

	}

	function getscrapeMacImg($last_id = 0) {
		$put = array();
		$puts = array();
		$q = "select * from jt_noimg where id>$last_id and imagetoget!='' and got=0 limit 1";
		$r = $this->db->query($q);
		if ($r->num_rows() == 0) {
			die("<h3>Output</h3><pre>" . print_r("DONE", 1) . "</pre>");
		}
		$row = $r->row();
		$r->free_result();
		$sku = $row->sku;
		$id = $row->id;

		$data = json_decode($row->data);
		$item = json_decode(json_encode($data->item), 1);

		$img_title = null;

		$pp = $this->db->query('select * from wp_posts where ID=' . $item['product_post_id'])->row();
		if ($pp) {
			$img_title = $pp->post_title;
		}
		$img = $row->imagetoget;
		$img = explode("?", $img);
		$img = $img[0];

		$iname = explode("/", $img);
		$iname = $iname[count($iname) - 1];

		if (!$img_title) {
			$img_title = $iname;
		}

		$ipostname = explode(".", $iname);
		$ext = strtolower($ipostname[count($ipostname) - 1]);
		$ipostname = $ipostname[0];

		$iloc = "2020/06/" . $iname;
		$dest = $_SERVER['DOCUMENT_ROOT'] . "/wp-content/uploads/" . $iloc;
		$this->getImage($img, $dest);

		if (!file_exists($dest)) {
			$put[] = "image did not download";
			$puts[] = $put;
			$write = array("item" => $item, "response" => $content, "url" => $endpoint . "?token=f9ef1f0279e7b37de96b&upc=" . $item['upc']);
			$aaa = array("data" => json_encode($write), "upc" => $item['upc']);
			//$this->db->insert("jt_noimg", $aaa);

			//$ct++;
			die("<h3>Output</h3><pre>" . print_r($content, 1) . "</pre>");
		}
		$put[] = "downloaded: $iloc";

		$gurl = "https://thepaint-chip.com/wp-content/uploads/" . $iloc;
		$mime = "";
		if ($ext == "jpg" || $ext == "jpeg") {
			$mime = "image/jpeg";
		} else if ($ext == "png") {
			$mime = "image/png";

		} else if ($ext == "gif") {
			$mime = "image/gif";

		}

		@$sz = getimagesize($dest);

		if (!$sz) {
			echo json_encode(array("this_id" => $id, "put" => $put, 'error' => 'no image'));
			die();
			die("<h3>Output</h3><pre>" . print_r($dest, 1) . "</pre>");
		}

		$img_meta = array(

			"width" => $sz[0],
			"height" => $sz[1],
			"file" => $iloc,
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
				"title" => $img_title,
				"orientation" => 0,
				"keywords" => Array
				(
				),

			),
		);
		$img_meta = serialize($img_meta);

		$up = array("meta_value" => $img_meta);
		$uuup = $this->db->update("wp_postmeta", $up, array("meta_id" => $item['_wp_attachment_metadata_id']));
		if (!$uuup) {
			die("<h3>Output</h3><pre>" . print_r($this->db->error(), 1) . "</pre>");
		}

		$up = array("meta_value" => $iloc);
		$uuup = $this->db->update("wp_postmeta", $up, array("meta_key" => "_wp_attached_file", "post_id" => $item['image_post_id']));
		if (!$uuup) {
			die("<h3>Output</h3><pre>" . print_r($this->db->error(), 1) . "</pre>");
		}

		$up = array("post_title" => $img_title, "post_name" => $img_title, "guid" => $gurl, "post_mime_type" => $mime);
		$uuup = $this->db->update("wp_posts", $up, array("ID" => $item['image_post_id']));

		if (!$uuup) {
			die("<h3>Output</h3><pre>" . print_r($this->db->error(), 1) . "</pre>");
		}

		$put[] = "did everything image: $iloc";
		$puts[] = $put;
		$this->db->update("jt_noimg", array("got" => 1), array("id" => $id));

		echo json_encode(array("this_id" => $id, "put" => $put));

	}

	function scrapeMacImg($last_id = 0) {

		$ct = 0;

		$q = "select * from jt_noimg where id>$last_id and supplier='MAC' and imagetoget='' limit 1";
		$r = $this->db->query($q);
		if ($r->num_rows() == 0) {
			die("<h3>Output</h3><pre>" . print_r("DONE", 1) . "</pre>");
		}
		$row = $r->row();
		$r->free_result();
		$sku = $row->sku;
		$id = $row->id;
		$url = "https://www.macphersonart.com/cgi-bin/maclive/wam_tmpl/catalog_browse.p?site=MAC&layout=Responsive&page=catalog_browse&searchText=" . $sku;
		//echo "<P> starting $ct";
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

		$res['content'] = $content;
		$res['content'] = strip_tags($content, "<body>");
		$res['url'] = $header['url'];

		$newurl = str_replace('document.location.replace("', "", $res['content']);
		$newurl = str_replace('");', "", $newurl);

		if (!$newurl || strpos($newurl, "Catalog Browse | MacPherson's") != FALSE) {
			$item['data'] = "NO URL";
			//$this->db->update("jt_mac_data", $item, array("id" => $row->id));
			die("<h3>Output</h3><pre>" . print_r("no url", 1) . "</pre>");

		}
		$html = file_get_html($newurl);
		//return $res;

		$item = array();

		//print_r(get_web_page("http://www.example.com/redirectfrom"));

		/*foreach ($d as $dd) {
					echo ("<h3>Output</h3><pre>" . print_r($dd->innerText, 1) . "</pre>");
				}
			*/
		$d = $html->find('#row' . $sku . ' td');
		if (count($d) == 0) {
			$ct++;

			//echo "<p>continuoing... <a href='$url' target='_blank'>$url</a>";

			die("<h3>Output</h3><pre>" . print_r("no data", 1) . "</pre>");
			//die("<h3>no data</h3><pre>" . print_r($newurl, 1) . print_r($row, 1) . "</pre>");
			$item['data'] = "NO DATA";
			$this->db->update("jt_mac_data", $item, array("id" => $row->id));

		}

		$de = $html->find('.prodDescription');
		$desc = "";
		foreach ($de as $des) {
			$desc .= $des->innerText;
		}

		$item['description'] = $desc;
		$imagetoget = "";

		$a = $html->find('img#mainProdImg1');
		if (count($a) > 0) {
			$imagetoget = "https://www.macphersonart.com" . $a->src;
			$this->db->update("jt_noimg", array("imagetoget" => $imagetoget), array("id" => $id));
			echo json_encode(array("this_id" => $id));
			return;
		} else {
			die("<h3>Output</h3><pre>" . print_r("nadad", 1) . "</pre>");
			$a = $d[0]->find('img');
			if (count($a) > 0) {
				$a = "https://www.macphersonart.com" . $a->src;
				if ($a) {
					$iname = explode("/", $a);
					$iname = $iname[count($iname) - 1];
					$imagetoget = "https://www.macphersonart.com" . $a;
				}
			}
		}

		if (!$imagetoget) {

			foreach ($d as $dd) {
				echo ("<h3>Output</h3><pre>" . print_r($dd->innerText, 1) . "</pre>");
			}

			die("<h3>NO IMG</h3><pre>" . print_r($d[0]->innerText, 1) . "</pre>");
		}
		die("<h3>Output</h3><pre>" . print_r($imagetoget, 1) . "</pre>");
		if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/helper/uploads/{$iname}")) {
			$up = $this->getImage($imagetoget, $iname);
			if (!$up) {
				die("<h3>Output</h3><pre>" . print_r("DID not get image", 1) . "</pre>");
			} else {
				$item['image'] = $iname;
			}
		} else {
			$item['image'] = $iname;

		}

		$tdata = $html->find('h2.prodCrumbDesc');
		$tdata = $tdata[0];
		$item['category'] = $tdata->innerText;

		$tdata = $html->find('.millDescription a');
		$tdata = $tdata[0];
		$item['brand'] = $tdata->innerText;

		$tdata = $html->find('a.prodCrumbLink');
		$tdata = $tdata[count($tdata) - 1];
		$item['main_category'] = $tdata->innerText;

		$tdata = $d[1]->find('div');
		//die("<h3>Output</h3><pre>" . print_r($d[1]->innerText, 1) . "</pre>");
		$tdata = $tdata[1];
		$item['title'] = str_replace("<br>", " ", $tdata->innerText);

		$tdata = $d[6]->find('div.qoRegPrice');
		$tdata = $tdata[0];
		$item['macprice'] = str_replace("$", "", $tdata->innerText);

		$item['data'] = "DONE";
		$this->db->update("jt_mac_data", $item, array("id" => $row->id));
		$act++;
		//echo ("<h3>Output</h3><pre>" . print_r($item, 1) . "</pre>");
		$ct++;
		//sleep(1);
		//die("<h3>Output</h3><pre>" . print_r($a, 1) . "</pre>");

	}

	function scrapeMac($sku) {
		$q = "select * from jt_mac_data where data='' limit 4";
		$r = $this->db->query($q);

		$rw = $r->result();
		if (count($rw) == 0) {
			echo json_encode(array("complete" => 1));
			die();
		}
		$ct = 0;
		$act = 0;
		foreach ($rw as $row) {
			$url = "https://www.macphersonart.com/cgi-bin/maclive/wam_tmpl/catalog_browse.p?site=MAC&layout=Responsive&page=catalog_browse&searchText=" . $row->sku;
			//echo "<P> starting $ct";
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

			$res['content'] = $content;
			$res['content'] = strip_tags($content, "<body>");
			$res['url'] = $header['url'];

			$newurl = str_replace('document.location.replace("', "", $res['content']);
			$newurl = str_replace('");', "", $newurl);

			if (!$newurl || strpos($newurl, "Catalog Browse | MacPherson's") != FALSE) {
				$item['data'] = "NO URL";
				$this->db->update("jt_mac_data", $item, array("id" => $row->id));

				continue;
			}
			$html = file_get_html($newurl);
			//return $res;

			$item = array();

			//print_r(get_web_page("http://www.example.com/redirectfrom"));

			/*foreach ($d as $dd) {
					echo ("<h3>Output</h3><pre>" . print_r($dd->innerText, 1) . "</pre>");
				}
			*/
			$d = $html->find('#row' . $row->sku . ' td');
			if (count($d) == 0) {
				$ct++;

				//echo "<p>continuoing... <a href='$url' target='_blank'>$url</a>";

				//die("<h3>no data</h3><pre>" . print_r($newurl, 1) . print_r($row, 1) . "</pre>");
				$item['data'] = "NO DATA";
				$this->db->update("jt_mac_data", $item, array("id" => $row->id));

				continue;
			}

			$de = $html->find('.prodDescription');
			$desc = "";
			foreach ($de as $des) {
				$desc .= $des->innerText;
			}

			$item['description'] = $desc;
			$imagetoget = "";

			$a = $d[0]->find('a');
			if (count($a) > 0) {
				$a = $a->href;
				if ($a) {
					$iname = explode("/", $a);
					$iname = $iname[count($iname) - 1];
					$imagetoget = "https://www.macphersonart.com" . $a;
				}
			} else {
				$a = $d[0]->find('img');
				if (count($a) > 0) {
					$a = $a->src;
					if ($a) {
						$iname = explode("/", $a);
						$iname = $iname[count($iname) - 1];
						$imagetoget = "https://www.macphersonart.com" . $a;
					}
				}
			}

			if (!$imagetoget) {

				foreach ($d as $dd) {
					echo ("<h3>Output</h3><pre>" . print_r($dd->innerText, 1) . "</pre>");
				}

				die("<h3>NO IMG</h3><pre>" . print_r($d[0]->innerText, 1) . "</pre>");
			}

			if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/helper/uploads/{$iname}")) {
				$up = $this->getImage($imagetoget, $iname);
				if (!$up) {
					die("<h3>Output</h3><pre>" . print_r("DID not get image", 1) . "</pre>");
				} else {
					$item['image'] = $iname;
				}
			} else {
				$item['image'] = $iname;

			}

			$tdata = $html->find('h2.prodCrumbDesc');
			$tdata = $tdata[0];
			$item['category'] = $tdata->innerText;

			$tdata = $html->find('.millDescription a');
			$tdata = $tdata[0];
			$item['brand'] = $tdata->innerText;

			$tdata = $html->find('a.prodCrumbLink');
			$tdata = $tdata[count($tdata) - 1];
			$item['main_category'] = $tdata->innerText;

			$tdata = $d[1]->find('div');
			//die("<h3>Output</h3><pre>" . print_r($d[1]->innerText, 1) . "</pre>");
			$tdata = $tdata[1];
			$item['title'] = str_replace("<br>", " ", $tdata->innerText);

			$tdata = $d[6]->find('div.qoRegPrice');
			$tdata = $tdata[0];
			$item['macprice'] = str_replace("$", "", $tdata->innerText);

			$item['data'] = "DONE";
			$this->db->update("jt_mac_data", $item, array("id" => $row->id));
			$act++;
			//echo ("<h3>Output</h3><pre>" . print_r($item, 1) . "</pre>");
			$ct++;
			//sleep(1);
			//die("<h3>Output</h3><pre>" . print_r($a, 1) . "</pre>");

		}

		echo json_encode(array("actual" => $act));

	}

	function macBrands($go = 0) {
		$newbrands = array();
		$newbrandsy = array();
		$a = $this->getBrands();
		foreach ($a as $aa) {
			$newbrands[$aa[1]] = $aa[0];
			$newbrandsy[] = $aa[1];

		}

		//die("<h3>Output</h3><pre>" . print_r($ex, 1) . "</pre>");
		$q = "select * from jt_mac_data where data='DONE'";
		$r = $this->db->query($q)->result();

		$brands = array();
		foreach ($r as $row) {
			if (!in_array($row->brand, $brands) && !in_array($row->brand, $newbrandsy)) {
				$brands[] = $row->brand;
			}

		}
		$ct = 1;
		foreach ($brands as $b) {

			$nt = strtolower($b);
			$nt = str_replace("& ", "", $nt);
			$nt = str_replace("&", "", $nt);
			$slug = str_replace(" ", "-", $nt);

			//	$b = htmlentities($b);

			$in = array("name" => $b, "slug" => $slug);
			$str = $this->db->insert_string("wp_terms", $in);

			echo "<P>" . $str;
			if ($go) {
				$this->db->query($str);
			}
			$id = $go ? $this->db->insert_id() : $ct;
			$newbrands[$b] = $id;

			// create the Taxonomy connex

			$in = array("term_id" => $id, "taxonomy" => "pwb-brand", "description" => "<h2>{$b}</h2>");
			$str = $this->db->insert_string("wp_term_taxonomy", $in);

			echo "<P>" . $str;
			if ($go) {
				$this->db->query($str);
			}
			///$id = $go ? $this->db->insert_id() : $ct;

			$ct++;

		}

		echo "<hr>";

		foreach ($r as $row) {
			$q = "select * from wp_posts where lower(post_title) = '" . addslashes(strtolower(trim(str_replace("\n", "", $row->title)))) . "'";
			$rr = $this->db->query($q)->result();

			if (count($rr) == 0) {
				//echo ("<h3>Output</h3>" . count($rr) . "<pre>" . print_r($q, 1) . "</pre>");
			} else {

				foreach ($rr as $rrow) {
					$ex = $this->db->query('select * from wp_term_relationships where object_id=' . $rrow->ID . " and term_taxonomy_id =" . $newbrands[$row->brand]);
					if ($ex->num_rows() > 0) {
						echo "<P>----------- ALREADY ASSIGNED IN DB - ({$row->post_title})";
						continue;

					}
					$ex->free_result();
					if (in_array($rrow->ID, $used)) {
						echo "<P>------------------------ ERROR - already assigned this post: {$row->post_title} for another brand, not {$newbrands[$row->brand]}";
					}
					$used[] = $rrow->ID;
					echo "<P>-- <strong>{$rrow->post_title}</strong> getting branded as <strong><i>{$row->brand}</i></strong>";
					if ($go) {
						$this->db->query("INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES ('{$rrow->ID}', '{$newbrands[$row->brand]}', '0');");
					}
				}

				//echo ("<h3>Output</h3><pre>" . print_r($rr, 1) . "</pre>");
			}

		}
		die("<h3>Brands</h3><pre>" . print_r($brands, 1) . "</pre>");
	}

	function fixTags($go = 0) {

		$tags = array(
			array(1327, "Winsor", "Cotman"),
			array(1328, "Winsor", "Oil"),
			/*array(1319, "Georgian", "Water Mixable"),
				array(1320, "Gamblin", "Artist Oil Colors"),
				array(1321, "Golden", "Artist"),
				array(1322, "Golden", "Fluid"),
				array(1323, "Golden", "Heavy Body"),
				array(1324, "Golden", "High Flow"),
				array(1325, "Liquitex", "Basics"),
				array(1326, "Liquitex", "Heavy Body"),
				array(1329, "Winsor", "Galeria Acrylic"),
				array(1330, "Daniel Smith", "Watercolors"),
				array(1331, "Louvre", "Acrylic"),
			*/
		);

		foreach ($tags as $ar) {
			$str = $ar[1];
			if (isset($ar[2])) {
				$str2 = $ar[2];
			} else {
				$str2 = "";
			}

			$pt = "post_title like '%$str%'";
			if (isset($ar[2])) {
				$pt .= "and post_title like '%$str2%' ";
			}

			$q = "select * from wp_posts where post_type='product' and ($pt)";
			$r = $this->db->query($q)->result();
			foreach ($r as $row) {
				/*$ex = $this->db->query('select * from wp_term_relationships where object_id=' . $row->ID . " and term_taxonomy_id in ($terma)");
					if ($ex->num_rows() > 0) {
						echo "<P>-- ALREADY ASSIGNED IN DB - ({$row->post_title})";
						continue;

				*/
				/**/
				if (in_array($row->ID, $used)) {
					//echo "<P>-- ERROR - already assigned this post: {$row->post_title} for another brand, not {$ar[1]}";
					continue;
				}
				$used[] = $row->ID;
				//echo "<P>-- <strong>{$row->post_title}</strong> getting branded as <strong><i>{$ar[1]} - {$str2}</i></strong>";
				echo "<P>INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES ('{$row->ID}', '{$ar[0]}', '0');";
			}

		}

	}

	function findImages() {

		$arr = array();
		$r = $this->db->query("SELECT * FROM `wp_postmeta`  where meta_value like '%width\";N%' ");
		$rr = $r->result();
		$r->free_result();

		foreach ($rr as $row) {

			// this post id is the image post
			// we'll test it to make sure there's an WP_POST image associated with it
			$q = $this->db->query("select * from wp_posts where ID=" . $row->post_id);
			$imgp = $q->result();
			$q->free_result();
			if (count($imgp) == 0) {
				echo "<p>-- continueing, no iamge post";
				continue;
			}

			// each of these is a broken image
			// find the post id so we can get the upc
			$r = $this->db->query("SELECT * FROM `wp_postmeta`  where meta_key='_thumbnail_id' and meta_value=" . $row->post_id);
			$pm = $r->result();
			$r->free_result();

			if (count($pm) == 0) {
				echo "<p>-- continuing, no _thumbnail_id ";
				continue;
			}

			// now we have the actual post ID, make sure there is a post
			$the_post_id = $pm[0]->post_id;

			$r = $this->db->query("SELECT * FROM `wp_postmeta`  where meta_key='_wpm_gtin_code' and post_id=" . $the_post_id);
			$pp = $r->row();

			$upc = $pp->meta_value;
			$r->free_result();
			foreach ($pm as $p) {

				$arr[] = array(
					"upc" => $upc,
					"meta_thumbnail_id" => $p->meta_id,
					"image_post_id" => $row->post_id,
					"product_post_id" => $the_post_id,
					"_wp_attachment_metadata_id" => $row->meta_id,
					"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
				);

/*

// update:::
get new image
-- update wp_postmeta _wp_attachment_metadata with values like
a:5:{s:5:"width";N;s:6:"height";N;s:4:"file";s:27:"2020/05/images-tb-56555.jpg";s:5:"sizes";a:0:{}s:10:"image_meta";a:12:{s:8:"aperture";i:0;s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";i:0;s:9:"copyright";s:0:"";s:12:"focal_length";i:0;s:3:"iso";i:0;s:13:"shutter_speed";i:0;s:5:"title";s:36:"DUAL BRUSH PEN REFLEX BLUE (ABT 493)";s:11:"orientation";i:0;s:8:"keywords";a:0:{}}}
-- update wp_postmeta _wp_attached_file with values like
2020/05/images-tb-56555.jpg

-- update wp_posts with
post_title like mc21120_t
post_name like  mc21120_t
guid like https://thepaint-chip.com/wp-content/uploads/2020/06/MC21120_t.png
post_mime_type like image/jpeg

 */

			}

			// get post UID
		}

		die("<h3>" . count($arr) . "</h3><pre>" . print_r($arr, 1) . "</pre>");

	}

	function getBrands() {
		$a = array(
			array(1167, "Gamblin"),
			array(1169, "Georgian"),
			array(1170, "Liquitex", "Basic"),
			array(1171, "Golden", "Artist Colors"),
			/*array(1172, "Golden Fluid "),
				array(1180, "Golden Heavy Body"),
			*/
			array(1174, "Winsor & Newton", "Acrylic"),
			/*array(1168, "Winsor", "Oil"),
			array(1177, "Winsor", "Water"),*/
			array(1175, "Liquitex", "Heavy Body"),
			array(1176, "Daniel Smith", "Watercolor"),
			array(1178, "LeFranc", "Gouache"),
			array(1179, "Louvre"),
		);

		return $a;
	}

	function makeTags($go = 0) {
		$tags = array(
			"Georgian Water Mixable Oils",
			"Gamblin Artist Oil Colors",
			"Golden Artist Colors",
			"Golden Fluid Acrylics",
			"Golden Heavy Body Acrylics",
			"Golden High Flow Acrylics",
			"Liquitex Basics",
			"Liquitex Processional Heavy Body Acrylic",
			"Winsor & Newton Cotman Water Colour",
			"Winsor & Newton Winton Oil Colour",
			"Winsor & Newton Galeria Acrylic",
			"Daniel Smith Extra-Fine Watercolors",
			"Louvre Acrylic",
			"LeFranc Guache",
		);

		$ct = 1;
		$ntags = array();

		foreach ($tags as $tag) {

			$nt = strtolower($tag);
			$nt = str_replace("& ", "", $nt);
			$nt = str_replace("&", "", $nt);
			$slug = str_replace(" ", "-", $nt);

			//	$b = htmlentities($b);

			$in = array("name" => $tag, "slug" => $slug);
			$str = $this->db->insert_string("wp_terms", $in);

			echo "<P>" . $str;
			if ($go) {
				$this->db->query($str);
			}
			$id = $go ? $this->db->insert_id() : $ct;
			$ntags[$tag] = $id;

			$in = array("term_id" => $id, "taxonomy" => "product_tag");
			$str = $this->db->insert_string("wp_term_taxonomy", $in);

			echo "<P>" . $str;
			if ($go) {
				$this->db->query($str);
			}

			$ct++;
		}

		die("<h3>Output</h3><pre>" . print_r($ntags, 1) . "</pre>");

	}

	/*

		Golden Artist Colors
		Golden Fluid Acrylics
		Golden Heavy Body Acrylics
		Golden High Flow Acrylics

		Liquitex Basics
		Liquitex Processional Heavy Body Acrylic

		Winsor & Newton Cotman Water Colour
		Winsor & Newton Winton Oil Colour
		Winsor & Newton Galeria Acrylic

	*/

	/*function addBrands($go = 0) {
		$brands = array(
			"Prismacolor",
		);

		foreach ($brands as $b) {

			$nt = strtolower($b);
			$slug = str_replace(" ", "-", $nt);

			$in = array("name" => $b, "slug" => $slug);
			$str = $this->db->insert_string("wp_terms", $in);

			//echo "<P>" . $str;
			if ($go) {
				$this->db->query($str);
			}
			$id = $go ? $this->db->insert_id() : $ct;

			echo "<br>array({$id}, '$b'),";
			//$newbrands[$b] = $id;

			$ct++;

		}
	}*/

	function fixBrands() {
		$a = $this->getBrands();
		$used = array();
		$terma = array();
		foreach ($a as $ar) {
			$terma[] = $ar[0];
		}

		$ct = 0;
		$terma = implode(",", $terma);
		foreach ($a as $ar) {
			$str = $ar[1];
			if (isset($ar[2])) {
				$str2 = $ar[2];
			} else {
				$str2 = "";
			}

			$pt = "post_title like '%$str%'";
			if (isset($ar[2])) {
				//$pt .= "and post_title like '%$str2%' ";
			}

			$q = "select * from wp_posts where post_type='product' and ($pt)";
			$r = $this->db->query($q)->result();
			foreach ($r as $row) {
				$ex = $this->db->query('select * from wp_term_relationships where object_id=' . $row->ID . " and term_taxonomy_id in ($terma)");
				if ($ex->num_rows() > 0) {
					//echo "<P>-- ALREADY ASSIGNED IN DB - ({$row->post_title})";
					continue;

				}
				$ex->free_result();
				if (in_array($row->ID, $used)) {
					//echo "<P>-- ERROR - already assigned this post: {$row->post_title} for another brand, not {$ar[1]}";
					continue;
				}
				$used[] = $row->ID;
				//echo "<P>-- <strong>{$row->post_title}</strong> getting branded as <strong><i>{$ar[1]} - {$str2}</i></strong>";
				echo "<P>INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES ('{$row->ID}', '{$ar[0]}', '0');";
			}

		}

		die("<h3>INSERTED</h3><pre>" . print_r(count($used), 1) . "</pre>");
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
		die("<h3>Output</h3><pre>" . print_r($ldata, 1) . "</pre>");
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
		$q = "select * from jt_supplier_data where upc='' and triedlink=0 and category!='' limit 3 ";

		$r = $this->db->query($q)->result();
		if (count($r) == 0) {
			die(json_encode(array("complete" => 1)));
		}
		foreach ($r as $row) {
			$q = "select * from linkys where data like '%" . $row->sku . "%'";
			//echo "<P>$q";
			$u = array('triedlink' => 1);
			$this->db->update('jt_supplier_data', $u, array("id" => $row->id));

			$rr = $this->db->query($q)->result();

			if (count($rr) > 0) {
				$lrow = $rr[0];
				$ldata = json_decode($lrow->data);

				//get category
				$category = $this->getMyCategoryFromLinkData($ldata);
				//$category = array("mycat" => $row->category, "mycatid" => $row->cat_id);
				$objects = $this->returnItemsFromLinkData($ldata, $category);

				foreach ($objects as $item) {

					//echo ("<h3>Output</h3><pre>" . print_r($item['upc'] . " == " . $row->upc, 1) . "</pre>");
					//continue;

					if ($item['sku'] != $row->sku) {
						continue;
					}

					/*$qq = "select * from jt_supplier_data where sku='{$item['sku']}'";
						$rrr = $this->db->query($qq)->result();
						if (count($rrr) > 0) {
							$u = array('triedlink' => 1);
							$this->db->update('jt_supplier_data', $u, array("id" => $row->id));
							die(json_encode(array("done" => 1, "exists" => 1)));

							//echo "<P>SKU Exists " . $item['sku'];
							//echo ("<h3>Output</h3><pre>" . print_r($rrr, 1) . "</pre>");
							continue;
					*/
					//echo ("<h3>Output</h3><pre>" . print_r($category, 1) . print_r($item, 1) . "</pre>");
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
					$item['approved'] = 1;
					$item['data'] = $row->tmp_data;
					$item['triedlink'] = 1;
					//echo ("<h3>Output</h3><pre>" . print_r($item, 1) . "</pre>");
					//continue;

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
		die(json_encode(array("done" => 1, "rowid" => $row->id)));

		die("<h3>Output</h3><pre>" . print_r("DONE", 1) . "</pre>");
	}

	function newupdate() {
		$q = "select * from jt_supplier_data where moved=0 and triedlink";
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
/**/
			}

			$a[$uid] = $subids;

		}

		$a = serialize($a);
		$in = array("option_value" => $a);

		//$this->db->update("wp_options", $in, array('option_name' => 'product_cat_children'));

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
			//die(json_encode(array("donwithelinks" => 1)));
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
		die(json_encode(array("done" => 1)));

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

			$cat->name = "CLAYS AND Accessories";
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
		$saveto = $img; //$_SERVER['DOCUMENT_ROOT'] . "/helper/uploads/{$img}";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
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

	function fixMacCatsWithNew($go = 0) {
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

			$q = "select * from jt_mac_data where data='DONE' and site_category='' and (" . implode(" OR ", $key) . ")";
			echo "<P>$q";
			$r = $this->db->query($q)->result();
			foreach ($r as $row) {
				if (in_array($row->id, $ids)) {
					continue;
				}

				$title = strip_tags($row->title);
				echo "<P> changing " . $title . " to $cat (from " . $row->category . ")";
				$q = "update jt_mac_data set site_category='$cat' where id={$row->id}";
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
		$q = "select * from wp_terms where term_id>14 order by name asc";
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
						"file" => "2020/06/" . $row->image,
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

	function popm() {
		$q = "select * from jt_mac_cats ";
		$r = $this->db->query($q)->result();
		foreach ($r as $row) {
			$u = array("site_category" => $row->category);
			$this->db->update('jt_mac_data', $u, array("category" => $row->o_subcat));
		}
	}

	/*function movei($go = 0) {
		$q = "select * from jt_mac_data where data='DONE' and approved=0 order by image desc, id asc limit 500";
		$rr = $this->db->query($q);
		$r = $rr->result();
		$rr->free_result();
		foreach ($r as $row) {

			echo "<P>moving " . $this->temp_img_dir . $row->image . " to " . $this->prod_img_dir . $row->image;
			echo "<P>exists? " . file_exists($this->prod_img_dir . $row->image);
			if ($go) {
				copy($this->temp_img_dir . $row->image, $this->prod_img_dir . $row->image);
			}

		}

	}*/

	function moveMacProducts($go = 0) {

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);

		/*$str = 'a:5:{s:5:"width";i:225;s:6:"height";i:225;s:4:"file";s:19:"2020/03/images.jpeg";s:5:"sizes";a:0:{}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}';
		die("<h3>Output</h3><pre>" . print_r(unserialize($str), 1) . "</pre>");*/

		// $go = 0;
		$q = "select * from jt_mac_data where data='DONE' and approved=0 order by image desc, id asc limit 500, 100000";

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
					"file" => "2020/06/" . $row->image,
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

			$up = array("object_id" => $post_id, "term_taxonomy_id" => $row->site_category);
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
			"meta_key" => "_wpm_gtin_code",
			"meta_value" => $row->upc,
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

	function getMacCats2() {

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

	function loopimages($startindex = 0) {

		$items = $this->getIarr();
		$ct = 0;
		$cont = 0;
		$num = 1;

		$puts = array();

		foreach ($items as $item) {
			$put = array();

			if ($ct < $startindex) {
				$ct++;
				continue;
			} else if ($ct == $startindex + $num || $ct == count($items)) {
				if ($ct == count($items)) {
					echo json_encode(array("startat" => "done", "puts" => $puts));
				} else {
					echo json_encode(array("startat" => $ct, "puts" => $puts));

				}
				die();
			}
			$ct++;
			/*if ($ct > 100) {
				die();
			}*/

			if (!$item['upc']) {
				$put[] = "NO UPC";
				$puts[] = $put;

				$cont++;
				continue;
			}

			$url = "https://www.upcitemdb.com/upc/" . $item['upc'];
			$url = "https://api.barcodespider.com/v1/lookup?upc=" . $item['upc'];
			$endpoint = "https://api.barcodespider.com/v1/lookup";
			$put[] = $url;
			//, false, stream_context_create($arrContextOptions));

			$ch = curl_init();

			$headers = array(
				'token' => "f9ef1f0279e7b37de96b",
				'Host' => "api.barcodespider.com",
				'Accept-Encoding' => "gzip, deflate",
				'Connection' => "keep-alive",
				'cache-control' => "no-cache",
			);

			curl_setopt_array($ch, array(
				CURLOPT_URL => $endpoint . "?token=f9ef1f0279e7b37de96b&upc=" . $item['upc'],
				CURLOPT_SSL_VERIFYHOST => 0, // do not return headers
				CURLOPT_SSL_VERIFYPEER => 0, // do not return headers
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_POSTFIELDS => "",
				CURLOPT_HTTPHEADER => $headers,
			));

			$content = curl_exec($ch);
			curl_close($ch);

			$json = json_decode($content);
			if ($json->item_response->code != 200) {
				$write = array("item" => $item, "response" => $content, "url" => $endpoint . "?token=f9ef1f0279e7b37de96b&upc=" . $item['upc']);
				$aaa = array("data" => json_encode($write), "upc" => $item['upc']);
				$this->db->insert("jt_noimg", $aaa);
				$put[] = "Did not find page on api";
				$puts[] = $put;
				continue;
				die("<h3>BAD response</h3><pre>" . print_r($json, 1) . "</pre>");
			}

			//die("<h3>Output</h3><pre>" . print_r($json, 1) . "</pre>");

			$imgs = array();
			$img = null;
			if ($json->item_attributes->image) {
				$imgs[] = $json->item_attributes->image;
			}

			if (isset($json->Stores)) {

				foreach ($json->Stores as $store) {
					if ($store->image) {
						if (strpos($store->store_name, "Amazon") !== false) {
							$img = $store->image;
						} else {
							$imgs[] = $store->image;
						}
					}
				}
			}

			if (!$img && count($imgs) > 0) {
				$img = $imgs[count($imgs) - 1];
			}

			if (!$img) {
				$put[] = "NO IMAGE at UPC";
				$puts[] = $put;

				$write = array("item" => $item, "response" => $content, "url" => $endpoint . "?token=f9ef1f0279e7b37de96b&upc=" . $item['upc']);
				$aaa = array("data" => json_encode($write), "upc" => $item['upc']);
				$this->db->insert("jt_noimg", $aaa);

				//die("<h3>NO IMAGE</h3><pre>" . print_r($content, 1) . "</pre>");
				//$ct++;
				$cont++;
				continue;
			}
			$put[] = "image: " . $img;

			$img_title = $json->item_attributes->title;
			/*
				$html = str_get_html($content);

				$d = $html->find('img.product');
				if (count($d) == 0) {
					die("<h3>Output</h3><pre>" . print_r($content, 1) . "</pre>");
					$put[] = "did not find image";
					if (strpos(strtolower($content), "slow down") !== false) {
						$put[] = "slowdown";
						echo json_encode(array("startat" => $ct));
						die();
					}
					//die("<h3>NO IMAGE</h3><pre>" . print_r($content, 1) . "</pre>");
					//$ct++;
					$cont++;
					continue;

				}
				$img = $d->src;

				$img = explode("?", $img);
				$img = $img[0];

			*/

			//foreach ($imgs as $img) {

			$iname = explode("/", $img);
			$iname = $iname[count($iname) - 1];

			if (!$img_title) {
				$img_title = $iname;
			}

			$ipostname = explode(".", $iname);
			$ext = strtolower($ipostname[count($ipostname) - 1]);
			$ipostname = $ipostname[0];

			$iloc = "2020/06/" . $iname;
			$dest = $_SERVER['DOCUMENT_ROOT'] . "/wp-content/uploads/" . $iloc;
			$this->getImage($img, $dest);

			if (!file_exists($dest)) {
				$put[] = "image did not download";
				$puts[] = $put;
				$write = array("item" => $item, "response" => $content, "url" => $endpoint . "?token=f9ef1f0279e7b37de96b&upc=" . $item['upc']);
				$aaa = array("data" => json_encode($write), "upc" => $item['upc']);
				$this->db->insert("jt_noimg", $aaa);

				//$ct++;
				continue;
				die("<h3>Output</h3><pre>" . print_r($content, 1) . "</pre>");
			}
			$put[] = "downloaded: $iloc";

			$gurl = "https://thepaint-chip.com/wp-content/uploads/" . $iloc;
			$mime = "";
			if ($ext == "jpg" || $ext == "jpeg") {
				$mime = "image/jpeg";
			} else if ($ext == "png") {
				$mime = "image/png";

			} else if ($ext == "gif") {
				$mime = "image/gif";

			}

			$sz = getimagesize($dest);

			$img_meta = array(

				"width" => $sz[0],
				"height" => $sz[1],
				"file" => $iloc,
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
					"title" => $img_title,
					"orientation" => 0,
					"keywords" => Array
					(
					),

				),
			);
			$img_meta = serialize($img_meta);

			$up = array("meta_value" => $img_meta);
			$uuup = $this->db->update("wp_postmeta", $up, array("meta_id" => $item['_wp_attachment_metadata_id']));
			if (!$uuup) {
				die("<h3>Output</h3><pre>" . print_r($this->db->error(), 1) . "</pre>");
			}

			$up = array("meta_value" => $iloc);
			$uuup = $this->db->update("wp_postmeta", $up, array("meta_key" => "_wp_attached_file", "post_id" => $item['image_post_id']));
			if (!$uuup) {
				die("<h3>Output</h3><pre>" . print_r($this->db->error(), 1) . "</pre>");
			}

			$up = array("post_title" => $img_title, "post_name" => $img_title, "guid" => $gurl, "post_mime_type" => $mime);
			$uuup = $this->db->update("wp_posts", $up, array("ID" => $item['image_post_id']));

			if (!$uuup) {
				die("<h3>Output</h3><pre>" . print_r($this->db->error(), 1) . "</pre>");
			}

			$put[] = "did everything image: $iloc";
			$puts[] = $put;
			//}

/*

// update:::
get new image
-- update wp_postmeta _wp_attachment_metadata with values like
a:5:{s:5:"width";N;s:6:"height";N;s:4:"file";s:27:"2020/05/images-tb-56555.jpg";s:5:"sizes";a:0:{}s:10:"image_meta";a:12:{s:8:"aperture";i:0;s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";i:0;s:9:"copyright";s:0:"";s:12:"focal_length";i:0;s:3:"iso";i:0;s:13:"shutter_speed";i:0;s:5:"title";s:36:"DUAL BRUSH PEN REFLEX BLUE (ABT 493)";s:11:"orientation";i:0;s:8:"keywords";a:0:{}}}
-- update wp_postmeta _wp_attached_file with values like
2020/05/images-tb-56555.jpg

-- update wp_posts with
post_title like mc21120_t
post_name like  mc21120_t
guid like https://thepaint-chip.com/wp-content/uploads/2020/06/MC21120_t.png
post_mime_type like image/jpeg

echo <<<EOT

array(
"upc" => "{$item['upc']}",
"meta_thumbnail_id" => "{$item['meta_thumbnail_id']}",
"image_post_id" => "{$item['image_post_id']}",
"product_post_id" => "{$item['product_post_id']}",
"_wp_attachment_metadata_id" => "{$item['_wp_attachment_metadata_id']}",
"new_image_url" => "$img",
"_wp_attached_file_id" => "",
),

EOT;

 */
			//echo "<br>" . '"' . $img . '",';

			//echo "<p>https://www.upcitemdb.com/upc/" . $item['upc'];

		}

		die("<h3>cont</h3><pre>" . print_r($cont, 1) . "</pre>");

	}

	function upnoimg() {
		$q = "select * from jt_noimg where sku=''";
		$r = $this->db->query($q)->result();
		foreach ($r as $row) {
			$qq = "select * from jt_mac_data where upc ='" . $row->upc . "'";
			$rr = $this->db->query($qq);
			if ($rr->num_rows() > 0) {
				$this->db->update('jt_noimg', array("supplier" => "MAC", "sku" => $rr->row()->sku), array("id" => $row->id));

			}
			$rr->free_result();
		}
	}

	function fixslugs() {
		$q = "SELECT * FROM `wp_posts` where post_name like '%-'";
		$r = $this->db->query($q)->result();
		foreach ($r as $row) {
			$p = $row->post_name;
			$p = str_replace("-x-", "x", $p);
			$p = explode("-", $p);
			$p = array_filter($p);
			$p = implode("-", $p);
			$u = array("post_name" => $p);
			$qq = $this->db->update_string("wp_posts", $u, array("ID" => $row->ID));
			echo "<P>$qq;";

		}
	}

	function getIarr() {

		return
		array(

			array(
				"upc" => "082335330045",
				"meta_thumbnail_id" => "164359",
				"image_post_id" => "15328",
				"product_post_id" => "15327",
				"_wp_attachment_metadata_id" => "164337",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376971514",
				"meta_thumbnail_id" => "70641",
				"image_post_id" => "7009",
				"product_post_id" => "7008",
				"_wp_attachment_metadata_id" => "70619",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376899412",
				"meta_thumbnail_id" => "70665",
				"image_post_id" => "7011",
				"product_post_id" => "7010",
				"_wp_attachment_metadata_id" => "70643",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376899467",
				"meta_thumbnail_id" => "70689",
				"image_post_id" => "7013",
				"product_post_id" => "7012",
				"_wp_attachment_metadata_id" => "70667",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376972283",
				"meta_thumbnail_id" => "70713",
				"image_post_id" => "7015",
				"product_post_id" => "7014",
				"_wp_attachment_metadata_id" => "70691",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376899450",
				"meta_thumbnail_id" => "70737",
				"image_post_id" => "7017",
				"product_post_id" => "7016",
				"_wp_attachment_metadata_id" => "70715",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376971491",
				"meta_thumbnail_id" => "70761",
				"image_post_id" => "7019",
				"product_post_id" => "7018",
				"_wp_attachment_metadata_id" => "70739",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376971620",
				"meta_thumbnail_id" => "70785",
				"image_post_id" => "7021",
				"product_post_id" => "7020",
				"_wp_attachment_metadata_id" => "70763",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376971552",
				"meta_thumbnail_id" => "70809",
				"image_post_id" => "7023",
				"product_post_id" => "7022",
				"_wp_attachment_metadata_id" => "70787",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376971545",
				"meta_thumbnail_id" => "70833",
				"image_post_id" => "7025",
				"product_post_id" => "7024",
				"_wp_attachment_metadata_id" => "70811",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376971590",
				"meta_thumbnail_id" => "70857",
				"image_post_id" => "7027",
				"product_post_id" => "7026",
				"_wp_attachment_metadata_id" => "70835",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376971583",
				"meta_thumbnail_id" => "70881",
				"image_post_id" => "7029",
				"product_post_id" => "7028",
				"_wp_attachment_metadata_id" => "70859",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376971569",
				"meta_thumbnail_id" => "70905",
				"image_post_id" => "7031",
				"product_post_id" => "7030",
				"_wp_attachment_metadata_id" => "70883",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376971521",
				"meta_thumbnail_id" => "70929",
				"image_post_id" => "7033",
				"product_post_id" => "7032",
				"_wp_attachment_metadata_id" => "70907",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376899481",
				"meta_thumbnail_id" => "70953",
				"image_post_id" => "7035",
				"product_post_id" => "7034",
				"_wp_attachment_metadata_id" => "70931",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376971606",
				"meta_thumbnail_id" => "70977",
				"image_post_id" => "7037",
				"product_post_id" => "7036",
				"_wp_attachment_metadata_id" => "70955",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376899504",
				"meta_thumbnail_id" => "71001",
				"image_post_id" => "7039",
				"product_post_id" => "7038",
				"_wp_attachment_metadata_id" => "70979",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376971507",
				"meta_thumbnail_id" => "71025",
				"image_post_id" => "7041",
				"product_post_id" => "7040",
				"_wp_attachment_metadata_id" => "71003",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376899399",
				"meta_thumbnail_id" => "71049",
				"image_post_id" => "7043",
				"product_post_id" => "7042",
				"_wp_attachment_metadata_id" => "71027",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376971576",
				"meta_thumbnail_id" => "71073",
				"image_post_id" => "7045",
				"product_post_id" => "7044",
				"_wp_attachment_metadata_id" => "71051",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376971538",
				"meta_thumbnail_id" => "71097",
				"image_post_id" => "7047",
				"product_post_id" => "7046",
				"_wp_attachment_metadata_id" => "71075",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "042229211829",
				"meta_thumbnail_id" => "71193",
				"image_post_id" => "7055",
				"product_post_id" => "7054",
				"_wp_attachment_metadata_id" => "71171",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376922400",
				"meta_thumbnail_id" => "71553",
				"image_post_id" => "7085",
				"product_post_id" => "7084",
				"_wp_attachment_metadata_id" => "71531",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376922394",
				"meta_thumbnail_id" => "71577",
				"image_post_id" => "7087",
				"product_post_id" => "7086",
				"_wp_attachment_metadata_id" => "71555",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376922264",
				"meta_thumbnail_id" => "71673",
				"image_post_id" => "7095",
				"product_post_id" => "7094",
				"_wp_attachment_metadata_id" => "71651",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376922257",
				"meta_thumbnail_id" => "71697",
				"image_post_id" => "7097",
				"product_post_id" => "7096",
				"_wp_attachment_metadata_id" => "71675",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376922240",
				"meta_thumbnail_id" => "71721",
				"image_post_id" => "7099",
				"product_post_id" => "7098",
				"_wp_attachment_metadata_id" => "71699",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376922219",
				"meta_thumbnail_id" => "71745",
				"image_post_id" => "7101",
				"product_post_id" => "7100",
				"_wp_attachment_metadata_id" => "71723",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376922165",
				"meta_thumbnail_id" => "71769",
				"image_post_id" => "7103",
				"product_post_id" => "7102",
				"_wp_attachment_metadata_id" => "71747",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376922158",
				"meta_thumbnail_id" => "71793",
				"image_post_id" => "7105",
				"product_post_id" => "7104",
				"_wp_attachment_metadata_id" => "71771",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376922141",
				"meta_thumbnail_id" => "71817",
				"image_post_id" => "7107",
				"product_post_id" => "7106",
				"_wp_attachment_metadata_id" => "71795",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376922097",
				"meta_thumbnail_id" => "71841",
				"image_post_id" => "7109",
				"product_post_id" => "7108",
				"_wp_attachment_metadata_id" => "71819",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376922080",
				"meta_thumbnail_id" => "71865",
				"image_post_id" => "7111",
				"product_post_id" => "7110",
				"_wp_attachment_metadata_id" => "71843",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376922073",
				"meta_thumbnail_id" => "71889",
				"image_post_id" => "7113",
				"product_post_id" => "7112",
				"_wp_attachment_metadata_id" => "71867",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376922059",
				"meta_thumbnail_id" => "71913",
				"image_post_id" => "7115",
				"product_post_id" => "7114",
				"_wp_attachment_metadata_id" => "71891",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376922042",
				"meta_thumbnail_id" => "71937",
				"image_post_id" => "7117",
				"product_post_id" => "7116",
				"_wp_attachment_metadata_id" => "71915",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376922035",
				"meta_thumbnail_id" => "71961",
				"image_post_id" => "7119",
				"product_post_id" => "7118",
				"_wp_attachment_metadata_id" => "71939",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376922028",
				"meta_thumbnail_id" => "71985",
				"image_post_id" => "7121",
				"product_post_id" => "7120",
				"_wp_attachment_metadata_id" => "71963",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921960",
				"meta_thumbnail_id" => "72009",
				"image_post_id" => "7123",
				"product_post_id" => "7122",
				"_wp_attachment_metadata_id" => "71987",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921953",
				"meta_thumbnail_id" => "72033",
				"image_post_id" => "7125",
				"product_post_id" => "7124",
				"_wp_attachment_metadata_id" => "72011",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921946",
				"meta_thumbnail_id" => "72057",
				"image_post_id" => "7127",
				"product_post_id" => "7126",
				"_wp_attachment_metadata_id" => "72035",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921939",
				"meta_thumbnail_id" => "72081",
				"image_post_id" => "7129",
				"product_post_id" => "7128",
				"_wp_attachment_metadata_id" => "72059",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921892",
				"meta_thumbnail_id" => "72105",
				"image_post_id" => "7131",
				"product_post_id" => "7130",
				"_wp_attachment_metadata_id" => "72083",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921885",
				"meta_thumbnail_id" => "72129",
				"image_post_id" => "7133",
				"product_post_id" => "7132",
				"_wp_attachment_metadata_id" => "72107",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921861",
				"meta_thumbnail_id" => "72153",
				"image_post_id" => "7135",
				"product_post_id" => "7134",
				"_wp_attachment_metadata_id" => "72131",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921854",
				"meta_thumbnail_id" => "72177",
				"image_post_id" => "7137",
				"product_post_id" => "7136",
				"_wp_attachment_metadata_id" => "72155",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921847",
				"meta_thumbnail_id" => "72201",
				"image_post_id" => "7139",
				"product_post_id" => "7138",
				"_wp_attachment_metadata_id" => "72179",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376943405",
				"meta_thumbnail_id" => "72225",
				"image_post_id" => "7141",
				"product_post_id" => "7140",
				"_wp_attachment_metadata_id" => "72203",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921830",
				"meta_thumbnail_id" => "72249",
				"image_post_id" => "7143",
				"product_post_id" => "7142",
				"_wp_attachment_metadata_id" => "72227",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921816",
				"meta_thumbnail_id" => "72273",
				"image_post_id" => "7145",
				"product_post_id" => "7144",
				"_wp_attachment_metadata_id" => "72251",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921779",
				"meta_thumbnail_id" => "72297",
				"image_post_id" => "7147",
				"product_post_id" => "7146",
				"_wp_attachment_metadata_id" => "72275",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921755",
				"meta_thumbnail_id" => "72321",
				"image_post_id" => "7149",
				"product_post_id" => "7148",
				"_wp_attachment_metadata_id" => "72299",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921724",
				"meta_thumbnail_id" => "72345",
				"image_post_id" => "7151",
				"product_post_id" => "7150",
				"_wp_attachment_metadata_id" => "72323",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921694",
				"meta_thumbnail_id" => "72369",
				"image_post_id" => "7153",
				"product_post_id" => "7152",
				"_wp_attachment_metadata_id" => "72347",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921687",
				"meta_thumbnail_id" => "72393",
				"image_post_id" => "7155",
				"product_post_id" => "7154",
				"_wp_attachment_metadata_id" => "72371",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921670",
				"meta_thumbnail_id" => "72417",
				"image_post_id" => "7157",
				"product_post_id" => "7156",
				"_wp_attachment_metadata_id" => "72395",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921632",
				"meta_thumbnail_id" => "72441",
				"image_post_id" => "7159",
				"product_post_id" => "7158",
				"_wp_attachment_metadata_id" => "72419",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921595",
				"meta_thumbnail_id" => "72465",
				"image_post_id" => "7161",
				"product_post_id" => "7160",
				"_wp_attachment_metadata_id" => "72443",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921588",
				"meta_thumbnail_id" => "72489",
				"image_post_id" => "7163",
				"product_post_id" => "7162",
				"_wp_attachment_metadata_id" => "72467",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921533",
				"meta_thumbnail_id" => "72513",
				"image_post_id" => "7165",
				"product_post_id" => "7164",
				"_wp_attachment_metadata_id" => "72491",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921526",
				"meta_thumbnail_id" => "72537",
				"image_post_id" => "7167",
				"product_post_id" => "7166",
				"_wp_attachment_metadata_id" => "72515",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921502",
				"meta_thumbnail_id" => "72561",
				"image_post_id" => "7169",
				"product_post_id" => "7168",
				"_wp_attachment_metadata_id" => "72539",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921496",
				"meta_thumbnail_id" => "72585",
				"image_post_id" => "7171",
				"product_post_id" => "7170",
				"_wp_attachment_metadata_id" => "72563",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921472",
				"meta_thumbnail_id" => "72609",
				"image_post_id" => "7173",
				"product_post_id" => "7172",
				"_wp_attachment_metadata_id" => "72587",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921434",
				"meta_thumbnail_id" => "72633",
				"image_post_id" => "7175",
				"product_post_id" => "7174",
				"_wp_attachment_metadata_id" => "72611",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921427",
				"meta_thumbnail_id" => "72657",
				"image_post_id" => "7177",
				"product_post_id" => "7176",
				"_wp_attachment_metadata_id" => "72635",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921397",
				"meta_thumbnail_id" => "72681",
				"image_post_id" => "7179",
				"product_post_id" => "7178",
				"_wp_attachment_metadata_id" => "72659",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921373",
				"meta_thumbnail_id" => "72705",
				"image_post_id" => "7181",
				"product_post_id" => "7180",
				"_wp_attachment_metadata_id" => "72683",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376921359",
				"meta_thumbnail_id" => "72729",
				"image_post_id" => "7183",
				"product_post_id" => "7182",
				"_wp_attachment_metadata_id" => "72707",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "738797404021",
				"meta_thumbnail_id" => "73905",
				"image_post_id" => "7281",
				"product_post_id" => "7280",
				"_wp_attachment_metadata_id" => "73883",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "738797400320",
				"meta_thumbnail_id" => "73929",
				"image_post_id" => "7283",
				"product_post_id" => "7282",
				"_wp_attachment_metadata_id" => "73907",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "738797141520",
				"meta_thumbnail_id" => "74121",
				"image_post_id" => "7299",
				"product_post_id" => "7298",
				"_wp_attachment_metadata_id" => "74099",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "738797136021",
				"meta_thumbnail_id" => "74145",
				"image_post_id" => "7301",
				"product_post_id" => "7300",
				"_wp_attachment_metadata_id" => "74123",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "738797130128",
				"meta_thumbnail_id" => "74169",
				"image_post_id" => "7303",
				"product_post_id" => "7302",
				"_wp_attachment_metadata_id" => "74147",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "8593539098836",
				"meta_thumbnail_id" => "92193",
				"image_post_id" => "8805",
				"product_post_id" => "8804",
				"_wp_attachment_metadata_id" => "92171",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "014173341884",
				"meta_thumbnail_id" => "92217",
				"image_post_id" => "8807",
				"product_post_id" => "8806",
				"_wp_attachment_metadata_id" => "92195",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "8593539098812",
				"meta_thumbnail_id" => "92241",
				"image_post_id" => "8809",
				"product_post_id" => "8808",
				"_wp_attachment_metadata_id" => "92219",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "014173341860",
				"meta_thumbnail_id" => "92265",
				"image_post_id" => "8811",
				"product_post_id" => "8810",
				"_wp_attachment_metadata_id" => "92243",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "014173341853",
				"meta_thumbnail_id" => "92289",
				"image_post_id" => "8813",
				"product_post_id" => "8812",
				"_wp_attachment_metadata_id" => "92267",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "014173341846",
				"meta_thumbnail_id" => "92313",
				"image_post_id" => "8815",
				"product_post_id" => "8814",
				"_wp_attachment_metadata_id" => "92291",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "8593539098775",
				"meta_thumbnail_id" => "92337",
				"image_post_id" => "8817",
				"product_post_id" => "8816",
				"_wp_attachment_metadata_id" => "92315",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "8593539098980",
				"meta_thumbnail_id" => "92361",
				"image_post_id" => "8819",
				"product_post_id" => "8818",
				"_wp_attachment_metadata_id" => "92339",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "8593539098973",
				"meta_thumbnail_id" => "92385",
				"image_post_id" => "8821",
				"product_post_id" => "8820",
				"_wp_attachment_metadata_id" => "92363",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "8593539098959",
				"meta_thumbnail_id" => "92409",
				"image_post_id" => "8823",
				"product_post_id" => "8822",
				"_wp_attachment_metadata_id" => "92387",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "0141733420032",
				"meta_thumbnail_id" => "92433",
				"image_post_id" => "8825",
				"product_post_id" => "8824",
				"_wp_attachment_metadata_id" => "92411",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "8593539093596",
				"meta_thumbnail_id" => "92457",
				"image_post_id" => "8827",
				"product_post_id" => "8826",
				"_wp_attachment_metadata_id" => "92435",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "0141733419839",
				"meta_thumbnail_id" => "92481",
				"image_post_id" => "8829",
				"product_post_id" => "8828",
				"_wp_attachment_metadata_id" => "92459",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "014173341976",
				"meta_thumbnail_id" => "92505",
				"image_post_id" => "8831",
				"product_post_id" => "8830",
				"_wp_attachment_metadata_id" => "92483",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "014173341969",
				"meta_thumbnail_id" => "92529",
				"image_post_id" => "8833",
				"product_post_id" => "8832",
				"_wp_attachment_metadata_id" => "92507",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "014173341952",
				"meta_thumbnail_id" => "92553",
				"image_post_id" => "8835",
				"product_post_id" => "8834",
				"_wp_attachment_metadata_id" => "92531",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "8593539098881",
				"meta_thumbnail_id" => "92577",
				"image_post_id" => "8837",
				"product_post_id" => "8836",
				"_wp_attachment_metadata_id" => "92555",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "8593539098874",
				"meta_thumbnail_id" => "92601",
				"image_post_id" => "8839",
				"product_post_id" => "8838",
				"_wp_attachment_metadata_id" => "92579",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "8593539098867",
				"meta_thumbnail_id" => "92625",
				"image_post_id" => "8841",
				"product_post_id" => "8840",
				"_wp_attachment_metadata_id" => "92603",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "8593539098850",
				"meta_thumbnail_id" => "92649",
				"image_post_id" => "8843",
				"product_post_id" => "8842",
				"_wp_attachment_metadata_id" => "92627",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "014173341907",
				"meta_thumbnail_id" => "92673",
				"image_post_id" => "8845",
				"product_post_id" => "8844",
				"_wp_attachment_metadata_id" => "92651",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "8593539093411",
				"meta_thumbnail_id" => "92697",
				"image_post_id" => "8847",
				"product_post_id" => "8846",
				"_wp_attachment_metadata_id" => "92675",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084001030303",
				"meta_thumbnail_id" => "99177",
				"image_post_id" => "9387",
				"product_post_id" => "9386",
				"_wp_attachment_metadata_id" => "99155",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084001030297",
				"meta_thumbnail_id" => "99201",
				"image_post_id" => "9389",
				"product_post_id" => "9388",
				"_wp_attachment_metadata_id" => "99179",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084001030266",
				"meta_thumbnail_id" => "99225",
				"image_post_id" => "9391",
				"product_post_id" => "9390",
				"_wp_attachment_metadata_id" => "99203",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084001030259",
				"meta_thumbnail_id" => "99249",
				"image_post_id" => "9393",
				"product_post_id" => "9392",
				"_wp_attachment_metadata_id" => "99227",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084001030228",
				"meta_thumbnail_id" => "99273",
				"image_post_id" => "9395",
				"product_post_id" => "9394",
				"_wp_attachment_metadata_id" => "99251",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084001030129",
				"meta_thumbnail_id" => "99297",
				"image_post_id" => "9397",
				"product_post_id" => "9396",
				"_wp_attachment_metadata_id" => "99275",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084001030044",
				"meta_thumbnail_id" => "99321",
				"image_post_id" => "9399",
				"product_post_id" => "9398",
				"_wp_attachment_metadata_id" => "99299",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084001030020",
				"meta_thumbnail_id" => "99345",
				"image_post_id" => "9401",
				"product_post_id" => "9400",
				"_wp_attachment_metadata_id" => "99323",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "3148950013569",
				"meta_thumbnail_id" => "99369",
				"image_post_id" => "9403",
				"product_post_id" => "9402",
				"_wp_attachment_metadata_id" => "99347",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "3148950414069",
				"meta_thumbnail_id" => "99393",
				"image_post_id" => "9405",
				"product_post_id" => "9404",
				"_wp_attachment_metadata_id" => "99371",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "3148950413970",
				"meta_thumbnail_id" => "99417",
				"image_post_id" => "9407",
				"product_post_id" => "9406",
				"_wp_attachment_metadata_id" => "99395",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "045173544814",
				"meta_thumbnail_id" => "101241",
				"image_post_id" => "9559",
				"product_post_id" => "9558",
				"_wp_attachment_metadata_id" => "101219",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084001041590",
				"meta_thumbnail_id" => "101265",
				"image_post_id" => "9561",
				"product_post_id" => "9560",
				"_wp_attachment_metadata_id" => "101243",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "090385480719",
				"meta_thumbnail_id" => "101769",
				"image_post_id" => "9603",
				"product_post_id" => "9602",
				"_wp_attachment_metadata_id" => "101747",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "090385480511",
				"meta_thumbnail_id" => "101793",
				"image_post_id" => "9605",
				"product_post_id" => "9604",
				"_wp_attachment_metadata_id" => "101771",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "090385480115",
				"meta_thumbnail_id" => "101817",
				"image_post_id" => "9607",
				"product_post_id" => "9606",
				"_wp_attachment_metadata_id" => "101795",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "090385481419",
				"meta_thumbnail_id" => "101841",
				"image_post_id" => "9609",
				"product_post_id" => "9608",
				"_wp_attachment_metadata_id" => "101819",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "090385481013",
				"meta_thumbnail_id" => "101865",
				"image_post_id" => "9611",
				"product_post_id" => "9610",
				"_wp_attachment_metadata_id" => "101843",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "4012700329141",
				"meta_thumbnail_id" => "101913",
				"image_post_id" => "9615",
				"product_post_id" => "9614",
				"_wp_attachment_metadata_id" => "101891",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014566438",
				"meta_thumbnail_id" => "102081",
				"image_post_id" => "9629",
				"product_post_id" => "9628",
				"_wp_attachment_metadata_id" => "102059",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014566414",
				"meta_thumbnail_id" => "102105",
				"image_post_id" => "9631",
				"product_post_id" => "9630",
				"_wp_attachment_metadata_id" => "102083",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014566391",
				"meta_thumbnail_id" => "102129",
				"image_post_id" => "9633",
				"product_post_id" => "9632",
				"_wp_attachment_metadata_id" => "102107",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014566346",
				"meta_thumbnail_id" => "102153",
				"image_post_id" => "9635",
				"product_post_id" => "9634",
				"_wp_attachment_metadata_id" => "102131",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014566308",
				"meta_thumbnail_id" => "102177",
				"image_post_id" => "9637",
				"product_post_id" => "9636",
				"_wp_attachment_metadata_id" => "102155",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014566261",
				"meta_thumbnail_id" => "102201",
				"image_post_id" => "9639",
				"product_post_id" => "9638",
				"_wp_attachment_metadata_id" => "102179",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014566223",
				"meta_thumbnail_id" => "102225",
				"image_post_id" => "9641",
				"product_post_id" => "9640",
				"_wp_attachment_metadata_id" => "102203",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014566193",
				"meta_thumbnail_id" => "102249",
				"image_post_id" => "9643",
				"product_post_id" => "9642",
				"_wp_attachment_metadata_id" => "102227",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014566186",
				"meta_thumbnail_id" => "102273",
				"image_post_id" => "9645",
				"product_post_id" => "9644",
				"_wp_attachment_metadata_id" => "102251",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014566179",
				"meta_thumbnail_id" => "102297",
				"image_post_id" => "9647",
				"product_post_id" => "9646",
				"_wp_attachment_metadata_id" => "102275",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014566162",
				"meta_thumbnail_id" => "102321",
				"image_post_id" => "9649",
				"product_post_id" => "9648",
				"_wp_attachment_metadata_id" => "102299",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014566124",
				"meta_thumbnail_id" => "102345",
				"image_post_id" => "9651",
				"product_post_id" => "9650",
				"_wp_attachment_metadata_id" => "102323",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014566117",
				"meta_thumbnail_id" => "102369",
				"image_post_id" => "9653",
				"product_post_id" => "9652",
				"_wp_attachment_metadata_id" => "102347",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014566100",
				"meta_thumbnail_id" => "102393",
				"image_post_id" => "9655",
				"product_post_id" => "9654",
				"_wp_attachment_metadata_id" => "102371",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014566094",
				"meta_thumbnail_id" => "102417",
				"image_post_id" => "9657",
				"product_post_id" => "9656",
				"_wp_attachment_metadata_id" => "102395",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014566087",
				"meta_thumbnail_id" => "102441",
				"image_post_id" => "9659",
				"product_post_id" => "9658",
				"_wp_attachment_metadata_id" => "102419",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014566063",
				"meta_thumbnail_id" => "102465",
				"image_post_id" => "9661",
				"product_post_id" => "9660",
				"_wp_attachment_metadata_id" => "102443",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014566056",
				"meta_thumbnail_id" => "102489",
				"image_post_id" => "9663",
				"product_post_id" => "9662",
				"_wp_attachment_metadata_id" => "102467",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014566049",
				"meta_thumbnail_id" => "102513",
				"image_post_id" => "9665",
				"product_post_id" => "9664",
				"_wp_attachment_metadata_id" => "102491",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014566032",
				"meta_thumbnail_id" => "102537",
				"image_post_id" => "9667",
				"product_post_id" => "9666",
				"_wp_attachment_metadata_id" => "102515",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014566025",
				"meta_thumbnail_id" => "102561",
				"image_post_id" => "9669",
				"product_post_id" => "9668",
				"_wp_attachment_metadata_id" => "102539",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014566018",
				"meta_thumbnail_id" => "102585",
				"image_post_id" => "9671",
				"product_post_id" => "9670",
				"_wp_attachment_metadata_id" => "102563",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565981",
				"meta_thumbnail_id" => "102609",
				"image_post_id" => "9673",
				"product_post_id" => "9672",
				"_wp_attachment_metadata_id" => "102587",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565974",
				"meta_thumbnail_id" => "102633",
				"image_post_id" => "9675",
				"product_post_id" => "9674",
				"_wp_attachment_metadata_id" => "102611",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565967",
				"meta_thumbnail_id" => "102657",
				"image_post_id" => "9677",
				"product_post_id" => "9676",
				"_wp_attachment_metadata_id" => "102635",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565950",
				"meta_thumbnail_id" => "102681",
				"image_post_id" => "9679",
				"product_post_id" => "9678",
				"_wp_attachment_metadata_id" => "102659",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565943",
				"meta_thumbnail_id" => "102705",
				"image_post_id" => "9681",
				"product_post_id" => "9680",
				"_wp_attachment_metadata_id" => "102683",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565912",
				"meta_thumbnail_id" => "102729",
				"image_post_id" => "9683",
				"product_post_id" => "9682",
				"_wp_attachment_metadata_id" => "102707",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565899",
				"meta_thumbnail_id" => "102753",
				"image_post_id" => "9685",
				"product_post_id" => "9684",
				"_wp_attachment_metadata_id" => "102731",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565875",
				"meta_thumbnail_id" => "102777",
				"image_post_id" => "9687",
				"product_post_id" => "9686",
				"_wp_attachment_metadata_id" => "102755",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565868",
				"meta_thumbnail_id" => "102801",
				"image_post_id" => "9689",
				"product_post_id" => "9688",
				"_wp_attachment_metadata_id" => "102779",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565851",
				"meta_thumbnail_id" => "102825",
				"image_post_id" => "9691",
				"product_post_id" => "9690",
				"_wp_attachment_metadata_id" => "102803",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565837",
				"meta_thumbnail_id" => "102849",
				"image_post_id" => "9693",
				"product_post_id" => "9692",
				"_wp_attachment_metadata_id" => "102827",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565813",
				"meta_thumbnail_id" => "102873",
				"image_post_id" => "9695",
				"product_post_id" => "9694",
				"_wp_attachment_metadata_id" => "102851",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565806",
				"meta_thumbnail_id" => "102897",
				"image_post_id" => "9697",
				"product_post_id" => "9696",
				"_wp_attachment_metadata_id" => "102875",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565790",
				"meta_thumbnail_id" => "102921",
				"image_post_id" => "9699",
				"product_post_id" => "9698",
				"_wp_attachment_metadata_id" => "102899",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565783",
				"meta_thumbnail_id" => "102945",
				"image_post_id" => "9701",
				"product_post_id" => "9700",
				"_wp_attachment_metadata_id" => "102923",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565776",
				"meta_thumbnail_id" => "102969",
				"image_post_id" => "9703",
				"product_post_id" => "9702",
				"_wp_attachment_metadata_id" => "102947",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565752",
				"meta_thumbnail_id" => "103017",
				"image_post_id" => "9707",
				"product_post_id" => "9706",
				"_wp_attachment_metadata_id" => "102995",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565714",
				"meta_thumbnail_id" => "103041",
				"image_post_id" => "9709",
				"product_post_id" => "9708",
				"_wp_attachment_metadata_id" => "103019",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565707",
				"meta_thumbnail_id" => "103065",
				"image_post_id" => "9711",
				"product_post_id" => "9710",
				"_wp_attachment_metadata_id" => "103043",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565691",
				"meta_thumbnail_id" => "103089",
				"image_post_id" => "9713",
				"product_post_id" => "9712",
				"_wp_attachment_metadata_id" => "103067",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565677",
				"meta_thumbnail_id" => "103113",
				"image_post_id" => "9715",
				"product_post_id" => "9714",
				"_wp_attachment_metadata_id" => "103091",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565660",
				"meta_thumbnail_id" => "103137",
				"image_post_id" => "9717",
				"product_post_id" => "9716",
				"_wp_attachment_metadata_id" => "103115",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565646",
				"meta_thumbnail_id" => "103161",
				"image_post_id" => "9719",
				"product_post_id" => "9718",
				"_wp_attachment_metadata_id" => "103139",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565639",
				"meta_thumbnail_id" => "103185",
				"image_post_id" => "9721",
				"product_post_id" => "9720",
				"_wp_attachment_metadata_id" => "103163",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565615",
				"meta_thumbnail_id" => "103209",
				"image_post_id" => "9723",
				"product_post_id" => "9722",
				"_wp_attachment_metadata_id" => "103187",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565592",
				"meta_thumbnail_id" => "103233",
				"image_post_id" => "9725",
				"product_post_id" => "9724",
				"_wp_attachment_metadata_id" => "103211",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565585",
				"meta_thumbnail_id" => "103257",
				"image_post_id" => "9727",
				"product_post_id" => "9726",
				"_wp_attachment_metadata_id" => "103235",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565578",
				"meta_thumbnail_id" => "103281",
				"image_post_id" => "9729",
				"product_post_id" => "9728",
				"_wp_attachment_metadata_id" => "103259",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565554",
				"meta_thumbnail_id" => "103305",
				"image_post_id" => "9731",
				"product_post_id" => "9730",
				"_wp_attachment_metadata_id" => "103283",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565547",
				"meta_thumbnail_id" => "103329",
				"image_post_id" => "9733",
				"product_post_id" => "9732",
				"_wp_attachment_metadata_id" => "103307",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565509",
				"meta_thumbnail_id" => "103377",
				"image_post_id" => "9737",
				"product_post_id" => "9736",
				"_wp_attachment_metadata_id" => "103355",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565493",
				"meta_thumbnail_id" => "103401",
				"image_post_id" => "9739",
				"product_post_id" => "9738",
				"_wp_attachment_metadata_id" => "103379",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565448",
				"meta_thumbnail_id" => "103425",
				"image_post_id" => "9741",
				"product_post_id" => "9740",
				"_wp_attachment_metadata_id" => "103403",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565356",
				"meta_thumbnail_id" => "103449",
				"image_post_id" => "9743",
				"product_post_id" => "9742",
				"_wp_attachment_metadata_id" => "103427",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565349",
				"meta_thumbnail_id" => "103473",
				"image_post_id" => "9745",
				"product_post_id" => "9744",
				"_wp_attachment_metadata_id" => "103451",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565325",
				"meta_thumbnail_id" => "103497",
				"image_post_id" => "9747",
				"product_post_id" => "9746",
				"_wp_attachment_metadata_id" => "103475",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565233",
				"meta_thumbnail_id" => "103521",
				"image_post_id" => "9749",
				"product_post_id" => "9748",
				"_wp_attachment_metadata_id" => "103499",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565219",
				"meta_thumbnail_id" => "103545",
				"image_post_id" => "9751",
				"product_post_id" => "9750",
				"_wp_attachment_metadata_id" => "103523",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565202",
				"meta_thumbnail_id" => "103569",
				"image_post_id" => "9753",
				"product_post_id" => "9752",
				"_wp_attachment_metadata_id" => "103547",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565196",
				"meta_thumbnail_id" => "103593",
				"image_post_id" => "9755",
				"product_post_id" => "9754",
				"_wp_attachment_metadata_id" => "103571",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565189",
				"meta_thumbnail_id" => "103617",
				"image_post_id" => "9757",
				"product_post_id" => "9756",
				"_wp_attachment_metadata_id" => "103595",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565134",
				"meta_thumbnail_id" => "103641",
				"image_post_id" => "9759",
				"product_post_id" => "9758",
				"_wp_attachment_metadata_id" => "103619",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565103",
				"meta_thumbnail_id" => "103665",
				"image_post_id" => "9761",
				"product_post_id" => "9760",
				"_wp_attachment_metadata_id" => "103643",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565097",
				"meta_thumbnail_id" => "103689",
				"image_post_id" => "9763",
				"product_post_id" => "9762",
				"_wp_attachment_metadata_id" => "103667",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565073",
				"meta_thumbnail_id" => "103713",
				"image_post_id" => "9765",
				"product_post_id" => "9764",
				"_wp_attachment_metadata_id" => "103691",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565059",
				"meta_thumbnail_id" => "103737",
				"image_post_id" => "9767",
				"product_post_id" => "9766",
				"_wp_attachment_metadata_id" => "103715",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565042",
				"meta_thumbnail_id" => "103761",
				"image_post_id" => "9769",
				"product_post_id" => "9768",
				"_wp_attachment_metadata_id" => "103739",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085014565035",
				"meta_thumbnail_id" => "103785",
				"image_post_id" => "9771",
				"product_post_id" => "9770",
				"_wp_attachment_metadata_id" => "103763",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084511318335",
				"meta_thumbnail_id" => "106473",
				"image_post_id" => "9995",
				"product_post_id" => "9994",
				"_wp_attachment_metadata_id" => "106451",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084511306448",
				"meta_thumbnail_id" => "106497",
				"image_post_id" => "9997",
				"product_post_id" => "9996",
				"_wp_attachment_metadata_id" => "106475",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084511306417",
				"meta_thumbnail_id" => "106521",
				"image_post_id" => "9999",
				"product_post_id" => "9998",
				"_wp_attachment_metadata_id" => "106499",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084511306318",
				"meta_thumbnail_id" => "106545",
				"image_post_id" => "10001",
				"product_post_id" => "10000",
				"_wp_attachment_metadata_id" => "106523",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084511318441",
				"meta_thumbnail_id" => "106569",
				"image_post_id" => "10003",
				"product_post_id" => "10002",
				"_wp_attachment_metadata_id" => "106547",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "4005401674924",
				"meta_thumbnail_id" => "106833",
				"image_post_id" => "10025",
				"product_post_id" => "10024",
				"_wp_attachment_metadata_id" => "106811",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "4005401674887",
				"meta_thumbnail_id" => "106857",
				"image_post_id" => "10027",
				"product_post_id" => "10026",
				"_wp_attachment_metadata_id" => "106835",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "4005401674863",
				"meta_thumbnail_id" => "106881",
				"image_post_id" => "10029",
				"product_post_id" => "10028",
				"_wp_attachment_metadata_id" => "106859",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "4005401674801",
				"meta_thumbnail_id" => "106905",
				"image_post_id" => "10031",
				"product_post_id" => "10030",
				"_wp_attachment_metadata_id" => "106883",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "4005401674764",
				"meta_thumbnail_id" => "106929",
				"image_post_id" => "10033",
				"product_post_id" => "10032",
				"_wp_attachment_metadata_id" => "106907",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "4005401674757",
				"meta_thumbnail_id" => "106953",
				"image_post_id" => "10035",
				"product_post_id" => "10034",
				"_wp_attachment_metadata_id" => "106931",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "4005401674740",
				"meta_thumbnail_id" => "106977",
				"image_post_id" => "10037",
				"product_post_id" => "10036",
				"_wp_attachment_metadata_id" => "106955",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "4005401674733",
				"meta_thumbnail_id" => "107001",
				"image_post_id" => "10039",
				"product_post_id" => "10038",
				"_wp_attachment_metadata_id" => "106979",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "4005401674702",
				"meta_thumbnail_id" => "107025",
				"image_post_id" => "10041",
				"product_post_id" => "10040",
				"_wp_attachment_metadata_id" => "107003",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "4005401674696",
				"meta_thumbnail_id" => "107049",
				"image_post_id" => "10043",
				"product_post_id" => "10042",
				"_wp_attachment_metadata_id" => "107027",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "4005401674689",
				"meta_thumbnail_id" => "107073",
				"image_post_id" => "10045",
				"product_post_id" => "10044",
				"_wp_attachment_metadata_id" => "107051",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "4005401674672",
				"meta_thumbnail_id" => "107097",
				"image_post_id" => "10047",
				"product_post_id" => "10046",
				"_wp_attachment_metadata_id" => "107075",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "4005401674474",
				"meta_thumbnail_id" => "107121",
				"image_post_id" => "10049",
				"product_post_id" => "10048",
				"_wp_attachment_metadata_id" => "107099",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "4005401674467",
				"meta_thumbnail_id" => "107145",
				"image_post_id" => "10051",
				"product_post_id" => "10050",
				"_wp_attachment_metadata_id" => "107123",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "4005401674351",
				"meta_thumbnail_id" => "107169",
				"image_post_id" => "10053",
				"product_post_id" => "10052",
				"_wp_attachment_metadata_id" => "107147",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "4005401674337",
				"meta_thumbnail_id" => "107193",
				"image_post_id" => "10055",
				"product_post_id" => "10054",
				"_wp_attachment_metadata_id" => "107171",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "4005401674320",
				"meta_thumbnail_id" => "107217",
				"image_post_id" => "10057",
				"product_post_id" => "10056",
				"_wp_attachment_metadata_id" => "107195",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "4005401674276",
				"meta_thumbnail_id" => "107241",
				"image_post_id" => "10059",
				"product_post_id" => "10058",
				"_wp_attachment_metadata_id" => "107219",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "4005401674108",
				"meta_thumbnail_id" => "107265",
				"image_post_id" => "10061",
				"product_post_id" => "10060",
				"_wp_attachment_metadata_id" => "107243",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "4005401674078",
				"meta_thumbnail_id" => "107289",
				"image_post_id" => "10063",
				"product_post_id" => "10062",
				"_wp_attachment_metadata_id" => "107267",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "4005401673880",
				"meta_thumbnail_id" => "107313",
				"image_post_id" => "10065",
				"product_post_id" => "10064",
				"_wp_attachment_metadata_id" => "107291",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "4005401673750",
				"meta_thumbnail_id" => "107337",
				"image_post_id" => "10067",
				"product_post_id" => "10066",
				"_wp_attachment_metadata_id" => "107315",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "4005401672883",
				"meta_thumbnail_id" => "107361",
				"image_post_id" => "10069",
				"product_post_id" => "10068",
				"_wp_attachment_metadata_id" => "107339",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "071641382848",
				"meta_thumbnail_id" => "108345",
				"image_post_id" => "10151",
				"product_post_id" => "10150",
				"_wp_attachment_metadata_id" => "108323",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "071641329881",
				"meta_thumbnail_id" => "108369",
				"image_post_id" => "10153",
				"product_post_id" => "10152",
				"_wp_attachment_metadata_id" => "108347",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "071641320895",
				"meta_thumbnail_id" => "108393",
				"image_post_id" => "10155",
				"product_post_id" => "10154",
				"_wp_attachment_metadata_id" => "108371",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "071641320888",
				"meta_thumbnail_id" => "108417",
				"image_post_id" => "10157",
				"product_post_id" => "10156",
				"_wp_attachment_metadata_id" => "108395",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "071641320833",
				"meta_thumbnail_id" => "108441",
				"image_post_id" => "10159",
				"product_post_id" => "10158",
				"_wp_attachment_metadata_id" => "108419",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "607312000058",
				"meta_thumbnail_id" => "124663",
				"image_post_id" => "12020",
				"product_post_id" => "12019",
				"_wp_attachment_metadata_id" => "124641",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "607312000034",
				"meta_thumbnail_id" => "124687",
				"image_post_id" => "12022",
				"product_post_id" => "12021",
				"_wp_attachment_metadata_id" => "124665",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "031248018472",
				"meta_thumbnail_id" => "124711",
				"image_post_id" => "12024",
				"product_post_id" => "12023",
				"_wp_attachment_metadata_id" => "124689",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "031248518309",
				"meta_thumbnail_id" => "124783",
				"image_post_id" => "12030",
				"product_post_id" => "12029",
				"_wp_attachment_metadata_id" => "124761",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "031248011176",
				"meta_thumbnail_id" => "124807",
				"image_post_id" => "12032",
				"product_post_id" => "12031",
				"_wp_attachment_metadata_id" => "124785",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "031248513076",
				"meta_thumbnail_id" => "124831",
				"image_post_id" => "12034",
				"product_post_id" => "12033",
				"_wp_attachment_metadata_id" => "124809",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "031248513014",
				"meta_thumbnail_id" => "124855",
				"image_post_id" => "12036",
				"product_post_id" => "12035",
				"_wp_attachment_metadata_id" => "124833",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "031248019820",
				"meta_thumbnail_id" => "124879",
				"image_post_id" => "12038",
				"product_post_id" => "12037",
				"_wp_attachment_metadata_id" => "124857",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "031248506528",
				"meta_thumbnail_id" => "124903",
				"image_post_id" => "12040",
				"product_post_id" => "12039",
				"_wp_attachment_metadata_id" => "124881",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "031248506238",
				"meta_thumbnail_id" => "124951",
				"image_post_id" => "12044",
				"product_post_id" => "12043",
				"_wp_attachment_metadata_id" => "124929",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "031248506139",
				"meta_thumbnail_id" => "124975",
				"image_post_id" => "12046",
				"product_post_id" => "12045",
				"_wp_attachment_metadata_id" => "124953",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "884955049495",
				"meta_thumbnail_id" => "125311",
				"image_post_id" => "12074",
				"product_post_id" => "12073",
				"_wp_attachment_metadata_id" => "125289",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "884955048870",
				"meta_thumbnail_id" => "125335",
				"image_post_id" => "12076",
				"product_post_id" => "12075",
				"_wp_attachment_metadata_id" => "125313",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "884955048580",
				"meta_thumbnail_id" => "125359",
				"image_post_id" => "12078",
				"product_post_id" => "12077",
				"_wp_attachment_metadata_id" => "125337",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "884955047309",
				"meta_thumbnail_id" => "125383",
				"image_post_id" => "12080",
				"product_post_id" => "12079",
				"_wp_attachment_metadata_id" => "125361",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "884955047293",
				"meta_thumbnail_id" => "125407",
				"image_post_id" => "12082",
				"product_post_id" => "12081",
				"_wp_attachment_metadata_id" => "125385",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "884955053683",
				"meta_thumbnail_id" => "125527",
				"image_post_id" => "12092",
				"product_post_id" => "12091",
				"_wp_attachment_metadata_id" => "125505",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "978082305022",
				"meta_thumbnail_id" => "125671",
				"image_post_id" => "12104",
				"product_post_id" => "12103",
				"_wp_attachment_metadata_id" => "125649",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "978082303279",
				"meta_thumbnail_id" => "125695",
				"image_post_id" => "12106",
				"product_post_id" => "12105",
				"_wp_attachment_metadata_id" => "125673",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "978082303274",
				"meta_thumbnail_id" => "125719",
				"image_post_id" => "12108",
				"product_post_id" => "12107",
				"_wp_attachment_metadata_id" => "125697",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "978082300855",
				"meta_thumbnail_id" => "125743",
				"image_post_id" => "12110",
				"product_post_id" => "12109",
				"_wp_attachment_metadata_id" => "125721",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "648234996814",
				"meta_thumbnail_id" => "125983",
				"image_post_id" => "12130",
				"product_post_id" => "12129",
				"_wp_attachment_metadata_id" => "125961",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "028617220901",
				"meta_thumbnail_id" => "126007",
				"image_post_id" => "12132",
				"product_post_id" => "12131",
				"_wp_attachment_metadata_id" => "125985",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "028617220307",
				"meta_thumbnail_id" => "126031",
				"image_post_id" => "12134",
				"product_post_id" => "12133",
				"_wp_attachment_metadata_id" => "126009",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "028617200705",
				"meta_thumbnail_id" => "126055",
				"image_post_id" => "12136",
				"product_post_id" => "12135",
				"_wp_attachment_metadata_id" => "126033",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "028617200507",
				"meta_thumbnail_id" => "126079",
				"image_post_id" => "12138",
				"product_post_id" => "12137",
				"_wp_attachment_metadata_id" => "126057",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "028617200408",
				"meta_thumbnail_id" => "126103",
				"image_post_id" => "12140",
				"product_post_id" => "12139",
				"_wp_attachment_metadata_id" => "126081",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "028617200309",
				"meta_thumbnail_id" => "126127",
				"image_post_id" => "12142",
				"product_post_id" => "12141",
				"_wp_attachment_metadata_id" => "126105",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "028617200200",
				"meta_thumbnail_id" => "126151",
				"image_post_id" => "12144",
				"product_post_id" => "12143",
				"_wp_attachment_metadata_id" => "126129",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "028617201108",
				"meta_thumbnail_id" => "126175",
				"image_post_id" => "12146",
				"product_post_id" => "12145",
				"_wp_attachment_metadata_id" => "126153",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "028617221007",
				"meta_thumbnail_id" => "126199",
				"image_post_id" => "12148",
				"product_post_id" => "12147",
				"_wp_attachment_metadata_id" => "126177",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "000772080828",
				"meta_thumbnail_id" => "126391",
				"image_post_id" => "12164",
				"product_post_id" => "12163",
				"_wp_attachment_metadata_id" => "126369",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "000772059312",
				"meta_thumbnail_id" => "126415",
				"image_post_id" => "12166",
				"product_post_id" => "12165",
				"_wp_attachment_metadata_id" => "126393",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "739301450541",
				"meta_thumbnail_id" => "128167",
				"image_post_id" => "12312",
				"product_post_id" => "12311",
				"_wp_attachment_metadata_id" => "128145",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "739301450480",
				"meta_thumbnail_id" => "128263",
				"image_post_id" => "12320",
				"product_post_id" => "12319",
				"_wp_attachment_metadata_id" => "128241",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "651032094378",
				"meta_thumbnail_id" => "128575",
				"image_post_id" => "12346",
				"product_post_id" => "12345",
				"_wp_attachment_metadata_id" => "128553",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "651032047305",
				"meta_thumbnail_id" => "128599",
				"image_post_id" => "12348",
				"product_post_id" => "12347",
				"_wp_attachment_metadata_id" => "128577",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "651032047121",
				"meta_thumbnail_id" => "128623",
				"image_post_id" => "12350",
				"product_post_id" => "12349",
				"_wp_attachment_metadata_id" => "128601",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "651032043062",
				"meta_thumbnail_id" => "128647",
				"image_post_id" => "12352",
				"product_post_id" => "12351",
				"_wp_attachment_metadata_id" => "128625",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "651032041297",
				"meta_thumbnail_id" => "128671",
				"image_post_id" => "12354",
				"product_post_id" => "12353",
				"_wp_attachment_metadata_id" => "128649",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "651032412172",
				"meta_thumbnail_id" => "128695",
				"image_post_id" => "12356",
				"product_post_id" => "12355",
				"_wp_attachment_metadata_id" => "128673",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "651032041051",
				"meta_thumbnail_id" => "128719",
				"image_post_id" => "12358",
				"product_post_id" => "12357",
				"_wp_attachment_metadata_id" => "128697",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "651032041044",
				"meta_thumbnail_id" => "128743",
				"image_post_id" => "12360",
				"product_post_id" => "12359",
				"_wp_attachment_metadata_id" => "128721",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "651032041013",
				"meta_thumbnail_id" => "128767",
				"image_post_id" => "12362",
				"product_post_id" => "12361",
				"_wp_attachment_metadata_id" => "128745",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "651032030666",
				"meta_thumbnail_id" => "128791",
				"image_post_id" => "12364",
				"product_post_id" => "12363",
				"_wp_attachment_metadata_id" => "128769",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "651032030604",
				"meta_thumbnail_id" => "128815",
				"image_post_id" => "12366",
				"product_post_id" => "12365",
				"_wp_attachment_metadata_id" => "128793",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "766416496652",
				"meta_thumbnail_id" => "128863",
				"image_post_id" => "12370",
				"product_post_id" => "12369",
				"_wp_attachment_metadata_id" => "128841",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "012017460593",
				"meta_thumbnail_id" => "129055",
				"image_post_id" => "12386",
				"product_post_id" => "12385",
				"_wp_attachment_metadata_id" => "129033",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "012017494116",
				"meta_thumbnail_id" => "129079",
				"image_post_id" => "12388",
				"product_post_id" => "12387",
				"_wp_attachment_metadata_id" => "129057",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "012017572029",
				"meta_thumbnail_id" => "129127",
				"image_post_id" => "12392",
				"product_post_id" => "12391",
				"_wp_attachment_metadata_id" => "129105",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "053482502500",
				"meta_thumbnail_id" => "129871",
				"image_post_id" => "12454",
				"product_post_id" => "12453",
				"_wp_attachment_metadata_id" => "129849",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084511362581",
				"meta_thumbnail_id" => "129895",
				"image_post_id" => "12456",
				"product_post_id" => "12455",
				"_wp_attachment_metadata_id" => "129873",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084511379626",
				"meta_thumbnail_id" => "130759",
				"image_post_id" => "12528",
				"product_post_id" => "12527",
				"_wp_attachment_metadata_id" => "130737",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084511379619",
				"meta_thumbnail_id" => "130783",
				"image_post_id" => "12530",
				"product_post_id" => "12529",
				"_wp_attachment_metadata_id" => "130761",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084511379596",
				"meta_thumbnail_id" => "130807",
				"image_post_id" => "12532",
				"product_post_id" => "12531",
				"_wp_attachment_metadata_id" => "130785",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084511379589",
				"meta_thumbnail_id" => "130831",
				"image_post_id" => "12534",
				"product_post_id" => "12533",
				"_wp_attachment_metadata_id" => "130809",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084511379572",
				"meta_thumbnail_id" => "130855",
				"image_post_id" => "12536",
				"product_post_id" => "12535",
				"_wp_attachment_metadata_id" => "130833",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084511379565",
				"meta_thumbnail_id" => "130879",
				"image_post_id" => "12538",
				"product_post_id" => "12537",
				"_wp_attachment_metadata_id" => "130857",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084511379558",
				"meta_thumbnail_id" => "130903",
				"image_post_id" => "12540",
				"product_post_id" => "12539",
				"_wp_attachment_metadata_id" => "130881",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084511379541",
				"meta_thumbnail_id" => "130927",
				"image_post_id" => "12542",
				"product_post_id" => "12541",
				"_wp_attachment_metadata_id" => "130905",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084511379534",
				"meta_thumbnail_id" => "130951",
				"image_post_id" => "12544",
				"product_post_id" => "12543",
				"_wp_attachment_metadata_id" => "130929",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084511379527",
				"meta_thumbnail_id" => "130975",
				"image_post_id" => "12546",
				"product_post_id" => "12545",
				"_wp_attachment_metadata_id" => "130953",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084511379510",
				"meta_thumbnail_id" => "130999",
				"image_post_id" => "12548",
				"product_post_id" => "12547",
				"_wp_attachment_metadata_id" => "130977",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084511376687",
				"meta_thumbnail_id" => "131047",
				"image_post_id" => "12552",
				"product_post_id" => "12551",
				"_wp_attachment_metadata_id" => "131025",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084511376571",
				"meta_thumbnail_id" => "131071",
				"image_post_id" => "12554",
				"product_post_id" => "12553",
				"_wp_attachment_metadata_id" => "131049",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "084511376557",
				"meta_thumbnail_id" => "131095",
				"image_post_id" => "12556",
				"product_post_id" => "12555",
				"_wp_attachment_metadata_id" => "131073",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "720077000030",
				"meta_thumbnail_id" => "131575",
				"image_post_id" => "12596",
				"product_post_id" => "12595",
				"_wp_attachment_metadata_id" => "131553",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "720077000016",
				"meta_thumbnail_id" => "131599",
				"image_post_id" => "12598",
				"product_post_id" => "12597",
				"_wp_attachment_metadata_id" => "131577",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "729730827625",
				"meta_thumbnail_id" => "131623",
				"image_post_id" => "12600",
				"product_post_id" => "12599",
				"_wp_attachment_metadata_id" => "131601",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "729730826635",
				"meta_thumbnail_id" => "131647",
				"image_post_id" => "12602",
				"product_post_id" => "12601",
				"_wp_attachment_metadata_id" => "131625",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "729730111946",
				"meta_thumbnail_id" => "131671",
				"image_post_id" => "12604",
				"product_post_id" => "12603",
				"_wp_attachment_metadata_id" => "131649",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "SA73015",
				"meta_thumbnail_id" => "131839",
				"image_post_id" => "12618",
				"product_post_id" => "12617",
				"_wp_attachment_metadata_id" => "131817",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "MASA3074",
				"meta_thumbnail_id" => "135055",
				"image_post_id" => "12886",
				"product_post_id" => "12885",
				"_wp_attachment_metadata_id" => "135033",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "MASA2199",
				"meta_thumbnail_id" => "135175",
				"image_post_id" => "12896",
				"product_post_id" => "12895",
				"_wp_attachment_metadata_id" => "135153",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "MASA2194",
				"meta_thumbnail_id" => "135199",
				"image_post_id" => "12898",
				"product_post_id" => "12897",
				"_wp_attachment_metadata_id" => "135177",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "SA2188",
				"meta_thumbnail_id" => "135223",
				"image_post_id" => "12900",
				"product_post_id" => "12899",
				"_wp_attachment_metadata_id" => "135201",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "MASA2179",
				"meta_thumbnail_id" => "135247",
				"image_post_id" => "12902",
				"product_post_id" => "12901",
				"_wp_attachment_metadata_id" => "135225",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "MASA2177",
				"meta_thumbnail_id" => "135271",
				"image_post_id" => "12904",
				"product_post_id" => "12903",
				"_wp_attachment_metadata_id" => "135249",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "MASA2176",
				"meta_thumbnail_id" => "135295",
				"image_post_id" => "12906",
				"product_post_id" => "12905",
				"_wp_attachment_metadata_id" => "135273",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "070735020222",
				"meta_thumbnail_id" => "135967",
				"image_post_id" => "12962",
				"product_post_id" => "12961",
				"_wp_attachment_metadata_id" => "135945",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "090672057723",
				"meta_thumbnail_id" => "136039",
				"image_post_id" => "12968",
				"product_post_id" => "12967",
				"_wp_attachment_metadata_id" => "136017",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "090672020987",
				"meta_thumbnail_id" => "136063",
				"image_post_id" => "12970",
				"product_post_id" => "12969",
				"_wp_attachment_metadata_id" => "136041",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "978076249423",
				"meta_thumbnail_id" => "136423",
				"image_post_id" => "13000",
				"product_post_id" => "12999",
				"_wp_attachment_metadata_id" => "136401",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "978076249383",
				"meta_thumbnail_id" => "136447",
				"image_post_id" => "13002",
				"product_post_id" => "13001",
				"_wp_attachment_metadata_id" => "136425",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "978076249380",
				"meta_thumbnail_id" => "136471",
				"image_post_id" => "13004",
				"product_post_id" => "13003",
				"_wp_attachment_metadata_id" => "136449",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "978076249168",
				"meta_thumbnail_id" => "136495",
				"image_post_id" => "13006",
				"product_post_id" => "13005",
				"_wp_attachment_metadata_id" => "136473",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "978076245930",
				"meta_thumbnail_id" => "136519",
				"image_post_id" => "13008",
				"product_post_id" => "13007",
				"_wp_attachment_metadata_id" => "136497",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "978014310900",
				"meta_thumbnail_id" => "138631",
				"image_post_id" => "13184",
				"product_post_id" => "13183",
				"_wp_attachment_metadata_id" => "138609",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "978039916208",
				"meta_thumbnail_id" => "138655",
				"image_post_id" => "13186",
				"product_post_id" => "13185",
				"_wp_attachment_metadata_id" => "138633",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "978014311021",
				"meta_thumbnail_id" => "138679",
				"image_post_id" => "13188",
				"product_post_id" => "13187",
				"_wp_attachment_metadata_id" => "138657",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "029444918306",
				"meta_thumbnail_id" => "138703",
				"image_post_id" => "13190",
				"product_post_id" => "13189",
				"_wp_attachment_metadata_id" => "138681",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "029444916906",
				"meta_thumbnail_id" => "138727",
				"image_post_id" => "13192",
				"product_post_id" => "13191",
				"_wp_attachment_metadata_id" => "138705",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "029444916807",
				"meta_thumbnail_id" => "138751",
				"image_post_id" => "13194",
				"product_post_id" => "13193",
				"_wp_attachment_metadata_id" => "138729",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "029444916609",
				"meta_thumbnail_id" => "138775",
				"image_post_id" => "13196",
				"product_post_id" => "13195",
				"_wp_attachment_metadata_id" => "138753",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "029444916500",
				"meta_thumbnail_id" => "138799",
				"image_post_id" => "13198",
				"product_post_id" => "13197",
				"_wp_attachment_metadata_id" => "138777",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "029444916401",
				"meta_thumbnail_id" => "138823",
				"image_post_id" => "13200",
				"product_post_id" => "13199",
				"_wp_attachment_metadata_id" => "138801",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "029444916302",
				"meta_thumbnail_id" => "138847",
				"image_post_id" => "13202",
				"product_post_id" => "13201",
				"_wp_attachment_metadata_id" => "138825",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "029444916203",
				"meta_thumbnail_id" => "138871",
				"image_post_id" => "13204",
				"product_post_id" => "13203",
				"_wp_attachment_metadata_id" => "138849",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "029444916104",
				"meta_thumbnail_id" => "138895",
				"image_post_id" => "13206",
				"product_post_id" => "13205",
				"_wp_attachment_metadata_id" => "138873",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "045173065906",
				"meta_thumbnail_id" => "138919",
				"image_post_id" => "13208",
				"product_post_id" => "13207",
				"_wp_attachment_metadata_id" => "138897",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "029444585461",
				"meta_thumbnail_id" => "138943",
				"image_post_id" => "13210",
				"product_post_id" => "13209",
				"_wp_attachment_metadata_id" => "138921",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "029444585065",
				"meta_thumbnail_id" => "138967",
				"image_post_id" => "13212",
				"product_post_id" => "13211",
				"_wp_attachment_metadata_id" => "138945",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "045173047735",
				"meta_thumbnail_id" => "138991",
				"image_post_id" => "13214",
				"product_post_id" => "13213",
				"_wp_attachment_metadata_id" => "138969",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "072512259085",
				"meta_thumbnail_id" => "139039",
				"image_post_id" => "13218",
				"product_post_id" => "13217",
				"_wp_attachment_metadata_id" => "139017",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "072512266427",
				"meta_thumbnail_id" => "139063",
				"image_post_id" => "13220",
				"product_post_id" => "13219",
				"_wp_attachment_metadata_id" => "139041",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "072512261569",
				"meta_thumbnail_id" => "139087",
				"image_post_id" => "13222",
				"product_post_id" => "13221",
				"_wp_attachment_metadata_id" => "139065",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "072512236383",
				"meta_thumbnail_id" => "139111",
				"image_post_id" => "13224",
				"product_post_id" => "13223",
				"_wp_attachment_metadata_id" => "139089",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "072512236376",
				"meta_thumbnail_id" => "139135",
				"image_post_id" => "13226",
				"product_post_id" => "13225",
				"_wp_attachment_metadata_id" => "139113",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "884851000675",
				"meta_thumbnail_id" => "139159",
				"image_post_id" => "13228",
				"product_post_id" => "13227",
				"_wp_attachment_metadata_id" => "139137",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "884851000668",
				"meta_thumbnail_id" => "139183",
				"image_post_id" => "13230",
				"product_post_id" => "13229",
				"_wp_attachment_metadata_id" => "139161",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "884851000651",
				"meta_thumbnail_id" => "139207",
				"image_post_id" => "13232",
				"product_post_id" => "13231",
				"_wp_attachment_metadata_id" => "139185",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "884851000637",
				"meta_thumbnail_id" => "139231",
				"image_post_id" => "13234",
				"product_post_id" => "13233",
				"_wp_attachment_metadata_id" => "139209",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "072838315632",
				"meta_thumbnail_id" => "139255",
				"image_post_id" => "13236",
				"product_post_id" => "13235",
				"_wp_attachment_metadata_id" => "139233",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "072838315625",
				"meta_thumbnail_id" => "139279",
				"image_post_id" => "13238",
				"product_post_id" => "13237",
				"_wp_attachment_metadata_id" => "139257",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "072838315618",
				"meta_thumbnail_id" => "139303",
				"image_post_id" => "13240",
				"product_post_id" => "13239",
				"_wp_attachment_metadata_id" => "139281",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "028995112386",
				"meta_thumbnail_id" => "139351",
				"image_post_id" => "13244",
				"product_post_id" => "13243",
				"_wp_attachment_metadata_id" => "139329",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "028995112362",
				"meta_thumbnail_id" => "139375",
				"image_post_id" => "13246",
				"product_post_id" => "13245",
				"_wp_attachment_metadata_id" => "139353",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "810078030928",
				"meta_thumbnail_id" => "139399",
				"image_post_id" => "13248",
				"product_post_id" => "13247",
				"_wp_attachment_metadata_id" => "139377",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "810078031659",
				"meta_thumbnail_id" => "139423",
				"image_post_id" => "13250",
				"product_post_id" => "13249",
				"_wp_attachment_metadata_id" => "139401",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "879426005186",
				"meta_thumbnail_id" => "139447",
				"image_post_id" => "13252",
				"product_post_id" => "13251",
				"_wp_attachment_metadata_id" => "139425",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "810078031512",
				"meta_thumbnail_id" => "139471",
				"image_post_id" => "13254",
				"product_post_id" => "13253",
				"_wp_attachment_metadata_id" => "139449",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "879426008873",
				"meta_thumbnail_id" => "139495",
				"image_post_id" => "13256",
				"product_post_id" => "13255",
				"_wp_attachment_metadata_id" => "139473",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "879426008224",
				"meta_thumbnail_id" => "139519",
				"image_post_id" => "13258",
				"product_post_id" => "13257",
				"_wp_attachment_metadata_id" => "139497",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "879426006541",
				"meta_thumbnail_id" => "139543",
				"image_post_id" => "13260",
				"product_post_id" => "13259",
				"_wp_attachment_metadata_id" => "139521",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "879426007388",
				"meta_thumbnail_id" => "139615",
				"image_post_id" => "13266",
				"product_post_id" => "13265",
				"_wp_attachment_metadata_id" => "139593",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "810078030041",
				"meta_thumbnail_id" => "139639",
				"image_post_id" => "13268",
				"product_post_id" => "13267",
				"_wp_attachment_metadata_id" => "139617",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "879426009832",
				"meta_thumbnail_id" => "139663",
				"image_post_id" => "13270",
				"product_post_id" => "13269",
				"_wp_attachment_metadata_id" => "139641",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "879426007418",
				"meta_thumbnail_id" => "139687",
				"image_post_id" => "13272",
				"product_post_id" => "13271",
				"_wp_attachment_metadata_id" => "139665",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "049223550749",
				"meta_thumbnail_id" => "139711",
				"image_post_id" => "13274",
				"product_post_id" => "13273",
				"_wp_attachment_metadata_id" => "139689",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "049223507033",
				"meta_thumbnail_id" => "139735",
				"image_post_id" => "13276",
				"product_post_id" => "13275",
				"_wp_attachment_metadata_id" => "139713",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "049223504728",
				"meta_thumbnail_id" => "139759",
				"image_post_id" => "13278",
				"product_post_id" => "13277",
				"_wp_attachment_metadata_id" => "139737",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "049223504704",
				"meta_thumbnail_id" => "139783",
				"image_post_id" => "13280",
				"product_post_id" => "13279",
				"_wp_attachment_metadata_id" => "139761",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "049223501307",
				"meta_thumbnail_id" => "139807",
				"image_post_id" => "13282",
				"product_post_id" => "13281",
				"_wp_attachment_metadata_id" => "139785",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "049223450001",
				"meta_thumbnail_id" => "139831",
				"image_post_id" => "13284",
				"product_post_id" => "13283",
				"_wp_attachment_metadata_id" => "139809",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "978144030813",
				"meta_thumbnail_id" => "139855",
				"image_post_id" => "13286",
				"product_post_id" => "13285",
				"_wp_attachment_metadata_id" => "139833",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "753182312705",
				"meta_thumbnail_id" => "140023",
				"image_post_id" => "13300",
				"product_post_id" => "13299",
				"_wp_attachment_metadata_id" => "140001",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "076818102007",
				"meta_thumbnail_id" => "140551",
				"image_post_id" => "13344",
				"product_post_id" => "13343",
				"_wp_attachment_metadata_id" => "140529",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "502018019511",
				"meta_thumbnail_id" => "141367",
				"image_post_id" => "13412",
				"product_post_id" => "13411",
				"_wp_attachment_metadata_id" => "141345",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "502018000209",
				"meta_thumbnail_id" => "141391",
				"image_post_id" => "13414",
				"product_post_id" => "13413",
				"_wp_attachment_metadata_id" => "141369",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "502018050040",
				"meta_thumbnail_id" => "141415",
				"image_post_id" => "13416",
				"product_post_id" => "13415",
				"_wp_attachment_metadata_id" => "141393",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "051131658110",
				"meta_thumbnail_id" => "141559",
				"image_post_id" => "13428",
				"product_post_id" => "13427",
				"_wp_attachment_metadata_id" => "141537",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "051131647794",
				"meta_thumbnail_id" => "141631",
				"image_post_id" => "13434",
				"product_post_id" => "13433",
				"_wp_attachment_metadata_id" => "141609",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "051131642041",
				"meta_thumbnail_id" => "141655",
				"image_post_id" => "13436",
				"product_post_id" => "13435",
				"_wp_attachment_metadata_id" => "141633",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "031901105518",
				"meta_thumbnail_id" => "141679",
				"image_post_id" => "13438",
				"product_post_id" => "13437",
				"_wp_attachment_metadata_id" => "141657",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "400781710415",
				"meta_thumbnail_id" => "141703",
				"image_post_id" => "13440",
				"product_post_id" => "13439",
				"_wp_attachment_metadata_id" => "141681",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "400781710417",
				"meta_thumbnail_id" => "141727",
				"image_post_id" => "13442",
				"product_post_id" => "13441",
				"_wp_attachment_metadata_id" => "141705",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "400781710413",
				"meta_thumbnail_id" => "141751",
				"image_post_id" => "13444",
				"product_post_id" => "13443",
				"_wp_attachment_metadata_id" => "141729",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "400781710399",
				"meta_thumbnail_id" => "141775",
				"image_post_id" => "13446",
				"product_post_id" => "13445",
				"_wp_attachment_metadata_id" => "141753",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "400781710401",
				"meta_thumbnail_id" => "141799",
				"image_post_id" => "13448",
				"product_post_id" => "13447",
				"_wp_attachment_metadata_id" => "141777",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "400781710429",
				"meta_thumbnail_id" => "141823",
				"image_post_id" => "13450",
				"product_post_id" => "13449",
				"_wp_attachment_metadata_id" => "141801",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "400781710403",
				"meta_thumbnail_id" => "141847",
				"image_post_id" => "13452",
				"product_post_id" => "13451",
				"_wp_attachment_metadata_id" => "141825",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "400781710405",
				"meta_thumbnail_id" => "141871",
				"image_post_id" => "13454",
				"product_post_id" => "13453",
				"_wp_attachment_metadata_id" => "141849",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "400781710425",
				"meta_thumbnail_id" => "141895",
				"image_post_id" => "13456",
				"product_post_id" => "13455",
				"_wp_attachment_metadata_id" => "141873",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "400781710407",
				"meta_thumbnail_id" => "141919",
				"image_post_id" => "13458",
				"product_post_id" => "13457",
				"_wp_attachment_metadata_id" => "141897",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "400781710423",
				"meta_thumbnail_id" => "141943",
				"image_post_id" => "13460",
				"product_post_id" => "13459",
				"_wp_attachment_metadata_id" => "141921",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "400781710409",
				"meta_thumbnail_id" => "141967",
				"image_post_id" => "13462",
				"product_post_id" => "13461",
				"_wp_attachment_metadata_id" => "141945",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "775749177398",
				"meta_thumbnail_id" => "142015",
				"image_post_id" => "13466",
				"product_post_id" => "13465",
				"_wp_attachment_metadata_id" => "141993",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "072228071025",
				"meta_thumbnail_id" => "142111",
				"image_post_id" => "13474",
				"product_post_id" => "13473",
				"_wp_attachment_metadata_id" => "142089",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "638799300010",
				"meta_thumbnail_id" => "142135",
				"image_post_id" => "13476",
				"product_post_id" => "13475",
				"_wp_attachment_metadata_id" => "142113",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "738998857510",
				"meta_thumbnail_id" => "142183",
				"image_post_id" => "13480",
				"product_post_id" => "13479",
				"_wp_attachment_metadata_id" => "142161",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "738998085715",
				"meta_thumbnail_id" => "142207",
				"image_post_id" => "13482",
				"product_post_id" => "13481",
				"_wp_attachment_metadata_id" => "142185",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "931330602188",
				"meta_thumbnail_id" => "142231",
				"image_post_id" => "13484",
				"product_post_id" => "13483",
				"_wp_attachment_metadata_id" => "142209",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "931330607034",
				"meta_thumbnail_id" => "142255",
				"image_post_id" => "13486",
				"product_post_id" => "13485",
				"_wp_attachment_metadata_id" => "142233",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "931330603854",
				"meta_thumbnail_id" => "142279",
				"image_post_id" => "13488",
				"product_post_id" => "13487",
				"_wp_attachment_metadata_id" => "142257",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "931330602746",
				"meta_thumbnail_id" => "142303",
				"image_post_id" => "13490",
				"product_post_id" => "13489",
				"_wp_attachment_metadata_id" => "142281",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "931330607011",
				"meta_thumbnail_id" => "142423",
				"image_post_id" => "13500",
				"product_post_id" => "13499",
				"_wp_attachment_metadata_id" => "142401",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "931330606185",
				"meta_thumbnail_id" => "142447",
				"image_post_id" => "13502",
				"product_post_id" => "13501",
				"_wp_attachment_metadata_id" => "142425",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "931330606184",
				"meta_thumbnail_id" => "142471",
				"image_post_id" => "13504",
				"product_post_id" => "13503",
				"_wp_attachment_metadata_id" => "142449",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "931330606768",
				"meta_thumbnail_id" => "142495",
				"image_post_id" => "13506",
				"product_post_id" => "13505",
				"_wp_attachment_metadata_id" => "142473",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "044021581025",
				"meta_thumbnail_id" => "142543",
				"image_post_id" => "13510",
				"product_post_id" => "13509",
				"_wp_attachment_metadata_id" => "142521",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "044021581018",
				"meta_thumbnail_id" => "142567",
				"image_post_id" => "13512",
				"product_post_id" => "13511",
				"_wp_attachment_metadata_id" => "142545",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "044021581001",
				"meta_thumbnail_id" => "142591",
				"image_post_id" => "13514",
				"product_post_id" => "13513",
				"_wp_attachment_metadata_id" => "142569",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "044021558249",
				"meta_thumbnail_id" => "142615",
				"image_post_id" => "13516",
				"product_post_id" => "13515",
				"_wp_attachment_metadata_id" => "142593",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "044021558119",
				"meta_thumbnail_id" => "142639",
				"image_post_id" => "13518",
				"product_post_id" => "13517",
				"_wp_attachment_metadata_id" => "142617",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "044021558102",
				"meta_thumbnail_id" => "142663",
				"image_post_id" => "13520",
				"product_post_id" => "13519",
				"_wp_attachment_metadata_id" => "142641",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "044021556207",
				"meta_thumbnail_id" => "142687",
				"image_post_id" => "13522",
				"product_post_id" => "13521",
				"_wp_attachment_metadata_id" => "142665",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "044021555071",
				"meta_thumbnail_id" => "142711",
				"image_post_id" => "13524",
				"product_post_id" => "13523",
				"_wp_attachment_metadata_id" => "142689",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "044021554067",
				"meta_thumbnail_id" => "142735",
				"image_post_id" => "13526",
				"product_post_id" => "13525",
				"_wp_attachment_metadata_id" => "142713",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "044021551141",
				"meta_thumbnail_id" => "142759",
				"image_post_id" => "13528",
				"product_post_id" => "13527",
				"_wp_attachment_metadata_id" => "142737",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "044021211212",
				"meta_thumbnail_id" => "142783",
				"image_post_id" => "13530",
				"product_post_id" => "13529",
				"_wp_attachment_metadata_id" => "142761",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "044021211205",
				"meta_thumbnail_id" => "142807",
				"image_post_id" => "13532",
				"product_post_id" => "13531",
				"_wp_attachment_metadata_id" => "142785",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "044021211199",
				"meta_thumbnail_id" => "142831",
				"image_post_id" => "13534",
				"product_post_id" => "13533",
				"_wp_attachment_metadata_id" => "142809",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "044021211182",
				"meta_thumbnail_id" => "142855",
				"image_post_id" => "13536",
				"product_post_id" => "13535",
				"_wp_attachment_metadata_id" => "142833",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "408490082013",
				"meta_thumbnail_id" => "142879",
				"image_post_id" => "13538",
				"product_post_id" => "13537",
				"_wp_attachment_metadata_id" => "142857",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "408490048044",
				"meta_thumbnail_id" => "142903",
				"image_post_id" => "13540",
				"product_post_id" => "13539",
				"_wp_attachment_metadata_id" => "142881",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "408490048040",
				"meta_thumbnail_id" => "142927",
				"image_post_id" => "13542",
				"product_post_id" => "13541",
				"_wp_attachment_metadata_id" => "142905",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "408490048037",
				"meta_thumbnail_id" => "142951",
				"image_post_id" => "13544",
				"product_post_id" => "13543",
				"_wp_attachment_metadata_id" => "142929",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "408490048058",
				"meta_thumbnail_id" => "142975",
				"image_post_id" => "13546",
				"product_post_id" => "13545",
				"_wp_attachment_metadata_id" => "142953",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "408490002022",
				"meta_thumbnail_id" => "142999",
				"image_post_id" => "13548",
				"product_post_id" => "13547",
				"_wp_attachment_metadata_id" => "142977",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "408490002014",
				"meta_thumbnail_id" => "143023",
				"image_post_id" => "13550",
				"product_post_id" => "13549",
				"_wp_attachment_metadata_id" => "143001",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "094376924404",
				"meta_thumbnail_id" => "143047",
				"image_post_id" => "13552",
				"product_post_id" => "13551",
				"_wp_attachment_metadata_id" => "143025",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "008957908318",
				"meta_thumbnail_id" => "143071",
				"image_post_id" => "13554",
				"product_post_id" => "13553",
				"_wp_attachment_metadata_id" => "143049",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "008957908295",
				"meta_thumbnail_id" => "143095",
				"image_post_id" => "13556",
				"product_post_id" => "13555",
				"_wp_attachment_metadata_id" => "143073",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "008957908288",
				"meta_thumbnail_id" => "143119",
				"image_post_id" => "13558",
				"product_post_id" => "13557",
				"_wp_attachment_metadata_id" => "143097",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "008957905157",
				"meta_thumbnail_id" => "143623",
				"image_post_id" => "13600",
				"product_post_id" => "13599",
				"_wp_attachment_metadata_id" => "143601",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "008957905102",
				"meta_thumbnail_id" => "143695",
				"image_post_id" => "13606",
				"product_post_id" => "13605",
				"_wp_attachment_metadata_id" => "143673",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "008957904624",
				"meta_thumbnail_id" => "143935",
				"image_post_id" => "13626",
				"product_post_id" => "13625",
				"_wp_attachment_metadata_id" => "143913",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "099295612173",
				"meta_thumbnail_id" => "144055",
				"image_post_id" => "13636",
				"product_post_id" => "13635",
				"_wp_attachment_metadata_id" => "144033",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "099295612074",
				"meta_thumbnail_id" => "144079",
				"image_post_id" => "13638",
				"product_post_id" => "13637",
				"_wp_attachment_metadata_id" => "144057",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "099295535304",
				"meta_thumbnail_id" => "144103",
				"image_post_id" => "13640",
				"product_post_id" => "13639",
				"_wp_attachment_metadata_id" => "144081",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "099295535113",
				"meta_thumbnail_id" => "144127",
				"image_post_id" => "13642",
				"product_post_id" => "13641",
				"_wp_attachment_metadata_id" => "144105",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "099295531900",
				"meta_thumbnail_id" => "144151",
				"image_post_id" => "13644",
				"product_post_id" => "13643",
				"_wp_attachment_metadata_id" => "144129",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "099295530675",
				"meta_thumbnail_id" => "144175",
				"image_post_id" => "13646",
				"product_post_id" => "13645",
				"_wp_attachment_metadata_id" => "144153",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "099295533539",
				"meta_thumbnail_id" => "144199",
				"image_post_id" => "13648",
				"product_post_id" => "13647",
				"_wp_attachment_metadata_id" => "144177",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "099295533553",
				"meta_thumbnail_id" => "144223",
				"image_post_id" => "13650",
				"product_post_id" => "13649",
				"_wp_attachment_metadata_id" => "144201",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "099295533546",
				"meta_thumbnail_id" => "144247",
				"image_post_id" => "13652",
				"product_post_id" => "13651",
				"_wp_attachment_metadata_id" => "144225",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "099295530019",
				"meta_thumbnail_id" => "144295",
				"image_post_id" => "13656",
				"product_post_id" => "13655",
				"_wp_attachment_metadata_id" => "144273",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "LCWC384-225",
				"meta_thumbnail_id" => "144319",
				"image_post_id" => "13658",
				"product_post_id" => "13657",
				"_wp_attachment_metadata_id" => "144297",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "LCWC382-225",
				"meta_thumbnail_id" => "144343",
				"image_post_id" => "13660",
				"product_post_id" => "13659",
				"_wp_attachment_metadata_id" => "144321",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "720540060011",
				"meta_thumbnail_id" => "144367",
				"image_post_id" => "13662",
				"product_post_id" => "13661",
				"_wp_attachment_metadata_id" => "144345",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "1124200401",
				"meta_thumbnail_id" => "144391",
				"image_post_id" => "13664",
				"product_post_id" => "13663",
				"_wp_attachment_metadata_id" => "144369",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "0408200501",
				"meta_thumbnail_id" => "144415",
				"image_post_id" => "13666",
				"product_post_id" => "13665",
				"_wp_attachment_metadata_id" => "144393",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "730767355265",
				"meta_thumbnail_id" => "144511",
				"image_post_id" => "13674",
				"product_post_id" => "13673",
				"_wp_attachment_metadata_id" => "144489",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "978133832151",
				"meta_thumbnail_id" => "144607",
				"image_post_id" => "13682",
				"product_post_id" => "13681",
				"_wp_attachment_metadata_id" => "144585",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "978133827128",
				"meta_thumbnail_id" => "144655",
				"image_post_id" => "13686",
				"product_post_id" => "13685",
				"_wp_attachment_metadata_id" => "144633",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "730767210182",
				"meta_thumbnail_id" => "144679",
				"image_post_id" => "13688",
				"product_post_id" => "13687",
				"_wp_attachment_metadata_id" => "144657",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "730767210175",
				"meta_thumbnail_id" => "144703",
				"image_post_id" => "13690",
				"product_post_id" => "13689",
				"_wp_attachment_metadata_id" => "144681",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "730767159603",
				"meta_thumbnail_id" => "144727",
				"image_post_id" => "13692",
				"product_post_id" => "13691",
				"_wp_attachment_metadata_id" => "144705",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "730767106447",
				"meta_thumbnail_id" => "144751",
				"image_post_id" => "13694",
				"product_post_id" => "13693",
				"_wp_attachment_metadata_id" => "144729",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "730767703219",
				"meta_thumbnail_id" => "144775",
				"image_post_id" => "13696",
				"product_post_id" => "13695",
				"_wp_attachment_metadata_id" => "144753",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "730767703196",
				"meta_thumbnail_id" => "144799",
				"image_post_id" => "13698",
				"product_post_id" => "13697",
				"_wp_attachment_metadata_id" => "144777",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "730767647964",
				"meta_thumbnail_id" => "144823",
				"image_post_id" => "13700",
				"product_post_id" => "13699",
				"_wp_attachment_metadata_id" => "144801",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "730767561666",
				"meta_thumbnail_id" => "144847",
				"image_post_id" => "13702",
				"product_post_id" => "13701",
				"_wp_attachment_metadata_id" => "144825",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "730767561642",
				"meta_thumbnail_id" => "144871",
				"image_post_id" => "13704",
				"product_post_id" => "13703",
				"_wp_attachment_metadata_id" => "144849",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "730767492847",
				"meta_thumbnail_id" => "144895",
				"image_post_id" => "13706",
				"product_post_id" => "13705",
				"_wp_attachment_metadata_id" => "144873",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "730767483074",
				"meta_thumbnail_id" => "144919",
				"image_post_id" => "13708",
				"product_post_id" => "13707",
				"_wp_attachment_metadata_id" => "144897",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "730767470005",
				"meta_thumbnail_id" => "144943",
				"image_post_id" => "13710",
				"product_post_id" => "13709",
				"_wp_attachment_metadata_id" => "144921",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "859353909873",
				"meta_thumbnail_id" => "144967",
				"image_post_id" => "13712",
				"product_post_id" => "13711",
				"_wp_attachment_metadata_id" => "144945",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "859353909872",
				"meta_thumbnail_id" => "144991",
				"image_post_id" => "13714",
				"product_post_id" => "13713",
				"_wp_attachment_metadata_id" => "144969",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "859353909871",
				"meta_thumbnail_id" => "145015",
				"image_post_id" => "13716",
				"product_post_id" => "13715",
				"_wp_attachment_metadata_id" => "144993",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "859353909870",
				"meta_thumbnail_id" => "145039",
				"image_post_id" => "13718",
				"product_post_id" => "13717",
				"_wp_attachment_metadata_id" => "145017",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "859353909869",
				"meta_thumbnail_id" => "145063",
				"image_post_id" => "13720",
				"product_post_id" => "13719",
				"_wp_attachment_metadata_id" => "145041",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "743772022879",
				"meta_thumbnail_id" => "145471",
				"image_post_id" => "13754",
				"product_post_id" => "13753",
				"_wp_attachment_metadata_id" => "145449",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "743772022831",
				"meta_thumbnail_id" => "145495",
				"image_post_id" => "13756",
				"product_post_id" => "13755",
				"_wp_attachment_metadata_id" => "145473",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "743772022824",
				"meta_thumbnail_id" => "145519",
				"image_post_id" => "13758",
				"product_post_id" => "13757",
				"_wp_attachment_metadata_id" => "145497",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "743772022794",
				"meta_thumbnail_id" => "145543",
				"image_post_id" => "13760",
				"product_post_id" => "13759",
				"_wp_attachment_metadata_id" => "145521",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "743772022763",
				"meta_thumbnail_id" => "145567",
				"image_post_id" => "13762",
				"product_post_id" => "13761",
				"_wp_attachment_metadata_id" => "145545",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "743772022732",
				"meta_thumbnail_id" => "145591",
				"image_post_id" => "13764",
				"product_post_id" => "13763",
				"_wp_attachment_metadata_id" => "145569",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "743772022725",
				"meta_thumbnail_id" => "145615",
				"image_post_id" => "13766",
				"product_post_id" => "13765",
				"_wp_attachment_metadata_id" => "145593",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "743772022701",
				"meta_thumbnail_id" => "145639",
				"image_post_id" => "13768",
				"product_post_id" => "13767",
				"_wp_attachment_metadata_id" => "145617",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "743772022671",
				"meta_thumbnail_id" => "145663",
				"image_post_id" => "13770",
				"product_post_id" => "13769",
				"_wp_attachment_metadata_id" => "145641",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "743772022633",
				"meta_thumbnail_id" => "145687",
				"image_post_id" => "13772",
				"product_post_id" => "13771",
				"_wp_attachment_metadata_id" => "145665",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "743772022596",
				"meta_thumbnail_id" => "145711",
				"image_post_id" => "13774",
				"product_post_id" => "13773",
				"_wp_attachment_metadata_id" => "145689",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "743772000501",
				"meta_thumbnail_id" => "145807",
				"image_post_id" => "13782",
				"product_post_id" => "13781",
				"_wp_attachment_metadata_id" => "145785",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "743772000402",
				"meta_thumbnail_id" => "145831",
				"image_post_id" => "13784",
				"product_post_id" => "13783",
				"_wp_attachment_metadata_id" => "145809",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "075633906869",
				"meta_thumbnail_id" => "145855",
				"image_post_id" => "13786",
				"product_post_id" => "13785",
				"_wp_attachment_metadata_id" => "145833",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "075633940351",
				"meta_thumbnail_id" => "145879",
				"image_post_id" => "13788",
				"product_post_id" => "13787",
				"_wp_attachment_metadata_id" => "145857",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "075633940313",
				"meta_thumbnail_id" => "145903",
				"image_post_id" => "13790",
				"product_post_id" => "13789",
				"_wp_attachment_metadata_id" => "145881",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "081187398289",
				"meta_thumbnail_id" => "145927",
				"image_post_id" => "13792",
				"product_post_id" => "13791",
				"_wp_attachment_metadata_id" => "145905",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "081187337592",
				"meta_thumbnail_id" => "145951",
				"image_post_id" => "13794",
				"product_post_id" => "13793",
				"_wp_attachment_metadata_id" => "145929",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "079252610022",
				"meta_thumbnail_id" => "146023",
				"image_post_id" => "13800",
				"product_post_id" => "13799",
				"_wp_attachment_metadata_id" => "146001",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "079252130186",
				"meta_thumbnail_id" => "146047",
				"image_post_id" => "13802",
				"product_post_id" => "13801",
				"_wp_attachment_metadata_id" => "146025",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "044974794787",
				"meta_thumbnail_id" => "146239",
				"image_post_id" => "13818",
				"product_post_id" => "13817",
				"_wp_attachment_metadata_id" => "146217",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "044974001007",
				"meta_thumbnail_id" => "146311",
				"image_post_id" => "13824",
				"product_post_id" => "13823",
				"_wp_attachment_metadata_id" => "146289",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "083392731615",
				"meta_thumbnail_id" => "146335",
				"image_post_id" => "13826",
				"product_post_id" => "13825",
				"_wp_attachment_metadata_id" => "146313",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "083392730816",
				"meta_thumbnail_id" => "146359",
				"image_post_id" => "13828",
				"product_post_id" => "13827",
				"_wp_attachment_metadata_id" => "146337",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "083392319554",
				"meta_thumbnail_id" => "146383",
				"image_post_id" => "13830",
				"product_post_id" => "13829",
				"_wp_attachment_metadata_id" => "146361",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "083392318120",
				"meta_thumbnail_id" => "146407",
				"image_post_id" => "13832",
				"product_post_id" => "13831",
				"_wp_attachment_metadata_id" => "146385",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "083392311121",
				"meta_thumbnail_id" => "146431",
				"image_post_id" => "13834",
				"product_post_id" => "13833",
				"_wp_attachment_metadata_id" => "146409",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "400186808960",
				"meta_thumbnail_id" => "146455",
				"image_post_id" => "13836",
				"product_post_id" => "13835",
				"_wp_attachment_metadata_id" => "146433",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "FT4425",
				"meta_thumbnail_id" => "146767",
				"image_post_id" => "13862",
				"product_post_id" => "13861",
				"_wp_attachment_metadata_id" => "146745",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "978160058339",
				"meta_thumbnail_id" => "147103",
				"image_post_id" => "13890",
				"product_post_id" => "13889",
				"_wp_attachment_metadata_id" => "147081",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "711888302345",
				"meta_thumbnail_id" => "147367",
				"image_post_id" => "13912",
				"product_post_id" => "13911",
				"_wp_attachment_metadata_id" => "147345",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "711888209514",
				"meta_thumbnail_id" => "147391",
				"image_post_id" => "13914",
				"product_post_id" => "13913",
				"_wp_attachment_metadata_id" => "147369",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "092633702741",
				"meta_thumbnail_id" => "147415",
				"image_post_id" => "13916",
				"product_post_id" => "13915",
				"_wp_attachment_metadata_id" => "147393",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "092633701065",
				"meta_thumbnail_id" => "147487",
				"image_post_id" => "13922",
				"product_post_id" => "13921",
				"_wp_attachment_metadata_id" => "147465",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "400540167394",
				"meta_thumbnail_id" => "147583",
				"image_post_id" => "13930",
				"product_post_id" => "13929",
				"_wp_attachment_metadata_id" => "147561",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "400540167392",
				"meta_thumbnail_id" => "147607",
				"image_post_id" => "13932",
				"product_post_id" => "13931",
				"_wp_attachment_metadata_id" => "147585",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "400540167390",
				"meta_thumbnail_id" => "147631",
				"image_post_id" => "13934",
				"product_post_id" => "13933",
				"_wp_attachment_metadata_id" => "147609",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "400540167352",
				"meta_thumbnail_id" => "147655",
				"image_post_id" => "13936",
				"product_post_id" => "13935",
				"_wp_attachment_metadata_id" => "147633",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "092633703021",
				"meta_thumbnail_id" => "147775",
				"image_post_id" => "13946",
				"product_post_id" => "13945",
				"_wp_attachment_metadata_id" => "147753",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "092633700730",
				"meta_thumbnail_id" => "147799",
				"image_post_id" => "13948",
				"product_post_id" => "13947",
				"_wp_attachment_metadata_id" => "147777",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "092633703267",
				"meta_thumbnail_id" => "147823",
				"image_post_id" => "13950",
				"product_post_id" => "13949",
				"_wp_attachment_metadata_id" => "147801",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "092633309995",
				"meta_thumbnail_id" => "147847",
				"image_post_id" => "13952",
				"product_post_id" => "13951",
				"_wp_attachment_metadata_id" => "147825",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "092633703014",
				"meta_thumbnail_id" => "148015",
				"image_post_id" => "13966",
				"product_post_id" => "13965",
				"_wp_attachment_metadata_id" => "147993",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "092633700310",
				"meta_thumbnail_id" => "148039",
				"image_post_id" => "13968",
				"product_post_id" => "13967",
				"_wp_attachment_metadata_id" => "148017",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "046501150080",
				"meta_thumbnail_id" => "148591",
				"image_post_id" => "14014",
				"product_post_id" => "14013",
				"_wp_attachment_metadata_id" => "148569",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "033331330089",
				"meta_thumbnail_id" => "148615",
				"image_post_id" => "14016",
				"product_post_id" => "14015",
				"_wp_attachment_metadata_id" => "148593",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "026000004282",
				"meta_thumbnail_id" => "148663",
				"image_post_id" => "14020",
				"product_post_id" => "14019",
				"_wp_attachment_metadata_id" => "148641",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "026000003643",
				"meta_thumbnail_id" => "148687",
				"image_post_id" => "14022",
				"product_post_id" => "14021",
				"_wp_attachment_metadata_id" => "148665",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "079946053432",
				"meta_thumbnail_id" => "148711",
				"image_post_id" => "14024",
				"product_post_id" => "14023",
				"_wp_attachment_metadata_id" => "148689",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "664392159182",
				"meta_thumbnail_id" => "148735",
				"image_post_id" => "14026",
				"product_post_id" => "14025",
				"_wp_attachment_metadata_id" => "148713",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "800759429820",
				"meta_thumbnail_id" => "149911",
				"image_post_id" => "14124",
				"product_post_id" => "14123",
				"_wp_attachment_metadata_id" => "149889",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "400788522550",
				"meta_thumbnail_id" => "153751",
				"image_post_id" => "14444",
				"product_post_id" => "14443",
				"_wp_attachment_metadata_id" => "153729",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435558240",
				"meta_thumbnail_id" => "153823",
				"image_post_id" => "14450",
				"product_post_id" => "14449",
				"_wp_attachment_metadata_id" => "153801",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "0127200502",
				"meta_thumbnail_id" => "153847",
				"image_post_id" => "14452",
				"product_post_id" => "14451",
				"_wp_attachment_metadata_id" => "153825",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435585888",
				"meta_thumbnail_id" => "153871",
				"image_post_id" => "14454",
				"product_post_id" => "14453",
				"_wp_attachment_metadata_id" => "153849",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "0427200501",
				"meta_thumbnail_id" => "153895",
				"image_post_id" => "14456",
				"product_post_id" => "14455",
				"_wp_attachment_metadata_id" => "153873",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "707310031884",
				"meta_thumbnail_id" => "153919",
				"image_post_id" => "14458",
				"product_post_id" => "14457",
				"_wp_attachment_metadata_id" => "153897",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "707310031662",
				"meta_thumbnail_id" => "153943",
				"image_post_id" => "14460",
				"product_post_id" => "14459",
				"_wp_attachment_metadata_id" => "153921",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "051221557354",
				"meta_thumbnail_id" => "153967",
				"image_post_id" => "14462",
				"product_post_id" => "14461",
				"_wp_attachment_metadata_id" => "153945",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "051221557309",
				"meta_thumbnail_id" => "153991",
				"image_post_id" => "14464",
				"product_post_id" => "14463",
				"_wp_attachment_metadata_id" => "153969",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "051221523038",
				"meta_thumbnail_id" => "154015",
				"image_post_id" => "14466",
				"product_post_id" => "14465",
				"_wp_attachment_metadata_id" => "153993",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "071662186708",
				"meta_thumbnail_id" => "154039",
				"image_post_id" => "14468",
				"product_post_id" => "14467",
				"_wp_attachment_metadata_id" => "154017",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "071662059064",
				"meta_thumbnail_id" => "154063",
				"image_post_id" => "14470",
				"product_post_id" => "14469",
				"_wp_attachment_metadata_id" => "154041",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "071662098520",
				"meta_thumbnail_id" => "154087",
				"image_post_id" => "14472",
				"product_post_id" => "14471",
				"_wp_attachment_metadata_id" => "154065",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "071662087036",
				"meta_thumbnail_id" => "154159",
				"image_post_id" => "14478",
				"product_post_id" => "14477",
				"_wp_attachment_metadata_id" => "154137",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "071662505042",
				"meta_thumbnail_id" => "154183",
				"image_post_id" => "14480",
				"product_post_id" => "14479",
				"_wp_attachment_metadata_id" => "154161",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "071662100803",
				"meta_thumbnail_id" => "154255",
				"image_post_id" => "14486",
				"product_post_id" => "14485",
				"_wp_attachment_metadata_id" => "154233",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "088107270021",
				"meta_thumbnail_id" => "154279",
				"image_post_id" => "14488",
				"product_post_id" => "14487",
				"_wp_attachment_metadata_id" => "154257",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "088359013216",
				"meta_thumbnail_id" => "154303",
				"image_post_id" => "14490",
				"product_post_id" => "14489",
				"_wp_attachment_metadata_id" => "154281",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "720362001254",
				"meta_thumbnail_id" => "154735",
				"image_post_id" => "14526",
				"product_post_id" => "14525",
				"_wp_attachment_metadata_id" => "154713",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "030674740643",
				"meta_thumbnail_id" => "154783",
				"image_post_id" => "14530",
				"product_post_id" => "14529",
				"_wp_attachment_metadata_id" => "154761",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "092633186909",
				"meta_thumbnail_id" => "156487",
				"image_post_id" => "14672",
				"product_post_id" => "14671",
				"_wp_attachment_metadata_id" => "156465",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "092633148501",
				"meta_thumbnail_id" => "156511",
				"image_post_id" => "14674",
				"product_post_id" => "14673",
				"_wp_attachment_metadata_id" => "156489",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "092633147306",
				"meta_thumbnail_id" => "156535",
				"image_post_id" => "14676",
				"product_post_id" => "14675",
				"_wp_attachment_metadata_id" => "156513",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "092633146309",
				"meta_thumbnail_id" => "156559",
				"image_post_id" => "14678",
				"product_post_id" => "14677",
				"_wp_attachment_metadata_id" => "156537",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "092633116500",
				"meta_thumbnail_id" => "156583",
				"image_post_id" => "14680",
				"product_post_id" => "14679",
				"_wp_attachment_metadata_id" => "156561",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "092633112106",
				"meta_thumbnail_id" => "156607",
				"image_post_id" => "14682",
				"product_post_id" => "14681",
				"_wp_attachment_metadata_id" => "156585",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "092633101100",
				"meta_thumbnail_id" => "156631",
				"image_post_id" => "14684",
				"product_post_id" => "14683",
				"_wp_attachment_metadata_id" => "156609",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "021196712232",
				"meta_thumbnail_id" => "156679",
				"image_post_id" => "14688",
				"product_post_id" => "14687",
				"_wp_attachment_metadata_id" => "156657",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "021196712164",
				"meta_thumbnail_id" => "156703",
				"image_post_id" => "14690",
				"product_post_id" => "14689",
				"_wp_attachment_metadata_id" => "156681",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "021196712140",
				"meta_thumbnail_id" => "156727",
				"image_post_id" => "14692",
				"product_post_id" => "14691",
				"_wp_attachment_metadata_id" => "156705",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "021196711204",
				"meta_thumbnail_id" => "156751",
				"image_post_id" => "14694",
				"product_post_id" => "14693",
				"_wp_attachment_metadata_id" => "156729",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "021196711266",
				"meta_thumbnail_id" => "156775",
				"image_post_id" => "14696",
				"product_post_id" => "14695",
				"_wp_attachment_metadata_id" => "156753",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "021196711259",
				"meta_thumbnail_id" => "156799",
				"image_post_id" => "14698",
				"product_post_id" => "14697",
				"_wp_attachment_metadata_id" => "156777",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "021196711211",
				"meta_thumbnail_id" => "156823",
				"image_post_id" => "14700",
				"product_post_id" => "14699",
				"_wp_attachment_metadata_id" => "156801",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "021196051171",
				"meta_thumbnail_id" => "156847",
				"image_post_id" => "14702",
				"product_post_id" => "14701",
				"_wp_attachment_metadata_id" => "156825",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "021196347526",
				"meta_thumbnail_id" => "156871",
				"image_post_id" => "14704",
				"product_post_id" => "14703",
				"_wp_attachment_metadata_id" => "156849",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "021196347427",
				"meta_thumbnail_id" => "156895",
				"image_post_id" => "14706",
				"product_post_id" => "14705",
				"_wp_attachment_metadata_id" => "156873",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "021196347120",
				"meta_thumbnail_id" => "156919",
				"image_post_id" => "14708",
				"product_post_id" => "14707",
				"_wp_attachment_metadata_id" => "156897",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "978185669979",
				"meta_thumbnail_id" => "156943",
				"image_post_id" => "14710",
				"product_post_id" => "14709",
				"_wp_attachment_metadata_id" => "156921",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "978185669959",
				"meta_thumbnail_id" => "156967",
				"image_post_id" => "14712",
				"product_post_id" => "14711",
				"_wp_attachment_metadata_id" => "156945",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "978185669946",
				"meta_thumbnail_id" => "156991",
				"image_post_id" => "14714",
				"product_post_id" => "14713",
				"_wp_attachment_metadata_id" => "156969",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "978178067488",
				"meta_thumbnail_id" => "157015",
				"image_post_id" => "14716",
				"product_post_id" => "14715",
				"_wp_attachment_metadata_id" => "156993",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "978081187122",
				"meta_thumbnail_id" => "157039",
				"image_post_id" => "14718",
				"product_post_id" => "14717",
				"_wp_attachment_metadata_id" => "157017",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "978178067106",
				"meta_thumbnail_id" => "157063",
				"image_post_id" => "14720",
				"product_post_id" => "14719",
				"_wp_attachment_metadata_id" => "157041",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "978178067011",
				"meta_thumbnail_id" => "157087",
				"image_post_id" => "14722",
				"product_post_id" => "14721",
				"_wp_attachment_metadata_id" => "157065",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "458946983295",
				"meta_thumbnail_id" => "157183",
				"image_post_id" => "14730",
				"product_post_id" => "14729",
				"_wp_attachment_metadata_id" => "157161",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "693280241717",
				"meta_thumbnail_id" => "157207",
				"image_post_id" => "14732",
				"product_post_id" => "14731",
				"_wp_attachment_metadata_id" => "157185",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "695634661279",
				"meta_thumbnail_id" => "157231",
				"image_post_id" => "14734",
				"product_post_id" => "14733",
				"_wp_attachment_metadata_id" => "157209",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "079946050004",
				"meta_thumbnail_id" => "157279",
				"image_post_id" => "14738",
				"product_post_id" => "14737",
				"_wp_attachment_metadata_id" => "157257",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "370041795097",
				"meta_thumbnail_id" => "157447",
				"image_post_id" => "14752",
				"product_post_id" => "14751",
				"_wp_attachment_metadata_id" => "157425",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "085593101013",
				"meta_thumbnail_id" => "157615",
				"image_post_id" => "14766",
				"product_post_id" => "14765",
				"_wp_attachment_metadata_id" => "157593",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "647020213319",
				"meta_thumbnail_id" => "157639",
				"image_post_id" => "14768",
				"product_post_id" => "14767",
				"_wp_attachment_metadata_id" => "157617",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "071617681012",
				"meta_thumbnail_id" => "157663",
				"image_post_id" => "14770",
				"product_post_id" => "14769",
				"_wp_attachment_metadata_id" => "157641",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435160283",
				"meta_thumbnail_id" => "157807",
				"image_post_id" => "14782",
				"product_post_id" => "14781",
				"_wp_attachment_metadata_id" => "157785",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435160276",
				"meta_thumbnail_id" => "157831",
				"image_post_id" => "14784",
				"product_post_id" => "14783",
				"_wp_attachment_metadata_id" => "157809",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435160269",
				"meta_thumbnail_id" => "157855",
				"image_post_id" => "14786",
				"product_post_id" => "14785",
				"_wp_attachment_metadata_id" => "157833",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435160252",
				"meta_thumbnail_id" => "157879",
				"image_post_id" => "14788",
				"product_post_id" => "14787",
				"_wp_attachment_metadata_id" => "157857",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435030456",
				"meta_thumbnail_id" => "158167",
				"image_post_id" => "14812",
				"product_post_id" => "14811",
				"_wp_attachment_metadata_id" => "158145",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "LELM723M",
				"meta_thumbnail_id" => "158335",
				"image_post_id" => "14826",
				"product_post_id" => "14825",
				"_wp_attachment_metadata_id" => "158313",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435720012",
				"meta_thumbnail_id" => "158359",
				"image_post_id" => "14828",
				"product_post_id" => "14827",
				"_wp_attachment_metadata_id" => "158337",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435711485",
				"meta_thumbnail_id" => "158383",
				"image_post_id" => "14830",
				"product_post_id" => "14829",
				"_wp_attachment_metadata_id" => "158361",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435711409",
				"meta_thumbnail_id" => "158407",
				"image_post_id" => "14832",
				"product_post_id" => "14831",
				"_wp_attachment_metadata_id" => "158385",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435711393",
				"meta_thumbnail_id" => "158431",
				"image_post_id" => "14834",
				"product_post_id" => "14833",
				"_wp_attachment_metadata_id" => "158409",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435711362",
				"meta_thumbnail_id" => "158455",
				"image_post_id" => "14836",
				"product_post_id" => "14835",
				"_wp_attachment_metadata_id" => "158433",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435711300",
				"meta_thumbnail_id" => "158479",
				"image_post_id" => "14838",
				"product_post_id" => "14837",
				"_wp_attachment_metadata_id" => "158457",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435711287",
				"meta_thumbnail_id" => "158503",
				"image_post_id" => "14840",
				"product_post_id" => "14839",
				"_wp_attachment_metadata_id" => "158481",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435711263",
				"meta_thumbnail_id" => "158527",
				"image_post_id" => "14842",
				"product_post_id" => "14841",
				"_wp_attachment_metadata_id" => "158505",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435711249",
				"meta_thumbnail_id" => "158551",
				"image_post_id" => "14844",
				"product_post_id" => "14843",
				"_wp_attachment_metadata_id" => "158529",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435711225",
				"meta_thumbnail_id" => "158575",
				"image_post_id" => "14846",
				"product_post_id" => "14845",
				"_wp_attachment_metadata_id" => "158553",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435711201",
				"meta_thumbnail_id" => "158599",
				"image_post_id" => "14848",
				"product_post_id" => "14847",
				"_wp_attachment_metadata_id" => "158577",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435711188",
				"meta_thumbnail_id" => "158623",
				"image_post_id" => "14850",
				"product_post_id" => "14849",
				"_wp_attachment_metadata_id" => "158601",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435711164",
				"meta_thumbnail_id" => "158647",
				"image_post_id" => "14852",
				"product_post_id" => "14851",
				"_wp_attachment_metadata_id" => "158625",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435711157",
				"meta_thumbnail_id" => "158671",
				"image_post_id" => "14854",
				"product_post_id" => "14853",
				"_wp_attachment_metadata_id" => "158649",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435711140",
				"meta_thumbnail_id" => "158695",
				"image_post_id" => "14856",
				"product_post_id" => "14855",
				"_wp_attachment_metadata_id" => "158673",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435711119",
				"meta_thumbnail_id" => "158719",
				"image_post_id" => "14858",
				"product_post_id" => "14857",
				"_wp_attachment_metadata_id" => "158697",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435711102",
				"meta_thumbnail_id" => "158743",
				"image_post_id" => "14860",
				"product_post_id" => "14859",
				"_wp_attachment_metadata_id" => "158721",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435711096",
				"meta_thumbnail_id" => "158767",
				"image_post_id" => "14862",
				"product_post_id" => "14861",
				"_wp_attachment_metadata_id" => "158745",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435711089",
				"meta_thumbnail_id" => "158791",
				"image_post_id" => "14864",
				"product_post_id" => "14863",
				"_wp_attachment_metadata_id" => "158769",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435070087",
				"meta_thumbnail_id" => "158959",
				"image_post_id" => "14878",
				"product_post_id" => "14877",
				"_wp_attachment_metadata_id" => "158937",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435070025",
				"meta_thumbnail_id" => "158983",
				"image_post_id" => "14880",
				"product_post_id" => "14879",
				"_wp_attachment_metadata_id" => "158961",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435470085",
				"meta_thumbnail_id" => "161119",
				"image_post_id" => "15058",
				"product_post_id" => "15057",
				"_wp_attachment_metadata_id" => "161097",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435462219",
				"meta_thumbnail_id" => "161143",
				"image_post_id" => "15060",
				"product_post_id" => "15059",
				"_wp_attachment_metadata_id" => "161121",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435461137",
				"meta_thumbnail_id" => "161167",
				"image_post_id" => "15062",
				"product_post_id" => "15061",
				"_wp_attachment_metadata_id" => "161145",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435461120",
				"meta_thumbnail_id" => "161191",
				"image_post_id" => "15064",
				"product_post_id" => "15063",
				"_wp_attachment_metadata_id" => "161169",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435461113",
				"meta_thumbnail_id" => "161215",
				"image_post_id" => "15066",
				"product_post_id" => "15065",
				"_wp_attachment_metadata_id" => "161193",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435461106",
				"meta_thumbnail_id" => "161239",
				"image_post_id" => "15068",
				"product_post_id" => "15067",
				"_wp_attachment_metadata_id" => "161217",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435461045",
				"meta_thumbnail_id" => "161263",
				"image_post_id" => "15070",
				"product_post_id" => "15069",
				"_wp_attachment_metadata_id" => "161241",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435461007",
				"meta_thumbnail_id" => "161287",
				"image_post_id" => "15072",
				"product_post_id" => "15071",
				"_wp_attachment_metadata_id" => "161265",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435404103",
				"meta_thumbnail_id" => "161359",
				"image_post_id" => "15078",
				"product_post_id" => "15077",
				"_wp_attachment_metadata_id" => "161337",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435403007",
				"meta_thumbnail_id" => "161383",
				"image_post_id" => "15080",
				"product_post_id" => "15079",
				"_wp_attachment_metadata_id" => "161361",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435401003",
				"meta_thumbnail_id" => "161407",
				"image_post_id" => "15082",
				"product_post_id" => "15081",
				"_wp_attachment_metadata_id" => "161385",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435272207",
				"meta_thumbnail_id" => "161575",
				"image_post_id" => "15096",
				"product_post_id" => "15095",
				"_wp_attachment_metadata_id" => "161553",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435271972",
				"meta_thumbnail_id" => "161599",
				"image_post_id" => "15098",
				"product_post_id" => "15097",
				"_wp_attachment_metadata_id" => "161577",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435271552",
				"meta_thumbnail_id" => "161671",
				"image_post_id" => "15104",
				"product_post_id" => "15103",
				"_wp_attachment_metadata_id" => "161649",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435201900",
				"meta_thumbnail_id" => "161743",
				"image_post_id" => "15110",
				"product_post_id" => "15109",
				"_wp_attachment_metadata_id" => "161721",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435201504",
				"meta_thumbnail_id" => "161767",
				"image_post_id" => "15112",
				"product_post_id" => "15111",
				"_wp_attachment_metadata_id" => "161745",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435183015",
				"meta_thumbnail_id" => "161935",
				"image_post_id" => "15126",
				"product_post_id" => "15125",
				"_wp_attachment_metadata_id" => "161913",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435182018",
				"meta_thumbnail_id" => "161959",
				"image_post_id" => "15128",
				"product_post_id" => "15127",
				"_wp_attachment_metadata_id" => "161937",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435179827",
				"meta_thumbnail_id" => "162031",
				"image_post_id" => "15134",
				"product_post_id" => "15133",
				"_wp_attachment_metadata_id" => "162009",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435179704",
				"meta_thumbnail_id" => "162151",
				"image_post_id" => "15144",
				"product_post_id" => "15143",
				"_wp_attachment_metadata_id" => "162129",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435177243",
				"meta_thumbnail_id" => "162631",
				"image_post_id" => "15184",
				"product_post_id" => "15183",
				"_wp_attachment_metadata_id" => "162609",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435177106",
				"meta_thumbnail_id" => "162655",
				"image_post_id" => "15186",
				"product_post_id" => "15185",
				"_wp_attachment_metadata_id" => "162633",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435176420",
				"meta_thumbnail_id" => "162751",
				"image_post_id" => "15194",
				"product_post_id" => "15193",
				"_wp_attachment_metadata_id" => "162729",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435176000",
				"meta_thumbnail_id" => "162775",
				"image_post_id" => "15196",
				"product_post_id" => "15195",
				"_wp_attachment_metadata_id" => "162753",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435175959",
				"meta_thumbnail_id" => "162823",
				"image_post_id" => "15200",
				"product_post_id" => "15199",
				"_wp_attachment_metadata_id" => "162801",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435173450",
				"meta_thumbnail_id" => "162967",
				"image_post_id" => "15212",
				"product_post_id" => "15211",
				"_wp_attachment_metadata_id" => "162945",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435173061",
				"meta_thumbnail_id" => "163039",
				"image_post_id" => "15218",
				"product_post_id" => "15217",
				"_wp_attachment_metadata_id" => "163017",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435173023",
				"meta_thumbnail_id" => "163063",
				"image_post_id" => "15220",
				"product_post_id" => "15219",
				"_wp_attachment_metadata_id" => "163041",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435173009",
				"meta_thumbnail_id" => "163111",
				"image_post_id" => "15224",
				"product_post_id" => "15223",
				"_wp_attachment_metadata_id" => "163089",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435165011",
				"meta_thumbnail_id" => "163279",
				"image_post_id" => "15238",
				"product_post_id" => "15237",
				"_wp_attachment_metadata_id" => "163257",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435162010",
				"meta_thumbnail_id" => "163303",
				"image_post_id" => "15240",
				"product_post_id" => "15239",
				"_wp_attachment_metadata_id" => "163281",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435073538",
				"meta_thumbnail_id" => "163447",
				"image_post_id" => "15252",
				"product_post_id" => "15251",
				"_wp_attachment_metadata_id" => "163425",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435083902",
				"meta_thumbnail_id" => "163471",
				"image_post_id" => "15254",
				"product_post_id" => "15253",
				"_wp_attachment_metadata_id" => "163449",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435048758",
				"meta_thumbnail_id" => "163495",
				"image_post_id" => "15256",
				"product_post_id" => "15255",
				"_wp_attachment_metadata_id" => "163473",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435093079",
				"meta_thumbnail_id" => "163519",
				"image_post_id" => "15258",
				"product_post_id" => "15257",
				"_wp_attachment_metadata_id" => "163497",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435156118",
				"meta_thumbnail_id" => "163615",
				"image_post_id" => "15266",
				"product_post_id" => "15265",
				"_wp_attachment_metadata_id" => "163593",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435156019",
				"meta_thumbnail_id" => "163639",
				"image_post_id" => "15268",
				"product_post_id" => "15267",
				"_wp_attachment_metadata_id" => "163617",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435155005",
				"meta_thumbnail_id" => "163735",
				"image_post_id" => "15276",
				"product_post_id" => "15275",
				"_wp_attachment_metadata_id" => "163713",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435154664",
				"meta_thumbnail_id" => "163807",
				"image_post_id" => "15282",
				"product_post_id" => "15281",
				"_wp_attachment_metadata_id" => "163785",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435154183",
				"meta_thumbnail_id" => "163831",
				"image_post_id" => "15284",
				"product_post_id" => "15283",
				"_wp_attachment_metadata_id" => "163809",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435154107",
				"meta_thumbnail_id" => "163855",
				"image_post_id" => "15286",
				"product_post_id" => "15285",
				"_wp_attachment_metadata_id" => "163833",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435154084",
				"meta_thumbnail_id" => "163879",
				"image_post_id" => "15288",
				"product_post_id" => "15287",
				"_wp_attachment_metadata_id" => "163857",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435003719",
				"meta_thumbnail_id" => "163903",
				"image_post_id" => "15290",
				"product_post_id" => "15289",
				"_wp_attachment_metadata_id" => "163881",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435002002",
				"meta_thumbnail_id" => "163927",
				"image_post_id" => "15292",
				"product_post_id" => "15291",
				"_wp_attachment_metadata_id" => "163905",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435135007",
				"meta_thumbnail_id" => "163999",
				"image_post_id" => "15298",
				"product_post_id" => "15297",
				"_wp_attachment_metadata_id" => "163977",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435134512",
				"meta_thumbnail_id" => "164023",
				"image_post_id" => "15300",
				"product_post_id" => "15299",
				"_wp_attachment_metadata_id" => "164001",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435134222",
				"meta_thumbnail_id" => "164047",
				"image_post_id" => "15302",
				"product_post_id" => "15301",
				"_wp_attachment_metadata_id" => "164025",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435134192",
				"meta_thumbnail_id" => "164071",
				"image_post_id" => "15304",
				"product_post_id" => "15303",
				"_wp_attachment_metadata_id" => "164049",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435134109",
				"meta_thumbnail_id" => "164095",
				"image_post_id" => "15306",
				"product_post_id" => "15305",
				"_wp_attachment_metadata_id" => "164073",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435133065",
				"meta_thumbnail_id" => "164119",
				"image_post_id" => "15308",
				"product_post_id" => "15307",
				"_wp_attachment_metadata_id" => "164097",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435743271",
				"meta_thumbnail_id" => "164143",
				"image_post_id" => "15310",
				"product_post_id" => "15309",
				"_wp_attachment_metadata_id" => "164121",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435133003",
				"meta_thumbnail_id" => "164167",
				"image_post_id" => "15312",
				"product_post_id" => "15311",
				"_wp_attachment_metadata_id" => "164145",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435132198",
				"meta_thumbnail_id" => "164191",
				"image_post_id" => "15314",
				"product_post_id" => "15313",
				"_wp_attachment_metadata_id" => "164169",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435132129",
				"meta_thumbnail_id" => "164215",
				"image_post_id" => "15316",
				"product_post_id" => "15315",
				"_wp_attachment_metadata_id" => "164193",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435132037",
				"meta_thumbnail_id" => "164239",
				"image_post_id" => "15318",
				"product_post_id" => "15317",
				"_wp_attachment_metadata_id" => "164217",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435130156",
				"meta_thumbnail_id" => "164263",
				"image_post_id" => "15320",
				"product_post_id" => "15319",
				"_wp_attachment_metadata_id" => "164241",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435130125",
				"meta_thumbnail_id" => "164287",
				"image_post_id" => "15322",
				"product_post_id" => "15321",
				"_wp_attachment_metadata_id" => "164265",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435130118",
				"meta_thumbnail_id" => "164311",
				"image_post_id" => "15324",
				"product_post_id" => "15323",
				"_wp_attachment_metadata_id" => "164289",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

			array(
				"upc" => "082435125008",
				"meta_thumbnail_id" => "164335",
				"image_post_id" => "15326",
				"product_post_id" => "15325",
				"_wp_attachment_metadata_id" => "164313",
				"_wp_attached_file_id" => "FIND based on post_id value like 2020/05/images-tb-56555.jpg",
			),

		);

	}
}
