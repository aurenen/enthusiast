# Enthusiast

[Enthusiast](https://github.com/angelasabas/enthusiast), but using PDO instead of the deprecated MySQL extension. Requires at least PHP 5.4, and compatible with PHP 7.

## Changes

- Converted all mysql_* functions to PDO
- Replaced all instances of `TYPE=MyISAM` with `ENGINE=MyISAM`
- Replaced `ereg()` with `preg_match()`
- Updated [PEAR](https://pear.php.net/package/PEAR/) to v1.10.5
- Updated [PEAR/Mail](https://pear.php.net/package/Mail/) to v1.4.1

## Upgrading

If you are using [this version](https://github.com/angelasabas/enthusiast) of Enthusiast:

1. **Back up all your current Enthusiast configurations, files, and databases first.**
2. Take note of your database information in all your `config.php` files.
3. Download a ZIP copy of this repository, then extract the contents.
4. Edit the contents of `enthusiast\config.sample.php` with your database information and save it as `enthusiast/config.php`.
5. Replace your current installation files with the contents of the `enthusiast/` folder from this repository.
6. In every fanlisting folder, paste the `config.sample.php` file. Edit your database information and listing ID variable accordingly, and save it as `config.php` to overwrite your old one.

## Disclaimer

- The original Enthusiast script was written by [Angela](https://github.com/angelasabas).
- The conversion of mysql_* to PDO to make this PHP 7 compatible was done by [Lysianthus](https://github.com/Lysianthus/enthusiast).
- Further modifications are customizations of my own (@aurenen). Check [commit logs](https://github.com/aurenen/enthusiast/commits/dev) for details (changes are tested on `dev` first, before merging into `master`).