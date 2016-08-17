#!/bin/bash


# --- Definitions below ----

sourcePath="/Users/gynzy/git/personal-utils/pinterestpinner"
destinationPath="/volume1/web/pinterestpinner"

remoteUserSSH="admin"
remoteHostSSH="192.168.1.101"


# --- Installation commands below ----

echo "Copy images"
scp -r $sourcePath/dynamic_content/images/. "$remoteUserSSH"@"$remoteHostSSH:$destinationPath/public/images"

echo "Copy csv data"
scp -r $sourcePath/dynamic_content/input.csv "$remoteUserSSH"@"$remoteHostSSH:$destinationPath/config/"
