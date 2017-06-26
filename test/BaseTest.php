<?php
use PHPUnit\Framework\TestCase;
use Docker\Composer\FileFormat2;

require __DIR__."/../vendor/autoload.php";



class BaseTest extends TestCase
{
    public function testPushAndPop()
    {
	$composer = new FileFormat2();
	$composer->addService("Base")->image("ubuntu:16.10");

	$composer->addService("Ftth")->image("ubuntu:17.10");

	echo $composer->render();
    }
}
