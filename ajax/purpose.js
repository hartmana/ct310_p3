function showPurpose(site) {

    var http;

    var target = site.getAttribute("href");

    var url = target + '/purpose.php';

    if (navigator.appName == "Microsoft Internet Explorer") {
        http = new ActiveXObject("Microsoft.XMLHTTP");
    } else {
        http = new XMLHttpRequest();
    }

    http.open("POST", url, true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    http.onreadystatechange = function () {
        if (http.readyState == 4) {

            var purpose = JSON.parse(http.responseText);

            document.getElementById("purpose").innerHTML = purpose.purpose;

        }

    }
    http.send(null);

}

function delPurpose() {
    document.getElementById("purpose").innerHTML = "Hover over a site name and their purpose will come up.";
}
