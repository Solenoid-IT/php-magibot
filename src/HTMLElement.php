<?php



namespace Solenoid\MagiBot;



use \Facebook\WebDriver\Remote\RemoteWebElement;
use \Facebook\WebDriver\WebDriverBy;



class HTMLElement
{
    private RemoteWebElement $rwe;



    # Returns [self]
    public function __construct (RemoteWebElement $rwe)
    {
        // (Getting the value)
        $this->rwe = $rwe;
    }

    # Returns [HTMLElement]
    public static function create (RemoteWebElement $rwe)
    {
        // Returning the value
        return new HTMLElement( $rwe );
    }



    # Returns [string]
    public function get_name ()
    {
        // Returning the value
        return $this->rwe->getTagName();
    }

    # Returns [string]
    public function get_text ()
    {
        // Returning the value
        return $this->rwe->getText();
    }

    # Returns [string]
    public function get_attribute (string $key)
    {
        // Returning the value
        return $this->rwe->getAttribute( $key );
    }



    # Returns [self]
    public function set_value (string $value)
    {
        // (Sending the keys)
        $this->rwe->sendKeys( $value );



        // Returning the value
        return $this;
    }



    # Returns [array<HTMLElement>]
    public function find (string $selector)
    {
        // (Getting the value)
        $elements = $this->rwe->findElements( WebDriverBy::cssSelector( $selector ) );

        foreach ($elements as $k => $v)
        {// Processing each entry
            // (Getting the value)
            $elements[ $k ] = HTMLElement::create( $v );
        }



        // Returning the value
        return $elements;
    }



    # Returns [self]
    public function clear ()
    {
        // (Clearing the element)
        $this->rwe->clear();



        // Returning the value
        return $this;
    }



    # Returns [self]
    public function click ()
    {
        // (Triggering the event)
        $this->rwe->click();



        // Returning the value
        return $this;
    }

    # Returns [self]
    public function submit ()
    {
        // (Triggering the event)
        $this->rwe->submit();



        // Returning the value
        return $this;
    }



    # Returns [string]
    public function take_screenshot ()
    {
        // Returning the value
        return $this->rwe->takeElementScreenshot();
    }



    # Returns [string]
    public function get_dom_property (string $key)
    {
        // Returning the value
        return $this->rwe->getDomProperty( $key );
    }



    # Returns [string]
    public function __toString ()
    {
        // Returning the value
        return $this->get_dom_property( 'innerHTML' );
    }
}



?>