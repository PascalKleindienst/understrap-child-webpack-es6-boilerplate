# understrap-child-webpack-es6-boilerplate [![Maintainability](https://api.codeclimate.com/v1/badges/6467c8f34c903d55e374/maintainability)](https://codeclimate.com/github/PascalKleindienst/understrap-child-webpack-es6-boilerplate/maintainability)

Basic Child Theme Boilerplate with webpack, scss, and babel es6 for UnderStrap Theme Framework: https://github.com/holger1411/understrap

Inspired by the understrap-child theme https://github.com/understrap/understrap-child

## How it works

It shares with the parent theme all PHP files and adds its own functions.php on top of the UnderStrap parent themes functions.php.

IT DID NOT LOAD THE PARENT THEMES CSS FILE(S)! Instead it uses the UnderStrap Parent Theme as dependency via npm and compiles its own CSS file from it.

Uses the Enqueue method the load and sort the CSS file the right way instead of the old @import method.

## Installation

1. Install the parent theme UnderStrap first: https://github.com/holger1411/understrap
* IMPORTANT: If you download it from GitHub make sure you rename the "understrap-master.zip" file just to "understrap.zip" or you might have problems using this child themes !!
2. Just upload the understrap-child-webpack-es6-boilerplate folder to your wp-content/themes directory
3. Go into your WP admin backend
4. Go to "Appearance -> Themes"
5. Activate the UnderStrap Child theme

## Editing

### SCSS

* Add your own CSS styles to `/src/styles/_components/` and import you own files into `/src/styles/app.scss`
* To overwrite Bootstrap variables just add your own value to: `/src/styles/_custom_bootstrap.scss`
* It will be outputted into: `/assets/styles.css` -> So you have one clean CSS file at the end and just one request

### JavaScript (ES6)

* Add your own CSS styles to `/src/` and import you own files into `/src/app.js`
* It will be outputted into: `/assets/bundle.js` -> So you have one clean JS file at the end and just one request

## Developing With NPM, webpack, scss and babel

### Installing Dependencies

* Make sure you have installed Node.js and [yarn](https://yarnpkg.com/en/) on your computer globally
* Then open your terminal and browse to the location of your  understrap-child-webpack-es6-boilerplate copy
* Run: `$ yarn install`

### Running

To work and compile your scss and javascript files on the fly start with inline source-maps:

```
$ yarn run build:dev
```

To build your assets for production run the following
```
$ yarn run build:dev
```