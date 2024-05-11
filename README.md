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
- Copy the file `config/config.php.dist` to `config/config.php`
- Use the provided template to add your servers to the `rcon_servers` configuration entry

## Usage
- Run `php application.php` to get a list of available commands
- You can pass the `SERVERNAME` from your configuration as argument to all server-specific commands to avoid being prompted for it. (Example: `php applicaiton.php rcon:vrising:list-players my-vrising-server`)

## Local Server management
- This tool provies a generator for scripts that help managing local game servers.
- For generating the scripts run `php application.php rcon:generate-scripts <server>` where `<server>` is the SERVERNAME used in the configuration.
- This will generate scripts in the `generated` directory.
- Currently only VRising has generators. Ark generators are in development.

### V Rising
#### Generating Scripts
- For V Rising there are two generated scripts: `crontask.bat` and `startServer.bat`.
- The `startServer.bat` script installs, updates and runs the server.
- The `crontask.bat` script should be set up as cronjob. It checks if the server needs an update. If it detects a new update, the server will be stopped (notifying online players before it shuts down) and started again using `startServer.bat`.

#### Setting up V Rising Server
Disclaimer: This is not a full guide to configuring your V Rising Server. These instructions set up the server ready to be configured to your needs. For Setting Up and configuring the V Rising Server always refer to the official documentation at https://github.com/StunlockStudios/vrising-dedicated-server-instructions or the official V Rising Discord.

For servers running with this tool I recommend following these steps:
- Configure your server in the config.php file. A V-Rising server config could look something like this (The port numbers can be chosen freely):
    ```php
    'rcon_servers' => [
        'awesomeSuckage' => [
            'type' => 'vrising',
            'host' => 'localhost',
            'port' => 27218,
            'steamQeryPort' => 27216,
            'password' => 'RCON_PASSWORD',
        ],
    ],
    'steamcmd' => [
        'path' => 'C:\Servers\steamcmd\steamcmd.exe',
    ],
    // Default directory templates
    'management' => [
        'vrising' => [
            // Do not remove or replace the {{server}} part. These are mustache templates. 
            'localInstallDirTemplate' => 'C:\Servers\VRising-{{server}}',
            'saveDataDirTemplate' => 'C:\Servers\SaveData\VRising-{{server}}',
        ],
    ],
    ```
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
    
