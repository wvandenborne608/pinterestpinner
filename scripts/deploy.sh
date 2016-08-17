#!/bin/bash


# --- Definitions below ----

sourcePath="/Users/gynzy/git/personal-utils/pinterestpinner"
destinationPath="/volume1/web/pinterestpinner"

sourceConfigPath="/etc/scripts"
sourceConfigFile="pinterestpinner.config"
destinationConfigFile="config.php"

remoteUserSSH="admin"
remoteHostSSH="192.168.1.101"


# --- Installation commands below ----

echo "Remove destination folder"
#ssh "$remoteUserSSH"@"$remoteHostSSH" "rm -rf $destinationPath"

echo "Create destination folder"
#ssh "$remoteUserSSH"@"$remoteHostSSH" "mkdir $destinationPath"

echo "Copy log file and update permissions"
#scp -r $sourcePath/log/ "$remoteUserSSH"@"$remoteHostSSH:$destinationPath"
#ssh "$remoteUserSSH"@"$remoteHostSSH" "chmod 660 $destinationPath/log/*"
#ssh "$remoteUserSSH"@"$remoteHostSSH" "chown http $destinationPath/log"
#ssh "$remoteUserSSH"@"$remoteHostSSH" "chown http $destinationPath/log/status.log"

# --- Copy commands below ----

echo "Copy public files"
scp -r $sourcePath/public/. "$remoteUserSSH"@"$remoteHostSSH:$destinationPath/public"

echo "Copy PHP classes"
scp -r $sourcePath/classes/. "$remoteUserSSH"@"$remoteHostSSH:$destinationPath/classes"

echo "Copy default config files"
scp -r $sourcePath/config/. "$remoteUserSSH"@"$remoteHostSSH:$destinationPath/config"

echo "Override default config files with real data"
scp $sourceConfigPath/$sourceConfigFile "$remoteUserSSH"@"$remoteHostSSH:$destinationPath/config/$destinationConfigFile" 

echo "Copy Vendor files"
#scp -r $sourcePath/vendor/. "$remoteUserSSH"@"$remoteHostSSH:$destinationPath/vendor"

echo "Copy .htaccess file"
#scp $sourcePath/.htaccess "$remoteUserSSH"@"$remoteHostSSH:$destinationPath/"