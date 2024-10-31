#!/bin/bash

now="$(date +"%Y-%m-%d")"
nowtime="$(date +"%Y-%m-%d_%T")"
name="retail_dev_$nowtime"
findfilename="$(/usr/bin/find /home/ois-admin/backup_database/backup_dbois_gvp/backup_dbois_gvp_$now*)"
echo $findfilename

#get token access
token="$(/usr/bin/curl --request POST --data "client_id={{client_id}}&client_secret={{client_secret}}&refresh_token={{refresh_token}}&grant_type=refresh_token" https://oauth2.googleapis.com/token)"
#echo $token
access_token=$( jq -r  '.access_token' <<< "${token}" )
echo $access_token
/usr/bin/curl -X POST -L \
    -H "Authorization: Bearer $access_token" \
    -F "metadata={name : '$name'};type=application/json;charset=UTF-8" \
    -F "file=@$findfilename;type=application/zip" \
   "https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart"


echo 'sukses'