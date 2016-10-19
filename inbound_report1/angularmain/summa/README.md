# simple-inline-countdown-directive
A simple inline countdown angular directive. [view demo]
## how to use
inclue script in html file
```html
cdn
<script src="https://cdn.rawgit.com/globaljake/simple-inline-countdown-directive/master/directive/countdownTimer.js"></script>

local
<script src="directive/countdownTimer.js"></script>
```
add service to angular app
```js
var myApp = angular.module('myApp', ['countdownTimer']);
```
add this inline countdown directive anywhere you choose
```html
<strong countdown end-date="May 9,2015" units="days|hours|minutes|seconds"></strong>
<span countdown end-date="May 9,2015" units="weeks"></strong>
```
## api
`countdown`: initializes directive

`end-date`: the end date. _takes any format js Date() allows_

`units`: which units you want the countdown to be viewed in

[view demo]:http://htmlpreview.github.io/?https://github.com/globaljake/simple-inline-countdown-directive/blob/master/index.html
