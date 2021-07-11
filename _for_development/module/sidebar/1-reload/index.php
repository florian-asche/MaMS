<?php
//echo $sysconfig['module_sidebar_reload']['aktiv']['wert'];                    // Soll das Module Aktiv sein?
//echo $sysconfig['module_sidebar_reload']['farbe']['wert'];                    // Welche Farbe soll der Hintergrund haben?



            $(document).ready(function(){
        // Initial Load on Startup
        $('.views').each(function(){
            $(this).jQuery.getJSON('api.php?function=getlastdata&objektid='+this.id);
        });
        
        // Start Intervall Reload
        setInterval(function(){
            $('.views').each(function(){
                $(this).getJSON('api.php?function=getlastdata&objektid='+this.id);
            });
        }, 5000);
    });	
	
	
	        $.getJSON('api.php', function(data) {
            //alert(data); //uncomment this for debug
            //alert (data.item1+" "+data.item2+" "+data.item3); //further debug
            $('#showdata').html("<p>item1="+data.item1+" item2="+data.item2+" item3="+data.item3+"</p>");
        });
        



function updateStatus() {
        var URL = "api.php";
        $.getJSON( URL, {
            sensorid: "{$objekt.objektid}",
            feld: "1",
        })
        .done(function( data ) {
            //alert(data); //uncomment this for debug
            //alert (data.item1+" "+data.item2+" "+data.item3); //further debug
            //$.each( data.items, function( i, item ) {
            //$( "<img>" ).attr( "src", item.media.m ).appendTo( "#images" );
            //if ( i === 3 ) {
            //return false;
            //}
            //$('#{$objekt.objektid}_wert1').html("<p>item1="+data.item1+" item2="+data.item2+" item3="+data.item3+"</p>");
            //$('#{$objekt.objektid}_wert1').html("<p>"+data.item1+"</p>");
            
            
            
        })
        .fail(function( jqxhr, textStatus, error ) {
            var err = textStatus + ", " + error;
            console.log( "Request Failed: " + err );
            //alert('JSON ERROR'); //uncomment this for debug
        });
        
	//setTimeout('updateStatus()',5000);                      
}


    function updateStatus(sensorid, feld) {
        alert("HERE");
        var URL = "api.php";
        $.getJSON( URL, {
            sensorid: sensorid,
            feld: feld,
        })
        .done(function( data ) {
            //alert(data); //uncomment this for debug
            //alert (data.item1+" "+data.item2+" "+data.item3); //further debug
            //$.each( data.items, function( i, item ) {
            //$( "<img>" ).attr( "src", item.media.m ).appendTo( "#images" );
            //if ( i === 3 ) {
            //return false;
            //}
            //$('#{$objekt.objektid}_wert1').html("<p>item1="+data.item1+" item2="+data.item2+" item3="+data.item3+"</p>");
            //$('#{$objekt.objektid}_wert1').html("<p>"+data.item1+"</p>");
            
            
            
        });
        .fail(function( jqxhr, textStatus, error ) {
            var err = textStatus + ", " + error;
            console.log( "Request Failed: " + err );
            //alert('JSON ERROR'); //uncomment this for debug
        });
        
	//setTimeout('updateStatus()',5000);                      
    };


    
        $(document).ready(function(){
        updateStatus("test", "1");
    });
    
    
    //$(document).ready(updateStatus);
    $(document).ready(function(){
    	   setInterval(function(){
    			$('.views').each(function(){
    				//$(this).load('ajax.php?id='+this.id);
                                updateStatus(this.id, '1')
                                //alert("HELLO");
    			});
    		}, 1000);
    	});
    
    
    
    
    
    
    
    function updateStatus(sensorid, feld) {
        var URL = "api.php";
        $.getJSON( URL, {
            sensorid: sensorid,
            feld: feld,
        })
        .done(function( data ) {
            console.log( "ALL OK"+data );
        })
        .fail(function( jqxhr, textStatus, error ) {
            var err = textStatus + ", " + error + jqxhr;
            console.log( "Request Failed: " + err );
            //alert('JSON ERROR'); //uncomment this for debug
        });
	//setTimeout('updateStatus()',5000);         
        alert(sensorid+feld); 
    };
    
    $(document).ready(function(){
        updateStatus("test", "1");
    });
    
    
    
    

if ($sysconfig['index']['system_autoreload']['wert'] == "1") {
    if ($reloadinEVG > "70") {
        $reloadmich = $sysconfig['module_sidebar_reload']['default_reloadtime']['wert'];
    } elseif ($reloadinEVG < "0") {
        $reloadmich = $sysconfig['module_sidebar_reload']['default_reloadtime']['wert'];
    } else {
        $reloadmich = $reloadinEVG;
    };
} else {
    $reloadmich = $sysconfig['module_sidebar_reload']['default_reloadtime']['wert'];
}
?>

<script type="text/javascript">
var text = "</b> Sek.";
var text2 = "Reload der Seite in: <b>";
var counter = <?php echo $reloadmich?>;
function countdown() {
    if (--counter > 0) {
        document.getElementById("countdown").innerHTML = text2 + counter + text;
        window.setTimeout(countdown, 1000);
    } else {
        document.getElementById("countdown").innerHTML = "Loading...";
    }
}
function startCountdown() {
    document.getElementById("countdown").innerHTML = text2 + counter + text;
    window.setTimeout(countdown, 1000);
}
</script>

<?php
if ($sysconfig['module_sidebar_reload']['reloadfunktion_aktiv']['wert'] == "1"){ echo '<head><meta http-equiv="refresh" content="' . $reloadmich . '"></head>'; };

if ($sysconfig['module_sidebar_reload']['aktiv']['wert'] == "1") {                                              // Prüfen, ob das Module Aktiviert ist
    if ($sysconfig['module_sidebar_reload']['reloadfunktion_aktiv']['wert'] == "1"){
        echo '<table border="' . $system_debug . '" class="mini" bgcolor="' . $sysconfig['module_sidebar_reload']['farbe']['wert'] . '" width="300" height="10">';
        echo '<td height="22" bgcolor="' . $sysconfig['module_sidebar_reload']['farbe']['wert'] . '">';
        echo '<body onLoad="startCountdown();">Uhrzeit:<b> ' . date("H:i:s") . '</b><br>Datum: <b>' . date("d.m.Y") . '</b><div id="countdown"></div></body>';
        echo '</table>';
        echo "<br>";                                                                // Neue Zeile ausgeben
    };
};
?>