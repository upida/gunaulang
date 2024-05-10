#!/bin/bash

set -euo pipefail

script_dir=$(dirname "$0")

function ensure_var() {
    local a=$1
}

ensure_var $SSH_KEY_FILE
ensure_var $REMOTE_HOST
ensure_var $SSH_USER

echo "Copying files to remote host..."
rsync \
    -e "ssh -i $SSH_KEY_FILE" \
    --rsync-path="sudo rsync" \
    -qi -Paz "$script_dir/../" "azureuser@$REMOTE_HOST":/var/www/gunaulang.tmp
echo "Running deployment script..."
ssh -i "$SSH_KEY_FILE" "$SSH_USER@$REMOTE_HOST" "bash ~/deploy.sh"