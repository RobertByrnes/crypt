Start-Process -FilePath "C:/wamp64/bin/apache/apache2.4.46/bin/httpd.exe" -ArgumentList "-k restart -n wampapache64"  -Verb RunAs;

'Apache has been restarted now...'

