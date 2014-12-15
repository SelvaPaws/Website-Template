<?php
$_ERRORS = array();
/* Informational */
$_ERRORS[100] = array("Continue", "The server has received the request headers, and the client should proceed to send the request body.");
$_ERRORS[101] = array("Switching Protocols", "The requester has asked the server to switch protocols.");
$_ERRORS[103] = array("Checkpoint", "Used in the resumable requests proposal to resume aborted PUT or POST requests.");
/* Success */
$_ERRORS[200] = array("OK", "The request is OK (this is the standard response for successful HTTP requests).");
$_ERRORS[201] = array("Created", "The request has been fulfilled, and a new resource is created.");
$_ERRORS[202] = array("Accepted", "The request has been accepted for processing, but the processing has not been completed.");
$_ERRORS[203] = array("Non-Authoritative Information", "The request has been successfully processed, but is returning information that may be from another source.");
$_ERRORS[204] = array("No Content", "The request has been successfully processed, but is not returning any content.");
$_ERRORS[205] = array("Reset Content", "The request has been successfully processed, but is not returning any content, and requires that the requester reset the document view.");
$_ERRORS[206] = array("Partial Content", "The server is delivering only part of the resource due to a range header sent by the client.");
/* Redirection */
$_ERRORS[300] = array("Multiple Choices", "A link list. The user can select a link and go to that location. Maximum five addresses.");
$_ERRORS[301] = array("Moved Permanently", "The requested page has moved to a new URL.");
$_ERRORS[302] = array("Found", "The requested page has moved temporarily to a new URL.");
$_ERRORS[303] = array("See Other", "The requested page can be found under a different URL.");
$_ERRORS[304] = array("Not Modified", "Indicates the requested page has not been modified since last requested.");
$_ERRORS[305] = array("Use Proxy", "Your URL should be redirected to another URL.");
$_ERRORS[306] = array("Switch Proxy", "No longer used.");
$_ERRORS[307] = array("Temporary Redirect", "The requested page has moved temporarily to a new URL.");
$_ERRORS[308] = array("Resume Incomplete", "Used in the resumable requests proposal to resume aborted PUT or POST requests.");
/* Client Error */
$_ERRORS[400] = array("Bad Request", "The request cannot be fulfilled due to bad syntax.");
$_ERRORS[401] = array("Unauthorized", "The request was a legal request, but the server is refusing to respond to it. For use when authentication is possible but has failed or not yet been provided.");
$_ERRORS[402] = array("Payment Required", "Reserved for future use.");
$_ERRORS[403] = array("Forbidden", "The request was a legal request, but the server is refusing to respond to it.");
$_ERRORS[404] = array("Not Found", "The requested page could not be found but may be available again in the future.");
$_ERRORS[405] = array("Method Not Allowed", "A request was made of a page using a request method not supported by that page.");
$_ERRORS[406] = array("Not Acceptable", "The server can only generate a response that is not accepted by the client.");
$_ERRORS[407] = array("Proxy Authentication Required", "The client must first authenticate itself with the proxy.");
$_ERRORS[408] = array("Request Timeout", "The server timed out waiting for the request.");
$_ERRORS[409] = array("Conflict", "The request could not be completed because of a conflict in the request.");
$_ERRORS[410] = array("Gone", "The requested page is no longer available.");
$_ERRORS[411] = array("Length Required", "The \"Content-Length\" is not defined. The server will not accept the request without it.");
$_ERRORS[412] = array("Precondition Failed", "The precondition given in the request evaluated to false by the server.");
$_ERRORS[413] = array("Request Entity Too Large", "The server will not accept the request, because the request entity is too large.");
$_ERRORS[414] = array("Request-URI Too Long", "The server will not accept the request, because the URL is too long.");
$_ERRORS[415] = array("Unsupported Media Type", "The server will not accept the request, because the media type is not supported.");
$_ERRORS[416] = array("Requested Range Not Satisfiable", "The client has asked for a portion of the file, but the server cannot supply that portion.");
$_ERRORS[417] = array("Expectation Failed", "The server cannot meet the requirements of the Expect request-header field.");
$_ERRORS[418] = array("I'm a teapot", "This code was defined in 1998 as one of the traditional IETF April Fools' jokes, in RFC 2324, Hyper Text Coffee Pot Control Protocol, and is not expected to be implemented by actual HTTP servers.");
/* Server Error */
$_ERRORS[500] = array("Internal Server Error", "A generic error message, given when no more specific message is suitable.");
$_ERRORS[501] = array("Not Implemented", "The server either does not recognize the request method, or it lacks the ability to fulfill the request.");
$_ERRORS[502] = array("Bad Gateway", "The server was acting as a gateway or proxy and received an invalid response from the upstream server.");
$_ERRORS[503] = array("Service Unavailable", "The server is currently unavailable (overloaded or down).");
$_ERRORS[504] = array("Gateway Timeout", "The server was acting as a gateway or proxy and did not receive a timely response from the upstream server.");
$_ERRORS[505] = array("HTTP Version Not Supported", "The server does not support the HTTP protocol version used in the request.");
$_ERRORS[511] = array("Network Authentication Required", "The client needs to authenticate to gain network access.");
?>