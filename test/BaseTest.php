<?php
use PHPUnit\Framework\TestCase;
use Docker\Composer\FileFormat2;
use Symfony\Component\Yaml\Yaml;

require __DIR__."/../vendor/autoload.php";



class BaseTest extends TestCase
{

   

    public function testSimpleUsage()
    {
	$composer = new FileFormat2();
	$composer->addService("Base")->image("ubuntu:16.10");
	$composer->addService("Ftth")->image("ubuntu:17.10");
	$composer->addService("ubuntu")->image("ubuntu");
	$composer->addService("custom")->build("./custom");
	
	$rtr = Yaml::parse($composer->render());
	$this->assertEquals(array ( 
		   "version"=> "2.2",
		  "services" => array ( "Base" => array("image" => "ubuntu:16.10"),
					"Ftth" => array ( "image" => "ubuntu:17.10"),
					"ubuntu" => array ( "image" => "ubuntu"),
					"custom" => array ( "build" => array("context" => "./custom")),
				)
	), $rtr);
    
    }
}
