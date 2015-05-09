var url = 'http://www.cs.colostate.edu/~ct310/yr2015sp/project/roster.php?key=WQT3xKmVV7';
var http = false;
var id;
var sites;

if (navigator.appName == "Microsoft Internet Explorer") {
    http = new ActiveXObject("Microsoft.XMLHTTP");
    p = new ActiveXObject("Microsoft.XMLHTTP");
} else {
    http = new XMLHttpRequest();
    p = new XMLHttpRequest();
}

/*working*/
function getSites() {
    http.open("POST", url, true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.onreadystatechange = function () {
        if (http.readyState == 4) {
            sites = JSON.parse(http.responseText);
            sitesToTable(sites);
        }
    }
    http.send(null);
}

/*NOT TESTED*/
function sitesToTable(sites) {
    var tab = document.getElementById('federation');
    var i = tab.rows.length;
    for (j = 0; j < sites.length; j++) {
        var addr = sites[j].url;
        var rt = "<tr> <td> " + sites[j].name + " </td> <td> <a href='" + addr + "'>" + addr + "</a></td> </tr>";
        var rr = tab.insertRow(i);
        rr.innerHTML = rt;
    }

    if (loggedon) {
        hover();
    }
}

/*NOT TESTED*/
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
}
/*NOT TESTED*/
function getPurpose() {
    var sites;
    id += "purpose.php";
    http.open("POST", id, true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.onreadystatechange = function () {
        if (http.readyState == 4) {
            sites = JSON.parse(http.responseText);
            if (Array.isArray(sites)) {
                purposeToTable(sites[0].purpose);
            } else {
                purposeToTable(sites.purpose);
            }
        }
    }
    http.send(null);
}

/*NOT TESTED*/
function purposeToTable(purpose) {
    var row;
    row = document.createElement('tr');
    var cell = document.createElement('td');
    cell.innerHTML = purpose;
    row.appendChild(cell);
    document.getElementById('purpose').appendChild(row);
}

function init() {
    getSites();
}
