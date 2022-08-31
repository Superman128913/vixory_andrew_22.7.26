#!/bin/bash
ngrok http -subdomain=vixory -host-header=rewrite c2c.test:443
#MAC ./ngrok http -subdomain=vixory -host-header=rewrite vixory.localhost:443