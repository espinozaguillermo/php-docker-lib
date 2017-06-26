<?php

namespace Docker\Composer;
use Symfony\Component\Yaml\Yaml;

use Exception;

class NetworkService{
	protected $name;
	protected $config;
	function __construct($name){
		$this->name = $name;
	}

	/**
        * aliases
        */
	function aliases($aliases){
		$this->config["aliases"] = array_values((array)$aliases);
		return $this;
	}

	function addAlias($alias){
		if(!is_array($this->config["aliases"])) $this->config["aliases"] = array();
		$this->config["aliases"][] = $alias;
		return $this;
	}

        /**
        * ipv4_address, 
        */
	function ipv4_address($ipv4_address){
		$this->config["ipv4_address"] = $ipv4_address;
	}

	/**
	* ipv6_address
        */
	function ipv6_address($ipv6_address){
		$this->config["ipv6_address"] = $ipv6_address;
	}

        /**
        * link_local_ips
        */
	function link_local_ips($link_local_ips){
		$this->config["link_local_ips"] = array_values((array)$link_local_ips);
		return $this;
	}
	function addLink_local_ips($link_local_ip){
		if(!is_array($this->config["link_local_ips"])) $this->config["link_local_ips"] = array();
		$this->config["link_local_ips"][] = $link_local_ip;
		return $this;
	}
}

class Service{

	protected $name;
	protected $config;
	protected $networks;

