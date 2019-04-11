## Features:
1. Certificate Server Requests (CSR/REQ).<br />
2. Certificate with Subject Alternative Name.<br />
3. Code Signing (Java, Microsoft Authenticode).<br />
4. Create PFX/P12 archives.<br />
5. Create Java Keystores.<br />
6. Update, Renew, Revoke, Delete certificates.<br />
7. Check if CSR/Certificate/PrivateKey matches.<br />
8. More TLS tools...

### Download <a href="https://mega.nz/#!GMZSSCDD">Virtual Machine (.OVA)</a>
> This VM is build with Oracle Virtual Box 6.0.4

## How to use your own CA Certificate:
Replace the following files with your own CA Certificates and Private Key (Keep the names unchanged):
#### Certificate in PEM format:
> /opt/ca/root/certs/root.cert.pem
#### Private Key in PEM format:
> /opt/ca/root/private/root.key.pem

## Manual install instructions:
1. Clone the Repo from Github:
> git clone https://github.com/lopeaa/CertAuth
2. Configure you Webserver for this application.
3. Run composer update to create the vendor folder from within the project folder:
> composer update
4. Configure the .env file to connect to your database.

## Dependencies:
1. Laravel Framework 5.7, MySql Server, PHP7.3
2. osslsigncode
3. default-jdk
4. gnutls-bin
5. PHP7.3-Intl(idn-to-ascii)
6. PHP7.3-zip
7. Python 3.6.x
8. MSMTP

### Download <a href="https://liquabit.com/get/step-by-step-installation.pdf">Step by Step installation</a>

# <a href="https://mega.nz/#!GMZSSCDD">Demo site</a>

