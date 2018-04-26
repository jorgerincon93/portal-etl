<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
ini_set('max_execution_time', 900);
define('COMPONENTS_PATH', '../componentes/');
define('LIB_PATH', '../../libraries/');
define('CLASSES_PATH', '../../libraries/classes/');
define('MASIVOS_PATH', 'archivos/');

require_once(CLASSES_PATH . 'DatabaseMySQL.php');
require_once(CLASSES_PATH . 'BDControlador.php');
require_once(CLASSES_PATH . 'reglas.php');

$db = Database::getInstance(array('localhost', 'meiko', 'meiko', 'meiko'));


echo "INICIO: " . date('Y-m-d h:i:s A ') . "\n";

$arregloRegistros = '20110,79278,120166,20107,19595,80843,80852,80840,80837,80839,80850,80845,80842,20116,80838,20113,20102,20105,80854,20103,20114,20106,80853,80855,20115,80849,20109,20112,80848,80844,20111,80847,80841,80846,80851,20108,20104,63516,102609,62707,89528,100616,63213,110044,84816,88353,83013,102252,102606,73219,55498,63429,56350,56399,76941,110404,78889,102322,105318,60768,38958,67998,52122,59549,66513,65448,17435,48720,60000,31342,27662,67084,1930,70606,38536,64015,64158,68177,8922,38009,57439,56428,55914,1438,14090,7024,57954,13639,13634,39012,17587,28450,25240,23818,6731,11888,8681,6406,44406,42879,12922,10806,10798,7178,21345,45799,1143,40151,1145,39597,42882,42335,42884,44313,2995,10033,23848,7717,29518,48196,47034,2086,1138,2092,2095,49739,7740,44337,44321,1777,6047,2595,25226,5670,5686,11197,52904,14859,5113,2601,5110,51455,4522,3547,51959,51960,50250,10989,10796,10805,10998,5707,4511,32252,52901,3008,48162,58543,54255,57445,28899,1646,26548,7335,45805,28916,32238,59648,32240,17580,25741,25744,27657,27038,12241,17002,17291,58569,15567,60116,60112,13638,13650,27019,41871,5668,2802,46538,45949,50266,31632,3630,313,11207,17838,17292,15574,50234,34408,10999,17836,60107,27066,41858,50276,7025,32233,50850,45803,2762,1441,43823,20242,19254,2774,50860,1447,44341,50848,51469,47043,14411,51775,41865,2777,13806,14101,14102,14409,5244,50876,46532,12242,17588,33671,29940,24572,331,33187,20229,25825,41856,56426,6057,34407,50232,33186,2769,35686,27937,40595,45483,33829,3633,20249,41862,24240,24239,24566,56423,47487,3639,10032,10283,10294,25227,25241,20739,12914,24258,12236,20760,12550,57435,40597,18627,18629,18633,33832,1439,1323,18961,18969,9756,18965,18971,32231,1749,4060,24260,22878,40593,18964,4061,1148,9737,13661,13645,12920,12921,12918,13646,29869,31747,20254,25726,20730,17298,59641,20243,29525,8678,21342,58562,24267,54858,55909,8147,12545,18631,8325,16644,18619,11383,6738,40153,25225,8925,9291,18967,48722,23839,12252,18988,48174,5697,55203,52924,16630,7752,45806,9748,35252,4512,6399,10795,47048,18972,14821,18985,5663,8334,11895,46536,53442,18158,5702,5691,7747,7745,8650,16092,12928,33673,28456,8648,12237,12926,12925,17000,16634,17003,14091,13643,10800,15786,18956,47123,17840,4071,37450,3538,12547,8161,18978,4871,45937,10039,10791,649,332,8632,5693,11275,27931,12554,6055,14826,6387,9295,8923,8688,15231,14104,38006,30957,29970,30949,29506,32914,29516,29515,6726,38008,16037,15794,32259,15230,10793,41129,28447,26549,27936,60425,32258,58559,9296,25727,27027,19252,12552,27052,28452,30463,27033,22880,23808,19521,7177,21350,19519,19257,6725,22334,2097,32244,20735,20750,49219,21329,10994,41575,8151,7328,7030,22879,8671,1136,13653,48184,48719,48724,8683,8661,7337,16629,14628,18647,30925,7032,16639,28463,19528,6407,18962,60101,24570,9309,51461,33180,8927,29519,30958,25237,24254,24253,24244,40156,4513,16039,4196,4195,325,319,318,330,9303,4524,29517,39013,1770,312,1628,32261,17599,17289,57950,50304,3535,24583,5246,4807,10792,6409,36757,6734,4062,2985,50857,25833,17596,45478,17005,1769,16631,20092,60424,1644,59642,26175,17593,17589,7039,7331,17701,25822,5718,4872,38013,10331,7719,7738,23823,24571,24251,28913,5250,41880,35248,27029,20094,6056,10678,6729,27072,7751,8144,31242,2088,18636,60115,35260,16635,8165,28455,59097,45122,58544,38685,17590,17592,5688,45934,27652,41863,37443,11904,9304,9754,9747,8337,8652,8335,17584,27655,10672,27045,11223,10692,3640,17010,17722,15228,50273,315,44330,41860,26546,24569,29529,24279,23822,27928,15575,15212,33184,31749,33834,30938,10808,21331,22872,47969,27935,17011,50852,51459,21354,9743,9738,9741,27949,6411,5674,27054,50253,13804,14415,50320,50843,50827,24277,24283,9293,30933,25238,11902,33831,20097,30939,27933,9308,30943,30951,20247,15218,30942,28915,20737,29971,29965,30466,21326,11204,28905,20727,28906,50830,51446,35247,23816,1244,14822,54921,24564,12553,14824,51961,30457,15571,9316,8332,49740,27943,8140,8166,16216,9305,18155,17581,58555,25835,25823,25743,59083,9314,8929,5714,3646,12249,2763,50836,49220,41145,25828,56923,4072,57438,57437,57440,11889,10037,45514,12243,47966,3652,48159,26544,54258,11887,22882,5723,50262,50287,12238,45807,46541,2221,10995,14404,8163,53446,36120,12903,15221,21349,29858,29511,15214,3536,2983,15211,18164,648,30465,14869,26553,19523,27051,24575,24579,24584,15572,18638,39008,45120,1642,1442,1619,1443,49213,1633,1640,47037,53434,52920,41853,39010,24568,30954,31241,3554,24269,30936,23845,24582,30928,30953,20100,21333,20236,30930,29881,26172,14863,28910,25820,12792,54265,53447,39263,10038,3868,3867,47960,51777,40592,1773,4192,3858,41879,47968,3649,51773,10031,16040,52350,52922,38004,6052,32254,20757,47971,49212,47965,49216,5245,29891,2998,10804,41138,14817,8338,42886,56421,59086,40160,12246,28658,50866,29507,17837,6736,44325,6392,7329,2098,45794,32912,17012,17293,17582,17585,47963,25745,25735,16068,25819,2590,4197,9294,27654,50839,9753,15569,41134,14413,58550,33835,18981,44314,40138,59099,40142,32919,41855,54262,35250,25827,25832,55912,50289,3552,3549,46423,66483,73998,69382,120089,81994,75002,73028,80736,103921,69869,69072,65072,78874,59908,96234,100155,112246,96492,106151,120477,44080,23924,55684,102392,119791,63191,69511,120446,120492,63524,70230,16191,65197,12809,106424,120480,120613,7622,121697,123325,122226,122228,65903,65901,84916,57665,65907,46825,67786,10296,124093,67977,112470,62918,124058,123983,124003,123986,44858,41131,106525,96012,94649,77565,66102,123993,69989,24256,17591,17597,33833,49594,79063,124095,1774,77158,75224,95170,113142,124006,122136,122107,60679,87343,66424,39985,51012,60030,63404,117145,54002,10176,68889,77287,109635,86861,62930,1320,61512,123880,84013,111736,6727,1444,47035,74255,81779,65962,65608,66722,123999,103117,32616,56267,95144,68250,69983,62072,36774,62064,124014,69078,72163,27951,62054,3841,70403,68259,77145,63254,66699,3557,81931,69044,119969,27020,17699,63270,50239,101804,62050,81058,51922,81691,74189,50272,111592,42596,66481,29413,123197,76639,110591,66556,64673,82404,67305,23825,63925,83977,50290,67793,67789,112798,68264,12919,63259,12233,16641,20758,18162,30462,23841,123984,124001,38002,69055,103525,62058,107058,88212,10802,26379,9744,57678,97908,9302,67806,46535,17583,8330,67294,67273,61267,29509,65587,100788,110569,124000,124005,64488,29972,114618,51250,85355,86851,66154,7029,58532,123994,84058,6054,10685,3556,7042,10686,69050,76877,15791,3651,14856,97963,54252,50311,50313,50264,15223,95153,82715,58792,76902,112968,84020,74115,3864,71888,9312,14862,68258,3641,81304,18228,61038,87452,87472,68234,83262,51897,67167,52708,71595,116722,56823,29420,43645,47425,4802,25646,15472,71739,120999,9697,61980,61401,122158,122250,35581,64967,64326,49426,63267,78373,10991,53441,27024,80011,122319,67297,70412,86844,71652,68241,50855,39014,69979,49736,10803,39007,67784,66680,44318,44323,67283,2772,2781,66703,72773,53435,49221,67304,2770,5141,57951,11314,61513,63256,46539,11205,3642,73276,121056,75562,15224,39595,81715,61032,20746,75201,18987,61036,18979,81300,23834,9310,97932,59646,79772,20235,12660,80511,37448,18643,48723,38691,8326,1245,64995,50845,65654,65584,123992,8158,16632,25731,1322,122320,97922,39596,5114,97925,103590,109920,4068,27669,110886,20723,11254,19253,10694,39005,69067,67271,7041,14103,27058,70409,119011,12911,8770,68247,12549,118322,8638,17300,10988,71858,2990,7749,109882,20252,2811,124009,124013,124022,16042,107470,78372,113581,25821,11255,84025,7332,2588,32829,67275,8159,18977,22875,51471,10030,12653,66682,17013,4077,44327,23832,69990,23820,16642,49217,906,18960,111340,61048,14627,81796,27065,27068,5258,61040,75559,80019,51963,61039,63884,66719,109877,62914,73260,69998,25732,28902,62938,63913,78846,65005,14092,11903,69976,25830,18650,97978,65579,2807,2226,2790,65641,65663,65573,65600,2765,4874,3643,2779,4518,48728,4519,4516,45125,69789,52913,44332,1139,84005,7334,26174,8172,11894,69980,52910,108262,65586,104990,25733,20240,124067,113126,114638,13802,108934,12546,107365,108592,101753,41136,13657,113128,69073,3005,116419,112672,107476,25728,3387,19255,322,60346,60518,45485,8686,15793,323,14866,50322,35688,117349,11384,3648,17594,17598,65575,13655,97902,102929,84613,80250,66490,34412,1141,45792,66678,66155,45940,69043,62413,53437,53438,50285,52121,62037,48729,47964,50825,47330,51450,23804,5679,11893,5721,123990,2793,5248,14819,25834,103131,32921,9300,11386,17014,64998,15577,4074,87488,87483,26547,25228,55916,29527,29911,76005,61525,65001,8333,103928,112665,112668,22874,119544,77542,41147,95140,115531,57949,53281,45928,41851,43828,61510,110352,2602,4190,27929,64495,110589,71875,4806,32235,9292,27946,69053,13662,66713,66143,61461,18742,120476,84070,78369,71113,65601,67787,64500,6404,28459,103104,15576,4067,11195,314,4870,3863,69987,31748,25829,107791,50280,69051,27661,43826,26555,86822,50236,58566,2096,83997,2748,62063,86769,2758,50841,69048,67281,34413,86835,47331,62053,35681,21352,73271,80020,16218,1625,15213,3635,20744,18983,116944,24246,23827,12916,20093,114955,41143,1775,77567,77561,20099,4189,77140,18153,77170,52906,14096,77549,18617,10799,16640,16217,97958,328,1140,113576,1436,6396,27675,101133,67790,18984,45512,11218,97928,11191,11890,68243,28900,6049,16219,66141,10287,1778,103108,25730,21322,25737,25734,909,29966,84048,2217,84040,87477,7033,84112,28898,86799,27677,27671,50267,63255,4873,70000,62040,10297,69996,27938,15792,61049,24565,62960,27950,32916,61507,6405,72774,65877,116412,29975,28465,12655,29528,29524,77168,15222,75205,63897,28908,50302,9752,3862,14818,14461,18980,68254,67723,8485,73278,14418,51457,10996,4065,64498,41140,5116,15215,15787,113705,45789,44329,16222,54862,30461,95172,109893,78106,110864,106522,2091,25230,24573,108260,122321,34410,9990,109492,17296,110247,62046,63899,72396,50241,16224,27031,21336,102782,63922,105567,67066,4066,110584,73258,77150,77154,73262,53353,32917,33182,61047,2224,66146,51475,50255,16044,51468,51478,67274,19260,11900,32249,95161,107051,18165,5251,48165,5683,78841,16638,17834,7326,27941,111338,29947,28904,103124,11216,13803,12909,5709,67788,4064,67302,74420,69988,62061,72171,2804';

actualizarLog(500, 1702, 62, 'Ejecutando Reglas');
ejecutarReglasCargaMasiva($arregloRegistros);
actualizarLog(500, 1702, 62, 'Procesado');

function actualizarLog($id, $filas, $columnas, $estado) {
    global $db;
    $query = "UPDATE calidad.logcargamasiva SET "
            . "fechaProceso = now(), "
            . "filas = " . $filas . ", "
            . "columnas = " . $columnas . ", "
            . "estado = '" . $estado . "' "
            . "WHERE id=" . $id;

    $db->query($query);
}


?>