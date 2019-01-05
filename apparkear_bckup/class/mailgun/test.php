<?php
require 'vendor/autoload.php';
use Mailgun\Mailgun;

# Instantiate the client.
$mgClient = new Mailgun('key-ac4d4f37d907013d4a03a09b3a3be0ff');
$domain = "roomarate.com";

# Make the call to the client.
$result = $mgClient->sendMessage($domain, array(
    'from'    => 'RoomaRate <hello@roomarate.com>',
    'to'      => array('dimayarema@gmail.com,mazafaks@gmail.com'),
    'subject' => 'Hello User',
    'text'    => 'Testing some Mailgun awesomness!',
'recipient-variables' => '{"dimayarema@gmail.com":{},"mazafaks@gmail.com":{}}'
));

echo($result);
