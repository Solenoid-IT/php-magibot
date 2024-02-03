<?php



namespace Solenoid\MagiBot;



use \Facebook\WebDriver\Firefox\FirefoxDriver;



class Alert
{
    private FirefoxDriver $driver;



    # Returns [self]
    public function __construct (FirefoxDriver &$driver)
    {
        // (Getting the value)
        $this->driver = $driver;
    }

    # Returns [Session]
    public static function create (FirefoxDriver &$driver)
    {
        // Returning the value
        return new Alert( $driver );
    }



    # Returns [self]
    public function dismiss ()
    {
        // (Dismissing the alert)
        $this->driver->switchTo()->alert()->dismiss();



        // Returning the value
        return $this;
    }

    # Returns [self]
    public function accept ()
    {
        // (Dismissing the alert)
        $this->driver->switchTo()->alert()->accept();



        // Returning the value
        return $this;
    }

    # Returns [string]
    public function get_text ()
    {
        // Returning the value
        return $this->driver->switchTo()->alert()->getText();
    }

    # Returns [self]
    public function set_value (string $value)
    {
        // (Dismissing the alert)
        $this->driver->switchTo()->alert()->sendKeys( $value );



        // Returning the value
        return $this;
    }
}



?>