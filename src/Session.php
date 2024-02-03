<?php



namespace Solenoid\MagiBot;



use \Facebook\WebDriver\Firefox\FirefoxProfile;
use \Facebook\WebDriver\Firefox\FirefoxOptions;
use \Facebook\WebDriver\Remote\DesiredCapabilities;
use \Facebook\WebDriver\Firefox\FirefoxDriver;
use \Facebook\WebDriver\WebDriverBy;
use \Facebook\WebDriver\Cookie;

use \Solenoid\MagiBot\Alert;
use \Solenoid\MagiBot\HTMLElement;



class Session
{
    const USER_AGENT = 'MagiBot/1.0.0';



    private DesiredCapabilities $capabilities;
    private FirefoxDriver $driver;



    public Alert $alert;



    # Returns [self]
    public function __construct (?string $user_agent = null)
    {
        if ( !$user_agent )
        {// Value not found
            // (Getting the value)
            $user_agent = self::USER_AGENT;
        }



        // (Getting the value)
        $profile = new FirefoxProfile();

        // (Setting the preference)
        $profile->setPreference( 'general.useragent.override', $user_agent );



        // (Getting the value)
        $options = new FirefoxOptions();

        // (Adding the arguments)
        $options->addArguments( [ '-headless' ] );

        // (Setting the profile)
        $options->setProfile( $profile );



        // (Getting the value)
        $capabilities = DesiredCapabilities::firefox();

        // (Setting the capability)
        $capabilities->setCapability( FirefoxOptions::CAPABILITY, $options );



        // (Getting the value)
        $this->capabilities = $capabilities;
    }

    # Returns [Session]
    public static function create (?string $user_agent = null)
    {
        // Returning the value
        return new Session( $user_agent );
    }



    # Returns [self]
    public function start ()
    {
        // (Starting the driver)
        $this->driver = FirefoxDriver::start( $this->capabilities );



        // (Getting the value)
        $this->alert = Alert::create( $this->driver );



        // Returning the value
        return $this;
    }



    # Returns [array<string>]
    public function list_cookies ()
    {
        // Returning the value
        return $this->driver->manage()->getCookies();
    }

    # Returns [self]
    public function set_cookie (string $key, string $value)
    {
        // (Adding the cookie)
        $this->driver->manage()->addCookie( new Cookie( $key, $value ) );



        // Returning the value
        return $this;
    }



    # Returns [self]
    public function set_location (string $url)
    {
        // (Setting the location)
        $this->driver->navigate()->to( $url );



        // Returning the value
        return $this;
    }

    # Returns [self]
    public function refresh ()
    {
        // (Refreshing the page)
        $this->driver->navigate()->refresh();



        // Returning the value
        return $this;
    }

    # Returns [self]
    public function back ()
    {
        // (Going back from the navigation)
        $this->driver->navigate()->back();



        // Returning the value
        return $this;
    }

    # Returns [self]
    public function forward ()
    {
        // (Forward from the navigation)
        $this->driver->navigate()->forward();



        // Returning the value
        return $this;
    }



    # Returns [string]
    public function get_source ()
    {
        // Returning the value
        return $this->driver->getPageSource();
    }

    # Returns [mixed]
    public function execute_script (string $script, array $args = [], int $lifetime = 0)
    {
        if ( $lifetime )
        {// Value is not 0
            // (Setting a script timeout)
            $this->driver->manage()->timeouts()->setScriptTimeout( $lifetime );
        }



        // (Getting the value)
        $script =
            <<<EOD
            // (Getting the value)
            const MagiBot =
            {
                'args':    Array.from( arguments ).filter( function (i, e) { return i !== arguments.length - 1; } ),
                'resolve': arguments[ arguments.length - 1 ]
            }
            ;



            $script



            // MagiBot.resolve('result');
            EOD
        ;



        // (Executing the script)
        return $this->driver->executeAsyncScript( $script, $args );
    }

    # Returns [self]
    public function wait (callable $condition, int $lifetime = 30, int $interval = 250)
    {
        // (Waiting until)
        $this->driver->wait( $lifetime, $interval )->until( function () use ($condition) { return $condition( $this ); } );



        // Returning the value
        return $this;
    }

    # Returns [array<HTMLElement>]
    public function find (string $selector)
    {
        // (Getting the value)
        $elements = $this->driver->findElements( WebDriverBy::cssSelector( $selector ) );

        foreach ($elements as $k => $v)
        {// Processing each entry
            // (Getting the value)
            $elements[ $k ] = HTMLElement::create( $v );
        }



        // Returning the value
        return $elements;
    }

    # Returns [string]
    public function take_screenshot ()
    {
        // (Taking the screenshot)
        return $this->driver->takeScreenshot();
    }



    # Returns [self]
    public function terminate ()
    {
        // (Quitting the driver)
        $this->driver->quit();



        // Returning the value
        return $this;
    }



    # Returns [string]
    public function __toString ()
    {
        // Returning the value
        return $this->get_source();
    }
}



?>