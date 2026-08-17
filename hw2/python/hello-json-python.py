#!/usr/bin/python3
import datetime
import json
import os

print("Cache-Control: no-cache")
print("Content-Type: application/json")
print()

message = {
    "name": "Eban",
    "title": "Hello, Python!",
    "heading": "Hello, Python!",
    "message": "This page was generated with the Python programming language",
    "time": datetime.datetime.now().strftime("%a %b %d %H:%M:%S %Y"),
    "IP": os.environ.get("REMOTE_ADDR", ""),
}

print(json.dumps(message))
