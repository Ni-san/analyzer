# git log analyzer

The simplest script for analyzing the frequency of changing files by commits, to find the most "hot" points of the project, as candidates for refactoring.

Version 0.0.0.1 (proof of concept)

## Installation and usage

### Standalone

`git clone git@github.com:Ni-san/analyzer.git`

`composer install`

`php /path/to/analyzer/analyzer` - analyze repo in current directory

`php /path/to/analyzer/analyzer /path/to/project` - analyze repo in any directory

### In existing project

Add following to your `composer.json`:
```json
"repositories": [
    {
        "type": "git",
        "url": "git@github.com:Ni-san/analyzer.git"
    }
],
```

Then run `composer require nisan/analyzer`

and use as `./vendor/bin/analyzer`
