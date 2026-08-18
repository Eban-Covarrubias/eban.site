#!/usr/bin/python3
import os
import sys
import datetime
import html
from urllib.parse import parse_qs

sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))
import _session_helper as sess

method = os.environ.get("REQUEST_METHOD", "GET")
sid, is_new = sess.get_session_id()
data = sess.load_session(sid)

saved = False
if method == "POST":
    length = int(os.environ.get("CONTENT_LENGTH", 0) or 0)
    raw = sys.stdin.read(length) if length else ""
    parsed = parse_qs(raw)
    data["name"] = parsed.get("name", [""])[0]
    data["favorite_color"] = parsed.get("favorite_color", [""])[0]
    data["saved_at"] = datetime.datetime.now().strftime("%a %b %d %H:%M:%S %Y")
    sess.save_session(sid, data)
    saved = True

print("Cache-Control: no-cache")
print(sess.cookie_header(sid))
print("Content-Type: text/html")
print()

print("<!DOCTYPE html>")
print("<html>")
print("<head><title>State Demo (Python) - Save</title>")
print('<link rel="stylesheet" href="/css/style.css"></head>')
print("<body>")
print('<h1 align="center">Server-Side State Demo, from Eban (Python)</h1><hr/>')
if saved:
    print('<p>Saved to your session! <a href="/hw2/python/state-view-python.py">View saved data &rarr;</a></p>')
print('<form method="post" action="/hw2/python/state-save-python.py">')
print('<p><label>Name: <input type="text" name="name" value="{}"></label></p>'.format(html.escape(data.get("name", ""))))
print('<p><label>Favorite color: <input type="text" name="favorite_color" value="{}"></label></p>'.format(html.escape(data.get("favorite_color", ""))))
print('<button type="submit">Save</button>')
print("</form>")
print('<p><a href="/hw2/python/state-view-python.py">View saved data</a> &middot; <a href="/hw2/python/state-clear-python.py">Clear saved data</a></p>')
print("</body>")
print("</html>")
