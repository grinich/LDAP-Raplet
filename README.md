# Rapportive + MIT's Directory Services

LDAP-Raplet is a [Raportive](http://rapportive.com) extension ("raplet") for MIT's directory services

### What is Rapportive?

Rapportive is a extension to Gmail that adds information  about the sender in the place of Google's ads. This plugin accesses MIT's public LDAP server to add office address, phone number, department, homepage, and more. Because they're public directories, this requires no password, certificates, or authentication of any kind. 

Current data sources:
- MIT general LDAP directory ([info](http://ist.mit.edu/ldap-directory)) `ldap.mit.edu`

## Example

![demo image](http://i.imgur.com/YhxXYWa.png "Example for Hal Abelson")

## Installation

* Make sure you're using Rapportive. If not, sign up and install the Chrome/Safari/Firefox extension.
* Visit http://www.raplets.com
* Go to the bottom of the page and click **Custom Raplet**
* Add the url `https://grinich.scripts.mit.edu/ldap-raplet/raplet.php`. 
* Enjoy your raplet! 

## TODOs
* Add CSAIL: `directory.csail.mit.edu`. Base DN: `ou=users,dc=csail,dc=mit,dc=edu`
* Add MIT Media Lab: `people.media.mit.edu`. Base DN: `cn=Users,dc=media,dc=mit,dc=edu`. 
* Map strings like "Electrical Eng & Computer Sci" --> "Course 6" for brevity.


## Misc

Some code and ideas based on LDAP Raplet 0.2 by [Craig Russell](http://www.craig-russell.co.uk) -- <craig@craig-russell.co.uk>. Everything else (c) 2013 Michael Grinich under MIT License.

Requires LDAP and JSON modules for PHP. See php.ini.
