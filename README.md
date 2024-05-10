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
- For V Rising there are two generated scripts: `crontask.bat` and `startServer.bat`.
- The `startServer.bat` script installs, updates and runs the server.
- The `crontask.bat` script should be set up as cronjob. It checks if the server needs an update. If it detects a new update, the server will be stopped (notifying online players before it shuts down) and started again using `startServer.bat`.