# README #

This repository is a collection of files required to get Zabbix to use low-level discovery to discover Philips Hue bulbs and monitor their attributes and trigger if they go unreachable

### What is this repository for? ###

* Discovers Hue Bulbs connected to the given hub
* Includes Triggers for bulb unreachable events
* More items can be added.

### Requirements ###
* A recent version of the php cli.

### How do I get set up? ###

#### Zabbix Agent Config ####
* Copy the `hue-agent-config.conf` file to  `/etc/zabbix/zabbix_agentd.d/hue-agent-config.conf`
* Modify the `hue-credentials.conf.php` file to set the Host and User info to match your environment
* Copy the `zabbix-hue-bulbs.php` and `hue-credentials.conf.php` files to `/usr/lib/zabbix/externalscripts/`
* Restart Zabbix Agent

#### Zabbix Server Config ####
* Import the `template-philips-hue-bulbs.xml` template file into Zabbix
* Attach this template to the host running the agent you have configured.

### Contribution guidelines ###

* Feel free

### Who do I talk to? ###

* Andrew Shaw