	function __construct($name){
		$this->name = $name;
		$this->config =  array();
		$this->networks = array();
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
		return $this;
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

	function addDevice($src, $dest){
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
	function env_file($env_file){
		$this->config["env_file"] = array_values((array)$env_file);
		return $this;
	}

	function addEnv_file($env_file){
		if(!is_array($this->config["env_file"])) $this->config["env_file"] = array();
		$this->config["env_file"][] = $env_file;
		return $this;
	}

        /**
        * environment
        */
	function environment($environment){
		if(!is_int(key($environment))){
			$new_env = array();
			foreach($environment as $key => $value){
				$new_env[] = $key . "=" . $value;
			}
		}
		$this->config["environment"] = array_values((array)$environment);
		return $this;
	}

	function addEnviroment($var, $value){
		if(!is_array($this->config["environment"])) $this->config["environment"] = array();
		$this->config["environment"][] = $var . "=" . $value;  
		return $this;
	}
 
        /**
        * expose
        */
	function expose($expose){
		$this->config["expose"] = array_values((array)$expose);
		return $this;
	}

	function addExpose($from, $to){
		if(!is_array($this->config["expose"])) $this->config["expose"] = array();
		$this->config["expose"][] = $from. ":" . $to;  
		return $this;
	}

        /**
        * extends
        */
	function extends($service, $file = null){
		$this->config["extends"]["service"] = $service;
		if($file){
			$this->config["extends"]["file"] = $file;
		}
	}

        /**
        * external_links
        */
	function external_links($external_links){
		$this->config["external_links"] = array_values((array)$external_links);
		return $this;
	}

	function addExternal_links($from, $to = null){
		if(!is_array($this->config["external_links"])) $this->config["external_links"] = array();
		if(!$to){
			$this->config["external_links"][] = $from;  
		}else{
			$this->config["external_links"][] = $from. ":" . $to;  
		}
		return $this;
	}

        /**
        * extra_hosts
        */
	function extra_hosts($extra_hosts){
		$this->config["extra_hosts"] = array_values((array)$extra_hosts);
		return $this;
	}

	function addExtra_hosts($from, $to){
		if(!is_array($this->config["extra_hosts"])) $this->config["extra_hosts"] = array();
		$this->config["extra_hosts"][] = $from. ":" . $to;  
		return $this;
	}

        /**
        * group_add
        * TODO : addGroup_add ? and reset the config[group_add] entry with this method?
        */
	function group_add($group_add){
		if(!is_array($this->config["egroup_add"])) $this->config["group_add"] = array();
		$this->config["group_add"] = $this->config["group_add"] + array_values((array)$group_add);
		return $this;
	}

        /**
        * healthcheck
        */
	function healthcheck($test, $interval = null, $timeout=null, $retries=null){
		if($test === false){
			$this->config["healthcheck"]["disabled"] = true;
		}else{
			$this->config["healthcheck"] = array(
				"test" => $test,
				"interval" => $interval,
				"timeout" => $timeout,
				"retries" => $retries,
				);
		}

		return $this;
	}

        /**
        * image
        */
	function image($image){
		$this->config["image"] = $image;
		return $this;
	}

        /**
        * init
        */
	function init($init){
		$this->config["init"] = $init;
	}

        /**
        * isolation
        */
	function isolation($isolation){
		$this->config["isolation"] = $isolation;
		return $this;
	}

        /**
        * labels
        */
	function labels($labels){
		$this->config["labels"] = $labels;
		return $this;
	}

	function addLabels($label, $value){
		if(!is_array($this->config["labels"])) $this->config["labels"] = array();
		$this->config["labels"][$label] = $value;
		return $this;
	}

        /**
        * links
        */
	function links($links){
		$this->config["links"] = array_values((array)$links);
		return $this;
	}
	function addLinks($source, $dest){
		if(!is_array($this->config["links"])) $this->config["links"] = array();
		$this->config["links"][] = $source . ":" . $dest;
		return $this;
	}

        /**
        * logging
        */
	function logging($driver, $options = false){
		$this->config["logging"]["driver"] = $driver;
		if($options){
			$this->config["logging"]["options"] = $options;
		}
		return $this;	
	}

        /**
        * network_mode
        */
	function network_mode($network_mode){
		$this->config["network_mode"] = $network_mode;
		return $this;
	}

        /**
        * networks
        */
	function network($network){
		$netObj = $this->networks[$network] = new NetworkService($network);
		return $netObj;
	}

	function getNetworks($network){
		return $this->networks[$networks];
	}

        
        /**
        * pid
        */
	function pid($pid){
		$this->config["pid"] = $pid;
		return $this;
	}

        /**
        * pids_limit
        */
	function pids_limit($pids_limit){
		$this->config["pids_limit"] = $pids_limit;
		return $this;
	}

        /**
        * ports
        */
	function ports($ports){
		$this->config["ports"] = array_values((array)$ports);
		return $this;
	}

	function addPorts($from, $to = false){
		if(!is_array($this->config["ports"])) $this->config["ports"] = array();
		if(!$to){
			$this->config["ports"][] = $from;
		}else{
			$this->config["ports"][] = $from . ":" . $to;
		}
		return $this;
	}

        /**
        * security_opt
        */
	function security_opt($security_opt){
		$this->config["security_opt"] = array_values((array)$security_opt);
		return $this;
	}

	function addSecurity_opt($security_opt){
		if(!is_array($this->config["security_opt"])) $this->config["security_opt"] = array();
		$this->config["ports"][] = $security_opt;
		return $this;
	}


        /**
        * stop_grace_period
        */
	function stop_grace_period($stop_grace_period){
		$this->config["stop_grace_period"] = $stop_grace_period;
		return $this;
	}

        /**
        * stop_signal
        */
	function stop_signal($stop_signal){
		$this->config["stop_signal"] = $stop_signal;
		return $stop_signal;
	}

        /**
        * sysctls
        */
	function sysctls($sysctls){
		$this->config["sysctls"] = array_values((array)$sysctls);
		return $this;
	}

	function addSysctls($sysctl, $value){
		if(!is_array( $this->config["sysctls"])) $this->config["sysctls"] = array();
		$this->config["sysctls"][] = $sysctls . "=" . $value;
		return $this;
	}

        /**
        * ulimits
        */
	function ulimits($ulimit, $config){
		if(!is_array( $this->config["ulimits"])) $this->config["ulimits"] = array();
		$this->config["ulimits"][$ulimit] = $config;
		return $this;
	}


        /**
        * userns_mode
        */
	function userns_mode($userns_mode){
		$this->config["userns_mode"] = $userns_mode;
		return $this;
		
	}

        /**
        * volumes
        */
	function volumes($volumes){
		$this->config["volumes"] = array_values((array)$volumes);
		return $this;
	}

	function addVolumes($from, $to = false){
		if(!is_array($this->config["volumes"])) $this->config["volumes"] = array();
		if(!$to){
			$this->config["volumes"][] = $from;  
		}else{
			$this->config["volumes"][] = $from . ":" . $to;  
		}
		return $this;
	}

	/**
	* volume_driver, not supported
	*/
	protected $volume_driver;

        /**
        * volumes_from
        */
	function volumes_from($volumes_from){
		$this->config["volumes_from"] = array_values((array)$volumes_from);
		return $this;
	}

	function addVolumes_from($volumes_from){
		if(!is_array($this->config["volumes_from"])) $this->config["volumes_from"] = array();
		$this->config["volumes_from"][] = $volumes_from;
		return $this;
	}


        /**
        * restart
        */
	function restart($restart){
		$this->config["restart"] = $restart;
		return $this;
	}
	

	function cpu_count($cpu_count){ 
		$this->config["cpu_count"] = $cpu_count;
		return $this;
	}

	function cpu_percent($cpu_percent){
		$this->config["cpu_percent"] = $cpu_percent;
		return $this;
	}
	function cpu_shares($cpu_shares){
		$this->config["cpu_shares"] = $cpu_shares;
		return $this;
	}
	function cpu_quota($cpu_quota){
		$this->config["cpu_quota"] = $cpu_quota;
		return $this;
	}
	function cpus($cpus){
		$this->config["cpus"] = $cpus;
		return $this;
	}
	function cpuset($cpuset){
		$this->config["cpuset"] = $cpuset;
		return $this;
	}
	function domainname($domainname){
		$this->config["domainname"] = $domainname;
		return $this;
	}
	function hostname($hostname){
		$this->config["hostname"] = $hostname;
		return $this;
	}

	function ipc($ipc){
		$this->config["ipc"] = $ipc;
		return $this;
	}
	function mac_address($mac_address){
		$this->config["mac_address"] = $mac_address;
		return $this;
	}

	function mem_limit($mem_limit){
		$this->config["mem_limit"] = $mem_limit;
		return $this;
	}

	function memswap_limit($memswap_limit){
		$this->config["memswap_limit"] = $memswap_limit;
		return $this;
	}

	function mem_swappiness($mem_swappiness){
		$this->config["mem_swappiness"] = $mem_swappiness;
		return $this;
	}

	function mem_reservation($mem_reservation){
		$this->config["mem_reservation"] = $mem_reservation;
		return $this;
	}

	function oom_score_adj($oom_score_adj){
		$this->config["oom_score_adj"] = $oom_score_adj;
		return $this;
	}

	function privileged($privileged){
		$this->config["privileged"] = $privileged;
		return $this;
	}

	function read_only($read_only){
		$this->config["read_only"] = $read_only;
		return $this;
	}

	function shm_size($shm_size){
		$this->config["shm_size"] = $shm_size;
		return $this;
	}

	function stdin_open($stdin_open){
		$this->config["stdin_open"] = $stdin_open;
		return $this;
	}

	function tty($tty){
		$this->config["tty"] = $tty;
		return $this;
	}

	function user($user){
		$this->config["user"] = $user;
		return $this;
	}

	function working_dir($working_dir){
		$this->config["working_dir"] = $working_dir;
		return $this;
	}

	function getConfig(){ return $this->config;}
}

class ServiceNotFoundException extends \Exception
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
		return $this->services[$name];
        }

	function render(){
		$rtr = array("version" => "2.2", "services" => array());
		foreach($this->services as $name => $service){
			$rtr["services"][$name] = $service->getConfig();
		}
		return  Yaml::dump($rtr, 3, 2);
	}
}


