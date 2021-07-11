function picker_update(picker) {
    //document.getElementById('hex-str').innerHTML = picker.toHEXString();
    document.getElementById('r').innerHTML = Math.round(picker.rgb[0]);
    document.getElementById('g').innerHTML = Math.round(picker.rgb[1]);
    document.getElementById('b').innerHTML = Math.round(picker.rgb[2]);
    FormSubmitRequest('{$objekt.station_protocols.ID}btn2', '{$objekt.page_objects.ID}');
}

function confirmSubmit() {
    //alert('Hallo Welt!');
    var agree=confirm("Sind Sie sich sicher, dass Sie fortfahren wollen?");
    if (agree) {
        return true;
    } else {
        return false;
    };
};

function updateStatus(page_objects_ID) {
    $.ajax({
        url: "api.php",
        type: "POST",
        data: { 
            action: "get_objekthtml", 
            page_objects_ID: page_objects_ID 
        },
        beforeSend: function( xhr ) {
            //xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
            xhr.overrideMimeType( "text/html; charset=ISO-8859-1" );
        }
    })
    .done(function( data ) {
        if ( console && console.log ) {
        //console.log( "DATA: " + data );
        }
        $('#' + page_objects_ID + '_data').html('' + data + '');
        //document.getElementById('' + page_objects_ID + '_data').innerHTML = data;
        if ( console && console.log ) {
            //console.log( "ALL OK" );
        }
    })
    .fail(function( jqxhr, textStatus, error ) {
        var err = textStatus + ", " + error + jqxhr;
        console.log( "Request Failed: " + err );
        //alert('JSON ERROR');
    });
}

function updateStatusStarter(page_objects_ID, timetoreload, reloadtime) {
    //console.log( objektid );
    
    //INITIAL DATA LOAD
    updateStatus(page_objects_ID);

    //FIRST RELOAD
    // Hier wird die Zeit bis zum resten Reload berechnet...
    timetoreload = (timetoreload * 1000);
    setTimeout(function(){
        updateStatus(page_objects_ID);
    }, timetoreload);

    //AUTO RELOAD
    // Hier wird die Zeit für den Schleifen Autoreload berechnet...
    reloadtime = (reloadtime * 1000);
    var timerid = setInterval(function(){
        updateStatus(page_objects_ID);
    }, reloadtime);
    
    //console.log(pageobjectid);
};

function updateStatusStopper(pageobjectid) {
    console.log(pageobjectid);
    
    
    if ( console && console.log ) {
        console.log("==updateStatusStopper==");
        console.log( "ID: " + pageobjectid );
    }
    
    clearInterval(pageobjectid);
};

//function ajaxupdateStatus(objektid) {
//    //console.log( objektid );
//    var URL = "api.php";
//    $.getJSON( URL, {
//        action: "get_data",
//        objektid: objektid
//    })
//    .done(function( data ) {
//        //if (objektid = 'MAMS-f11a1b78bdbeaaa82e43') {
////$('#' + objektid + '_data').html('<p class="objectview">' + 'MISSING DATA' + '</p>');
////        if (data.timestamp === undefined) {
////            $('#' + objektid + '__message').html('<p class="objectview">' + 'MISSING DATA' + '</p>');
////            console.log("NO DATA FOR SENSOR: "+objektid);
////        } else {
//            $('#' + objektid + '__wert1').html('<p class="objectview">' + data.wert1 + '</p>');
////            $('#' + objektid + '__wert2').html('<p class="objectview">' + data.wert2 + '</p>');
////            $('#' + objektid + '__wert3').html('<p class="objectview">' + data.wert3 + '</p>');
////            $('#' + objektid + '__wert4').html('<p class="objectview">' + data.wert4 + '</p>');
////            $('#' + objektid + '__wert5').html('<p class="objectview">' + data.wert5 + '</p>');
////            $('#' + objektid + '__wert6').html('<p class="objectview">' + data.wert6 + '</p>');
////            $('#' + objektid + '__wert7').html('<p class="objectview">' + data.wert7 + '</p>');
////            $('#' + objektid + '__wert8').html('<p class="objectview">' + data.wert8 + '</p>');
////            $('#' + objektid + '__wert9').html('<p class="objectview">' + data.wert9 + '</p>');
////            $('#' + objektid + '__timestamp').html("<p>" + data.timestamp + "</p>");
////            //console.log( feld );
////            //console.log( data.wert1 );
////            //console.log( eval("data."+feld) );
////            //console.log( "ALL OK" );
////        }
//    })
//    .fail(function( jqxhr, textStatus, error ) {
//        var err = textStatus + ", " + error + jqxhr;
//        console.log( "Request Failed: " + err );
//        //alert('JSON ERROR');
//    });
//    //console.log( "objektid: " + objektid );
//    //window.setTimeout(updateStatus(objektid, feld), 1000);
//    //setTimeout('updateStatus()',5000);
//    //alert(sensorid+feld); 
//};

