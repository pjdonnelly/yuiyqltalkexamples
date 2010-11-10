<?php

include_once("lib/Yahoo.inc"); //located at https://github.com/yahoo/yos-social-php

//get your keys from https://developer.apps.yahoo.com/dashboard/createKey.html
define("API_KEY","<YOUR_KEY_HERE>");
define("SHARED_SECRET","<YOUR_SECRET_HERE>");

YahooLogger::setDebug(true); //optional debug output.
$session=YahooSession::requireSession(API_KEY, SHARED_SECRET);

if ($session == NULL) {
    echo "<p>Error: Cannot get session object. Check your API Key (Consumer Key) and Shared Secret (Consumer Secret)</p>";
    exit;
}

//find out how many unread messages there are in your ymail.com Inbox
$query = 'select folder.unread from ymail.folders where folder.folderInfo.name = "Inbox"';

$queryResponse = $session->query($query);

if ($queryResponse == NULL) {
    echo "<p>Error: No query response. Check your permissions. Also, check the syntax of the YQL query.</p>";
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title>YQL 3legged OAuth example</title>
        <script type="text/javascript" charset="utf-8" src="http://yui.yahooapis.com/3.2.0/build/yui/yui-min.js"></script>
        <style type="text/css">
                #unreadmsg {
                        font-weight:bold;
                        color:#ff0000;
                        font-size:1.5em;
                }
        </style>
    </head>
    <body>
        <h1>Welcome!</h1>
        <div>You have: <span id="unreadmsg"><?php echo $queryResponse->query->results->result->folder->unread; ?></span> unread messages in your ymail.com INBOX</div>
        <div>Click here to <a href="http://ymail.com">read</a></div>
        
        
        <!-- //example of how to use YUI to pass in the data if you wanted to use JS..
    <script>
                YUI().use('node','json-parse', function(Y){
                    var jsonString = '<?php echo json_encode($queryResponse); ?>';
                    try {
                        var data = Y.JSON.parse(jsonString);
                    } catch (e) {
                        console.log(e);
                    }
                    var myunread = data.query.results.result.folder.unread || "0";
                    Y.get("#unreadmsg").set("innerHTML", myunread);
        });
        </script>
    -->
    </body>
</html>