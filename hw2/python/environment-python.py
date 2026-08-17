#!/usr/bin/python3
import os
import html

print("Cache-Control: no-cache")
print("Content-Type: text/html")
print()

print("<!DOCTYPE html>")
print("<html>")
print("<head><title>Environment Variables - Python</title>")
print('<link rel="stylesheet" href="/css/style.css"></head>')
print("<body>")
print('<h1 align="center">Environment Variables, from Eban (Python)</h1><hr/>')
print('<table border="1" cellpadding="6" style="margin:0 auto;color:#eef0f3;border-color:#262a33;border-collapse:collapse;">')
print("<tr><th>Variable</th><th>Value</th></tr>")
for key in sorted(os.environ):
    print("<tr><td>{}</td><td>{}</td></tr>".format(html.escape(key), html.escape(os.environ[key])))
print("</table>")
print("</body>")
print("</html>")
