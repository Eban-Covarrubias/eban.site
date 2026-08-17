(function () {
  var ENDPOINTS = {
    php: "/hw2/php/echo-php.php",
    python: "/hw2/python/echo-python.py",
    node: "/hw2/node/echo-node",
  };

  var form = document.getElementById("echo-form");
  var result = document.getElementById("echo-result");
  if (!form) {
    return;
  }

  form.addEventListener("submit", function (event) {
    event.preventDefault();

    var language = document.getElementById("language").value;
    var method = document.getElementById("method").value;
    var encoding = document.getElementById("encoding").value;
    var message = document.getElementById("message").value;
    var name = document.getElementById("name").value;

    var url = ENDPOINTS[language];
    var options = { method: method };
    var payload = { message: message, name: name };

    if (method === "GET") {
      url += "?" + new URLSearchParams(payload).toString();
    } else if (encoding === "json") {
      options.headers = { "Content-Type": "application/json" };
      options.body = JSON.stringify(payload);
    } else {
      options.headers = { "Content-Type": "application/x-www-form-urlencoded" };
      options.body = new URLSearchParams(payload).toString();
    }

    result.textContent = "Loading...";

    fetch(url, options)
      .then(function (response) {
        return response.text().then(function (text) {
          return { status: response.status, text: text };
        });
      })
      .then(function (res) {
        result.textContent = "HTTP " + res.status + "\n\n" + res.text;
      })
      .catch(function (err) {
        result.textContent = "Request failed: " + err;
      });
  });
})();
