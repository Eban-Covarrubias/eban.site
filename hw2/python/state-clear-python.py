#!/usr/bin/python3
import os
import sys

sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))
import _session_helper as sess

sid, is_new = sess.get_session_id()
sess.clear_session(sid)

print("Cache-Control: no-cache")
print(sess.cookie_header(sid))
print("Content-Type: text/html")
print()

print("<!DOCTYPE html>")
print("<html>")
print("<head><title>State Demo (Python) - Cleared</title>")
print('<link rel="stylesheet" href="/css/style.css"></head>')
print("<body>")
print('<h1 align="center">Session Cleared, from Eban (Python)</h1><hr/>')
print("<p>Your saved data has been cleared.</p>")
print('<p><a href="/hw2/python/state-save-python.py">Back to save page</a></p>')
print("</body>")
print("</html>")
