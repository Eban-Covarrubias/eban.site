(function () {
  var API = "/hw2/extra-credit/fingerprint-api.php";
  var statusText = document.getElementById("status-text");
  var fpText = document.getElementById("fingerprint-text");
  var form = document.getElementById("fp-form");
  var nameInput = document.getElementById("name");
  var noteInput = document.getElementById("note");
  var visitorId = null;

  function renderStatus(data) {
    if (data.status === "known-cookie") {
      statusText.textContent =
        "Recognized via cookie. Saved data: " + data.name + " / " + data.note + " (saved " + data.savedAt + ")";
      nameInput.value = data.name || "";
      noteInput.value = data.note || "";
    } else if (data.status === "reassociated") {
      statusText.textContent =
        "Cookie was missing, but recognized you via device fingerprint! Restored data: " +
        data.name +
        " / " +
        data.note +
        " (saved " +
        data.savedAt +
        ")";
      nameInput.value = data.name || "";
      noteInput.value = data.note || "";
    } else if (data.status === "new") {
      statusText.textContent = "New visitor - no saved data yet.";
    } else if (data.status === "saved") {
      statusText.textContent = "Saved! Name: " + data.name + ", Note: " + data.note;
    }
  }

  FingerprintJS.load()
    .then(function (fp) {
      return fp.get();
    })
    .then(function (result) {
      visitorId = result.visitorId;
      fpText.textContent = "Fingerprint ID: " + visitorId + " (confidence: " + result.confidence.score + ")";

      return fetch(API + "?action=identify", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ visitorId: visitorId }),
      });
    })
    .then(function (response) {
      return response.json();
    })
    .then(function (data) {
      renderStatus(data);
    })
    .catch(function (err) {
      statusText.textContent = "Error computing fingerprint or contacting server: " + err;
    });

  form.addEventListener("submit", function (event) {
    event.preventDefault();
    if (!visitorId) {
      statusText.textContent = "Fingerprint not ready yet, try again in a moment.";
      return;
    }
    fetch(API + "?action=save", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        visitorId: visitorId,
        name: nameInput.value,
        note: noteInput.value,
      }),
    })
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
        renderStatus(data);
      });
  });
})();
