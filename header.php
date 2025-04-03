<?php
$json_raw = file_get_contents($back . 'include/json/language.json');
$lang_php = json_decode($json_raw, TRUE);

if (!isset($lang)) {
    $lang = 'es';
}
if ($lang == 'es') {
    $_url_php = $url;
} else {
    $_url_php = $enurl;
}
include_once($back . 'include/php/motores.php');

function buscarPais()
{
    $array_mx = [
        '45.232.254.38',
        '187.188.148.239',
        '177.227.20.55',
        '45.232.255.178',
        '200.68.139.',
        '207.46.13.1',
        '216.56.36.115',
        '187.139.215.52',
        '200.68.129.',
        '200.68.138.',
        '200.68.141.',
        '200.68.146.',
        '200.68.159.',
        '200.68.166.',
        '200.68.167.',
        '200.68.175.',
    ];
    $array_no_mx = [
        "3.224.220.101",
        "3.19.75.166",
        "52.70.240.171",
        "23.22.35.162",
        "107.77.228.166",
        '51.222.253.',
        '114.119.1',
        '185.191.171.',
        '85.208.98.',
        '17.121.11',
        '54.174.5',
        '77.88.5.',
        '77.75.7',
        '31.13.127.',
        '148.251.1',
        '144.76.',
        '107.148.162.',
        '119.13.',
        '119.12.',
        '168.151.',
        '150.158.130.124',
        '99.44.99.246',
        '88.198.33.145',
        '5.9.66.153',
        '5.9.156.20',
        '157.55.39.',
        '40.77.190.',
        '193.186.4.45'
    ];

    $ip_public = $_SERVER['REMOTE_ADDR'];
    $ip_mx = false;
    $ip_no_mx = false;
    for ($i = 0; $i < count($array_mx); $i++) {
        if (strpos($ip_public, $array_mx[$i]) !== false) {
            $ip_mx = true;
            break;
        }
    }
    if (!$ip_mx) {
        for ($i = 0; $i < count($array_no_mx); $i++) {
            if (strpos($ip_public, $array_no_mx[$i]) !== false) {
                $ip_no_mx = true;
                break;
            }
        }
    }
    if ($_SERVER['SERVER_NAME'] != 'localhost' && !$ip_mx) {
        if (!$ip_no_mx) {
            // $api_key = '9abyjxt4wq3muu62';
            // $resultsAPI = "http://api.ipregistry.co/" . $ip_public . "?key=" . $api_key . "&fields=location.country.code";
            // $curl = curl_init();
            // curl_setopt($curl, CURLOPT_URL, $resultsAPI);
            // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            // curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json;api_version=2'));
            // $resp = curl_exec($curl);
            // curl_close($curl);
            $apiKey = 'qms4v0vv426g440a';
            $url = "https://api.ipregistry.co/$ip_public?key=$apiKey&fields=location.country.code";
            $response = file_get_contents($url);
            if ($response) {
                $data = json_decode($response, true);
            }
            $results = $data['location'];
            $pais = (isset($results['country']['code'])) ? $results['country']['code'] : 'NO-MX';
            $api = (isset($results['country']['code'])) ? $results['country']['code'] : 'FULL';
        } else {
            $pais = 'NO-MX';
        }
    } else {
        $pais = 'MX';
    }

    if ($pais == 'MX') {
        setcookie("coun", 'MX', strtotime('+60 days'), '/', $_SERVER['SERVER_NAME']);
    } else {
        setcookie("coun", 'NO-MX', strtotime('+30 days'), '/', $_SERVER['SERVER_NAME']);
    }
}

