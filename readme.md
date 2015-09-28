#Front-End Project Starter
*Hand-crafted by: Killian Grant, c/o [Spire Digital](http://spire.digital)*

## Gulp Commands
### Singular Commands
- **gulp fonts**: moves fonts from /src/fonts to /build/fonts
- **gulp scss**: compiles SCSS files to CSS files from /src/scss to /build/css
- **gulp js**: minifies and lints JavaScript files from /src/js to /build/js
- **gulp img**: optimizes (using ImageOptim) and moves images from /src/img to /build/img
- **gulp bower**: moves main javascript files installed by Bower from /bower_components to /build/js/vendor
- **gulp svg**: moves SVG files from /src/svg to /build/svg

### Global Commands
- **gulp clean**: empties the build directory
- **gulp build**: runs through all singular Gulp commands once
- **gulp watch**: launches daemon which listens to file changes and executes Gulp commands accordingly
