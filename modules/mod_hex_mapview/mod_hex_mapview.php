<?php
/*------------------------------------------------------------------------
# mod_hex_mapview - HexSys Google Map
# ------------------------------------------------------------------------
# author Team HexSys
# copyright Copyright (C) 2013 hexsystechnologies.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.hexsystechnologies.com
# Technical Support:  Forum - http://www.hexsystechnologies.com/support-forum
-----------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$document = JFactory::getDocument();

// clientids must be an integer
$height  = (int)str_replace('px', '', $params->get( 'height', '500' ));
$width   = (int)str_replace('px', '', $params->get( 'width', '500' ));
$lat     = (float)$params->get( 'lat', '' );
$long    = (float)$params->get( 'long', '' );
$zoom    = $params->get( 'zoom', '5' );

$lat1    = (float)$params->get( 'lat1', '' );
$lat2    = (float)$params->get( 'lat2', '' );
$lat3    = (float)$params->get( 'lat3', '' );
$lat4    = (float)$params->get( 'lat4', '' );
$lat5    = (float)$params->get( 'lat5', '' );

$long1   = (float)$params->get( 'long1', '' );
$long2   = (float)$params->get( 'long2', '' );
$long3   = (float)$params->get( 'long3', '' );
$long4   = (float)$params->get( 'long4', '' );
$long5   = (float)$params->get( 'long5', '' );

$title1  = $params->get( 'title1', '' );
$title2  = $params->get( 'title2', '' );
$title3  = $params->get( 'title3', '' );
$title4  = $params->get( 'title4', '' );
$title5  = $params->get( 'title5', '' );

$html1   = $params->get( 'html1', '' );
$html2   = $params->get( 'html2', '' );
$html3   = $params->get( 'html3', '' );
$html4   = $params->get( 'html4', '' );
$html5   = $params->get( 'html5', '' );

$pub1    = (int)$params->get( 'pub1', '0' );
$pub2    = (int)$params->get( 'pub2', '0' );
$pub3    = (int)$params->get( 'pub3', '0' );
$pub4    = (int)$params->get( 'pub4', '0' );
$pub5    = (int)$params->get( 'pub5', '0' );

$mapType = $params->get( 'mapType', 'ROADMAP' );
$mapCSS  = "#map { height:".$height."px; width:".$width."px;max-width:100% }";
$document->addStyleDeclaration($mapCSS);
		$lats = array($lat1,$lat2,$lat3,$lat4,$lat5);
		$longs = array($long1,$long2,$long3,$long4,$long5);
		$pubs = array($pub1,$pub2,$pub3,$pub4,$pub5);
		$htmls = array(preg_replace("/\r?\n/", "\\n", addslashes($html1)),preg_replace("/\r?\n/", "\\n", addslashes($html2)),preg_replace("/\r?\n/", "\\n", addslashes($html3)),preg_replace("/\r?\n/", "\\n", addslashes($html4)),preg_replace("/\r?\n/", "\\n", addslashes($html5)));
		$titles = array(preg_replace("/\r?\n/", "\\n", addslashes($title1)),preg_replace("/\r?\n/", "\\n", addslashes($title2)),preg_replace("/\r?\n/", "\\n", addslashes($title3)),preg_replace("/\r?\n/", "\\n", addslashes($title4)),preg_replace("/\r?\n/", "\\n", addslashes($title5)));
?>
<div id="map"></div>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&callback=hxmapsLoadMap"></script>
<script type="text/javascript">
	var map

	function attachSecretMessage(marker, message) {
		var infowindow = new google.maps.InfoWindow(
			{ content: message
			});
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map,marker);
		});
	}

	window.hxmapsLoadMap = function()
	{
		var center = new google.maps.LatLng('<?php echo $lat ?>', '<?php echo $long ?>');
		var settings = {
		  mapTypeId: google.maps.MapTypeId.<?php echo $mapType ?>,
		  zoom: <?php echo $zoom ?>,
		  center: center
		};
		map = new google.maps.Map(document.getElementById('map'), settings);
		<?php for ($i = 0; $i < 5; $i++) {
			if($pubs[$i]){?>
				var marker = new google.maps.Marker({
					position: new google.maps.LatLng('<?php echo $lats[$i] ?>', '<?php echo $longs[$i] ?>'),
					title: '<?php echo $titles[$i] ?>',
					map: map
				});
				marker.setTitle('<?php echo $titles[$i] ?>'.toString());
				attachSecretMessage(marker, '<?php echo $titles[$i] ?>'+' - '+'<?php echo $htmls[$i] ?>');
			<?php }
		}?>
	}
</script>
