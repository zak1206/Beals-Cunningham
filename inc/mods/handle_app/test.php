<?php header("Access-Control-Allow-Origin: https://smithtractorco.com/"); ?>
<!DOCTYPE html>
<html>
<body id="body" onload="checkAuth()">

<div id="main" style="display: none;">
    <h2>EntityCreateHandler Test</h2>
    <div id="notAuthMessage" style="display: block;">
        <div>User is not authenticated, please login:</div><br/>
        <form id="frm0">
            Username: <input id="username" type="text" name="username" size="83" /><br/>
            Password: <input id="password" type="password" name="password" size="83" /><br/>
        </form>
        <button id="loginbtn" type="button" onclick="Auth()">Log In</button>
    </div>

    <div id="waitingMessage" style="display: none;">waiting for authentication...</div>

    <div id="authMessage" style="display: none;">
        <div id="authMessageText">User is authenticated</div>
        <button id="logoutbtn" type="button" onclick="Logout()">Log Out</button>
    </div>
    <br/><br/><br/>
    <form id="frm1">
        Data (XML or JSON): <br/><textarea id="data" rows="20" cols="70" name="data"></textarea><br/>
    </form>

    <button type="button" onclick="loadXMLDoc()">Post XML Data to Handler</button>
    <button type="button" onclick="loadJSONDoc()">Post JSON Data to Handler</button>

    <p>Result:</p>
    <p id="demo"></p>
</div>
<script>

    function loadXMLDoc(){
        loadDoc("application/xml");
    }

    function loadJSONDoc(){
        loadDoc("application/json");
    }

    function Auth() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.status == 200)
                {
                    document.getElementById("waitingMessage").style.display="none";
                    var xmlDoc = {};
                    if (window.DOMParser)
                    {
                        var parser = new DOMParser();
                        xmlDoc = parser.parseFromString(this.responseText, "text/xml");
                    }
                    else // Internet Explorer
                    {
                        xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
                        xmlDoc.async = false;
                        xmlDoc.loadXML(this.responseText);
                    }
                    var LoginResult = xmlDoc.getElementsByTagName("LoginResult")[0];
                    if (LoginResult.childNodes === undefined || LoginResult.childNodes === null || LoginResult.childNodes[0] === undefined || LoginResult.childNodes[0] === null)
                    {
                        document.getElementById("authMessage").style.display="none";
                        document.getElementById("notAuthMessage").style.display="block";
                        alert("Not Authentified");
                    }
                    else
                    {
                        document.getElementById("authMessage").style.display="block";
                        document.getElementById("notAuthMessage").style.display="none";
                        document.getElementById("authMessageText").innerText = "User " + document.getElementById("username").value + " is authenticated";
                    }
                }
                else
                {
                    document.getElementById("waitingMessage").style.display="none";
                    document.getElementById("authMessage").style.display="none";
                    document.getElementById("notAuthMessage").style.display="block";
                    alert("Not Authentified");
                }
            }
        };
        document.getElementById("authMessage").style.display="none";
        document.getElementById("notAuthMessage").style.display="none";
        document.getElementById("waitingMessage").style.display="block";
        var body = '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Body><Login><username>'+document.getElementById("username").value+'</username><password>'+document.getElementById("password").value+'</password><isPersistent>true</isPersistent></Login></s:Body></s:Envelope>';
        xhttp.open("POST", "/Services/Portal/Security/10/MyAuthenticationService.svc", true);
        xhttp.setRequestHeader("Content-type", "text/xml; charset=utf-8");
        xhttp.setRequestHeader("SOAPAction", "urn:MyAuthenticationService/Login");
        xhttp.send(body);
    };

    function checkAuth() {

        var xhttp = new XMLHttpRequest();
        var body = '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Body><Logout></Logout></s:Body></s:Envelope>';
        xhttp.open("POST", "/Services/Portal/Security/10/MyAuthenticationService.svc", true);
        xhttp.setRequestHeader("Content-type", "text/xml; charset=utf-8");
        xhttp.setRequestHeader("SOAPAction", "urn:MyAuthenticationService/Logout");
        xhttp.send(body);
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4) {
                document.getElementById("notAuthMessage").style.display="block";
                document.getElementById("main").style.display="block";}
        }
    }

    function loadDoc(value) {
        document.getElementById("demo").innerText = "waiting for result...";
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.status == 200)
                    document.getElementById("demo").innerText = this.responseText;
                else
                    document.getElementById("demo").innerText = "Error " + this.status;
            }
        };
        xhttp.open("POST", "/Services/Crm/Notes/10/EntityCreateHandler.ashx", true);
        xhttp.setRequestHeader("Content-type", value);
        xhttp.setRequestHeader("Cookie", document.cookie);
        xhttp.send(document.getElementById("data").value);
    }

    function Logout() {
        var xhttp = new XMLHttpRequest();
        var body = '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Body><Logout></Logout></s:Body></s:Envelope>';
        xhttp.open("POST", "/Services/Portal/Security/10/MyAuthenticationService.svc", true);
        xhttp.setRequestHeader("Content-type", "text/xml; charset=utf-8");
        xhttp.setRequestHeader("SOAPAction", "urn:MyAuthenticationService/Logout");
        xhttp.send(body);
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) {
                document.getElementById("waitingMessage").style.display="none";
                document.getElementById("authMessage").style.display="none";
                document.getElementById("notAuthMessage").style.display="block";
            }
        }
    }

    function isGuid(value) {
        var regex = /[a-f0-9]{8}(?:-[a-f0-9]{4}){3}-[a-f0-9]{12}/i;
        var match = regex.exec(value);
        return match != null;
    }
</script>

</body>
</html>