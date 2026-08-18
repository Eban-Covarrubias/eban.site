#!/usr/bin/python3
import os
import sys
import html

sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))
import _session_helper as sess

sid, is_new = sess.get_session_id()
data = sess.load_session(sid)

print("Cache-Control: no-cache")
print(sess.cookie_header(sid))
print("Content-Type: text/html")
print()

print("<!DOCTYPE html>")
print("<html>")
print("<head><title>State Demo (Python) - View</title>")
print('<link rel="stylesheet" href="/css/style.css"></head>')
print("<body>")
print('<h1 align="center">Saved Session Data, from Eban (Python)</h1><hr/>')
if not data:
    print('<p>No data saved yet. <a href="/hw2/python/state-save-python.py">Go save some &rarr;</a></p>')
else:
    print("<ul>")
    for key, value in data.items():
        print("<li><strong>{}:</strong> {}</li>".format(html.escape(key), html.escape(str(value))))
    print("</ul>")
print('<p><a href="/hw2/python/state-save-python.py">Back to save page</a> &middot; <a href="/hw2/python/state-clear-python.py">Clear saved data</a></p>')
print("</body>")
print("</html>")
