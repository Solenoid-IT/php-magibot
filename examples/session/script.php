<?php



use \Solenoid\MagiBot\Session;



// (Creating a session)
$session = Session::create();



// (Starting the session)
$session->start();






// (Setting the location)
$session->set_location( 'https://kb.solenoid.it/page-1' );

// (Waiting for the condition)
$session->wait
(
    function ($session)
    {
        // Returning the value
        return $session->find( '#page-loader' )[0]->get_attribute( 'hidden' ) ? true : false;
    }
)
;



// (Making the directory)
mkdir( __DIR__ . '/storage/page-1' );

// (Writing to the files)
file_put_contents( __DIR__ . '/storage/page-1/body.html', $session->find( 'body' )[0] );
file_put_contents( __DIR__ . '/storage/page-1/source.html', $session );



// (Writing to the file)
file_put_contents( __DIR__ . '/storage/page-1/screenshot.png', $session->take_screenshot() );






// (Setting the location)
$session->set_location( 'https://kb.solenoid.it/page-2' );

// (Waiting for the condition)
$session->wait
(
    function ($session)
    {
        // Returning the value
        return $session->find( '#page-loader' )[0]->get_attribute( 'hidden' ) ? true : false;
    }
)
;



// (Executing the script)
$result = $session->execute_script( file_get_contents( __DIR__ . '/storage/script.js' ), [ 'test', '1.0.0' ] );

// Printing the value
echo "\n\n$result\n\n\n";



// (Making the directory)
mkdir( __DIR__ . '/storage/page-2' );

// (Writing to the file)
file_put_contents( __DIR__ . '/storage/page-2/screenshot.png', $session->take_screenshot() );






// (Terminating the session)
$session->terminate();



?>