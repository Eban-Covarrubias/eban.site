const express = require("express");
const session = require("express-session");
const os = require("os");

const app = express();
const PORT = process.env.PORT || 3000;

app.set("trust proxy", true);
app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(
  session({
    secret: "cse135-hw2-node-demo-secret",
    resave: false,
    saveUninitialized: true,
  })
);

function nowString() {
  return new Date().toString();
}

function clientIp(req) {
  return req.headers["x-forwarded-for"] || req.socket.remoteAddress || "";
}

function page(title, heading, bodyHtml) {
  return (
    "<!DOCTYPE html>\n<html>\n<head><title>" +
    title +
    '</title>\n<link rel="stylesheet" href="/css/style.css"></head>\n<body>\n<h1 align="center">' +
    heading +
    "</h1><hr/>\n" +
    bodyHtml +
    "\n</body>\n</html>"
  );
}

app.get("/hello-html-node", (req, res) => {
  const body =
    "<p>Hello World</p>" +
    "<p>This page was generated with the Node.js (Express) programming language</p>" +
    "<p>This program was generated at: " +
    nowString() +
    "</p>" +
    "<p>Your current IP Address is: " +
    clientIp(req) +
    "</p>";
  res.send(page("Hello CGI World - From Eban", "Hello HTML World, from Eban", body));
});

app.get("/hello-json-node", (req, res) => {
  res.json({
    name: "Eban",
    title: "Hello, Node.js!",
    heading: "Hello, Node.js!",
    message: "This page was generated with the Node.js (Express) programming language",
    time: nowString(),
    IP: clientIp(req),
  });
});

app.get("/environment-node", (req, res) => {
  const rows = Object.keys(process.env)
    .sort()
    .map((k) => "<tr><td>" + k + "</td><td>" + String(process.env[k]).replace(/</g, "&lt;") + "</td></tr>")
    .join("\n");
  const body =
    '<table border="1" cellpadding="6" style="margin:0 auto;color:#eef0f3;border-color:#262a33;border-collapse:collapse;">\n' +
    "<tr><th>Variable</th><th>Value</th></tr>\n" +
    rows +
    "\n</table>";
  res.send(page("Environment Variables - Node", "Environment Variables, from Eban (Node.js)", body));
});

app.all("/echo-node", (req, res) => {
  res.json({
    language: "Node.js (Express)",
    hostname: os.hostname(),
    time: nowString(),
    method: req.method,
    contentType: req.headers["content-type"] || "",
    userAgent: req.headers["user-agent"] || "",
    IP: clientIp(req),
    receivedData: req.method === "GET" ? req.query : req.body,
  });
});

app.get("/state-save-node", (req, res) => {
  const data = req.session.data || {};
  const body =
    '<form method="post" action="/hw2/node/state-save-node">\n' +
    '<p><label>Name: <input type="text" name="name" value="' +
    (data.name || "") +
    '"></label></p>\n' +
    '<p><label>Favorite color: <input type="text" name="favorite_color" value="' +
    (data.favorite_color || "") +
    '"></label></p>\n' +
    '<button type="submit">Save</button>\n' +
    "</form>\n" +
    '<p><a href="/hw2/node/state-view-node">View saved data</a> &middot; <a href="/hw2/node/state-clear-node">Clear saved data</a></p>';
  res.send(page("State Demo (Node) - Save", "Server-Side State Demo, from Eban (Node.js)", body));
});

app.post("/state-save-node", (req, res) => {
  req.session.data = {
    name: req.body.name || "",
    favorite_color: req.body.favorite_color || "",
    saved_at: nowString(),
  };
  const body =
    '<p>Saved to your session! <a href="/hw2/node/state-view-node">View saved data &rarr;</a></p>' +
    '<p><a href="/hw2/node/state-save-node">Back to save page</a></p>';
  res.send(page("State Demo (Node) - Save", "Server-Side State Demo, from Eban (Node.js)", body));
});

app.get("/state-view-node", (req, res) => {
  const data = req.session.data;
  let body;
  if (!data) {
    body = '<p>No data saved yet. <a href="/hw2/node/state-save-node">Go save some &rarr;</a></p>';
  } else {
    const items = Object.entries(data)
      .map(([k, v]) => "<li><strong>" + k + ":</strong> " + v + "</li>")
      .join("\n");
    body = "<ul>" + items + "</ul>";
  }
  body +=
    '<p><a href="/hw2/node/state-save-node">Back to save page</a> &middot; <a href="/hw2/node/state-clear-node">Clear saved data</a></p>';
  res.send(page("State Demo (Node) - View", "Saved Session Data, from Eban (Node.js)", body));
});

app.get("/state-clear-node", (req, res) => {
  req.session.data = null;
  const body =
    "<p>Your saved data has been cleared.</p>" +
    '<p><a href="/hw2/node/state-save-node">Back to save page</a></p>';
  res.send(page("State Demo (Node) - Cleared", "Session Cleared, from Eban (Node.js)", body));
});

app.listen(PORT, "127.0.0.1", () => {
  console.log("hw2 node app listening on 127.0.0.1:" + PORT);
});
