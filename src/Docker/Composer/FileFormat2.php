<?php

namespace Docker\Composer
use Extension;

class Service{

	protected $name;
	protected $config;

	function __construct($name, $){
		$this->name = $name;
	}

	function getName($name){ return $this->name; }

	protected $cap_add;
	protected $cap_drop;

	function capAdd($name){
		if(!is_array($this->config["cap_add"])) $this->config["cap_add"] = array();
		$this->$config["cap_add"][] = $name;

		return $this;
        }

	function capDrop($name){
		if(!is_array($this->config["cap_drop"])) $this->config["cap_drop"] = array();
		$this->$config["cap_drop"][] = $name;

		return $this;
        }

	function getCapAdd(){ return $this->config["cap_add"]; }
	function getCapDrop(){ return $this->config["cap_drop"]; }

	function buid($context, $dockerfile = null, $args = array()){
		$this->config["build"] = 
			  array('context'=> $context,
				'dockerfile' => $dockerfile,
				'args' => $args);
		return $this;
        }

	function getBuild(){ return $this->build; }


	function command($cmd){
		$this->config["command"] = $cmd; 
		return $this:
	}

	function getCommand(){ return $this->config["command"]; }

        /**
        * cgroup_parent
        */
	function cgroup_parent($cgroup_parent){
		$this->config["cgroup_parent"] = $cgroup_parent;
		return $this;
	}
        
        /**
        * container_name
        */
	function container_name($container_name){
		$this->config["container_name"] = $container_name;
		return $this;
	}
        
        /**
        * devices
        */
	function devices($devices){
		$this->config["devices"] = (array)($devices);
		return $this;
	}

	function addDevice($src $dest){
		$this->config["devices"][] =  $src . ":" . $dest;
		return $this;
	}

        /**
        * depends_on
        */
	function depends_on($depends_on){
		$this->config["depends_on"] = (array)($depends_on);
		return $this;
	}

	function addDepends_on($service){
		if(!is_array($this->config["depends_on"])) $this->config["depends_on"] = array();
		$this->config["depends_on"][] = $service;
		return $this;
	}
        
        /**
        * dns
        */
	function dns($dns){
		$this->config["dns"] = array_values((array)($dns));
		return $this;
	}

	function addDns($dns){
		if(!is_array($this->config["dns"])) $this->config["dns"] = array();
		$this->config["dns"][] = $dns;
		return $this;
	}
        
        /**
        * dns_opt
        */
	function dns_opt($dns_opt){
		$this->config["dns_opt"] = array_values((array)($dns_opt));
		return $this;
	}
        
        /**
        * dns_search
        */
	function dns_search($dns_search){
		$this->config["dns_search"] = array_values((array)$dns_search);
		return $this;
		
	}

	function addDns_search($dns_search){
		if(!is_array($this->config["dns_search"])) $this->config["dns_search"] = array();
		$this->config["dns_search"][] = $dns_search;
		return $this;
	}
        
        /**
        * tmpfs
        */
	function tmpfs($tmpfs){
		$this->config["tmpfs"] = array_values((array)($tmpfs));
		return $this;
	}

	function addTmpfs($tmpfs){
		if(!is_array($this->config["tmpfs"])) $this->config["tmpfs"] = array();
		$this->config["tmpfs"][] = $tmpfs;
		return $this;
	}
        
        /**
        * entrypoint
        */
	function entrypoint($entrypoint){
		$this->config["entrypoint"] = $entrypoint;
		return $this;
	}
		
        
        /**
        * env_file
        */
	protected $env_file;

        /**
        * environment
        */
	protected $environment;

        /**
        * expose
        */
	protected $expose;

        /**
        * extends
        */
	protected $extends;

        /**
        * external_links
        */
	protected $external_links;

        /**
        * extra_hosts
        */
	protected $extra_hosts;

        /**
        * group_add
        */
	protected $group_add;

        /**
        * healthcheck
        */
	protected $healthcheck;

        /**
        * image
        */
	protected $image;

        /**
        * init
        */
	protected $init
        /**
        * isolation
        */
	protected $isolation;

        /**
        * labels
        */
	protected $labels;

        /**
        * links
        */
	protected $links;

        /**
        * logging
        */
	protected $logging;

        /**
        * network_mode
        */
	protected $network_mode;

        /**
        * networks
        */
	protected $networks;

        /**
        * aliases
        */
	protected $aliases;

        /**
        * ipv4_address, 
        */
	protected $ipv4_address;

	/**
	* ipv6_address
        */
	protected $ipv6_address;

        /**
        * link_local_ips
        */
	protected $link_local_ips;

        /**
        * pid
        */
	protected $pid;

        /**
        * pids_limit
        */
	protected $pids_limit;

        /**
        * ports
        */
	protected $ports;

        /**
        * security_opt
        */
	protected $security_opt;

        /**
        * stop_grace_period
        */
	protected $stop_grace_period;

        /**
        * stop_signal
        */
	protected $stop_signal;

        /**
        * sysctls
        */
	protected $sysctls;

        /**
        * ulimits
        */
	protected $ulimits;

        /**
        * userns_mode
        */
	protected $userns_mode;

        /**
        * volumes
        */
	protected $volumes;

	/**
	* volume_driver
	*/
	protected $volume_driver;

        /**
        * volumes_from
        */
	protected $volumes_from;

        /**
        * restart
        */
	protected $restart;
}

class ServiceNotFoundException extends Extension
{
	function __construct($name){
		parent::__construct("Service $name not found");
	}
}

class FileFormat2 
{
	/**
         * path of the docker-compose.yml
         */
	protected $path;

        protected $services;

	function __construct($path = "."){
		$this->path = $path;
		$this->services = array();
        }

	function addService($name){
 		$this->services[$name] = new Service($name);     		
		return $this->services[$name];
        }

	function service($name){
		if(!$this->services[$name]) throw new ServiceNotFoundException($name);
		return $this->services[$name]
        }

	
}


