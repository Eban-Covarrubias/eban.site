"""Shared cookie/session-file helpers for the Python CGI state demo.

Not a CGI entry point itself - imported by the state-*-python.py scripts via
a sys.path insert, since each CGI request is a fresh process with no shared
memory to hold session state in.
"""
import os
import json
import uuid
import http.cookies

SESSION_DIR = "/var/lib/hw2-python-sessions"
COOKIE_NAME = "hw2py_sid"


def get_session_id():
    cookie_header = os.environ.get("HTTP_COOKIE", "")
    jar = http.cookies.SimpleCookie()
    jar.load(cookie_header)
    if COOKIE_NAME in jar:
        sid = jar[COOKIE_NAME].value
        if sid and all(c.isalnum() for c in sid):
            return sid, False
    return uuid.uuid4().hex, True


def session_path(sid):
    return os.path.join(SESSION_DIR, sid + ".json")


def load_session(sid):
    path = session_path(sid)
    if os.path.exists(path):
        with open(path, "r") as f:
            try:
                return json.load(f)
            except ValueError:
                return {}
    return {}


def save_session(sid, data):
    with open(session_path(sid), "w") as f:
        json.dump(data, f)


def clear_session(sid):
    path = session_path(sid)
    if os.path.exists(path):
        os.remove(path)


def cookie_header(sid):
    return "Set-Cookie: {}={}; Path=/hw2/python/; HttpOnly".format(COOKIE_NAME, sid)
