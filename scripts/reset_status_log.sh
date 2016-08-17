#!/bin/bash


# --- Definitions below ----

sourcePath="/Users/gynzy/git/personal-utils/pinterestpinner"
destinationPath="/volume1/web/pinterestpinner"

remoteUserSSH="admin"
remoteHostSSH="192.168.1.101"


# --- Installation commands below ----

echo "Copy log file and update permissions"
scp -r $sourcePath/log/ "$remoteUserSSH"@"$remoteHostSSH:$destinationPath"
ssh "$remoteUserSSH"@"$remoteHostSSH" "chown http $destinationPath/log"
ssh "$remoteUserSSH"@"$remoteHostSSH" "chmod 770 $destinationPath/log/*"
ssh "$remoteUserSSH"@"$remoteHostSSH" "chown http $destinationPath/log/status.log"
ssh "$remoteUserSSH"@"$remoteHostSSH" "chmod 660 $destinationPath/log/status.log"
