<?php
header("Cache-Control: no-cache");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fingerprint Re-association Demo</title>
  <meta name="description" content="Extra credit: combines cookie-based state with browser fingerprinting for re-association.">
  <link rel="icon" type="image/svg+xml" href="/favicon.svg">
  <link rel="alternate icon" href="/favicon.ico">
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
  <header>
    <h1>Fingerprint Re-association Demo</h1>
    <p>Extra credit: cookie-based state, backed up by browser fingerprinting so we can still recognize you if your cookie gets cleared.</p>
  </header>

  <main>
    <a class="back-link" href="/hw2/index.html">&larr; Back to HW2</a>

    <section id="status">
      <h2>Status</h2>
      <p id="status-text">Checking...</p>
      <p id="fingerprint-text" style="color:var(--muted); font-size:0.85rem;"></p>
    </section>

    <section id="save-form">
      <h2>Save some data</h2>
      <form id="fp-form">
        <p><label>Name: <input type="text" id="name" name="name" value=""></label></p>
        <p><label>Note: <input type="text" id="note" name="note" value=""></label></p>
        <button type="submit">Save</button>
      </form>
    </section>

    <section id="how-to-test">
      <h2>How to test re-association</h2>
      <ol>
        <li>Enter a name/note above and click Save.</li>
        <li>Reload this page &mdash; you should see "Recognized via cookie."</li>
        <li>Open DevTools &rarr; Application (or Storage) &rarr; Cookies &rarr; delete the <code>fp_demo_sid</code> cookie for this site.</li>
        <li>Reload this page again &mdash; you should see "Recognized via fingerprint" with your data restored, even though the cookie was gone.</li>
      </ol>
    </section>
  </main>

  <footer>
    <p>Hosted on <a href="https://eban.site">eban.site</a> &middot; CSE 135</p>
  </footer>

  <script src="https://openfpcdn.io/fingerprintjs/v4/iife.min.js"></script>
  <script src="/hw2/extra-credit/fingerprint-demo.js"></script>
</body>
</html>
