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
	$composer->addService("test1")->build("./custom1")->addVolumes('volumen_test1_test2', '/opt/test1');
        $composer->addService("test2")->build("./custom2")->addVolumes('volumen_test1_test2', '/opt/test2');
    
        $composer->getVolumes()->addVolumen('volumen_test1_test2', 'local');

	$rtr = Yaml::parse($composer->render());
        $this->assertEquals(
            array ( 
                "version"=> "2.2",
                "services" => array ( 
                    "Base" => array("image" => "ubuntu:16.10"),
                    "Ftth" => array ( "image" => "ubuntu:17.10"),
                    "ubuntu" => array ( "image" => "ubuntu"),
                    "custom" => array ( "build" => array("context" => "./custom")),
                    "test1" => array ( "build" => array("context" => "./custom1"),"volumes" => array('volumen_test1_test2:/opt/test1')),
                    "test2" => array ( "build" => array("context" => "./custom2"),"volumes" => array('volumen_test1_test2:/opt/test2')),
                ),
                "volumes" => array('volumen_test1_test2' => array('driver' => 'local'))
            ), $rtr);    
    }
}
