var url = 'http://www.cs.colostate.edu/~ct310/yr2015sp/project/roster.php?key=WQT3xKmVV7';
var http = false;
var id;
var sites;

function getSites() {
	
	if (navigator.appName == "Microsoft Internet Explorer") {
		http = new ActiveXObject("Microsoft.XMLHTTP");
	} else {
		http = new XMLHttpRequest();
	}
	
    http.open("POST", url, true);
    http.setRequestHeader("Content-type", "text/json");
    http.onreadstatechange = function(){
		if (http.readyState == 4){
			sites = JSON.parse(http.responseText);
			var tab = "";
			var site = "";
			for (j = 0; j < sites.length; j++){
			
				if(sites[j].url.startsWith("https")){
					var addr = sites[j].url.substring(5, sites[j].url.length);
					sites[j].url = "http" + addr;
				}
				if(!sites[j].url.startsWith("http")){
					sites[j].url = "http://" + sites[j].url;
				}
				
				if (loggedon == 1){
					site = "onmouseover=\"showPurpose(this)\" onmouseout=\"delPurpose()\"";
				} else {
					document.getElementById("purpose").innerHTML = "Login to see purposes.";
					site = "";
				}
				tab += '<a href="' + sites[j].url + '"' + site + '>' + sites[j].name + </a><br>';
			}
			document.getElementById("federation").innerHTML = tab;
		}
	}
	http.send(null);
    
}

function showPurpose(s){
	var target = s.getAttribute("href");
	var url = target + "/purpose.php";
	var http = false;
	
	if (navigator.appName == "Microsoft Internet Explorer") {
		http = new ActiveXObject("Microsoft.XMLHTTP");
	} else {
		http = new XMLHttpRequest();
	}
	
	http.open("POST", url, true);
	http.setRequestHeader("Content-type", "text/json");
	http.onreadystatechange = function(){
		if (http.readyState == 4 && http.status == 200){
			var purp = JSON.parse(http.responseText);
			
			if(Array.isArray(purp)){
				var tab = purp[0].purpose;
			} else {
				var tab = purp.purpose;
			}
			document.getElementById("purpose").innerHTML = "<p>" + tab + "</p>";
		}
		if(http.readyState == 4 && http.status != 200){
			document.getElementById("purpose").innerHTML = "<p> + Off limits </p>";
		}
		http.send(null);
	}
	
}

function delPurpose(){
	document.getElementById("purpose").innerHTML = "<p>Hover over a site name and their purpose will come up.</p>";
}

/*working
function sitesToTable(sites) {
    var tab = document.getElementById('federation');
    var i = tab.rows.length;
    for (j = 0; j < sites.length; j++) {
        var addr = sites[j].url;
        var rt = "<tr> <td> " + sites[j].name + " </td> <td> <a href='" + addr + "'>" + addr + "</a></td> </tr>";
        var rr = tab.insertRow(i);
        rr.innerHTML = rt;
    }
}*/

/*NOT TESTED
function hover() {
    $(document).ready(function () {
        $("th").hover(function () {
        });
        $("tr").hover(function () {
            id = $(this).find("td:nth-child(3)").text();
            getPurpose();
            $("#purpose").toggle(1);
            document.getElementById('purpose').deleteRow(1);
        });
        $("tr").mouseleave(function () {
            leave();
        });
        $("table").mouseleave(function () {
            leave();
        });
    });
}

function leave() {
    document.getElementById('purpose').deleteRow(1);
    document.getElementById('purpose').deleteRow(2);
}*/

/*NOT TESTED
function getPurpose() {
    
    http.open("POST", url, true);
    var sites = JSON.parse(http.responseText);
    
    for (i = 0; i < sites.length; i++){
    	id = sites[j].url+'/purpose.php';
    	http.open("POST", id, true);
    	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    	http.onreadystatechange = function () {
    		if (http.readyState == 4){
    			id = JSON.parse(http.responseText);
    			purposeToTable(sites, id.purpose);
    		} else {
    			purposeToTable("Purpose not accessible!");
    		}
    	}
    }
    http.send(null);
}*/

/*NOT TESTED
function purposeToTable(sites, purpose) {
    var tab = document.getElementById('federation');
    var i = tab.rows.length;
    for (j = 0; j < sites.length; j++) {
    	var rt = "<tr><td>" + purpose + "</td></tr>";
    	var rr = tab.insertRow(i);
    	rr.innerHTML = rt;
    }
    
}*/

function init() {
    getSites();
}
