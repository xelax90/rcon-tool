# RCON Server Management tool
This tool helps managing game servers utilizing RCON and the Steam Query API. Currently the following game servers are supported:
- Ark Survival Ascended
- V Rising

## System requirements
- Windows 10
- PHP >= 8.1
- Composer (https://getcomposer.org)
- steamcmd for managing local servers. This is optional if you are only using RCON commands

## Installation
- Download the source files zip from github
- Extract the files to some folder on your PC
- Open the extracted folder in CMD and run the following command:
  ```
  composer install
  ```

## Configuration
- All files with the `.php` extension in the `config` directory are used by this tool.
- Copy the file `config/config.php.dist` to `config/config.php` for base configuration
- Use the provided configuraiton examples as base for the configuration
- The following templates are provided:
  - remote-server.php.dist
    - Use this template to only run RCON Commands and scripts on remote servers
  - ark-local-server.php.dist
    - Use this template to run and manage local ark servers
    - The example in this template shows a working cluster setup
  - vrising-local-server.php.dist
    - Use this template to run and manage local vrising server


## Usage
- Run `php application.php` to get a list of available commands
- You can pass the server name from your configuration as argument to all server-specific commands to avoid being prompted for it. (Example: `php applicaiton.php rcon:ark:list-players island`)

## Local Server management
- This tool provies a generator for scripts that help managing local game servers.
- For generating the scripts run `php application.php rcon:generate-scripts <server>` where `<server>` is the SERVERNAME used in the configuration.
- This will generate scripts in the `generated` directory.

### V Rising
#### Generating Scripts
- For V Rising there are two generated scripts: `crontask.bat` and `startServer.bat`.
- The `startServer.bat` script installs, updates and runs the server.
- The `crontask.bat` script should be set up as cronjob. It checks if the server needs an update. If it detects a new update, the server will be stopped (notifying online players before it shuts down) and started again using `startServer.bat`.

#### Setting up V Rising Server
Disclaimer: This is not a full guide to configuring your V Rising Server. These instructions set up the server ready to be configured to your needs. For Setting Up and configuring the V Rising Server always refer to the official documentation at https://github.com/StunlockStudios/vrising-dedicated-server-instructions or the official V Rising Discord.

For servers running with this tool I recommend following these steps:
- Copy the provided `config/vrising-local-server.php.dist` to `config/vrising-local-server.php` and adjust it to your needs. The port numbers can be chosen freely as long as they are not occupied by a program on your server
- Generate the bat scripts using `php application.php rcon:generate-scripts awesomeSuckage`
- Generate initial json configuration by running `php application.php rcon:vrising:init-local-server awesomeSuckage`
    - This command will generate the `ServerHostSettings.json` and an empty `ServerGameSettings.json` in the configured saveDataDir (In this case `C:\Servers\SaveData\VRising-awesomeSuckage`)
- Adjust the generated `ServerHostSettings.json` and `ServerGameSettings.json` to your needs (For details refer to the official dedicated server guide at https://github.com/StunlockStudios/vrising-dedicated-server-instructions or the official V Rising Discord)
- Open the `generated\awesomeSuckage` Folder in the explorer and double-click the `startServer.bat` file.
- Wait until the server is installed and started
- You should be able to connect to your server now
- Setting up automated updates with scheduled tasks:
    - Open the Windows Scheduled Tasks.
    - Create a new simple task with the following settings:
        - Name: V Rising Update awesomeSuckage
        - Daily at 00:00:00, Repeat every day
        - Action: Start program. Select the generated crontask.bat file
        - After the creation is finished, doubleclick the created task
        - Select Trigger
        - Doubleclick on the daily trigger
        - Check the Repeat checkbox and select 15 minutes
        - Click OK and save the task
- The server should now be up and running and will check for updates every 15 minutes.
- If the script detects a required update, the server will be shut down using the `rcon:vrising:stop-server` command and then started again.
- All online players will be notified about the restart according to shutdown intervals configuration and the world will be saved before the restart happens

### Ark: Survival Ascended
#### Generating Scripts
- For Ark the following scripts are generated:
  - `startServer.bat`: Install, update and runs the server.
  - `crontask.bat`: script should be set up as cronjob. It checks if the server needs an update. If it detects a new update, the server will be stopped (notifying online players before it shuts down) and started again using `startServer.bat`.
  - `Game.ini`: This is the Game.ini configuration file. It will be copied to the server on every server start
  - `GameUserSettings.ini`: This is the GameUserSettings.ini configuration file. It will be copied to the server on every server start

#### Setting up Ark Server
Disclaimer: This is not a full guide to configuring your Ark Server. These instructions set up the server ready to be configured to your needs. For Setting Up and configuring the Ark Server always refer to the official wiki at https://ark.wiki.gg/wiki/Server_configuration or the official Ark Discord.

For servers running with this tool I recommend following these steps:
- Copy the provided `config/ark-local-server.php.dist` to `config/ark-local-server.php` and adjust it to your needs. The example provides a configuration example for a cluster with one Island and one Scorched Earth Server.
- Generate the scripts and server configuration using `php application.php rcon:generate-scripts island` and `php application.php rcon:generate-scripts scorched`
- Run the generated scripts `generated\island\startServer.bat` and  `generated\scorched\startServer.bat` files by double-clicking them.
- Wait until the servers are installed and started
- You should be able to connect to your servers now. To find the server you might have to check the "Show player Servers" and/or the "Show Password Protected Servers" checkbox in the Ark Server browser.
- Setting up automated updates with scheduled tasks:
    - Open the Windows Scheduled Tasks.
    - Create two new new simple tasks with the following settings:
        - Name: Ark Server Update island (and Ark Server Update scorched)
        - Daily at 00:00:00, Repeat every day
        - Action: Start program. Select the generated crontask.bat file
        - After the creation is finished, doubleclick the created task
        - Select Trigger
        - Doubleclick on the daily trigger
        - Check the Repeat checkbox and select 15 minutes
        - Click OK and save the task
- The server should now be up and running and will check for updates every 15 minutes.
- If the script detects a required update, the server will be shut down using the `rcon:ark:stop-server` command and then started again.
- All online players will be notified about the restart according to shutdown intervals configuration and the world will be saved before the restart happens
