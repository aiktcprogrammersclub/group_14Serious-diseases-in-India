<?php 

$dbhost="localhost"; $dbname="wordpress"; $dbun="root"; $dbpass="1234";

$con=mysql_connect($dbhost,$dbun,$dbpass) or die(mysql_error());
mysql_select_db($dbname) or die(mysql_error());
//---------------------------------------------------------------------------------------------
$sql="SELECT DISTINCT value FROM wordpress.wp_bp_xprofile_data where field_id = 605";	
  $result=mysql_query($sql);
  $count=mysql_num_rows($result);
//$rows=mysql_fetch_array($result);
$country[]=array();
$lan[]=array();
$lon[]=array();
$country_count[]=array();
$i=0;

while($rows=mysql_fetch_array($result))
{

$sql_count="SELECT COUNT(value) FROM wordpress.wp_bp_xprofile_data where value like '%$rows[0]%' and field_id = 605";	
  $result_count=mysql_query($sql_count);
//$count_count=mysql_num_rows($result_count);
$rows_count=mysql_fetch_array($result_count);
//echo "<br>"."$rows_count[0]";
$country_count[$i]=$rows_count[0];

$sql_lanlong="SELECT * FROM wordpress.country where country ='$rows[0]'";	
  $result_lanlong=mysql_query($sql_lanlong);
  $count_lanlong=mysql_num_rows($result_lanlong);
  $rows_lanlong=mysql_fetch_array($result_lanlong);

$country[$i]=$rows_lanlong[0];
$lan[$i]=$rows_lanlong[1];
$lon[$i]=$rows_lanlong[2];
  // echo "<br>"."$country[$i]"."<br>"."$lan[$i]"."<br>"."$lon[$i]"; 
   $i++;
  }
  mysql_close($con);
?>




<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
  <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map-canvas { height: 100% }
    </style>
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-EyStYNEGKc17adYUbGTfzUUUYchKoMA&sensor=false">
    </script>
    <script type="text/javascript">
    
	 // alert(cc);
	  function initialize() {
	    var marker;
	  var map;
	  var country = <?php echo json_encode($country); ?>;
	  var lat = <?php echo json_encode($lan); ?>;
	  var lng = <?php echo json_encode($lon); ?>;
	  var cc = <?php echo json_encode($country_count); ?>;
	  var myflag= <?php echo json_encode($count); ?>;
	  var i=0;
	   var mapOptions = {
          center: new google.maps.LatLng(0,0),
          zoom: 2,
		  
        };
		
         map = new google.maps.Map(document.getElementById("map-canvas"),
            mapOptions);
	var infowindow = new google.maps.InfoWindow();	
	var marker;
	var iconBase = ''; 
     while(i<myflag)
	 {
myLatlng = new google.maps.LatLng(lat[i], lng[i]);

var marker = new google.maps.Marker({
    position: myLatlng,
	map: map,
	icon: iconBase + 'markerimg7.png',
	animation: google.maps.Animation.DROP
});
		 
	  
google.maps.event.addListener(marker, 'click', (function(marker, i) {
	return function(){
   var contentString = '<div style="text-align : center; height:100px; width:100%; "> <h3  style="text-align : center; width:100%; background-color:#13b6df;" > '+ country[i] + '</h3>'+'<div id="bodyContent">' +  "<p > " + "Number of Alumni : " + cc[i] + '</div>' + '</div>' ;
   infowindow = new google.maps.InfoWindow({
      content: contentString
  });

   infowindow.open(map,marker);
   }
  })(marker, i));
//marker.setMap(map); // To add the marker to the map, call setMap();
i++;
    }
	  }



    
    </script>
  </head>
  <body onload="initialize()">
    <div id="map-canvas"/>
  
  </body>

  </html>	
