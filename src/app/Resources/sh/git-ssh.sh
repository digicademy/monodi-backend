#
# Wrapper to use an other sshkeyfile
# http://alvinabad.wordpress.com/2013/03/23/how-to-specify-an-ssh-key-file-with-the-git-command/
# http://linuxcommando.blogspot.de/2008/10/how-to-disable-ssh-host-key-checking.html
#!/bin/sh
if [ -z "$PKEY" ]; then
# if PKEY is not specified, run ssh using default keyfile
ssh "$@"
else
#echo "Use alternative SSH-Key-File: $PKEY" > /tmp/gitKey.txt
ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no -i "$PKEY" "$@"
fi