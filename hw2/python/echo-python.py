#!/usr/bin/python3
import os
import sys
import json
import datetime
import socket
from urllib.parse import parse_qs

print("Cache-Control: no-cache")
print("Content-Type: application/json")
print()

method = os.environ.get("REQUEST_METHOD", "GET")
content_type = os.environ.get("CONTENT_TYPE", "")


def flatten(parsed):
    return {k: (v[0] if len(v) == 1 else v) for k, v in parsed.items()}


data = {}
if method == "GET":
    data = flatten(parse_qs(os.environ.get("QUERY_STRING", "")))
else:
    length = int(os.environ.get("CONTENT_LENGTH", 0) or 0)
    raw = sys.stdin.read(length) if length else ""
    if "application/json" in content_type:
        try:
            data = json.loads(raw) if raw else {}
        except ValueError:
            data = {"raw": raw}
    elif "application/x-www-form-urlencoded" in content_type:
        data = flatten(parse_qs(raw))
    elif raw:
        data = {"raw": raw}

response = {
    "language": "Python",
    "hostname": socket.gethostname(),
    "time": datetime.datetime.now().strftime("%a %b %d %H:%M:%S %Y"),
    "method": method,
    "contentType": content_type,
    "userAgent": os.environ.get("HTTP_USER_AGENT", ""),
    "IP": os.environ.get("REMOTE_ADDR", ""),
    "receivedData": data,
}

print(json.dumps(response, indent=2))
