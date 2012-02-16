# Partial Template support for [li3](http://lithify.me
Plugin to pass template sections from view to the layout.

## Installation
1. Clone/Download the plugin into your app's ``libraries`` directory.
2. Tell your app to load the plugin by adding the following to your app's ``config/bootstrap/libraries.php``:

        Libraries::add('li3_partials');

## Features
1. Assign strings or entire blocks of markup to a partial.

## Usage
__Blocks__
In your view, wrap the markup you want passed to the layout in `<partial></partial>` tags with a `name` attribute.
```
<partial name="sidebar"><h2>Sidebar for this view!</h2></partial>
```
