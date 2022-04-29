if [[ $# == "0" ]] ; then
	echo "Start garne ki restart garne tyo ta bhan bhai"
fi

if [[ $1 == "start" ]]; then
	`sudo service nginx stop`
	sudo /opt/lampp/lampp start
elif [[ $1 == "restart" ]]; then
	`sudo service nginx stop`
	sudo /opt/lampp/lampp restart
elif [[ $1 == "stop" ]]; then
	sudo /opt/lampp/lampp stop
else
	echo "K garna khojeko bhai clear bhona yaar. Ki start gar ki restart, aru sabai chhod ahile ko lagi."
fi