var framefenster = document.getElementsByTagName("iFrame");
var framefenster_size_offset = 10;
//var auto_resize_timer = window.setInterval("autoresize_frames()", 400);
function autoresize_frames() {
    for (var i = 0; i < framefenster.length; ++i) {
        if(framefenster[i].contentWindow.document.body){
            var framefenster_size = framefenster_size_offset + framefenster[i].contentWindow.document.body.offsetHeight;
            if(document.all && !window.opera) {
                framefenster_size = framefenster[i].contentWindow.document.body.scrollHeight;
            }
            framefenster[i].style.height = framefenster_size + 'px';
        }
    }
}

//function MaMS_MouseOver_Tip(objectid){
//    Tip(TooltipTxt(objectid)); 
//    autoresize_frames();
//}
//
//function MaMS_MouseOver_UnTip(objectid){
//    UnTip();
//}

function TooltipTxt(n) {
    //updateStatusStopper(n);
    return "<iFrame style='width:3500px; height:3500px;' frameBorder='0' scrolling='no' src='api.php?action=get_mouseover&pageobjectid=" + n + "'><p>Ihr Browser kann leider keine eingebetteten Frames anzeigen: Sie k&ouml;nnen die eingebettete Seite &uuml;ber den folgenden Verweis aufrufen:</p></iframe>";
}

function init(){
    hide_notify();
};

function show_notify() {
    notify.style.display = "block";
    //window.clearTimeout(notify_hide_timerid);
    window.setTimeout("hide_notify()", 4000);
}

function hide_notify() {
    notify.style.display = "none";
    //var notifyblocking = 0;
}

function show_mams_notify(n_type,msg) {
    hide_notify();
   //msg = "test";
   //console.log('DATA='+msg);
   
    if (n_type == "generic") {
            notify.className = "notify";
    } else if (n_type == "progress") {
            notify.className = "notify progress";
            msg = "<img src='lib/images/indicator_white.gif'> " + msg;
    } else if (n_type == "error") {
            notify.className = "notify error";
            msg = "<img src='lib/images/sign_excl.svg'> " + msg;
    } else if (n_type == "info") {
            //alert("Hallo Welt!");
            notify.className = "notify info2";
            msg = "<img src='lib/images/sign_info.svg'> " + msg;
    }

    show_notify();
    $('#notify').html(msg);
}

function serializeToJson(serializer){
    var _string = '{';
    for(var ix in serializer)
    {
        var row = serializer[ix];
        _string += '"' + row.name + '":"' + row.value + '",';
    }
    var end =_string.length - 1;
    _string = _string.substr(0, end);
    _string += '}';
    //console.log('_string: ', _string);
    //return JSON.parse(_string);
    return _string;
}

function FormSubmitRequest(FormName, page_objects_ID) {
    // Show Data Loading Window
    show_mams_notify("progress","Sending data ...");
    
    // serialize to JSON
    var params = $("#"+FormName).serializeArray();
    var result = serializeToJson(params);
    
    // Submit form using AJAX.
    $.ajax({
        type        : 'POST', 
        url         : 'api.php', 
        data: { 
            action: "add_queue_job",
            FormName: FormName,
            page_objects_ID: page_objects_ID,
            json_data: result,
        },
    })
    .success(function(data) {
        //console.log(data);
        if (data == "OK") {
            show_mams_notify("info","Daten wurden  &uuml;bermittelt.");
        } else {
            show_mams_notify("error","ERROR: "+data);
        }
        
        console.log(data);
        
        // Update der Objektdaten starten
        setTimeout(function(){ 
            updateStatus(page_objects_ID);
        }, '1000');
        
        setTimeout(function(){ 
            updateStatus(page_objects_ID);
        }, '2000');
        
        setTimeout(function(){ 
            updateStatus(page_objects_ID);
        }, '5000');
    })
    .error (function(jqxhr) {
        //it  will be errors: 324, 500, 404 or anythings else
        console.log(jqxhr.responseText);
        show_mams_notify("error",jqxhr.responseText);
    })
}

//function SubmitData(station_protocols_ID, action_wert1) {
//    $.ajax({
//        url: "api.php",
//        type: "POST",
//        data: { 
//            action: "add_queue_job",
//            station_protocols_ID: station_protocols_ID,
//            action_wert1: action_wert1
//        },
//        beforeSend: function( xhr ) {
//            //xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
//            xhr.overrideMimeType( "text/html; charset=ISO-8859-1" );
//        }
//    })
//    .done(function( data ) {
//        if ( console && console.log ) {
//        //console.log( "DATA: " + data );
//        }
//        if (data == "OK") {
//            show_mams_notify("info","Daten wurden  &uuml;bermittelt.");
//        } else {
//            show_mams_notify("error","ERROR: "+data);
//        }
//        
//        // Update der Objektdaten starten
//        setTimeout(function(){ 
//            updateStatus(objektid);
//        }, '1000');
//        
//        setTimeout(function(){ 
//            updateStatus(objektid);
//        }, '2000');
//        
//        setTimeout(function(){ 
//            updateStatus(objektid);
//        }, '5000');
//        //console.log( "ALL OK" );
//    })
//    .fail(function( jqxhr, textStatus, error ) {
//        var err = textStatus + ", " + error + jqxhr;
//        console.log( "Request Failed: " + err );
//        show_mams_notify("error",jqxhr.responseText);
//        //alert('JSON ERROR');
//        
//    });
//}
