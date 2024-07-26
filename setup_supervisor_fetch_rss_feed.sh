#!/bin/bash

# Define variables
SUPERVISOR_CONF_DIR="/etc/supervisor/conf.d"
SUPERVISOR_CONF_FILE="fetch_rss_feed.conf"
ARTISAN_PATH="$(pwd)/artisan"  # Using the current directory for artisan path
LOGFILE_PATH="$(pwd)/storage/logs/fetch_rss_feed.log"  # Log file path within the current directory
USERNAME="rejneesh6"  # Replace with the actual username under which you want to run the command

# Check if running as root
if [[ $EUID -ne 0 ]]; then
   echo "This script must be run as root" 
   exit 1
fi

# Create Supervisor config file
cat <<EOL > $SUPERVISOR_CONF_DIR/$SUPERVISOR_CONF_FILE
[program:fetch_rss_feed]
process_name=%(program_name)s_%(process_num)02d
command=php $ARTISAN_PATH fetch:rssfeed
autostart=true
autorestart=true
user=$USERNAME
numprocs=1
redirect_stderr=true
stdout_logfile=$LOGFILE_PATH
EOL

# Reload Supervisor configuration
supervisorctl reread
supervisorctl update
supervisorctl start fetch_rss_feed:*

echo "Supervisor configuration for fetch_rss_feed has been set up and started."
