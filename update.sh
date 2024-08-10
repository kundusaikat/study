#!/bin/sh

# Fetch changes from the remote repository
git fetch origin

# Add all changes to the index
git add .

# Commit changes with the provided message
commit_message="$1"
git commit -m "$commit_message"

# Get the name of the currently checked-out branch
current_branch=$(git rev-parse --abbrev-ref HEAD)

# Push the changes to the current branch
git push origin "$current_branch"

# To use this script, save it to a file named update.sh, make the file executable by running chmod +x update.sh, and then run it by executing ./update.sh "Your commit message here" in your terminal.