#!/usr/bin/python3
import datetime
import os

print("Cache-Control: no-cache")
print("Content-Type: text/html")
print()

print("<!DOCTYPE html>")
print("<html>")
print("<head><title>Hello CGI World - From Eban</title></head>")
print("<body>")

print('<h1 align="center">Hello HTML World, from Eban</h1><hr/>')
print("<p>Hello World</p>")
print("<p>This page was generated with the Python programming language</p>")

date = datetime.datetime.now().strftime("%a %b %d %H:%M:%S %Y")
print("<p>This program was generated at: {}</p>".format(date))

address = os.environ.get("REMOTE_ADDR", "")
print("<p>Your current IP Address is: {}</p>".format(address))

print("</body>")
print("</html>")
