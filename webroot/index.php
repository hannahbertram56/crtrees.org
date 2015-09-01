<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
		<style>
            html, body, #map-canvas {
            height: 90%;
            margin: 0px;
            padding: 0px;
          }
		</style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
 		<script>
 		$(document).ready(function(){
				var latitude;
				var longitude;
			
				function get_location(){
					navigator.geolocation.getCurrentPosition(show_map);
				}
		
				function show_map(position){
					latitude = position.coords.latitude;
					longitude = position.coords.longitude;
					initialize();
				}
		
			get_location();
		
			function initialize() {
				var myLatLng = new google.maps.LatLng(latitude, longitude);
				
                var mapOptions = {
					zoom: 15,
					center: myLatLng
				};
                
                var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
                
                <?php
                
                	$con = new PDO('mysql:host=crtreesorg.fatcowmysql.com;dbname=crtrees',"crtreesadmin","G0whalephants1!");
                    $s = $con->prepare("SELECT * FROM `trees`");
                    $s->execute();
                    $results = $s->fetchAll();
                    foreach($results as $result){
                        echo "
                            var contentString$result[ID] = '$result[Species] $result[Health] <img src=\'http://7-themes.com/data_images/out/66/6997593-maple-tree-autumn.jpg\'>';
                            
                            var infowindow$result[ID] = new google.maps.InfoWindow({
                                content: contentString$result[ID]
                            });
                        
                            var marker$result[ID] = new google.maps.Marker({
                                position: new google.maps.LatLng($result[Lat],$result[Long]),
                                map: map,
                                title: 'BANANA!'
                            });
                            
                            google.maps.event.addListener(marker$result[ID], 'click', function() {
                                infowindow$result[ID].open(map,marker$result[ID]);
                            });
                        ";
                    }
                
                ?>
			}
            
			
			$('#btn').click(function(){
				var species = $('#species').val();
				var height = $('#height').val();
                var health = $('#health').val();
				$.post("insertTree.php",{lat: latitude, longi: longitude, s: species, h: height, he: health},function(data){
					location.reload();
				});
			});
			
		});
		
	 </script>
	</head>
	
	<body>

		<div style='text-align: center;' id="map-canvas"><img src='http://ftp.crtrees.org/npruetttrees/load.gif'/></div>

			<label>Species<a target='_blank' href='https://www.arborday.org/trees/whattree/whatTree.cfm?ItemID=E6A'>[?]</a></label>
			<input type='text' name='species' id='species' />
			<label>Height</label>
			<input type='number' name='height' id='height'/>
            <label>Health</label>
            <select id='health'>
                <option value=''>...health...</option>
                <option value='g'>Good</option>
                <option value='f'>Fair</option>
                <option value='p'>Poor</option>
                <option value='d'>Dead</option>
            </select>
			<input type='button' value='Log Tree' id='btn' />
	</body>
</html>