if (!isset($_COOKIE['ControlCookie'])) {
    setcookie("ControlCookie", "1", strtotime('+1 day'), '/', $_SERVER['SERVER_NAME']);
    echo '<script>location.reload();</script>';
}
if (!isset($_COOKIE['coun'])) {
    buscarPais();
    buscarMotor();
} else {
    buscarMotor();
}
if ($_COOKIE['ControlCookie'] == '1') {
    if ($_COOKIE['coun'] == "NO-MX" && (!isset($lang) || $lang != 'en')) {
        setcookie("ControlCookie", "2", strtotime('+1 day'), '/', $_SERVER['SERVER_NAME']);
        echo '<script>window.location.replace("' . URL . '/en/");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-TGGTGGL');
    </script>
    <!-- End Google Tag Manager -->

    <meta charset="utf-8">
    <title><?php echo !isset($title) ? "Hard Rock Hotel Guadalajara" : $title . " - Hard Rock Hotel Guadalajara"; ?> | <?php echo $lang_php[$lang]['extra_title'] ?></title>
    <meta name="description" content="<?= $lang_php[$lang]['meta_description'] ?>">
    <meta name="keywords" content="hard rock hotel guadalajara, guadalajara hard rock, guadalajara resorts, guadalajara hotels">
    <link rel="stylesheet" type="text/css" href="https://www.vizergy.com/assets/daterangepicker/daterangepicker.min.css">
    <script type="text/javascript" src="https://www.vizergy.com/assets/daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="https://www.vizergy.com/assets/daterangepicker/jquery.daterangepicker.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbtsYXCVM3p238AlxFLX0QcHg9IhpdiWM"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.6.1.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!--/ bodyincludes -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <link rel="stylesheet" href="<?php echo URL; ?>/assets/css/fonts.css" />
    <script>
        WebFontConfig = {
            custom: {
                families: ['ApexSans Medium', 'ApexSans Book', 'ApexSans Bold', 'Titillium Web']
            }
        };
        (function(d) {
            var wf = d.createElement('script'),
                s = d.scripts[0];
            wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js';
            wf.async = true;
            s.parentNode.insertBefore(wf, s);
        })(document);
    </script>
    <!-- bodyincludes -->
    <script>
        var WWPSiteProperties = {
            siteId: 555,
            siteGuid: "8df8e314-a37a-4eba-9120-a0854798710a",
            siteCultureCode: "en-US",
            domainId: 2545,
            domain: "hardrockhotels.com",
            domainSSLMandatory: true,
            mobileDomain: "",
            mobileDomainSSLMandatory: false,
            cdbeDomains: ["gds.secure-res.com", "gc.synxis.com"],
            hasSecureResIBE: false,
            hasGoogleAnalytics: false,
            hasMobileSite: false,
            TimeZoneName: "Central Standard Time"
        };
    </script>
    <link href="<?php echo URL; ?>/files/555/combined-dt=201702141415.css" rel="stylesheet" type="text/css" media="screen">
    <script src="<?php echo URL; ?>/files/555/combined-dt=201702141415.js" type="text/javascript"></script>
    <!-- /bodyincludes -->
    <link rel="shortcut icon" href="<?php echo URL; ?>/files/templates/1521/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo URL; ?>/files/templates/1521/apple-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo URL; ?>/files/templates/1521/apple-icon-60x60.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo URL; ?>/files/templates/1521/apple-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo URL; ?>/files/templates/1521/apple-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo URL; ?>/files/templates/1521/apple-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo URL; ?>/files/templates/1521/apple-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo URL; ?>/files/templates/1521/apple-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo URL; ?>/files/templates/1521/apple-icon-152x152.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo URL; ?>/files/templates/1521/apple-icon-180x180.png" />
    <link rel="icon" type="image/png" href="<?php echo URL; ?>/files/templates/1521/favicon-16x16.png" sizes="16x16" />
    <link rel="icon" type="image/png" href="<?php echo URL; ?>/files/templates/1521/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?php echo URL; ?>/files/templates/1521/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/png" href="<?php echo URL; ?>/files/templates/1521/android-icon-192x192.png" sizes="192x192" />
    <meta name="msapplication-square70x70logo" content="smalltile.png" />
    <meta name="msapplication-square150x150logo" content="mediumtile.png" />
    <meta name="msapplication-wide310x150logo" content="widetile.png" />
    <meta name="msapplication-square310x310logo" content="largetile.png" />
    <meta name="apple-mobile-web-app-title" content="Hard Rock Hotel" />
    <?php
    if (!isset($folder) || (isset($folder) && $folder != 'home')) {
        echo '<link rel="stylesheet" href="' . URL . '/assets/css/bootstrap4.css" type="text/css">';
    }
    ?>
    <link rel="stylesheet" href="<?php echo URL; ?>/assets/css/trash.css" type="text/css">
    <link rel="stylesheet" href="<?php echo URL; ?>/assets/css/semi-main.css" type="text/css">
    <link rel="stylesheet" href="<?php echo URL; ?>/assets/css/footer.css" type="text/css">
    <link rel="stylesheet" href="<?php echo URL; ?>/files/templates/1521/combined.css" type="text/css">
    <script src="<?php echo URL; ?>/files/templates/1521/combined.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php echo URL; ?>/files/templates/1521/print.css" type="text/css" media="print">
    <link rel="stylesheet" href="<?php echo URL; ?>/assets/css/main.css" type="text/css">
    <link rel="stylesheet" href="<?= URL ?>/assets/css/fontawesome-all.min.css" />
</head>

<body id="pageid80862" itemscope itemtype="https://schema.org/Resort" class="cbp-spmenu-push close-button">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TGGTGGL" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->