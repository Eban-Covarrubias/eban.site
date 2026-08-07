# CSE 135 Team Site

Team homepage and personal pages for CSE 135, hosted at [eban.site](https://eban.site).

## Structure

- `index.html` — team homepage, links to member pages and homework
- `members/ebancovarrubias.html` — personal page
- `css/style.css` — shared stylesheet
- `favicon.svg` / `favicon.ico` — site favicon (SVG for modern browsers, ICO fallback)
- `robots.txt` — crawler rules

## Hosting

Served via Apache on a DigitalOcean droplet (Ubuntu), with a virtual host for
`eban.site` pointing `DocumentRoot` at `/var/www/eban.site/public_html`.

## Deployment

This site auto-deploys from GitHub to the droplet on every push to `main`,
using a GitHub Actions workflow (`.github/workflows/deploy.yml`) that:

1. Checks out the repo
2. Loads a dedicated deploy-only SSH key (via `webfactory/ssh-agent`)
3. Adds the droplet's host key to `known_hosts`
4. `rsync`s the repo contents to `/var/www/eban.site/public_html` on the droplet

### One-time setup (already done for this repo)

1. Generated a dedicated SSH keypair solely for CI deployment (not reused
   anywhere else):
   ```bash
   ssh-keygen -t ed25519 -C "github-actions-deploy@cse135" -f ~/.ssh/cse135_deploy -N ""
   ```
2. Added the public key (`cse135_deploy.pub`) to `~/.ssh/authorized_keys`
   for the `eban` user on the droplet, which owns `/var/www/eban.site`.
3. Added the following repository secrets in GitHub
   (**Settings → Secrets and variables → Actions**):
   - `DEPLOY_SSH_KEY` — contents of the private key `cse135_deploy`
   - `DEPLOY_HOST` — droplet's public IP
   - `DEPLOY_USER` — `eban`

After that, any push to `main` automatically updates the live site — no
manual file editing on the server.

## Validation

All pages are checked against the
[W3C Nu HTML Checker](https://validator.w3.org/nu/) before merging.
