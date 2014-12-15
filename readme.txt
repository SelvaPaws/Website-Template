______ HOW TO USE THIS WEBSITE TEMPLATE ______

index.php and .htaccess works together to make this great system.
it is easily modifiable and easy to add/remove pages/programs.


== SETTING UP ==
.htaccess
	RewriteBase /_________
	[the siteroot without the http:// and server name]

settings/mysql.php		[enter all of the mysql user information]

templates/default.php	[change the SiteName to show up on the titles of sent pages]
templates/header.php	[to whatever you want at the top of every page]
templates/footer.php	[to whatever you want at the bottom of every page]
templates/navbar.php	[you will have to edit this to be appropriate for your site]

libraries/auth.php		[fill this in based on your authentication system]

== REQUESTING THE ROOT OF THE SITE ==

eg. http://www.sitename.com/

at line 57 of index.php, you'll see that there is an option to redirect to another page if the root is requested.
you can keep this in there, but change the target location, or remove it.

if you do remove it, index.php will load "_".
the files (controller and view) looked at when viewing the site root are called (exactly) "_.php"


== HOW THE REQUEST_URI IS HANDLED ==

index.php destroys the url (in a good way) and supplies lots of information to you.

first it disregards the site root. The site root is hard coded in index.php, line 12.
(everything after the # is not sent to the server.)
then it takes everything after the ? off (eg. from "?X=blah&Y=cake&Z=nom") into the actual global $_GET array (which is originally empty because of .htaccess).
next it takes the remaining parts of the URI, separated by forward slashes, and stores those in $_URI.
$_URI[0] is what determines which controller is loaded, and the rest can be whatever you want.
then it takes each pair of parts and groups them into a key-value relationship inside the array $_ARGS. Any left without a pair will be set to $_ARGS[key]=''.

in shorthand:
	siteRoot/programName/var1/val1/var2/val2/etc?getStuff#ignored

To recap: the useful variables set globally in index.php about the URI are:
	array	$_GET		as usual
	string	$_URI[0]	the first "parameter"
	array	$_URI		every "parameter" with int indices
	array	$_ARGS		every "parameter" after the first, grouped into key-value pairs (key indices)


== AJAX ==
if $_URI[0] is "ajax" or "static", the server will not return a page inside the site template.
instead, it will directly return the page as found in 
for example, "siteRoot/ajax/LOLCAT.php?nom=cake" will return the computed result of "ajax/LOLCAT.php" with $_GET['nom'] set to 'cake'.
if the file is not found, the 404 error page will be returned inside the site template.


== FINALLY DISPLAYING THE PAGE ==

assuming you're still executing by this stage (which is quite often), the site will look in "controllers" and "views" for $_URI[0].'.php'.
if it doesn't find both of these files, a 404 is returned.
if it does find both of these files, it includes first the controller and then the view.
the view can request information from everywhere to display it, but the controller is where any processes should occur.

function __construct($_ARGS) in the controller is always executed first.
the view is shown last (after all processes are done, so it is possible to redirect with the controller).


== REDIRECTING ==

this can only be done in the controller, but it can be done anywhere in it (unless you have debug on or something else that echoes data beforehand):

	header("Location: ".$siteroot."/whateverYouWant");


== USING MYSQL ==

you'd think mysql would have to be used in both the controllers and the views to make effective websites.
while this is true, you would be better off using it in only the controllers, and storing massess of dynamic HTML for sending in the view, using code such as the following:
	<?php echo $this->massOfHTML; ?>

to use the mysql library object, put the following code (or similar) where you need it:

	$SQL = new DatabaseAccess();
	$query = ""; //fill this in

then choose one of the methods of doing stoof from the list of available functions in the library:

	NULL	 $SQL->selectDb($db)					selects the specified database.
	NULL	 $SQL->checkError()						shows an error screen if the query failed (automatically used).
	int		 $SQL->count($query)					returns the number of records selected.
	array	 $SQL->fetchSingle($query)				returns the first selected record in a 1D array.
	string	 $SQL->fetchSingleField($query, $field)	returns the contents of a single field in the first record.
	array	 $SQL->fetchAll($query)					retuns everything selected in a 2D array (keys = field names).
	resource $SQL->query($query)					basically just executes the query. good for INSERT or ALTER statements.
	NULL	 $SQL->close()							closes the connection.


== SOME NOTES ON MAKING PROGRAMS (IN CONTROLLERS) ==

some programs are going to need to make sure that certain things were sent into the $_POST array (or maybe the $_GET or $_SESSION, or even something else)
to do this, a function has been given in "libraries/misc.php", called isset_r.
it checks that every key is present in the given array, and returns the result.
it is used such as follows:

	if (!isset_r($_POST, array('username', 'password')))
		raiseError(401);

== CHANGING THE PAGE TITLE ==

in the __construct() function of the controller of the appropriate page, paste the following:

	$this->pageTitle = "New Name Here";

if this isn't provided, ucfirst($_URI[0]) is used by default.

also remember to always call the following in the constructor:
	
	$this->setup();
or
	$this->setup('default'); //replace 'default' with the template to use
or
	parent::__constructor();


== CHANGING THE TEMPLATE ==

within your controller's constructor, paste an alternative to:

	$this->template = 'default';